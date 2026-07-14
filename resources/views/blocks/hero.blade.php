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

     <div 
        style="
            position: absolute !important;
            clip-path: polygon(100% 100%, 13.05% 100%, 54.95% 70.09%, 0% 1.17%, 0% 0%, 100% 0%);
            -webkit-clip-path: polygon(100% 100%, 13.05% 100%, 54.95% 70.09%, 0% 1.17%, 0% 0%, 100% 0%);
            backdrop-filter: blur(28px) saturate(140%);
            -webkit-backdrop-filter: blur(28px) saturate(140%);
            background-color: rgba(255, 255, 255, 0.08);
        "
        class="absolute inset-y-0 right-0 h-full w-[45%] lg:w-[40%] z-20 hidden md:block pointer-events-none">
        
        <!-- Wektorowe, lśniące białe obramowanie dopasowane do krawędzi -->
        <svg class="absolute inset-0 w-full h-full z-10" viewBox="0 0 566 715" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M565.929 715.001H73.8691L311.003 501.122L0 8.39648V0L565.929 0V715.001Z" stroke="rgba(255, 255, 255, 0.25)" stroke-width="2.5" />
        </svg>
    </div>

    <div class="__wrapper c-main grid grid-cols-1 md:grid-cols-2 items-center gap-10">

        <div class="__content relative flex flex-col justify-center z-30 py-30">
            <h1 data-gsap-element="header" class="m-header text-white [&_strong]:!text-secondary-50">
                {!! strip_tags($g_hero['header'], '<strong><em><a><br>') !!}
            </h1>
            <div data-gsap-element="text" class="text-white">
                {!! $g_hero['text'] !!}
            </div>

            <div class="inline-buttons m-btn mt-8">
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