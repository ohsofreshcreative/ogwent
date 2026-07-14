@php
global $product;
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
@endphp

@if (!empty($product))
<li class="bg-white b-shadow p-8">

	@php do_action('woocommerce_before_shop_loop_item') @endphp

	<a href="{{ get_the_permalink() }}" class="woocommerce-LoopProduct-link flex flex-col gap-4">

		<div class="__thumb overflow-hidden aspect-square flex items-center justify-center">
			{!! get_the_post_thumbnail($product->get_id(), 'woocommerce_thumbnail', ['class' => 'w-full h-full object-cover object-center']) !!}
		</div>

		@php do_action('woocommerce_before_shop_loop_item_title') @endphp

		<h6 class="woocommerce-loop-product__title !text-lg line-clamp-2">{!! get_the_title() !!}</h6>

		@php do_action('woocommerce_after_shop_loop_item_title') @endphp

		{{-- Cena netto --}}
		@php
		if ($product->is_type('variable')) {
		$min_net = wc_get_price_excluding_tax($product, ['price' => $product->get_variation_price('min')]);
		$net_html = wc_price($min_net);
		} else {
		$net = wc_get_price_excluding_tax($product);
		$net_html = $net > 0 ? wc_price($net) : '';
		}
		@endphp
		@if (!empty($net_html))
		<p class="text-lg text-gray-500 !font-medium [&_bdi]:!text-lg [&_bdi]:!text-gray-500 [&_bdi_span]:!text-lg [&_bdi_span]:!text-gray-500">
			{!! $net_html !!} netto
		</p>
		@endif

	</a>

	@php do_action('woocommerce_after_shop_loop_item') @endphp

</li>
@endif