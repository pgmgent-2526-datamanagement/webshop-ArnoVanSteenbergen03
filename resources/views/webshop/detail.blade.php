<x-layout>
	<x-slot:seo>
		<x-seo 
			:title="$product->name"
			:description="$product->description . ' - ' . $product->category->name . ' LEGO set with ' . ($product->piece_count ? number_format($product->piece_count) . ' pieces' : 'quality pieces') . '. Condition: ' . ucfirst($product->condition) . '. Price: €' . number_format($product->price, 2)"
			:image="$product->image ? asset($product->image) : null"
			type="product"
			:schema="[
				'@context' => 'https://schema.org',
				'@type' => 'Product',
				'name' => $product->name,
				'description' => $product->description,
				'image' => $product->image ? asset($product->image) : 'https://via.placeholder.com/800x800/0066CC/FFFFFF?text=' . urlencode($product->name),
				'brand' => [
					'@type' => 'Brand',
					'name' => 'LEGO'
				],
				'category' => $product->category->name,
				'offers' => [
					'@type' => 'Offer',
					'url' => url()->current(),
					'priceCurrency' => 'EUR',
					'price' => (string) $product->price,
					'priceValidUntil' => now()->addYear()->toDateString(),
					'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
					'itemCondition' => match($product->condition) {
						'new' => 'https://schema.org/NewCondition',
						'used' => 'https://schema.org/UsedCondition',
						'refurbished' => 'https://schema.org/RefurbishedCondition',
						default => 'https://schema.org/UsedCondition'
					},
					'seller' => [
						'@type' => 'Organization',
						'name' => config('app.name')
					]
				],
				'aggregateRating' => [
					'@type' => 'AggregateRating',
					'ratingValue' => '4.5',
					'reviewCount' => '10'
				]
			]"
		/>
	</x-slot:seo>
	<div class="container mx-auto px-4 py-8 max-w-7xl">
		<a href="{{ route('webshop.list') }}" class="inline-flex items-center text-blue-300 hover:text-blue-100 mb-6 transition-colors">
			<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewbox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
			</svg>
			Back to Products
		</a>

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
			<div
				class="bg-white rounded-lg shadow-lg overflow-hidden">
				@if($product->image)
					<img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
				@else
					<img src="https://via.placeholder.com/800x800/0066CC/FFFFFF?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
				@endif
			</div>

			<div class="flex flex-col">
				<p
					class="text-sm text-blue-300 uppercase tracking-wide mb-2">{{ $product->category->name }}
				</p>

				<h1
					class="text-4xl font-bold text-white mb-4">{{ $product->name }}
				</h1>

				<div class="flex flex-wrap gap-2 mb-6">
					<span
						class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 capitalize">{{ $product->condition }}
					</span>
					@if($product->stock > 0)
						<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
							✓ In Stock:
							{{ $product->stock }}
						</span>
					@else
						<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
							Out of Stock
						</span>
					@endif
				</div>

				<div class="mb-6">
					<span class="text-4xl font-bold text-blue-600">
						€
						{{ number_format($product->price, 2) }}
					</span>
				</div>

				<div class="mb-6">
					<h2 class="text-lg font-semibold text-white mb-2">Description</h2>
					<p
						class="text-blue-100 leading-relaxed">{{ $product->description }}
					</p>
				</div>

				@if($product->tags->count() > 0)
					<div class="mb-6">
						<h2 class="text-lg font-semibold text-white mb-3">Tags</h2>
						<div class="flex flex-wrap gap-2">
							@foreach($product->tags as $tag)
								<span
									class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-white/20 text-white hover:bg-white/30 transition-colors">{{ $tag->name }}
								</span>
							@endforeach
						</div>
					</div>
				@endif

				<div class="bg-white/10 backdrop-blur-lg rounded-lg p-6 space-y-4">
					<h2 class="text-xl font-bold text-white mb-4">Product Details</h2>

					@if($product->piece_count)
						<div class="flex justify-between items-center border-b border-white/20 pb-3">
							<span class="text-blue-200 font-medium">🧱 Piece Count</span>
							<span
								class="text-white font-semibold">
								{{ number_format($product->piece_count) }}
								pieces</span>
						</div>
					@endif

					@if($product->release_date)
						<div class="flex justify-between items-center border-b border-white/20 pb-3">
							<span class="text-blue-200 font-medium">📅 Release Date</span>
							<span class="text-white font-semibold">{{ $product->release_date->format('F Y') }}</span>
						</div>
					@endif

					<div class="flex justify-between items-center border-b border-white/20 pb-3">
						<span class="text-blue-200 font-medium">🏷️ Condition</span>
						<span class="text-white font-semibold capitalize">{{ $product->condition }}</span>
					</div>

					<div class="flex justify-between items-center">
						<span class="text-blue-200 font-medium">📦 Availability</span>
						<span class="text-white font-semibold">@if($product->stock > 0)
							{{ $product->stock }}
							unit(s) in stock
						@else
															<span class="text-red-400"> Out of stock</span>
														@endif
						</span>
					</div>
				</div>

				<div
					class="mt-8">
					@if($product->stock > 0)
						<form action="{{ route('cart.add', $product->id) }}" method="POST">
							@csrf
							<button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg transition-colors duration-200 transform hover:scale-105">
								Add to Cart
							</button>
						</form>
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

