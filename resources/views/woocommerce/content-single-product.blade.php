@php
/**
* Szablon pojedynczego produktu nadpisany w Blade.
* Klasy Tailwinda dodane są bezpośrednio do sekcji galerii i opisu.
*/
defined('ABSPATH') || exit;

// Pobranie wartości z opcji ACF
$g_values = get_field('g_values', 'option');
$r_values = get_field('r_values', 'option');

// Akcje wywoływane przed strukturą produktu
if (post_password_required()) {
echo get_the_password_form(); // WPCS: XSS ok.
return;
}
@endphp

<div id="product-{{ the_ID() }}" {{ wc_product_class('', $product) }}>

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

		<div class="">
			@php
			/**
			* Hook: woocommerce_before_single_product_summary.
			*
			* @hooked woocommerce_show_product_sale_flash - 10
			* @hooked woocommerce_show_product_images - 20 (Galeria)
			*/
			do_action('woocommerce_before_single_product_summary');
			@endphp
		</div>

		{{-- KOLUMNA PRAWA: Tytuł, Cena, Opis, Przycisk koszyka --}}
		<div class="">

			@php
			/**
			* Hook: woocommerce_single_product_summary.
			*
			* @hooked woocommerce_template_single_title - 5
			* @hooked woocommerce_template_single_rating - 10
			* @hooked woocommerce_template_single_price - 10
			* @hooked woocommerce_template_single_excerpt - 20
			* @hooked woocommerce_template_single_add_to_cart - 30
			* @hooked woocommerce_template_single_meta - 40
			* @hooked woocommerce_template_single_sharing - 50
			* @hooked WC_Structured_Data::generate_product_data() - 60
			*/
			do_action('woocommerce_single_product_summary');
			@endphp
		</div>

	</div>

	<div class="w-full mt-16 pt-16 border-t border-gray-100 !float-none !clear-both">
		@php
		/**
		* Hook: woocommerce_after_single_product_summary.
		*
		* @hooked woocommerce_output_product_data_tabs - 10
		* @hooked woocommerce_upsell_display - 15
		* @hooked woocommerce_output_related_products - 20
		*/
		do_action('woocommerce_after_single_product_summary');
		@endphp
	</div>


	<section data-gsap-anim="section" class="b-values relative -smt -spb">

		<div class="__wrapper c-main">

			@if (!empty($r_values))
			@php
			$itemCount = count($r_values);
			$gridCols = 1;
			if ($itemCount == 2) $gridCols = 2;
			if ($itemCount == 3) $gridCols = 3;
			if ($itemCount >= 4) $gridCols = 4;
			$gridClass = $gridCols > 1 ? 'grid-cols-1 lg:grid-cols-' . $gridCols : 'grid-cols-1';
			@endphp

			<div class="grid {{ $gridClass }} gap-8 mt-10">
				@foreach ($r_values as $item)
				<div data-gsap-element="card" class="__card relative bg-white p-8 flex flex-col h-full b-shadow">
					@if (!empty($item['image']['url']))
					<img class="mb-6 !max-w-[64px] h-auto object-contain" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
					@endif
					@if (!empty($item['title']))
					<p class="text-lg !font-semibold text-primary mb-3">{{ $item['title'] }}</p>
					@endif
					@if (!empty($item['text']))
					<p class="text-sm opacity-80 mt-auto">{{ $item['text'] }}</p>
					@endif
				</div>
				@endforeach
			</div>
			@endif

		</div>

	</section>

</div>

@php do_action('woocommerce_after_single_product'); @endphp