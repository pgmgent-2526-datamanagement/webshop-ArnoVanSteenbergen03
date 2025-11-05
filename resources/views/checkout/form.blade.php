<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-8">Checkout</h1>

        <!-- Order Summary -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Order Summary</h2>
            
            <div class="space-y-3">
                @foreach($cartItems as $item)
                <div class="flex justify-between text-white/90">
                    <span>{{ $item['product']->name }} x {{ $item['quantity'] }}</span>
                    <span>€{{ number_format($item['subtotal'], 2) }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-white/20 mt-4 pt-4">
                <div class="flex justify-between text-xl font-bold text-white">
                    <span>Total</span>
                    <span>€{{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Delivery Information</h2>

            @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-white px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('cart.checkout.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-white font-medium mb-2">Full Name *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-2 bg-white/10 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-blue-500"
                        placeholder="John Doe"
                    >
                </div>

                <div>
                    <label for="email" class="block text-white font-medium mb-2">Email Address *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2 bg-white/10 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-blue-500"
                        placeholder="john@example.com"
                    >
                </div>

                <div>
                    <label for="address" class="block text-white font-medium mb-2">Street Address *</label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address" 
                        value="{{ old('address') }}"
                        required
                        class="w-full px-4 py-2 bg-white/10 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-blue-500"
                        placeholder="123 Main Street"
                    >
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-white font-medium mb-2">City *</label>
                        <input 
                            type="text" 
                            id="city" 
                            name="city" 
                            value="{{ old('city') }}"
                            required
                            class="w-full px-4 py-2 bg-white/10 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-blue-500"
                            placeholder="Ghent"
                        >
                    </div>

                    <div>
                        <label for="zipcode" class="block text-white font-medium mb-2">Zipcode *</label>
                        <input 
                            type="text" 
                            id="zipcode" 
                            name="zipcode" 
                            value="{{ old('zipcode') }}"
                            required
                            class="w-full px-4 py-2 bg-white/10 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-blue-500"
                            placeholder="9000"
                        >
                    </div>
                </div>

                <div class="pt-4">
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                    >
                        Proceed to Payment
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('cart.index') }}" class="text-blue-400 hover:text-blue-300">
                        ← Back to Cart
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
