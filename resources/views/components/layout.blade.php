<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

		<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 flex flex-col">
		<header class="bg-white/95 backdrop-blur-lg shadow-lg sticky top-0 z-50">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center py-4">
					<div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
						{{ config('app.name', 'Webshop AVSWorks') }}
					</div>

					{{-- Mobile menu button --}}
					<button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" id="mobile-menu-button">
						<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-icon">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
						</svg>
						<svg class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="close-icon">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
						</svg>
					</button>

					{{-- Desktop navigation --}}
					<nav class="hidden md:block">
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
									@php
										$cart = session()->get('cart', []);
										$cartCount = array_sum($cart);
									@endphp
									@if($cartCount > 0)
										<span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg">
											{{ $cartCount > 9 ? '9+' : $cartCount }}
										</span>
									@endif
									<span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-300 group-hover:w-4/5 transform -translate-x-1/2"></span>
								</a>
							</li>
						</ul>
					</nav>
				</div>

				{{-- Mobile navigation menu --}}
				<div class="md:hidden hidden pb-4" id="mobile-menu">
					<ul class="space-y-2">
						<li>
							<a href="/" class="block px-4 py-3 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all">
								Home
							</a>
						</li>
						<li>
							<a href="/webshop" class="block px-4 py-3 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all">
								Webshop
							</a>
						</li>
						<li>
							<a href="/cart" class="block px-4 py-3 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all relative">
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
			// Mobile menu toggle
			document.addEventListener('DOMContentLoaded', function() {
				const menuButton = document.getElementById('mobile-menu-button');
				const mobileMenu = document.getElementById('mobile-menu');
				const menuIcon = document.getElementById('menu-icon');
				const closeIcon = document.getElementById('close-icon');

				if (menuButton) {
					menuButton.addEventListener('click', function() {
						mobileMenu.classList.toggle('hidden');
						menuIcon.classList.toggle('hidden');
						closeIcon.classList.toggle('hidden');
					});
				}
			});
		</script>

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

