<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name') }}</title>

		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

		@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
    @endif
	</head>

		<body class="h-full bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 flex flex-col"> <header class="bg-white/95 backdrop-blur-lg shadow-lg sticky top-0 z-50">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center py-4">
					<div
						class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ config('app.name', 'Webshop AVSWorks') }}
					</div>
					<nav>
						<ul class="flex gap-6">
							<li>
								<a href="/" class="px-4 py-2 text-blue-600 font-medium rounded-lg transition-all duration-300 hover:text-blue-700 hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow-md relative group">
									Home
									<span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
								</a>
							</li>
							<li>
								<a href="/webshop" class="px-4 py-2 text-blue-600 font-medium rounded-lg transition-all duration-300 hover:text-blue-700 hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow-md relative group">
									Webshop
									<span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
								</a>
							</li>
							<li>
								<a href="/cart" class="px-4 py-2 text-blue-600 font-medium rounded-lg transition-all duration-300 hover:text-blue-700 hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow-md relative group">
									Shopping Cart
									<span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</header>

		<main
			class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">{{ $slot }}
		</main>

		<footer class="bg-white/95 backdrop-blur-lg shadow-lg mt-auto">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
				<p class="text-center text-slate-600">&copy;{{ date('Y') }}
					{{ config('app.name', 'Laravel') }}
				. All rights reserved.
			</p>
		</div>
	</footer>
</body></html>

