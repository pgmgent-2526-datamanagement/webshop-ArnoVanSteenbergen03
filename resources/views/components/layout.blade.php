<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	{{ $seo ?? '' }}

	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

	@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	@else
	@endif
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 flex flex-col">
	<header class="bg-white/95 backdrop-blur-lg shadow-lg sticky top-0 z-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between items-center py-4">
				<div
					class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
					{{ config('app.name', 'Webshop AVSWorks') }}
				</div>

				<button type="button"
					class="md:hidden inline-flex items-center justify-center p-2 bg-blue-600 rounded-lg focus:outline-none"
					id="mobile-menu-button">
					<div id="menu-icon" class="w-5 h-4 flex flex-col justify-between">
						<span class="block w-full h-0.5 bg-white rounded"></span>
						<span class="block w-full h-0.5 bg-white rounded"></span>
						<span class="block w-full h-0.5 bg-white rounded"></span>
					</div>
					<svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="white" stroke-width="2"
						viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>

				<nav class="hidden md:block">
					<ul class="flex gap-6">
						<li>
							<a href="/"
								class="px-4 py-2 text-blue-600 font-medium rounded-lg transition-all duration-300 hover:text-blue-700 hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow-md relative group">
								Home
								<span
									class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
							</a>
						</li>
						<li>
							<a href="/webshop"
								class="px-4 py-2 text-blue-600 font-medium rounded-lg transition-all duration-300 hover:text-blue-700 hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow-md relative group">
								Webshop
								<span
									class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
							</a>
						</li>
						<li>
							<a href="/cart"
								class="px-4 py-2 text-blue-600 font-medium rounded-lg transition-all duration-300 hover:text-blue-700 hover:bg-blue-50 hover:-translate-y-0.5 hover:shadow-md relative group">
								Shopping Cart
								@php
									$cart = session()->get('cart', []);
									$cartCount = array_sum($cart);
								@endphp
								@if($cartCount > 0)
									<span
										class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg">
										{{ $cartCount > 9 ? '9+' : $cartCount }}
									</span>
								@endif
								<span
									class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
							</a>
						</li>
					</ul>
				</nav>
			</div>

			<div class="md:hidden hidden pb-4" id="mobile-menu">
				<ul class="space-y-2">
					<li>
						<a href="/"
							class="block px-4 py-3 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all">
							Home
						</a>
					</li>
					<li>
						<a href="/webshop"
							class="block px-4 py-3 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all">
							Webshop
						</a>
					</li>
					<li>
						<a href="/cart"
							class="block px-4 py-3 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all relative">
							Shopping Cart
							@php
								$cart = session()->get('cart', []);
								$cartCount = array_sum($cart);
							@endphp
							@if($cartCount > 0)
								<span class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5">
									{{ $cartCount > 9 ? '9+' : $cartCount }}
								</span>
							@endif
						</a>
					</li>
				</ul>
			</div>
		</div>
	</header>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const menuButton = document.getElementById('mobile-menu-button');
			const mobileMenu = document.getElementById('mobile-menu');
			const menuIcon = document.getElementById('menu-icon');
			const closeIcon = document.getElementById('close-icon');

			if (menuButton) {
				menuButton.addEventListener('click', function () {
					mobileMenu.classList.toggle('hidden');
					menuIcon.classList.toggle('hidden');
					closeIcon.classList.toggle('hidden');
				});
			}
		});
	</script>

	<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">{{ $slot }}
	</main>

	<footer class="bg-white/95 backdrop-blur-lg shadow-lg mt-auto">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
			<p class="text-center text-slate-600">&copy;{{ date('Y') }}
				{{ __('AVSWorks') }}
				. All rights reserved.
			</p>
		</div>
	</footer>
</body>

</html>