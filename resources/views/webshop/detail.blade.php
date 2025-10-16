<x-layout>
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Back Link -->
        <a href="{{ route('webshop.list') }}" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Products
        </a>

        <!-- Product Detail Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-auto object-cover"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/800x800/0066CC/FFFFFF?text={{ urlencode($product->name) }}';">
                @else
                    <img src="https://via.placeholder.com/800x800/0066CC/FFFFFF?text={{ urlencode($product->name) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-auto object-cover">
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <!-- Category -->
                <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">
                    {{ $product->category->name }}
                </p>
                
                <!-- Product Name -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    {{ $product->name }}
                </h1>
                
                <!-- Badges -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 capitalize">
                        {{ $product->condition }}
                    </span>
                    @if($product->stock > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            ✓ In Stock: {{ $product->stock }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Out of Stock
                        </span>
                    @endif
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <span class="text-4xl font-bold text-blue-600">
                        €{{ number_format($product->price, 2) }}
                    </span>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Description</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Tags -->
                @if($product->tags->count() > 0)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Product Details Card -->
                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Product Details</h2>
                    
                    @if($product->piece_count)
                        <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                            <span class="text-gray-600 font-medium">🧱 Piece Count</span>
                            <span class="text-gray-900 font-semibold">{{ number_format($product->piece_count) }} pieces</span>
                        </div>
                    @endif

                    @if($product->release_date)
                        <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                            <span class="text-gray-600 font-medium">📅 Release Date</span>
                            <span class="text-gray-900 font-semibold">{{ $product->release_date->format('F Y') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                        <span class="text-gray-600 font-medium">🏷️ Condition</span>
                        <span class="text-gray-900 font-semibold capitalize">{{ $product->condition }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">📦 Availability</span>
                        <span class="text-gray-900 font-semibold">
                            @if($product->stock > 0)
                                {{ $product->stock }} unit(s) in stock
                            @else
                                <span class="text-red-600">Out of stock</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Add to Cart Button (placeholder) -->
                <div class="mt-8">
                    @if($product->stock > 0)
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg transition-colors duration-200 transform hover:scale-105">
                            Add to Cart
                        </button>
                    @else
                        <button class="w-full bg-gray-300 text-gray-500 font-bold py-4 px-8 rounded-lg cursor-not-allowed" disabled>
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>