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
			@if (!empty($g_accordion['title']))
			<h2 data-gsap-element="header" class="m-header">{{ $g_accordion['title'] }}</h2>
			@endif
			<div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1.5fr] gap-8 lg:gap-20 my-10">
				@if (!empty($g_accordion['image']))
				<img
					data-gsap-element="img"
					class="__img w-full h-auto aspect-[4/3] lg:aspect-[4/5] object-cover self-start lg:sticky lg:top-24 order-1"
					src="{{ $g_accordion['image']['url'] }}"
					alt="{{ $g_accordion['image']['alt'] ?? '' }}">
				@endif
				<div class="__content order-2">
					<div data-gsap-element="txt" class="">{!! $g_accordion['text'] !!}</div>
					@if (!empty($g_accordion['button']))
					<a class="main-btn m-btn" href="{{ $g_accordion['button']['url'] }}">{{ $g_accordion['button']['title'] }}</a>
					@endif
					<div data-gsap-element="accordion" class="accordion-wrapper grid">
						@foreach ($r_accordion as $item)
						<div class="accordion border border-secondary h-max">
							<input class="acc-check" type="radio" name="accordion-radio" id="check{{ $loop->index }}" {{ $loop->first ? 'checked' : '' }}>
							<label class="accordion-label flex items-center justify-between font-semibold text-h7 gap-4" for="check{{ $loop->index }}">
								{{ $item['title'] }}
								<span class="__toggle-btn relative flex items-center justify-center w-7 h-7 rounded-lg bg-secondary shrink-0">
									<span class="__line-horizontal absolute w-4 h-0.5 bg-primary rounded-full transition-transform duration-300"></span>
									<span class="__line-vertical absolute h-4 w-0.5 bg-primary rounded-full transition-transform duration-300"></span>
								</span>
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