<!--- callout -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-callout relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col bg-gradient flex flex-col lg:flex-row p-20 pb-0 lg:pb-20">
			<img class="absolute left-0 top-1/2 -translate-y-1/2 mix-blend-overlay opacity-40" src="http://ogwent.local/wp-content/uploads/2026/06/logo-shape.svg" />

			@if (!empty($g_callout['image']))
			<img class="relative lg:absolute bottom-0 right-0 order-2" src="{{ $g_callout['image']['url'] }}" alt="{{ $g_callout['image']['alt'] ?? '' }}">
			@endif

			<div class="__callout w-full md:w-2/3 order-1">
				<h2 data-gsap-element="header" class="text-h4 text-white">{{ $g_callout['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt text-white mt-4">
					{!! $g_callout['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_callout['button1']))
					<x-button
						:href="$g_callout['button1']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_callout['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_callout['button2']))
					<x-button
						:href="$g_callout['button2']['url']"
						variant="white"
						class=""
						data-gsap-element="btn">
						{{ $g_callout['button2']['title'] }}
					</x-button>
					@endif
				</div>

			</div>

		</div>
	</div>

</section>