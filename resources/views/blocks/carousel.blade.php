@php
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $nolist ? ' no-list' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? ' wider-gap' : '';

if (!empty($background) && $background !== 'none') {
$sectionClass .= ' ' . $background;
}
@endphp

<!--- carousel --->

<section data-gsap-anim="section" @if(!empty($section_id)) id="{{ $section_id }}" @endif class="b-carousel relative -smt  {{ $sectionClass }} {{ $section_class }}">

	<div class="c-main __top">
		<div class="w-full md:w-1/2">
			@if(!empty($g_carousel['title']))
			<p data-gsap-element="title" class="__title m-title">{{ $g_carousel['title'] }}</p>
			@endif
			@if(!empty($g_carousel['header']))
			<h2 data-gsap-element="header" class="m-header">{{ strip_tags($g_carousel['header']) }}</h2>
			@endif
			@if(!empty($g_carousel['text']))
			<p data-gsap-element="text">{{ $g_carousel['text'] }}</p>
			@endif
		</div>
	</div>

	<div class="__carousel-outer flex flex-col lg:flex-row items-stretch gap-6 pl-6">

		{{-- Kafelek promo --}}
		<div class="__promo-tile relative flex-shrink-0 overflow-hidden w-full lg:w-105 !min-h-80 lg:!min-h-120 flex flex-col justify-end p-12 mb-5">
			@if(!empty($g_carousel['promo_image']['url']))
			<img class="absolute inset-0 w-full h-full object-cover" src="{{ $g_carousel['promo_image']['url'] }}" alt="" />
			<div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(2,0,61,0.2) 0%, rgba(2,0,61,0.85) 100%)"></div>
			@endif
			<div class="relative z-10">
				@if(!empty($g_carousel['promo_title']))
				<p class="text-h4 text-white">{{ $g_carousel['promo_title'] }}</p>
				@endif
				@if(!empty($g_carousel['promo_text']))
				<p class="text-white opacity-90 mt-4">{{ $g_carousel['promo_text'] }}</p>
				@endif
				@if(!empty($g_carousel['promo_btn']['url']) && !empty($g_carousel['promo_btn']['title']))
				<a href="{{ $g_carousel['promo_btn']['url'] }}" class="btn btn-secondary mt-6">{{ $g_carousel['promo_btn']['title'] }}</a>
				@endif
			</div>
		</div>

		{{-- Slider --}}
		<div class="relative overflow-x-hidden overflow-y-visible">
			<div class="swiper slider-carousel h-full !pb-6">
				<div class="swiper-wrapper ml-6">
					@foreach($carousel as $product)
					@php $p = wc_get_product($product->ID); @endphp
					<a href="{{ get_permalink($product->ID) }}" class="swiper-slide __product-card bg-white b-shadow overflow-hidden !flex flex-col h-full p-10">
						<div class="__img flex flex-col items-center justify-center overflow-hidden h-2/3 aspect-square">
							{!! get_the_post_thumbnail($product->ID, 'medium', ['class' => 'w-full object-cover']) !!}
						</div>
						<div class="__content flex flex-col gap-6">
							<p class="!font-semibold line-clamp-3 min-h-18 mb-2">{{ $product->post_title }}</p>
							<div class="text-primary-light text-2xl">{!! $p->get_price_html() !!}</div>
						</div>
					</a>
					@endforeach
				</div>
			</div>
			<div class="__prev slider-carousel-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-secondary hover:bg-secondary-hover hover:text-white h-14 w-14 flex items-center justify-center cursor-pointer transition-all duration-400">
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 13 12" fill="none">
					<path d="M0.270429 5.31498C0.270706 5.31469 0.270937 5.31435 0.27126 5.31406L5.08882 0.281803C5.44973 -0.0951806 6.03348 -0.0937777 6.39273 0.285093C6.75194 0.663916 6.75055 1.27664 6.38964 1.65367L3.15514 5.03226L12.078 5.03226C12.5872 5.03226 13 5.46552 13 6C13 6.53448 12.5872 6.96774 12.078 6.96774L3.15518 6.96774L6.3896 10.3463C6.75051 10.7234 6.75189 11.3361 6.39269 11.7149C6.03344 12.0938 5.44963 12.0951 5.08877 11.7182L0.271213 6.68594C0.270936 6.68565 0.270706 6.68531 0.270383 6.68502C-0.0907122 6.30673 -0.08956 5.69202 0.270429 5.31498Z" fill="currentColor" />
				</svg>
			</div>
			<div class="__next slider-carousel-next absolute right-4 top-1/2 -translate-y-1/2 z-10 bg-secondary hover:bg-secondary-hover h-14 w-14 flex items-center justify-center cursor-pointer transition-all duration-300">
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 13 12" fill="none">
					<path d="M12.7296 5.31498C12.7293 5.31469 12.7291 5.31435 12.7287 5.31406L7.91118 0.281803C7.55027 -0.0951806 6.96652 -0.0937777 6.60727 0.285093C6.24806 0.663916 6.24945 1.27664 6.61036 1.65367L9.84486 5.03226L0.921985 5.03226C0.412773 5.03226 0 5.46552 0 6C0 6.53448 0.412773 6.96774 0.921985 6.96774L9.84482 6.96774L6.6104 10.3463C6.24949 10.7234 6.24811 11.3361 6.60731 11.7149C6.96657 12.0938 7.55037 12.0951 7.91123 11.7182L12.7288 6.68594C12.7291 6.68565 12.7293 6.68531 12.7296 6.68502C13.0907 6.30673 13.0896 5.69202 12.7296 5.31498Z" fill="currentColor" />
				</svg>
			</div>
		</div>

	</div>
</section>