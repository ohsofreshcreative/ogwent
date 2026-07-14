<!--- contact --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-contact  relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper relative z-2 py-30">

		@if (!empty($g_contact_1['image']['url']))
		<figure class="absolute inset-0 z-0 m-0 overflow-hidden">
			<picture>
				<source
					media="(max-width: 767px)"
					srcset="{{ $g_contact_1['image']['sizes']['medium_large'] ?? $g_contact_1['image']['url'] }}"
					width="{{ $g_contact_1['image']['sizes']['medium_large-width'] ?? '' }}"
					height="{{ $g_contact_1['image']['sizes']['medium_large-height'] ?? '' }}" />
				<source
					media="(min-width: 768px)"
					srcset="{{ $g_contact_1['image']['sizes']['large'] ?? $g_contact_1['image']['url'] }}"
					width="{{ $g_contact_1['image']['sizes']['large-width'] ?? '' }}"
					height="{{ $g_contact_1['image']['sizes']['large-height'] ?? '' }}" />
				<img
					src="{{ $g_contact_1['image']['url'] }}"
					alt="{{ $g_contact_1['image']['alt'] ?? '' }}"
					width="{{ $g_contact_1['image']['width'] ?? '' }}"
					height="{{ $g_contact_1['image']['height'] ?? '' }}"
					loading="eager"
					decoding="async"
					fetchpriority="high"
					class="w-full h-full object-cover object-center" />
			</picture>
		</figure>
		@endif

		<div class="absolute inset-0 z-10 bg-primary/56"></div>

		<div class="c-main relative grid grid-cols-1 lg:grid-cols-2 items-center gap-10 z-10">
			<div class="__content flex flex-col justify-between gap-6">
				<h1 data-gsap-element="header" class="text-white w-full md:w-2/3">{!! $g_contact_1['header'] !!}</h1>
				<div>
					<a data-gsap-element="txt" class="__phone flex items-center !text-white" href="tel:{{ $g_contact_1['phone'] }}">{{ $g_contact_1['phone'] }}</a>
					<a data-gsap-element="txt" class="__mail flex items-center !text-white" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
				</div>

				<div data-gsap-element="txt" class="text-white">{!! $g_contact_1['data'] !!}</div>
				<div data-gsap-element="txt" class="text-white ">{!! $g_contact_1['hours'] !!}</div>
			</div>

			<div data-gsap-element="form" class="bg-white p-10">
				<h4 class="!text-primary mb-4">{!! $g_contact_2['title'] !!}</h4>
				{!! do_shortcode($g_contact_2['shortcode']) !!}
			</div>
		</div>
	</div>

</section>