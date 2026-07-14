@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- herosub --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-herosub relative overflow-hidden {{ $sectionClass }} {{ $section_class }}">

	<div class="__wrapper relative">

		@if (!empty($g_herosub['image']['url']))
		<figure class="absolute inset-0 z-0 m-0 overflow-hidden">
			<picture>
				<source
					media="(max-width: 767px)"
					srcset="{{ $g_herosub['image']['sizes']['medium_large'] ?? $g_herosub['image']['url'] }}"
					width="{{ $g_herosub['image']['sizes']['medium_large-width'] ?? '' }}"
					height="{{ $g_herosub['image']['sizes']['medium_large-height'] ?? '' }}" />
				<source
					media="(min-width: 768px)"
					srcset="{{ $g_herosub['image']['sizes']['large'] ?? $g_herosub['image']['url'] }}"
					width="{{ $g_herosub['image']['sizes']['large-width'] ?? '' }}"
					height="{{ $g_herosub['image']['sizes']['large-height'] ?? '' }}" />
				<img
					src="{{ $g_herosub['image']['url'] }}"
					alt="{{ $g_herosub['image']['alt'] ?? '' }}"
					width="{{ $g_herosub['image']['width'] ?? '' }}"
					height="{{ $g_herosub['image']['height'] ?? '' }}"
					loading="eager"
					decoding="async"
					fetchpriority="high"
					class="w-full h-full object-cover object-center" />
			</picture>
		</figure>
		@endif

		<div class="absolute inset-0 z-10 bg-primary/56"></div>

		<svg class="absolute top-1/2 -translate-y-1/2 right-40 z-20" xmlns="http://www.w3.org/2000/svg" width="417" height="858" viewBox="0 0 417 858" fill="none">
			<path d="M412.789 442.393L294.002 853.694L17.2212 777.708L139.04 474.557L139.685 472.952L138.619 471.591L3.40921 298.716L115.51 6.42395L412.789 442.393Z" stroke="#00D5AF" stroke-width="6" />
		</svg>

		<div class="__inside c-main relative z-20">
			<div class="__content w-full md:w-2/3 pt-60 pb-40">

				<h1 data-gsap-element="header" class="text-white leading-tight">
					{!! $g_herosub['header'] !!}
				</h1>
				<div data-gsap-element="txt" class="text-base md:text-lg text-white mt-4 w-full md:w-1/2 opacity-90 leading-relaxed">
					{!! $g_herosub['text'] !!}
				</div>

				@if (!empty($g_herosub['button1']))
				<div class="inline-buttons m-btn flex flex-col sm:flex-row gap-4 w-full sm:w-auto mt-8">
					@if (!empty($g_herosub['button1']))
					<x-button
						:href="$g_herosub['button1']['url']"
						variant="primary"
						class="w-full sm:w-auto text-center justify-center"
						data-gsap-element="btn">
						{{ $g_herosub['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_herosub['button2']))
					<x-button
						:href="$g_herosub['button2']['url']"
						variant="secondary"
						class="w-full sm:w-auto text-center justify-center"
						data-gsap-element="btn">
						{{ $g_herosub['button2']['title'] }}
					</x-button>
					@endif
				</div>
				@endif
			</div>
		</div>

	</div>

</section>