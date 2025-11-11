@props(['categories' => [], 'tags' => []])

<form method="GET" class="mb-8">
	<div class="bg-white/95 backdrop-blur-lg rounded-xl p-6 shadow-lg border border-gray-200">
		<div class="flex gap-3 items-center mb-4">
			<div class="flex-1">
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Search for LEGO sets..."
					class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 placeholder-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
			</div>
			<button type="submit"
				class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg border-2 border-white/30 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:border-white/60 hover:from-blue-600 hover:to-purple-700 whitespace-nowrap">{{ $buttonText ?? 'Search' }}
			</button>
		</div>

		<details class="group">
			<summary
				class="cursor-pointer text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-2 mb-3">
				<svg class="w-5 h-5 transition-transform group-open:rotate-90" fill="none" stroke="currentColor"
					viewbox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
				</svg>
				Advanced Filters
			</summary>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-200">
				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
					<select name="category"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="">All Categories</option>
						@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
								{{ $category->name }}
							</option>
						@endforeach
					</select>
				</div>

				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Tag</label>
					<select name="tag"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="">All Tags</option>
						@foreach($tags as $tag)
							<option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}
							</option>
						@endforeach
					</select>
				</div>

				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Condition</label>
					<select name="condition"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="">All Conditions</option>
						<option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
						<option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
						<option value="sealed" {{ request('condition') == 'sealed' ? 'selected' : '' }}>Sealed</option>
					</select>
				</div>

				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
					<select name="sort_by"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest
						</option>
						<option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
						<option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
						<option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Stock</option>
					</select>
				</div>

				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Min Price (€)</label>
					<input type="number" name="min_price" value="{{ request('min_price') }}" step="0.01" min="0"
						placeholder="0.00"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
				</div>

				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Max Price (€)</label>
					<input type="number" name="max_price" value="{{ request('max_price') }}" step="0.01" min="0"
						placeholder="999.99"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
				</div>

				<div>
					<label class="block text-sm font-semibold text-gray-700 mb-2">Order</label>
					<select name="sort_order"
						class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
						<option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
					</select>
				</div>

				<div class="flex items-end">
					<label class="flex items-center cursor-pointer">
						<input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
							class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
						<span class="ml-2 text-sm font-semibold text-gray-700">In Stock Only</span>
					</label>
				</div>
			</div>

			<div class="mt-4 flex justify-end">
				<a href="{{ route('webshop.list') }}"
					class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-semibold border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
					Clear All Filters
				</a>
			</div>
		</details>
	</div>
</form>