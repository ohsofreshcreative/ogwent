<!--- complex -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-complex relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-x-8 gap-y-14">

			<h2 data-gsap-element="header" class="">{{ $g_complex['header'] }}</h2>

			<div data-gsap-element="txt" class="__txt mt-4">
				{!! $g_complex['text'] !!}
			</div>

			@if (!empty($g_complex['image']))
			<figure data-gsap-element="img" class="__img h-full overflow-hidden">
				<picture>
					<img
						class="w-full h-full min-h-130 object-cover"
						src="{{ $g_complex['image']['url'] }}"
						alt="{{ $g_complex['image']['alt'] }}"
						loading="lazy" />
				</picture>
			</figure>
			@endif

			<div class="__cards flex flex-1 flex-col gap-4">
				@foreach ($r_complex as $item)
				<a href="{{ $item['button']['url'] }}">
					<div data-gsap-element="card" class="__card relative bg-white px-6 py-2 flex items-center gap-4 h-full b-shadow">
						@if (!empty($item['image']['url']))
						<div class="__img w-10 h-10">
						<img class="h-full" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
						</div>
						@endif
						@if (!empty($item['header']))
						<p class="text-lg !font-semibold text-primary mb-3">{{ $item['header'] }}</p>
						@endif
					</div>
				</a>
				@endforeach
			</div>

		</div>
	</div>

</section>