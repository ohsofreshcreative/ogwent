<!--- banner --->

<section
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    @class([ 'b-banner c-main relative -smt overflow-hidden' ,
    $sectionClass=> filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
    ])>

    @if(!empty($g_banner['title']))
    <div class="__wrapper block relative z-20 mb-6 md:mb-10">
        <h2 class="text-center text-2xl md:text-h2">{{ $g_banner['title']}}</h2>
    </div>
    @endif

    <div class="relative z-20">
        <div class="swiper banner-slider">
            <div class="swiper-wrapper">
                @foreach($banner as $slide)
                <div class="swiper-slide relative">
                    @if(!empty($slide['bg']))
                    <figure class="absolute inset-0 m-0">
                        <picture>
                            {!! wp_get_attachment_image($slide['bg']['ID'], 'full', false, ['class' => 'w-full h-full object-cover', 'loading' => 'eager']) !!}
                        </picture>
                    </figure>
                    @endif
                    
                    <div class="__content relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center z-10 p-6 md:p-30">
                        {{-- order-2 md:order-1 (tekst ląduje pod zdjęciem na mobile) oraz centrowanie --}}
                        <div class="flex flex-col justify-center items-center text-center md:items-start md:text-left order-2 md:order-1">
                            @if (!empty($slide['title']))
                            <p class="__title m-0 text-sm md:text-base uppercase tracking-wider">{{ $slide['title'] }}</p>
                            @endif
                            @if(!empty($slide['header']))
                            <p class="__header text-h4 md:text-h3 text-white m-0 mt-2">{{ $slide['header'] }}</p>
                            @endif
                            @if (!empty($slide['button']))
                            <div class="mt-6">
                                <x-button
                                    :href="$slide['button']['url']"
                                    variant="secondary"
                                    class="m-btn block">
                                    {{ $slide['button']['title'] }}
                                </x-button>
                            </div>
                            @endif
                        </div>
                        
                        @if(!empty($slide['image']))
                        {{-- order-1 md:order-2 (zdjęcie jest nad tekstem na mobile) --}}
                        <figure class="__image order-1 md:order-2 mt-0 w-full max-w-sm mx-auto md:max-w-none">
                            <picture>
                                {!! wp_get_attachment_image($slide['image']['ID'], 'full', false, ['class' => 'w-full h-auto md:h-full object-contain md:object-cover rounded-lg', 'loading' => 'eager']) !!}
                            </picture>
                        </figure>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        {{-- Strzałka LEWA: Na mobile wewnątrz (left-2, h-10, w-10), na desktopie na zewnątrz (md:-left-7, md:h-14, md:w-14) --}}
        <div class="__prev slider-carousel-prev absolute left-2 md:-left-7 top-1/2 -translate-y-1/2 z-10 bg-secondary hover:bg-secondary-hover hover:text-white h-10 w-10 md:h-14 md:w-14 flex items-center justify-center cursor-pointer transition-all duration-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" class="md:w-3.5 md:h-3.5" viewBox="0 0 13 12" fill="none">
                <path d="M0.270429 5.31498C0.270706 5.31469 0.270937 5.31435 0.27126 5.31406L5.08882 0.281803C5.44973 -0.0951806 6.03348 -0.0937777 6.39273 0.285093C6.75194 0.663916 6.75055 1.27664 6.38964 1.65367L3.15514 5.03226L12.078 5.03226C12.5872 5.03226 13 5.46552 13 6C13 6.53448 12.5872 6.96774 12.078 6.96774L3.15518 6.96774L6.3896 10.3463C6.75051 10.7234 6.75189 11.3361 6.39269 11.7149C6.03344 12.0938 5.44963 12.0951 5.08877 11.7182L0.271213 6.68594C0.270936 6.68565 0.270706 6.68531 0.270383 6.68502C-0.0907122 6.30673 -0.08956 5.69202 0.270429 5.31498Z" fill="currentColor" />
            </svg>
        </div>
        
        {{-- Strzałka PRAWA: Na mobile wewnątrz (right-2, h-10, w-10), na desktopie na zewnątrz (md:-right-7, md:h-14, md:w-14) --}}
        <div class="__next slider-carousel-next absolute right-2 md:-right-7 top-1/2 -translate-y-1/2 z-10 bg-secondary hover:bg-secondary-hover h-10 w-10 md:h-14 md:w-14 flex items-center justify-center cursor-pointer transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" class="md:w-3.5 md:h-3.5" viewBox="0 0 13 12" fill="none">
                <path d="M12.7296 5.31498C12.7293 5.31469 12.7291 5.31435 12.7287 5.31406L7.91118 0.281803C7.55027 -0.0951806 6.96652 -0.0937777 6.60727 0.285093C6.24806 0.663916 6.24945 1.27664 6.61036 1.65367L9.84486 5.03226L0.921985 5.03226C0.412773 5.03226 0 5.46552 0 6C0 6.53448 0.412773 6.96774 0.921985 6.96774L9.84482 6.96774L6.6104 10.3463C6.24949 10.7234 6.24811 11.3361 6.60731 11.7149C6.96657 12.0938 7.55037 12.0951 7.91123 11.7182L12.7288 6.68594C12.7291 6.68565 12.7293 6.68531 12.7296 6.68502C13.0907 6.30673 13.0896 5.69202 12.7296 5.31498Z" fill="currentColor" />
            </svg>
        </div>
    </div>
</section>