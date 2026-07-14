<!--- content -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-content relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20">

			@if (!empty($g_content['image']))
			<figure data-gsap-element="img" class="__img h-full order-1 overflow-hidden">
				<picture>
					<img
						class="w-full h-full min-h-130 object-cover"
						src="{{ $g_content['image']['url'] }}"
						alt="{{ $g_content['image']['alt'] }}"
						loading="lazy" />
				</picture>
			</figure>
			@endif

			<div class="__content order-2">
				@if (!empty($g_content['title']))
				<p data-gsap-element="title" class="__title m-title">{{ $g_content['title'] }}</p>
				@endif
				<h2 data-gsap-element="header" class="text-h4">{{ $g_content['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt mt-4">
					{!! $g_content['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_content['button1']))
					<x-button
						:href="$g_content['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_content['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_content['button2']))
					<x-button
						:href="$g_content['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_content['button2']['title'] }}
					</x-button>
					@endif
				</div>

			</div>

		</div>
	</div>

</section>