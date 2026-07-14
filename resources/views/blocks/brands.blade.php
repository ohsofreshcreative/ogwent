<!--- brands -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-brands relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20">

			@if (!empty($g_brands['gallery']))
			<div class="">
				<div class="logos-track grid grid-cols-2 md:grid-cols-3 items-center gap-8">
					@foreach ($g_brands['gallery'] as $image)
					<div class="logos-item bg-white border border-gray-200 flex items-center justify-center h-24 p-4">
						<img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="max-h-16 w-auto">
					</div>
					@endforeach
				</div>
			</div>
			@endif

			<div class="__brands order-2">
				@if (!empty($g_brands['title']))
				<p data-gsap-element="title" class="__title m-title">{{ $g_brands['title'] }}</p>
				@endif
				<h2 data-gsap-element="header" class="text-h4">{{ $g_brands['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt mt-4">
					{!! $g_brands['text'] !!}
				</div>

				@if (!empty($g_brands['button1']) || !empty($g_brands['button2']))
				<div class="inline-buttons m-btn">
					@if (!empty($g_brands['button1']))
					<x-button
						:href="$g_brands['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_brands['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_brands['button2']))
					<x-button
						:href="$g_brands['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_brands['button2']['title'] }}
					</x-button>
					@endif
				</div>
				@endif

			</div>

		</div>
	</div>

</section>