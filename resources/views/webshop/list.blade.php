<x-layout>
    <div class="container">
        <h1>LEGO Resale Shop</h1>

        <div class="product-grid">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden" >
                    <!-- Product Image -->
                    <div class="relative h-64 bg-gray-100">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400/0066CC/FFFFFF?text={{ urlencode($product->name) }}';">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span>No Image</span>
                            </div>
                        @endif

                        <!-- Stock Badge -->
                        @if($product->stock > 0)
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                In Stock: {{ $product->stock }}
                            </span>
                        @else
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                Out of Stock
                            </span>
                        @endif

                        <!-- Condition Badge -->
                        <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded capitalize">
                            {{ $product->condition }}
                        </span>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Category -->
                        <p class="text-xs text-gray-500 uppercase mb-1">{{ $product->category->name }}</p>

                        <!-- Product Name -->
                        <h2 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[3.5rem]">
                            {{ $product->name }}
                        </h2>

                        <!-- Description -->
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            {{ $product->description }}
                        </p>

                        <!-- Piece Count -->
                        @if($product->piece_count)
                            <p class="text-xs text-gray-500 mb-2">
                                {{ number_format($product->piece_count) }} pieces
                            </p>
                        @endif

                        <!-- Tags -->
                        @if($product->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($product->tags->take(3) as $tag)
                                    <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Price and Button -->
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                            <span class="text-2xl font-bold text-blue-600">
                                €{{ number_format($product->price, 2) }}
                            </span>
                            <a href="{{ route('webshop.detail', ['id' => $product->id]) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No products available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layout>