<!--- promo --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-promo relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top">
			<p data-gsap-element="title" class="__title m-title">{{ $g_promo['title'] }}</p>
			<h2 data-gsap-element="header" class="m-header">{{ strip_tags($g_promo['header']) }}</h2>
			<p data-gsap-element="text">{{ $g_promo['text'] }}</p>
		</div>

		@if (!empty($r_promo))
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">
			@foreach ($r_promo as $item)
			<div data-gsap-element="card" class="__card relative bg-white flex flex-col justify-center p-8 overflow-hidden min-h-64 {{ $loop->first ? 'lg:col-span-2' : '' }}">
				@if (!empty($item['image']['url']))
				<img
					class="absolute inset-0 w-full h-full object-cover"
					src="{{ $item['image']['url'] }}"
					alt="{{ $item['image']['alt'] ?? '' }}" />
				<div class="absolute inset-0" style="background: linear-gradient(90deg, #020069 0%, rgba(2, 0, 105, 0.24) 100%)"></div>
				@endif
				<div class="relative z-10">
					@if (!empty($item['title']))
					<p class="text-h5 text-white">{{ $item['title'] }}</p>
					@endif
					@if (!empty($item['text']))
					<p class="text-white">{{ $item['text'] }}</p>
					@endif
					@if (!empty($item['button']['url']))
					<a href="{{ $item['button']['url'] }}" class="btn btn-secondary-small mt-4">{{ $item['button']['title'] }}</a>
					@endif
				</div>
			</div>
			@endforeach
		</div>
		@endif

	</div>

</section>