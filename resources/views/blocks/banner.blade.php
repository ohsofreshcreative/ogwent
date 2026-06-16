@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- banner --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-banner relative {{ $sectionClass }} {{ $section_class }}">

	<div class=" __wrapper relative" style="background-image:linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ $g_banner['image']['url'] }}'); background-size:cover; background-position:center;">
		<div class="__inside c-main relative">
			<div class="__content py-20">

				<div>
					<h1 data-gsap-element="header" class=" text-white">
						{!! $g_banner['header'] !!}
					</h1>
					<div data-gsap-element="txt" class="text-lg text-white mt-2 w-full md:w-1/2">
						{!! $g_banner['text'] !!}
					</div>
					@if (!empty($g_banner['button1']))
					<div class="inline-buttons m-btn">
						@if (!empty($g_banner['button1']))
						<x-button
							:href="$g_banner['button1']['url']"
							variant="primary"
							class=""
							data-gsap-element="btn">
							{{ $g_banner['button1']['title'] }}
						</x-button>
						@endif

						@if (!empty($g_banner['button2']))
						<x-button
							:href="$g_banner['button2']['url']"
							variant="secondary"
							class=""
							data-gsap-element="btn">
							{{ $g_banner['button2']['title'] }}
						</x-button>
						@endif
					</div>
					@endif
				</div>
			</div>
		</div>

</section>