<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-8 text-center">
            @if($order->payment_status === 'paid')
            <div class="mb-6">
                <svg class="w-20 h-20 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-white mb-4">Thank You for Your Order!</h1>
            <p class="text-white/80 text-lg mb-2">Your payment was successful.</p>
            <p class="text-white/60 mb-8">Order #{{ $order->id }}</p>
            @elseif($order->payment_status === 'pending' || $order->payment_status === 'open')
            <div class="mb-6">
                <svg class="w-20 h-20 text-yellow-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-white mb-4">Payment Pending</h1>
            <p class="text-white/80 text-lg mb-2">We're processing your payment.</p>
            <p class="text-white/60 mb-8">Order #{{ $order->id }}</p>
            @else
            <div class="mb-6">
                <svg class="w-20 h-20 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-white mb-4">Payment {{ ucfirst($order->payment_status) }}</h1>
            <p class="text-white/80 text-lg mb-2">There was an issue with your payment.</p>
            <p class="text-white/60 mb-8">Order #{{ $order->id }}</p>
            @endif

            <!-- Order Details -->
            <div class="bg-white/5 rounded-lg p-6 mb-6 text-left">
                <h2 class="text-xl font-semibold text-white mb-4">Order Details</h2>
                
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between text-white/90">
                        <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <span>€{{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-white/20 mt-4 pt-4">
                    <div class="flex justify-between text-xl font-bold text-white">
                        <span>Total</span>
                        <span>€{{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>

                @if($order->payment_method)
                <div class="mt-4 pt-4 border-t border-white/20">
                    <p class="text-white/70">
                        Payment Method: <span class="text-white font-semibold">{{ ucfirst($order->payment_method) }}</span>
                    </p>
                </div>
                @endif
            </div>

            <div class="space-y-4">
                @if($order->payment_status === 'paid')
                <p class="text-white/80">
                    A confirmation email will be sent to you shortly.
                </p>
                @endif

                <div class="flex gap-4 justify-center">
                    <a href="{{ route('webshop.list') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
