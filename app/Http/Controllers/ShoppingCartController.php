<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Mollie\Api\MollieApiClient;

class ShoppingCartController extends Controller
{
    public function shoppingCart()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::with(['category', 'tags'])->find($productId);

            if ($product) {
                $subtotal = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }
        }

        return view('shoppingCart.shoppingCart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if ($quantity > 0) {
            $cart[$productId] = $quantity;
        } else {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function clearCart()
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public static function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum($cart);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty!');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }
        }

        return view('checkout.form', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $quantity;
            }
        }

        // Create order
        $order = Order::create([
            'user_id' => null, // Or auth()->id() if you have authentication
            'total_price' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Create order items
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }
        }

        // Create Mollie payment
        $mollie = new MollieApiClient();
        $mollie->setApiKey(config('services.mollie.key'));
        
        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($total, 2, '.', ''),
            ],
            'description' => 'Order #' . $order->id,
            'redirectUrl' => route('cart.checkout.success') . '?order_id=' . $order->id,
            'webhookUrl' => route('webhooks.mollie'),
            'metadata' => [
                'order_id' => $order->id,
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_address' => $validated['address'],
                'customer_city' => $validated['city'],
                'customer_zipcode' => $validated['zipcode'],
            ],
        ]);

        // Update order with payment info
        $order->update([
            'payment_id' => $payment->id,
            'payment_status' => $payment->status,
        ]);

        // Clear cart
        session()->forget('cart');

        // Redirect to Mollie payment page
        return redirect($payment->getCheckoutUrl());
    }

    public function checkoutSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Check payment status
        if ($order->payment_id) {
            $mollie = new MollieApiClient();
            $mollie->setApiKey(config('services.mollie.key'));
            
            $payment = $mollie->payments->get($order->payment_id);
            
            $order->update([
                'payment_status' => $payment->status,
                'payment_method' => $payment->method ?? null,
            ]);

            if ($payment->isPaid()) {
                $order->update(['status' => 'paid']);
            }
        }

        return view('checkout.success', compact('order'));
    }

    public function checkoutCancel()
    {
        return redirect()->route('cart.show')->with('error', 'Payment was cancelled.');
    }

    public function webhook(Request $request)
    {
        $paymentId = $request->input('id');
        
        if (!$paymentId) {
            return response()->json(['error' => 'No payment ID provided'], 400);
        }

        $mollie = new MollieApiClient();
        $mollie->setApiKey(config('services.mollie.key'));
        
        $payment = $mollie->payments->get($paymentId);
        $order = Order::where('payment_id', $paymentId)->first();

        if ($order) {
            $order->update([
                'payment_status' => $payment->status,
                'payment_method' => $payment->method ?? null,
            ]);

            if ($payment->isPaid()) {
                $order->update(['status' => 'paid']);
                
                // TODO: Send confirmation email here
            } elseif ($payment->isFailed() || $payment->isExpired() || $payment->isCanceled()) {
                $order->update(['status' => 'cancelled']);
            }
        }

        return response()->json(['success' => true]);
    }
}
