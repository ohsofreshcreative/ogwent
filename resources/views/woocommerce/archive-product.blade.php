{{--
The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
@php
$term = get_queried_object();
$hero_image = ($term instanceof WP_Term) ? get_field('hero_image', $term) : null;
$hero_header_custom = ($term instanceof WP_Term) ? get_field('hero_header', $term) : null;
$display_header = !empty($hero_header_custom) ? $hero_header_custom : woocommerce_page_title(false);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
do_action('get_header', 'shop');
do_action('woocommerce_before_main_content');

// Pobranie wartości z opcji ACF
$g_values = get_field('g_values', 'option');
$r_values = get_field('r_values', 'option');

// Pobranie opisu kategorii / archiwum
$description = ($term instanceof WP_Term) ? term_description($term->term_id, $term->taxonomy) : '';
@endphp

<header class="b-herosub relative overflow-hidden" {!! empty($hero_image['url']) ? 'style="background: var(--gradient);"' : '' !!}>
	<div class="__wrapper relative">

		@if (!empty($hero_image['url']))
		<figure class="absolute inset-0 z-0 m-0 overflow-hidden">
			<picture>
				<source media="(max-width: 767px)"
					srcset="{{ $hero_image['sizes']['medium_large'] ?? $hero_image['url'] }}" />
				<source media="(min-width: 768px)"
					srcset="{{ $hero_image['sizes']['large'] ?? $hero_image['url'] }}" />
				<img src="{{ $hero_image['url'] }}"
					alt="{{ $hero_image['alt'] ?? '' }}"
					width="{{ $hero_image['width'] ?? '' }}"
					height="{{ $hero_image['height'] ?? '' }}"
					loading="eager" decoding="async" fetchpriority="high"
					class="w-full h-full object-cover object-center" />
			</picture>
		</figure>
		<div class="absolute inset-0 z-10 bg-primary/56"></div>
		@endif

		<svg class="absolute top-1/2 -translate-y-1/2 right-40 z-20" xmlns="http://www.w3.org/2000/svg" width="417" height="858" viewBox="0 0 417 858" fill="none">
			<path d="M412.789 442.393L294.002 853.694L17.2212 777.708L139.04 474.557L139.685 472.952L138.619 471.591L3.40921 298.716L115.51 6.42395L412.789 442.393Z" stroke="#00D5AF" stroke-width="6" />
		</svg>

		<div class="__inside c-main relative z-20">
			<div class="__content w-full md:w-2/3 pt-60 pb-40">
				@if(function_exists('yoast_breadcrumb'))
				<div class="__breadcrumb mb-4">
					{!! yoast_breadcrumb('<p id="breadcrumbs">','</p>') !!}
				</div>
				@endif

				<h1 class="text-white [&_strong]:!text-secondary-50"> {!! strip_tags($hero_header_custom, '<strong><em><a><br>') !!}</h1>
			</div>
		</div>

	</div>
</header>

<div class="c-main flex flex-col lg:flex-row gap-10 py-16">

	{{-- Sidebar z filtrami --}}
	@if (is_active_sidebar('shop-sidebar'))
	<aside class="__shop-sidebar w-full lg:w-1/4">
		@php dynamic_sidebar('shop-sidebar') @endphp
	</aside>
	@endif

	{{-- Produkty --}}
	<div class="__products min-w-0">
		@if (woocommerce_product_loop())
		@php
		do_action('woocommerce_before_shop_loop');
		woocommerce_product_loop_start();
		@endphp

		@if (wc_get_loop_prop('total'))
		@while (have_posts())
		@php
		the_post();
		do_action('woocommerce_shop_loop');
		wc_get_template_part('content', 'product');
		@endphp
		@endwhile
		@endif

		@php
		woocommerce_product_loop_end();
		do_action('woocommerce_after_shop_loop');
		@endphp
		@else
		@php do_action('woocommerce_no_products_found') @endphp
		@endif
	</div>

</div>

{{-- Sekcja z opisem kategorii --}}
@if (!empty($description))
<section class="b-category-desc py-12 bg-[#F9F9FF]">
	<div class="c-main max-w-4xl mx-auto">
		<div class="relative">
			<div id="category-desc-content" class=" max-w-none text-body overflow-hidden transition-all duration-300 max-h-[140px]">
				{!! $description !!}
			</div>

			{{-- Gradient w kolorze tła (#F9F9FF) znikający po rozwinięciu --}}
			<div id="category-desc-gradient" class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-[#F9F9FF] to-transparent pointer-events-none transition-opacity duration-300"></div>
		</div>

		<div class="text-center mt-6">
			<button id="category-desc-toggle" class="inline-flex items-center gap-2 font-semibold text-primary hover:text-secondary transition-colors group">
				<span class="btn-text">Rozwiń opis</span>
				<svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
				</svg>
			</button>
		</div>
	</div>
</section>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const content = document.getElementById('category-desc-content');
		const button = document.getElementById('category-desc-toggle');
		const gradient = document.getElementById('category-desc-gradient');

		if (!content || !button || !gradient) return;

		// Jeżeli wysokość rzeczywista opisu jest mniejsza niż zwiniecie (140px), ukrywamy dodatki
		if (content.scrollHeight <= 140) {
			button.style.display = 'none';
			gradient.style.display = 'none';
			content.style.maxHeight = 'none';
			return;
		}

		button.addEventListener('click', function() {
			const isOpen = content.classList.contains('is-open');
			const arrow = button.querySelector('svg');
			const textSpan = button.querySelector('.btn-text');

			if (isOpen) {
				content.style.maxHeight = '140px';
				content.classList.remove('is-open');
				gradient.classList.remove('opacity-0');
				arrow.classList.remove('rotate-180');
				textSpan.textContent = 'Rozwiń opis';
			} else {
				content.style.maxHeight = content.scrollHeight + 'px';
				content.classList.add('is-open');
				gradient.classList.add('opacity-0');
				arrow.classList.add('rotate-180');
				textSpan.textContent = 'Zwiń opis';
			}
		});
	});
</script>
@endif


<section data-gsap-anim="section" class="b-values relative -smt -spb">

	<div class="__wrapper c-main">

		@if (!empty($r_values))
		@php
		$itemCount = count($r_values);
		$gridCols = 1;
		if ($itemCount == 2) $gridCols = 2;
		if ($itemCount == 3) $gridCols = 3;
		if ($itemCount >= 4) $gridCols = 4;
		$gridClass = $gridCols > 1 ? 'grid-cols-1 lg:grid-cols-' . $gridCols : 'grid-cols-1';
		@endphp

		<div class="grid {{ $gridClass }} gap-8 mt-10">
			@foreach ($r_values as $item)
			<div data-gsap-element="card" class="__card relative bg-white p-8 flex flex-col h-full b-shadow">
				@if (!empty($item['image']['url']))
				<img class="mb-6 !max-w-[64px] h-auto object-contain" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
				@endif
				@if (!empty($item['title']))
				<p class="text-lg !font-semibold text-primary mb-3">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['text']))
				<p class="text-sm opacity-80 mt-auto">{{ $item['text'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@endif

	</div>

</section>