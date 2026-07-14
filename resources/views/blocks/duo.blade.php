<!--- duo -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-duo relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-3 items-center gap-8 lg:gap-20">

			@if (!empty($g_duo['image']))
			<figure data-gsap-element="img" class="__img h-full order-3 overflow-hidden">
				<picture>
					<img
						class="w-full h-full min-h-130 object-cover"
						src="{{ $g_duo['image']['url'] }}"
						alt="{{ $g_duo['image']['alt'] }}"
						loading="lazy" />
				</picture>
			</figure>
			@endif

			@if (!empty($g_duo['image2']))
			<figure data-gsap-element="img" class="__img h-full order-2 overflow-hidden">
				<picture>
					<img
						class="w-full h-full min-h-130 object-cover"
						src="{{ $g_duo['image2']['url'] }}"
						alt="{{ $g_duo['image2']['alt'] }}"
						loading="lazy" />
				</picture>
			</figure>
			@endif

			<div class="__content order-1">
				@if (!empty($g_duo['title']))
				<p data-gsap-element="title" class="__title m-title">{{ $g_duo['title'] }}</p>
				@endif
				<h2 data-gsap-element="header" class="text-h4">{{ $g_duo['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt mt-4">
					{!! $g_duo['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_duo['button1']))
					<x-button
						:href="$g_duo['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_duo['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_duo['button2']))
					<x-button
						:href="$g_duo['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_duo['button2']['title'] }}
					</x-button>
					@endif
				</div>

			</div>

		</div>
	</div>

</section>