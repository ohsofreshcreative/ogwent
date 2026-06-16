<!-- hero --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-hero relative -spt overflow-visible' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class=" __wrapper c-main grid grid-cols-1 md:grid-cols-2 items-center gap-10">
		<div class="__content relative flex flex-col justify-center z-20 pt-10 pb-10 md:py-30">
			<h1 data-gsap-element="header" class="m-header">
				{{ $g_hero['title'] }}
			</h1>
			<div data-gsap-element="text" class="">
				{!! $g_hero['text'] !!}
			</div>

			<div class="inline-buttons m-btn">
				@if (!empty($g_hero['button1']))
				<x-button
					:href="$g_hero['button1']['url']"
					variant="primary"
					class=""
					data-gsap-element="btn">
					{{ $g_hero['button1']['title'] }}
				</x-button>
				@endif

				@if (!empty($g_hero['button2']))
				<x-button
					:href="$g_hero['button2']['url']"
					variant="secondary"
					class=""
					data-gsap-element="btn">
					{{ $g_hero['button2']['title'] }}
				</x-button>
				@endif
			</div>
		</div>

		<div class="__img relative z-20 overflow-visible">
			<img src="{{ $g_hero['image']['url'] }}" alt="{{ $g_hero['image']['alt'] }}"
				class="" />
		</div>
	</div>

</section>