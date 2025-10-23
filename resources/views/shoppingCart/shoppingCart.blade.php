<x-layout>
	<div class="w-full max-w-7xl mx-auto px-4">
		<h1 class="text-4xl font-bold text-blue-300 mb-6">Shopping Cart</h1>

		@if(session('success'))
            <div
                class="bg-green-500/20 border border-green-500 text-green-100 px-4 py-3 rounded-lg mb-6">{{ session('success') }}
            </div>
        @endif

		@if(empty($cartItems))
            <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-blue-300 mb-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-white mb-2">Your cart is empty</h2>
                <p class="text-blue-200 mb-6">Start adding some LEGO sets to your cart!</p>
                <a href="{{ route('webshop.list') }}" class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold px-8 py-3 rounded-lg border-2 border-white/30 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:border-white/60">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-lg shadow-md p-4 flex gap-4">
                            <div
                                class="w-24 h-24 bg-gray-50 rounded flex-shrink-0">
                                @if($item['product']->image)
                                    <img src="{{ asset($item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-contain p-2">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow">
                                <h3 class="font-semibold text-gray-800 mb-1">{{ $item['product']->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $item['product']->category->name }}</p>
                                <p class="text-lg font-bold text-blue-600">€{{ number_format($item['product']->price, 2) }}</p>
                            </div>

                            <div class="flex flex-col items-end justify-between">
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                    @csrf
                                                                        @method
                                    ('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>

                                <div class="flex items-center gap-2">
                                    <form action="{{ route('cart.update', $item['product']->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                        <button type="submit" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center transition-colors">
                                            <span class="text-gray-700 font-bold">-</span>
                                        </button>
                                    </form>

                                    <span class="w-12 text-center font-semibold text-gray-800">{{ $item['quantity'] }}</span>

                                    <form action="{{ route('cart.update', $item['product']->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center transition-colors">
                                            <span class="text-gray-700 font-bold">+</span>
                                        </button>
                                    </form>
                                </div>

                                <p class="text-sm font-semibold text-gray-600">
                                    Subtotal: €
                                    {{ number_format($item['subtotal'], 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition-colors" onclick="return confirm('Are you sure you want to clear your cart?')">
                            Clear Cart
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl p-6 sticky top-24">
                        <h2 class="text-2xl font-bold text-white mb-4">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-blue-100">
                                <span>Items ({{ array_sum(array_column($cartItems, 'quantity')) }})</span>
                                <span>€{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-blue-100">
                                <span>Shipping</span>
                                <span>FREE</span>
                            </div>
                            <div class="border-t border-white/20 pt-3 flex justify-between text-white text-xl font-bold">
                                <span>Total</span>
                                <span>€{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 rounded-lg border-2 border-white/30 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:border-white/60 mb-3">
                            Proceed to Checkout
                        </button>

                        <a href="{{ route('webshop.list') }}" class="block text-center text-blue-200 hover:text-blue-100 transition-colors">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
	</div>
</x-layout>

