<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
