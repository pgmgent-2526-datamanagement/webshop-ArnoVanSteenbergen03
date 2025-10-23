<x-layout>
	<div class="w-full max-w-7xl mx-auto px-4">
		<h1 class="text-4xl font-bold text-blue-300 mb-6">LEGO Resale Shop</h1>

		<x-searchform buttontext="Filter"></x-searchform>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
			@forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                    <div
                        class="relative h-72 bg-gray-50 flex-shrink-0">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-6" loading="lazy" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x600/0066CC/FFFFFF?text={{ urlencode($product->name) }}';">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span>No Image</span>
                            </div>
                        @endif

                        @if($product->stock > 0)
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded shadow-md">
                                In Stock:
                                {{ $product->stock }}
                            </span>
                        @else
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded shadow-md">
                                Out of Stock
                            </span>
                        @endif

                        <span
                            class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded capitalize shadow-md">{{ $product->condition }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <p class="text-xs text-gray-500 uppercase mb-1">{{ $product->category->name }}</p>

                        <h2
                            class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[3.5rem]">{{ $product->name }}
                        </h2>

                        <p
                            class="text-sm text-gray-600 mb-3 line-clamp-2 flex-grow">{{ $product->description }}
                        </p>

                        @if($product->piece_count)
                            <p
                                class="text-xs text-gray-500 mb-2">
                                {{ number_format($product->piece_count) }}
                                pieces
                            </p>
                        @endif

                        @if($product->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($product->tags->take(3) as $tag)
                                    <span
                                        class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-200 gap-2">
                            <span class="text-2xl font-bold text-blue-600">
                                €
                                {{ number_format($product->price, 2) }}
                            </span>
                            <div
                                class="flex gap-2">
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm font-semibold transition-colors flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                            Add
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('webshop.detail', ['id' => $product->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-blue-200 text-lg">No products available at the moment.</p>
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

