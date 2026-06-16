<!--- cta -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cta relative c-main -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper py-12" style="background-image:linear-gradient(rgba(19,42,35,0.7), rgba(13, 63, 47,0.7)), url('{{ $g_cta['image']['url'] }}'); background-size:cover; background-position:center;">

		<div class="__inside items-center gap-6 px-12">
			<div class="__content">
				@if ($g_cta['header'])
				<p data-gsap-element="header" class="text-h5 text-white">{{ $g_cta['header'] }}</p>
				@endif
				@if ($g_cta['txt'])
				<div data-gsap-element="txt" class="text-secondary text-xl mt-1">{!! $g_cta['txt'] !!}</div>
				@endif
			</div>

			<div class="inline-buttons m-btn">
				@if (!empty($g_cta['button1']))
				<x-button
					:href="$g_cta['button1']['url']"
					variant="primary"
					class=""
					data-gsap-element="btn">
					{{ $g_cta['button1']['title'] }}
				</x-button>
				@endif

				@if (!empty($g_cta['button2']))
				<x-button
					:href="$g_cta['button2']['url']"
					variant="secondary"
					class=""
					data-gsap-element="btn">
					{{ $g_cta['button2']['title'] }}
				</x-button>
				@endif
			</div>
		</div>

	</div>

</section>