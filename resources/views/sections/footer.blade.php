<footer class="footer bg-white overflow-hidden relative z-10">
	<div class="__wrapper c-main relative z-10">

		<div class="__widgets grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1 md:gap-6 pt-10 pb-36 mt-12">
			@for ($i = 1; $i <= 4; $i++)
				@if (is_active_sidebar('sidebar-footer-' . $i))
				<div>@php(dynamic_sidebar('sidebar-footer-' . $i))</div>
		@endif
		@endfor
	</div>
	</div>

	<div class="c-main flex flex-col md:flex-row justify-between gap-6 py-10 footer-bottom border-t border-primary-lighter">
		<p class="">Copyright ©{{ date('Y') }} {{ get_bloginfo('name') }}. All Rights Reserved</p>
		<p class="flex gap-2">Designed &amp; Developed by
			<a target="_blank" rel="nofollow" href="https://www.ohsofresh.pl" title="OhSoFresh"><img class="oh" src="{{ get_template_directory_uri() }}/resources/images/ohsofresh.svg"></a>
		</p>
	</div>

</footer>