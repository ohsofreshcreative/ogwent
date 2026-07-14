<!--- cta -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cta relative -smt overflow-hidden' , {{-- Usunięto zaokrąglenie p-cta na PC, żeby szło od brzegu do brzegu --}}
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper relative py-12 md:py-40">

		@if (!empty($g_cta['image']['url']))
		<figure class="absolute inset-0 z-0 m-0 overflow-hidden">
			<picture>
				<source
					media="(max-width: 767px)"
					srcset="{{ $g_cta['image']['sizes']['medium_large'] ?? $g_cta['image']['url'] }}"
					width="{{ $g_cta['image']['sizes']['medium_large-width'] ?? '' }}"
					height="{{ $g_cta['image']['sizes']['medium_large-height'] ?? '' }}" />
				<source
					media="(min-width: 768px)"
					srcset="{{ $g_cta['image']['sizes']['large'] ?? $g_cta['image']['url'] }}"
					width="{{ $g_cta['image']['sizes']['large-width'] ?? '' }}"
					height="{{ $g_cta['image']['sizes']['large-height'] ?? '' }}" />
				<img
					src="{{ $g_cta['image']['url'] }}"
					alt="{{ $g_cta['image']['alt'] ?? '' }}"
					width="{{ $g_cta['image']['width'] ?? '' }}"
					height="{{ $g_cta['image']['height'] ?? '' }}"
					loading="lazy"
					class="w-full h-full object-cover object-center" />
			</picture>
		</figure>
		@endif

		<div class="absolute inset-0 z-10" style="background-image: linear-gradient(rgba(1,0,61,0.56), rgba(1,0,61,0.56));"></div>

		<div class="c-main relative z-20">
			<div class="__inside px-6 md:px-0">

				<div class="__content max-w-2xl">
					@if (!empty($g_cta['title']))
					<p data-gsap-element="title" class="__title m-title">{{ $g_cta['title'] }}</p>
					@endif
					@if ($g_cta['header'])
					<h2 data-gsap-element="header" class="m-header text-white">{{ $g_cta['header'] }}</h2>
					@endif
					@if ($g_cta['txt'])
					<div data-gsap-element="txt" class="text-white">{!! $g_cta['txt'] !!}</div>
					@endif
				</div>

				<div class="inline-buttons m-btn flex flex-col sm:flex-row gap-4 w-full sm:w-auto shrink-0">
					@if (!empty($g_cta['button1']))
					<x-button
						:href="$g_cta['button1']['url']"
						variant="secondary"
						class="w-full sm:w-auto text-center justify-center"
						data-gsap-element="btn">
						{{ $g_cta['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_cta['button2']))
					<x-button
						:href="$g_cta['button2']['url']"
						variant="white"
						class="w-full sm:w-auto text-center justify-center"
						data-gsap-element="btn">
						{{ $g_cta['button2']['title'] }}
					</x-button>
					@endif
				</div>
			</div>
		</div>

	</div>

</section>