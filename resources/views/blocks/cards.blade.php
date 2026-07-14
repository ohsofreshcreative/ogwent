<!--- cards --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cards relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">

		<div class="__top">
			@if (!empty($g_cards['title']))
			<p data-gsap-element="title" class="__title m-title">{{ $g_cards['title'] }}</p>
			@endif
			@if (!empty($g_cards['header']))
			<h2 data-gsap-element="header" class="m-header">{{ strip_tags($g_cards['header']) }}</h2>
			@endif
			@if (!empty($g_cards['text']))
			<p data-gsap-element="text">{{ $g_cards['text'] }}</p>
			@endif
		</div>

		@if (!empty($r_cards))
		@php
		$itemCount = count($r_cards);
		$gridCols = 1;
		if ($itemCount == 2) $gridCols = 2;
		if ($itemCount == 3) $gridCols = 3;
		if ($itemCount >= 4) $gridCols = 4;
		$gridClass = $gridCols > 1 ? 'grid-cols-1 lg:grid-cols-' . $gridCols : 'grid-cols-1';
		@endphp

		<div class="grid {{ $gridClass }} gap-8 mt-10">
			@foreach ($r_cards as $item)
			<div data-gsap-element="card" class="__card relative bg-white p-8 flex flex-col h-full b-shadow">
				@if (!empty($item['image']['url']))
				<img class="mb-6 max-w-[64px] h-auto object-contain" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
				@endif
				@if (!empty($item['title']))
				<p class="text-lg !font-semibold text-primary mb-3">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['text']))
				<p class="text-sm opacity-80 mt-auto">{{ $item['text'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@endif

	</div>

</section>