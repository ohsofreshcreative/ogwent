@php
use App\Walkers\DropdownWalker;
use App\Walkers\MobileDropdownWalker;
@endphp

<header x-data="{ mobileOpen: false }" class="relative top-0 z-50 bg-primary masthead fixed-top">
	<!-- Desktop Header -->


	<div class="relative items-center justify-between hidden h-full py-4 px-12 mx-auto md:flex md:flex-col">

		<div class="c-main flex items-center justify-between gap-4">
			<a class="brand shrink-0" href="{{ home_url('/') }}">
				@if ($logo)
				<img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12">
				@else
				<span class="text-xl font-bold">{{ $siteName }}</span>
				@endif
			</a>
			<div x-data="productSearch()" @click.away="searchResults = []" class="relative max-w-1/2 w-full">

				{{-- Zoptymalizowany podkład zamiast ciężkiego x-glass-effect --}}
				<div class="bg-white border rounded-full">
					<form role="search"
						method="get"
						action="{{ home_url('/') }}"
						class="flex items-stretch gap-2 p-1 relative">
						<button type="submit"
							class="rounded-full p-3 font-semibold bg-secondary hover:bg-secondary-hover transition text-white">
							<img src="{{ get_template_directory_uri() }}/resources/images/magnifier.svg" alt="Szukaj" />
						</button>
						<label for="hero-search" class="sr-only text-white">Szukaj produktów</label>
						<div class="relative flex-1">
							<input id="hero-search"
								type="search"
								name="s"
								placeholder="Szukaj produktów…"
								class="w-full rounded-xl px-4 py-3 pr-10 text-primary bg-transparent border-none focus:outline-none"
								required
								autocomplete="off"
								x-model="searchQuery"
								@input.debounce.300ms="searchProducts">

							<button
								type="button"
								@click="searchQuery = ''; searchResults = []"
								x-show="searchQuery.length"
								class="absolute top-1/2 -translate-y-1/2 right-3 p-1 text-white hover:text-gray-300 transition-colors">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
									<path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"></path>
								</svg>
							</button>
						</div>
						<input type="hidden" name="post_type" value="product">


					</form>
				</div>

				{{-- Wyniki wyszukiwania — płaski, elegancki kontener z głębokim cieniem --}}
				<div x-show="searchResults.length" x-transition style="display: none;">
					<div class="absolute top-full left-0 right-0 mt-2 z-50 rounded-2xl bg-primary border border-white/20 p-2 overflow-hidden shadow-2xl">
						<ul class="max-h-[13.5rem] overflow-y-auto custom-scrollbar">
							<template x-for="product in searchResults" :key="product.id">
								<li class="group border-b border-white/10 last:border-b-0">
									<a :href="product.url" class="flex items-center gap-3 p-3 hover:bg-black/20 transition-colors duration-150 rounded-lg">
										<img :src="product.image" :alt="product.title" class="w-10 h-10 object-cover rounded-md shrink-0">
										<span class="font-semibold text-sm text-white" x-text="product.title"></span>
									</a>
								</li>
							</template>
						</ul>
					</div>
				</div>
			</div>
		<div class="__action flex items-center gap-4">
             @if (function_exists('wc_get_page_id'))
                 <a href="{{ get_permalink(wc_get_page_id('myaccount')) }}" class="hover:opacity-80 transition-opacity">
                     <img src="{{ get_template_directory_uri() }}/resources/images/user.svg" alt="Moje konto" />
                 </a>
             @else
                 <img src="{{ get_template_directory_uri() }}/resources/images/user.svg" alt="Użytkownik" />
             @endif

             @if (function_exists('WC'))
             <a href="{{ wc_get_cart_url() }}" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative hover:opacity-80 transition-opacity cart-custom-location-desktop">
                     <img src="{{ get_template_directory_uri() }}/resources/images/cart.svg" alt="Koszyk" />
                     @if (WC()->cart && WC()->cart->get_cart_contents_count() > 0)
                         <span class="absolute -top-2 -right-2 bg-secondary text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full cart-count">
                             {{ WC()->cart->get_cart_contents_count() }}
                         </span>
                     @endif
                 </a>
             @else
                 <img src="{{ get_template_directory_uri() }}/resources/images/cart.svg" alt="Koszyk" />
             @endif
         </div>
		</div>

		@if (has_nav_menu('primary_navigation'))
		<nav class="c-main ml-6 lg:ml-15 nav-primary w-full border-t border-primary-100/40 pt-4 relateive z-20" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
			{!! wp_nav_menu([
			'theme_location' => 'primary_navigation',
			'menu_class' => 'nav flex w-full gap-x-3 lg:gap-x-6 text-lg font-medium items-center',
			'container' => false,
			'echo' => false,
			'walker' => new DropdownWalker(),
			]) !!}
		</nav>
		@endif
	</div>

	<!-- Mobile Header Bar -->
	 <div class="flex items-center justify-between p-4 mobile-menu fixed-top md:hidden">
     <a class="brand shrink-0" href="{{ home_url('/') }}">
         @if ($logo)
         <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12">
         @else
         <span class="text-lg font-bold">{{ $siteName }}</span>
         @endif
     </a>
     
     <div class="flex items-center gap-3">
         {{-- Mobilna ikonka koszyka ze zdarzeniem otwarcia Drawera --}}
         @if (function_exists('WC'))
            <a href="{{ wc_get_cart_url() }}" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative p-2 text-white hover:opacity-80 transition-opacity cart-custom-location-mobile">
                 <img src="{{ get_template_directory_uri() }}/resources/images/cart.svg" class="w-6 h-6" alt="Koszyk" />
                 @if (WC()->cart && WC()->cart->get_cart_contents_count() > 0)
                     <span class="absolute top-1 right-1 bg-secondary text-primary text-[9px] font-bold w-4.5 h-4.5 flex items-center justify-center rounded-full cart-count">
                         {{ WC()->cart->get_cart_contents_count() }}
                     </span>
                 @endif
             </a>
         @endif

         <button
             @click.stop="mobileOpen = !mobileOpen"
             class="p-2 primary bg-white rounded-md text-primary"
             aria-expanded="mobileOpen"
             aria-controls="mobile-menu-panel">
             <span class="sr-only">Otwórz menu główne</span>
             <svg x-show="!mobileOpen" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
             </svg>
             <svg x-show="mobileOpen" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" style="display: none;">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
             </svg>
         </button>
     </div>
 </div>

	<!-- Mobile Menu Panel -->
	<div
		id="mobile-menu-panel"
		x-show="mobileOpen"
		@click.away="mobileOpen = false"
		@keydown.escape.window="mobileOpen = false"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 transform translate-x-full"
		x-transition:enter-end="opacity-100 transform translate-x-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 transform translate-x-0"
		x-transition:leave-end="opacity-0 transform translate-x-full"
		class="mobile-menu fixed top-0 right-0 bottom-0 w-full h-full bg-primary shadow-xl z-[51] overflow-y-auto md:hidden"
		aria-label="Menu mobilne">
		<div class="p-4 relative z-10">
			<div class="flex items-center justify-between mb-6">
				<span class=""><a class="brand shrink-0" href="{{ home_url('/') }}"><img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12"></a></span>
				<button
					@click="mobileOpen = false"
					class="p-2 text-white rounded-md">
					<span class="sr-only">Zamknij menu</span>
					<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			@if (has_nav_menu('primary_navigation'))
			<nav class="flex flex-col space-y-1 mt-20">
				{!! wp_nav_menu([
				'theme_location' => 'primary_navigation',
				'menu_class' => 'nav-mobile flex flex-col space-y-2',
				'container' => false,
				'echo' => false,
				'walker' => new MobileDropdownWalker(),
				]) !!}
			</nav>
			@endif

			<div class="mt-8">
				<a href="/kontakt/" class="block w-full btn btn-secondary">
					Kontakt
				</a>
			</div>
		</div>

	</div>
</header>