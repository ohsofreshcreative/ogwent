<!--- who --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-who relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top w-full md:w-1/2">
			<p data-gsap-element="title" class="__title m-title">{{ $g_who['title'] }}</p>
			<h2 data-gsap-element="header" class="m-header">{{ strip_tags($g_who['header']) }}</h2>
			<p data-gsap-element="text">{{ $g_who['text'] }}</p>
		</div>

		@if (!empty($r_who))
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">
			@foreach ($r_who as $item)
			<a
				data-gsap-element="card"
				href="{{ $item['button']['url'] ?? '#' }}"
				class="__card group relative bg-white flex flex-col justify-end p-8 overflow-hidden shadow-primary/10 shadow-sm hover:shadow-xl transition-shadow block min-h-110">
				@if (!empty($item['image']['url']))
				<img
					class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
					src="{{ $item['image']['url'] }}"
					alt="{{ $item['image']['alt'] ?? '' }}" />
				<div class="absolute inset-0 transition-opacity duration-500 opacity-80 group-hover:opacity-100" style="background: linear-gradient(90deg, rgba(2, 0, 105, 0.64) 0%, rgba(2, 0, 105, 0.64) 100%)"></div>
				@endif

				<div class="bg-secondary transition-all duration-1000 w-12 h-12 absolute top-2 right-2 flex items-center justify-center text-primary group-hover:text-white group-hover:-top-0 group-hover:-right-0">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path d="M13.027 4.43847L1.83847 15.627L0 13.7886L11.1886 2.6H1.32707V0H15.627V14.3H13.027V4.43847Z" fill="currentColor" />
					</svg>
				</div>

				<div class="relative z-10">
					@if (!empty($item['title']))
					<p class="text-h5 text-white">{{ $item['title'] }}</p>
					@endif
					@if (!empty($item['text']))
					<p class="text-white mt-4">{{ $item['text'] }}</p>
					@endif
				</div>
			</a>
			@endforeach
		</div>
		@endif

	</div>

</section>