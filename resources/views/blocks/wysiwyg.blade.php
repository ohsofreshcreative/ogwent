<!--- wysiwyg -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-wysiwyg relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		@if (!empty($g_wysiwyg['header']))
		<h2 data-gsap-element="header" class="">{{ $g_wysiwyg['header'] }}</h2>
		@endif

		<div data-gsap-element="txt" class="__txt mt-4">
			{!! $g_wysiwyg['txt'] !!}
		</div>

		@if (!empty($g_wysiwyg['button']))
		<x-button
			:href="$g_wysiwyg['button']['url']"
			variant="primary"
			class="mt-6"
			data-gsap-element="btn">
			{{ $g_wysiwyg['button']['title'] }}
		</x-button>
		@endif
	</div>

</section>