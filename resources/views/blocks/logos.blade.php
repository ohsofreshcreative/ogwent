<!--- logos -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-logos relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<h4 data-gsap-element="header" class="w-full md:w-1/2">{{ $g_logos['header'] }}</h4>

		@if (!empty($g_logos['gallery']))
		<div class="mt-6 grid grid-cols-2 md:grid-cols-4 items-center gap-6">
			
			@foreach ($g_logos['gallery'] as $image)
			<div class="bg-white flex items-center justify-center p-4">
			<img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="max-h-16 w-auto">
			</div>
			@endforeach
		</div>
		@endif
	</div>

</section>