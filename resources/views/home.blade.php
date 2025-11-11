<x-layout>
	<x-slot:seo>
		<x-seo title="Home"
			description="Welcome to our LEGO resale webshop. Discover high-quality LEGO sets at competitive prices with a seamless shopping experience."
			:schema="[
		'@context' => 'https://schema.org',
		'@type' => 'WebSite',
		'name' => config('app.name'),
		'url' => url('/'),
		'description' => 'LEGO resale webshop offering quality LEGO sets',
		'potentialAction' => [
			'@type' => 'SearchAction',
			'target' => [
				'@type' => 'EntryPoint',
				'urlTemplate' => url('/webshop') . '?search={search_term_string}'
			],
			'query-input' => 'required name=search_term_string'
		]
	]" />
	</x-slot:seo>
	<div class="space-y-8">
		<div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 md:p-12">
			<h1 class="text-4xl md:text-5xl font-bold text-blue-300 mb-4 animate-fade-in">
				Welcome to our Webshop!
			</h1>
			<p class="text-xl text-blue-200 mb-6">
				Discover our amazing products and enjoy a seamless shopping experience.
			</p>
			<a href="/webshop"
				class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold px-8 py-3 rounded-lg shadow-lg border-2 border-white/30 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:border-white/60 hover:from-blue-600 hover:to-purple-700">
				Start Shopping
			</a>
		</div>

		<div class="grid md:grid-cols-2 gap-6">
			<div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl p-6">
				<h2 class="text-2xl font-bold text-blue-300 mb-3 flex items-center gap-2">
					<svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M13 10V3L4 14h7v7l9-11h-7z" />
					</svg>
					About Us
				</h2>
				<p class="text-blue-100 leading-relaxed">
					Hello! I&apos;m Arno, a junior developer currently studying at
					Arteveldehogeschool. <br /> I created this webshop as part of my datamanagement course exam project.
					Here I learned PHP for the first time, we also learned how to use Artisan and Laravel. <br />
					I learned a lot in this project and i was also excited to learn PHP for the first time, so this
					project was very fun to make for me.
				</p>
			</div>

			<div class="bg-white/10 backdrop-blur-lg rounded-xl shadow-xl p-6">
				<h2 class="text-2xl font-bold text-blue-300 mb-3 flex items-center gap-2">
					<svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
					</svg>
					Project Info
				</h2>
				<p class="text-blue-100 leading-relaxed">
					- Framework: Laravel 12 <br />
					- PHP: 8.2+ <br />
					- Database: MariaDB <br />
					- Admin Panel: Filament 4.0 <br />
					- Payment: Mollie API <br />
					- Frontend: Tailwind CSS, Vite <br />
					- Development Environment: DDEV
				</p>
			</div>
		</div>
	</div>
</x-layout>