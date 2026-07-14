<!doctype html>
<html @php(language_attributes())>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@php(do_action('get_header'))
	@php(wp_head())

	{{-- Fonts --}}
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

	{{-- Styles --}}
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
		integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
		integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body @php(body_class())>
	{{-- Glass distortion SVG filter --}}
	<svg style="display:none" aria-hidden="true">
		<defs>
			<filter id="glass-distort" x="-5%" y="-5%" width="110%" height="110%" color-interpolation-filters="sRGB">
				<feTurbulence type="fractalNoise" baseFrequency="0.022 0.018" numOctaves="2" seed="6" result="noise">
					<animate attributeName="baseFrequency"
						values="0.022 0.018; 0.026 0.022; 0.022 0.018"
						dur="7s" repeatCount="indefinite" />
				</feTurbulence>
				<feDisplacementMap in="SourceGraphic" in2="noise" scale="18"
					xChannelSelector="R" yChannelSelector="G" />
			</filter>
		</defs>
	</svg>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5TV295L"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	@php(wp_body_open())

	<div id="app">

		@include('sections.header')

		@if (function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag()))

		@yield('content')

		@elseif (function_exists('is_woocommerce') && (is_product() || is_cart() || is_checkout() || is_account_page()))

		<main id="main" class="c-main -menu-mt py-10">
			@yield('content')
		</main>

		@else

		<main id="main" class="main -menu-mt">
			@yield('content')
		</main>

		@endif

		@include('sections.footer')
	</div>

    {{-- Załączenie wysuwanego koszyka (Drawer) --}}
    @if (function_exists('WC'))
        @include('partials.cart-drawer')
    @endif

	@php(do_action('get_footer'))
	@php(wp_footer())

</body>

</html>