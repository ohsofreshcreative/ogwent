<!--- categories --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-categories relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top grid grid-cols-1 lg:grid-cols-2 items-end justify-between gap-8 lg:gap-20">
			<div class="__content">
				@if (!empty($g_categories['title']))
				<p data-gsap-element="title" class="__title m-title">{{ $g_categories['title'] }}</p>
				@endif
				<h2 data-gsap-element="header" class="">{{ strip_tags($g_categories['header']) }}</h2>
				@if (!empty($g_categories['text']))
				<p data-gsap-element="text" class="mt-6">{{ $g_categories['text'] }}</p>
				@endif
			</div>
			<x-button
				href="/kategoria-produktu/produkty/"
				variant="underline"
				class="ml-auto mb-2"
				data-gsap-element="btn">
				Zobacz wszystkie produkty
			</x-button>
		</div>




		@if (!empty($r_categories))
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mt-10">
			@foreach ($r_categories as $item)
			<a
				data-gsap-element="card"
				href="{{ $item['link'] }}"
				class="__card group relative bg-white px-8 py-12 block text-center b-shadow">

				<div class="bg-secondary transition-all duration-1000 w-12 h-12 absolute top-2 right-2 flex items-center justify-center text-primary group-hover:text-white group-hover:-top-0 group-hover:-right-0">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path d="M13.027 4.43847L1.83847 15.627L0 13.7886L11.1886 2.6H1.32707V0H15.627V14.3H13.027V4.43847Z" fill="currentColor" />
					</svg>
				</div>
				@if (!empty($item['image_url']))
				<figure class="p-6 mb-10">
					<img
						src="{{ $item['image_url'] }}"
						alt="{{ $item['image_alt'] }}"
						class="w-full h-auto" />
				</figure>
				@endif
				<p class="text-h6">{{ $item['name'] }}</p>
			</a>
			@endforeach
		</div>
		@endif

	</div>

</section>