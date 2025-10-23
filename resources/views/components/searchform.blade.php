<form class="mb-8">
	<div class="flex gap-3 items-center bg-white/10 backdrop-blur-lg rounded-xl p-4 shadow-lg border border-white/20">
		<div class="flex-1">
			<input type="text" name="search" value="{{ $slot }}" placeholder="Search for LEGO sets..." class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-800 placeholder-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
		</div>
		<button
			type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-black font-semibold rounded-lg border-2 border-white/30 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:border-white/60 hover:from-blue-600 hover:to-purple-700 whitespace-nowrap">{{ $buttonText ?? 'Search' }}
		</button>
	</div>
</form>
