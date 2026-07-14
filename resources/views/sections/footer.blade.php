<footer class="footer overflow-hidden relative z-10">

	<div class="__wrapper bg-primary relative overflow-hidden footer-py">
		<img class="absolute -left-1/8 -bottom-4/6 pointer-events-none" src="/wp-content/uploads/2026/06/footer-shape-1.svg" alt="" />
		<img class="absolute top-1/2 -translate-y-1/2 -right-[10%] pointer-events-none" src="/wp-content/uploads/2026/06/footer-shape-2.svg" alt="" />

		<div class="__widgets relative z-20 c-main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-8 md:gap-12">

			<div class="flex flex-col gap-6 text-white text-sm">
				@if(!empty($logo_footer))
				<a href="{{ home_url('/') }}" class="block max-w-[180px]">
					<img src="{{ $logo_footer['url'] }}" alt="{{ $logo_footer['alt'] ?? get_bloginfo('name') }}" class="w-full h-auto object-contain" />
				</a>
				@endif

				@if(!empty($footer_contact['address']))
				<div class="opacity-90">{!! $footer_contact['address'] !!}</div>
				@endif

				<div class="flex flex-col gap-2 mt-2">
					@if(!empty($footer_contact['phone']))
					<a href="tel:{{ str_replace(' ', '', $footer_contact['phone']) }}" class="hover:text-secondary transition-colors inline-flex items-center gap-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary">
							<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.79 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
						</svg>
						{{ $footer_contact['phone'] }}
					</a>
					@endif

					@if(!empty($footer_contact['email']))
					<a href="mailto:{{ $footer_contact['email'] }}" class="hover:text-secondary transition-colors inline-flex items-center gap-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<polyline points="22,6 12,13 2,6"></polyline>
						</svg>
						{{ $footer_contact['email'] }}
					</a>
					@endif
				</div>
			</div>

			@for ($i = 2; $i <= 5; $i++)
				@if (is_active_sidebar('sidebar-footer-' . $i))
				<div class="text-white text-sm">
				@php(dynamic_sidebar('sidebar-footer-' . $i))
		</div>
		@endif
		@endfor

	</div>
	</div>

	<div class="c-main flex flex-col md:flex-row justify-between gap-6 py-10 footer-bottom">
		<p class="">Copyright ©{{ date('Y') }} {{ get_bloginfo('name') }}. All Rights Reserved</p>
		<p class="flex gap-2">Designed &amp; Developed by
			<a target="_blank" rel="nofollow" href="https://www.ohsofresh.pl" title="OhSoFresh"><img class="oh" src="{{ get_template_directory_uri() }}/resources/images/ohsofresh.svg" alt="OhSoFresh"></a>
		</p>
	</div>

	<svg style="display: none" xmlns="http://www.w3.org/2000/svg">
		<filter id="glass-blur" x="0" y="0" width="100%" height="100%" filterUnits="objectBoundingBox">
			<feTurbulence type="fractalNoise" baseFrequency="0.02 0.02" numOctaves="1" result="turbulence" />
			<feDisplacementMap in="SourceGraphic" in2="turbulence" scale="50" xChannelSelector="R" yChannelSelector="G" />
		</filter>
	</svg>

</footer>