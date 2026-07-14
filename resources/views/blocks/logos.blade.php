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
		<div class="w-full md:w-1/2">
			@if (!empty($g_logos['title']))
			<p data-gsap-element="title" class="__title m-title">{{ $g_logos['title'] }}</p>
			@endif
			@if (!empty($g_logos['header']))
			<h2 data-gsap-element="header" class="w-full">{{ $g_logos['header'] }}</h2>
			@endif
		</div>
	</div>

	@if (!empty($g_logos['gallery']))
	<div class="logos-marquee-wrapper mt-20 overflow-hidden">
	<div class="logos-track flex flex-nowrap items-center gap-8">
			@foreach ($g_logos['gallery'] as $image)
			<div class="logos-item flex-shrink-0 bg-white flex items-center justify-center p-4">
				<img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="max-h-16 w-auto">
			</div>
			@endforeach
			@foreach ($g_logos['gallery'] as $image)
			<div class="logos-item flex-shrink-0 bg-white flex items-center justify-center p-4">
				<img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="max-h-16 w-auto">
			</div>
			@endforeach
		</div>
	</div>
	@endif

</section>