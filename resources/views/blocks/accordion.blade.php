<!-- accordion -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-accordion relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="c-main">
		<div class="__wrapper">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 my-10">
				@if (!empty($g_accordion['image']))
				<img data-gsap-element="img" class="__img object-cover order1 h-full radius-img" src="{{ $g_accordion['image']['url'] }}" alt="{{ $g_accordion['image']['alt'] ?? '' }}">
				@endif
				<div class="__content order2">
					<h4 data-gsap-element="header" class="m-header">{{ $g_accordion['title'] }}</h4>
					<div data-gsap-element="txt" class="">{!! $g_accordion['text'] !!}</div>
					@if (!empty($g_accordion['button']))
					<a class="main-btn m-btn" href="{{ $g_accordion['button']['url'] }}">{{ $g_accordion['button']['title'] }}</a>
					@endif
					<div data-gsap-element="accordion" class="accordion-wrapper grid mt-10">
						@foreach ($r_accordion as $item)
						<div class="accordion rounded-2xl bg-white border border-secondary h-max">
							<input class="acc-check" type="radio" name="accordion-radio" id="check{{ $loop->index }}" {{ $loop->first ? 'checked' : '' }}>
							<label class="accordion-label flex items-center justify-between font-semibold text-md md:text-h5 gap-4" for="check{{ $loop->index }}">
								{{ $item['title'] }}
								<x-icon.arrow-up class="__arrow text-secondary w-3 h-4" />
							</label>
							<div class="accordion-content">
								{!! $item['text'] !!}
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>