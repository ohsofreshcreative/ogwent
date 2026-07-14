<!-- hero --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-hero relative overflow-hidden' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	@if (!empty($g_hero['image']['url']))
	<figure class="absolute inset-0 z-0 m-0 overflow-hidden">
		<picture>
			<source
				media="(max-width: 767px)"
				srcset="{{ $g_hero['image']['sizes']['medium_large'] }}"
				width="{{ $g_hero['image']['sizes']['medium_large-width'] }}"
				height="{{ $g_hero['image']['sizes']['medium_large-height'] }}" />
			<source
				media="(min-width: 768px)"
				srcset="{{ $g_hero['image']['sizes']['large'] }}"
				width="{{ $g_hero['image']['sizes']['large-width'] }}"
				height="{{ $g_hero['image']['sizes']['large-height'] }}" />
			<img
				src="{{ $g_hero['image']['url'] }}"
				alt="{{ $g_hero['image']['alt'] }}"
				width="{{ $g_hero['image']['width'] }}"
				height="{{ $g_hero['image']['height'] }}"
				loading="eager"
				decoding="async"
				fetchpriority="high"
				class="bg w-full h-full object-cover object-center" />
		</picture>
	</figure>
	@endif

	<div class="absolute inset-0 z-10 bg-primary/56"></div>



	<div class="__wrapper c-main grid grid-cols-1 md:grid-cols-2 items-center gap-10">


		<div class="__content relative flex flex-col justify-center z-30 pt-60 pb-40">
			<h1 data-gsap-element="header" class="m-header text-white [&_strong]:!text-secondary-50">
				{!! strip_tags($g_hero['header'], '<strong><em><a><br>') !!}
			</h1>
			<div data-gsap-element="text" class="text-white">
				{!! $g_hero['text'] !!}
			</div>
			                 <!-- INTERAKTYWNY KAFEL LIQUID GLASS Z TILTEM -->
            <div 
                x-data="{ 
                    tiltX: 0, 
                    tiltY: 0,
                    handleMouseMove(e) {
                        const rect = $el.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        const xc = rect.width / 2;
                        const yc = rect.height / 2;
                        // Lekkie wychylenie w zakresie -10 do 10 stopni
                        this.tiltX = -(x - xc) / (rect.width / 15);
                        this.tiltY = (y - yc) / (rect.height / 15);
                        
                        // Wymuszenie odświeżenia tekstury WebGL przy ruchu myszą nad kafelkiem
                        window.dispatchEvent(new CustomEvent('liquid-refresh'));
                    },
                    resetTilt() {
                        this.tiltX = 0;
                        this.tiltY = 0;
                        window.dispatchEvent(new CustomEvent('liquid-refresh'));
                    }
                }"
                @mousemove="handleMouseMove($event)"
                @mouseleave="resetTilt()"
                :style="`transform: perspective(1000px) rotateX(${tiltY}deg) rotateY(${tiltX}deg); transition: transform 0.15s ease-out;`"
                class="liquid-glass liquid-glass--card my-6 relative cursor-default">
                
                <div class="liquid-glass__content">
                    <h3 class="text-white text-xl font-bold">Nowoczesne strony internetowe</h3>
                    <p class="text-white/80 text-sm mt-1">
                        Projektujemy i wdrażamy strony oparte na WordPressie i Sage 11.
                    </p>
                </div>
            </div>
			<div class="inline-buttons m-btn">
				@if (!empty($g_hero['button1']))
				<x-button
					:href="$g_hero['button1']['url']"
					variant="secondary"
					class=""
					data-gsap-element="btn">
					{{ $g_hero['button1']['title'] }}
				</x-button>
				@endif

				@if (!empty($g_hero['button2']))
				<x-button
					:href="$g_hero['button2']['url']"
					variant="white"
					class=""
					data-gsap-element="btn">
					{{ $g_hero['button2']['title'] }}
				</x-button>
				@endif
			</div>
		</div>
	</div>

</section>