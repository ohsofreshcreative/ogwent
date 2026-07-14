<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
	return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});


add_action('pre_get_posts', function ($q) {
	if (is_admin() || !$q->is_main_query()) {
		return;
	}
	if ($q->is_search()) {
		if (!empty($_GET['post_type']) && $_GET['post_type'] === 'produkty') {
			$q->set('post_type', 'produkty');
		}
	}
});


/*--- BREACRUMB SEPARATOR ---*/
add_filter('woocommerce_breadcrumb_defaults', function ($defaults) {
	// Opakowujemy separator w element <span> z własną klasą CSS.
	$defaults['delimiter'] = '<span class="__separator">•</span>';
	return $defaults;
});



/**
 * Override WooCommerce Coming Soon template
 */
add_filter('woocommerce_coming_soon_template', function ($template) {
	$custom_template = get_theme_file_path('resources/views/patterns/coming-soon.php');

	if (file_exists($custom_template)) {
		return $custom_template;
	}

	return $template;
});

/*--- BRANDS LOGO ON PRODUCT PAGE ---*/

add_action('woocommerce_single_product_summary', function () {
	global $product;

	$brands = get_the_terms($product->get_id(), 'product_brand');

	if (empty($brands) || is_wp_error($brands)) {
		return;
	}

	$brand        = $brands[0];
	$thumbnail_id = get_term_meta($brand->term_id, 'thumbnail_id', true);

	if (!$thumbnail_id) {
		return;
	}

	$img = wp_get_attachment_image($thumbnail_id, 'medium', false, [
		'class' => 'h-10 w-auto object-contain',
		'alt'   => esc_attr($brand->name),
	]);

	echo '<div class="__brand mb-4">' . $img . '</div>';
}, 1);


/*--- MOVE EXCERPT ABOVE PRICE ---*/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6);


/*--- REMOVE META ---*/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


/*--- SINGLE PRODUCT BUTTON TO STANDARD 30 ---*/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);


/*--- REMOVE GENERAL PRICE RANGE FROM THE TOP (variable only, so variants go first) ---*/
add_action('woocommerce_single_product_summary', function () {
	global $product;
	if ($product && $product->is_type('variable')) {
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	}
}, 1);

/*--- DELIVERY & NET PRICE FOR SIMPLE PRODUCTS (ONLY) ---*/

// 1. Cena netto pod ceną brutto
add_action('woocommerce_single_product_summary', function () {
	global $product;
	if (!$product || $product->is_type('variable')) {
		return;
	}

	$net      = wc_get_price_excluding_tax($product);
	$net_html = $net > 0 ? wc_price($net) : '';

	if (!empty($net_html)) {
		// Ujednolicone klasy identyczne jak na kafelku
		echo '<p class="price-net text-lg text-gray-500 !font-medium [&_bdi]:!text-lg [&_bdi]:!text-gray-500 [&_bdi]:!font-medium [&_bdi_span]:!text-lg [&_bdi_span]:!text-gray-500 [&_bdi_span]:!font-medium">'
			. $net_html . ' netto'
			. '</p>';
	}
}, 11);

// 2. Czas dostawy dla prostych produktów pod ceną netto
add_action('woocommerce_single_product_summary', function () {
	global $product;
	if (!$product || $product->is_type('variable')) {
		return;
	}

	$delivery = get_field('delivery_time', $product->get_id());
	if (!empty($delivery)) {
		echo '<p class="__delivery text-sm mt-2">Czas dostawy: <strong>' . esc_html($delivery) . '</strong></p>';
	}
}, 12);


/*--- DELIVERY & NET PRICE FOR VARIABLE PRODUCTS (ONLY) ---*/

// 1. Wstrzykujemy netto do JSON'a wariantów
add_filter('woocommerce_available_variation', function ($data, $product, $variation) {
	$net = wc_get_price_excluding_tax($variation);
	$data['price_net_html'] = $net > 0 ? wc_price($net) : '';
	return $data;
}, 10, 3);

// 2. Czas dostawy wstrzyknięty wewnątrz kontenera wariantu (nad przyciskiem "dodaj do koszyka")
add_action('woocommerce_single_variation', function () {
	global $product;
	if ($product && $product->is_type('variable')) {
		$delivery = get_field('delivery_time', $product->get_id());
		if (!empty($delivery)) {
			echo '<p class="__delivery pb-4 mt-6"><strong>Czas dostawy: </strong>' . esc_html($delivery) . '</p>';
		}
	}
}, 15); // priorytet 15 = pod dynamiczną ceną / opisem wariantu, ale nad ilością i przyciskiem


/*--- AUTO SELECT FIRST VARIATION BY DEFAULT ---*/
add_filter('woocommerce_dropdown_variation_attribute_options_args', function ($args) {
	// Jeśli nie ma wybranego domyślnego wariantu w bazie ani w zapytaniu URL, a opcje istnieją
	if (empty($args['selected']) && !empty($args['options']) && is_array($args['options'])) {
		$first_option = reset($args['options']);

		// Zabezpieczenie na wypadek gdyby opcja była obiektem taksonomii (WP_Term)
		if (is_object($first_option)) {
			$args['selected'] = $first_option->slug;
		} else {
			$args['selected'] = $first_option;
		}
	}
	return $args;
});


/*--- PRODUCT BADGES BELOW ADD TO CART ---*/
add_action('woocommerce_single_product_summary', function () {
	global $product;

	$badges = get_field('product_badges', $product->get_id());

	if (empty($badges)) {
		return;
	}

	echo '<div class="__product-badges flex flex-wrap gap-4 items-center mt-8 pt-6 border-t border-gray-100">';
	foreach ($badges as $badge) {
		if (empty($badge['image']['url'])) {
			continue;
		}

		$html = '<img src="' . esc_url($badge['image']['url']) . '" alt="' . esc_attr($badge['image']['alt'] ?? '') . '" class="h-12 w-auto object-contain max-w-[80px]" />';

		if (!empty($badge['link']['url'])) {
			$target = !empty($badge['link']['target']) ? ' target="' . esc_attr($badge['link']['target']) . '"' : '';
			echo '<a href="' . esc_url($badge['link']['url']) . '"' . $target . ' class="hover:opacity-80 transition-opacity">' . $html . '</a>';
		} else {
			echo '<div class="select-none">' . $html . '</div>';
		}
	}
	echo '</div>';
}, 31); // 31 = dokładnie pod przyciskiem koszyka (który jest na 30)


/*--- CUSTOM PRODUCT PAGE LAYOUT & ANCHORS ---*/

// 1. Usuwamy standardowy widget z tabami oraz stare Up-Sells
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

// 2. Renderujemy nasz nowy layout z kotwicami
add_action('woocommerce_after_single_product_summary', function () {
	global $product;
	if (!$product) return;

	$product_id = $product->get_id();
	$sections = [];

	// --- REUSAWABLE RENDERING HELPER FOR TABLE REPEATERS ---
	$render_table = function ($table_data) {
		if (empty($table_data) || !is_array($table_data)) {
			return '';
		}
		$html = '<table class="w-full border-collapse align-middle">';
		$html .= '<tbody class="divide-y divide-gray-100">';
		foreach ($table_data as $row) {
			if (!empty($row['is_header'])) {
				if (!empty($row['header_title'])) {
					$html .= '<tr class="table-group-header"><td colspan="2">' . esc_html($row['header_title']) . '</td></tr>';
				}
			} else {
				if (!empty($row['param_name'])) {
					$html .= '<tr>';
					$html .= '<td>' . esc_html($row['param_name']) . '</td>';
					$html .= '<td>' . nl2br(esc_html($row['param_value'] ?? '')) . '</td>';
					$html .= '</tr>';
				}
			}
		}
		$html .= '</tbody></table>';
		return $html;
	};

	// A. Opis Główny z WordPressa
	$description = get_post_field('post_content', $product_id);
	if (!empty($description)) {
		$sections[] = [
			'id'      => 'opis',
			'title'   => 'Opis produktu',
			'content' => apply_filters('the_content', $description),
		];
	}

	// B. Specyfikacja (Zastąpiona nowym repeaterem specyfikacji)
	$spec_table = get_field('specification_table', $product_id);
	if (!empty($spec_table)) {
		$sections[] = [
			'id'      => 'specyfikacja',
			'title'   => 'Specyfikacja',
			'content' => $render_table($spec_table),
		];
	}

	// C. Ustawa F-Gaz (Skompresowa z tekstem + opcjonalną tabelą pod spodem)
	$fgaz_text = get_field('fgaz_text', $product_id);
	$fgaz_enable_table = get_field('fgaz_enable_table', $product_id);
	$fgaz_table = get_field('fgaz_table', $product_id);

	$fgaz_content = '';
	if (!empty($fgaz_text)) {
		$fgaz_content .= '<div class="wysiwyg mb-6">' . apply_filters('the_content', $fgaz_text) . '</div>';
	}
	if ($fgaz_enable_table && !empty($fgaz_table)) {
		$fgaz_content .= $render_table($fgaz_table);
	}

	if (!empty($fgaz_content)) {
		$sections[] = [
			'id'      => 'ustawa-f-gaz',
			'title'   => 'Ustawa F-Gaz',
			'content' => $fgaz_content,
		];
	}

	// D. Dynamiczne sekcje z Repeatera (ACF)
	$custom_tabs = get_field('custom_tabs', $product_id);
	if (!empty($custom_tabs)) {
		foreach ($custom_tabs as $index => $tab) {
			if (!empty($tab['title']) && !empty($tab['content'])) {
				$sections[] = [
					'id'      => 'custom-' . sanitize_title($tab['title']) . '-' . $index,
					'title'   => $tab['title'],
					'content' => apply_filters('the_content', $tab['content']),
				];
			}
		}
	}

	// E. Dobierz do zestawu
	$recommended_ids = $product->get_cross_sells();
	if (empty($recommended_ids)) {
		$recommended_ids = $product->get_upsells();
	}

	if (!empty($recommended_ids)) {
		$sections[] = [
			'id'       => 'dobierz-do-zestawu',
			'title'    => 'Dobierz do zestawu',
			'is_loop'  => true,
			'item_ids' => $recommended_ids,
		];
	}

	// F. Podobne produkty (Related)
	$sections[] = [
		'id'         => 'podobne-produkty',
		'title'      => 'Podobne produkty',
		'is_related' => true,
	];

	if (empty($sections)) return;

	// --- RENDER NAWIGACJI ANCHORÓW (PRZYCISKI NA GÓRZE, Z PRZYCISKIEM SCROLL-TO-TOP) ---
	echo '<div class="__product-anchors flex flex-wrap items-center gap-4 mb-12 px-3 py-3 border-b border-gray-100 select-none sticky top-14 bg-white/90 b-shadow backdrop-blur-md z-40">';

	$arrow_url = get_theme_file_uri('resources/images/arrow-top.svg');
	echo '<a href="#product-' . esc_attr($product_id) . '" class="second-btn !py-2 !px-3 hover:scale-115 transition-transform flex items-center justify-center top-arrow-btn" title="Do góry">';
	echo '<div class="border border-secondary rounded-full p-2"><img src="' . esc_url($arrow_url) . '" class="w-4 h-4" alt="W górę" /></div>';
	echo '</a>';

	foreach ($sections as $section) {
		echo '<a href="#' . esc_attr($section['id']) . '" class="second-btn !py-2 !px-5 !text-sm hover:scale-105 transition-transform border-r border-secondary-lighter last-of-type:border-r-0">' . esc_html($section['title']) . '</a>';
	}
	echo '</div>';

	// --- RENDER POSZCZEGÓLNYCH SEKCJI ---
	echo '<div class="__product-section-wrapper flex flex-col gap-12">';
	foreach ($sections as $section) {

		if (!empty($section['is_related'])) {
			continue;
		}

		echo '<div id="' . esc_attr($section['id']) . '" class="scroll-mt-[180px] pt-10 pb-6 __border-top">';
		echo '<h4 class="mb-6">' . esc_html($section['title']) . '</h4>';

		if (!empty($section['is_loop']) && !empty($section['item_ids'])) {
			$query = new \WP_Query([
				'post_type'      => 'product',
				'post__in'       => $section['item_ids'],
				'posts_per_page' => 3,
			]);

			if ($query->have_posts()) {
				woocommerce_product_loop_start();
				while ($query->have_posts()) {
					$query->the_post();
					wc_get_template_part('content', 'product');
				}
				woocommerce_product_loop_end();
			}
			wp_reset_postdata();
		} else {
			echo '<div class="wysiwyg leading-relaxed text-gray-700 [&>p]:mb-4">' . $section['content'] . '</div>';
		}

		echo '</div>';
	}
	echo '</div>';
}, 10);

// 3. Pozycjonowanie Podobnych Produktów (Related) na samym dole pod kotwicą #podobne-produkty
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product_summary', function () {
	echo '<div id="podobne-produkty" class="scroll-mt-[180px] py-8 border-t border-gray-100 mt-12">';
	woocommerce_output_related_products();
	echo '</div>';
}, 20);


/*--- PRODUCT GALLERY HINT BLOCK ---*/
add_action('woocommerce_before_single_product_summary', function () {
	global $product;
	if (!$product) return;

	$hint = get_field('product_gallery_hint', $product->get_id());

	if (empty($hint)) {
		return;
	}

	echo '<div class="__product-gallery-hint mt-8 p-6 border-2 border-dotted border-secondary leading-relaxed text-slate-700">';
	echo apply_filters('the_content', $hint);
	echo '</div>';
}, 25);


add_action('pre_get_posts', function ($q) {
	if (is_admin() || !$q->is_main_query()) {
		return;
	}
	if ($q->is_search()) {
		// Jeżeli przyszło z naszego paska: post_type=produkty
		if (!empty($_GET['post_type']) && $_GET['post_type'] === 'produkty') {
			$q->set('post_type', 'produkty');
			// (opcjonalnie) sortowanie / ilość:
			// $q->set('posts_per_page', 12);
			// $q->set('orderby', 'date');
			// $q->set('order', 'DESC');
		}
	}
});

/*--- AJAX SEARCH ---*/

/**
 * Obsługa wyszukiwania produktów przez AJAX.
 */
add_action('wp_ajax_search_products', __NAMESPACE__ . '\\handle_ajax_search_products');
add_action('wp_ajax_nopriv_search_products', __NAMESPACE__ . '\\handle_ajax_search_products');

function handle_ajax_search_products()
{
	// Pobieramy dane bezpiecznie z parametru GET w adresie URL
	$search_query = sanitize_text_field($_GET['s'] ?? '');

	if (empty($search_query)) {
		wp_send_json_error('Empty search query');
		return;
	}

	$args = [
		'post_type' => 'product',
		'posts_per_page' => 5,
		's' => $search_query,
		'post_status' => 'publish',
	];

	$products_query = new \WP_Query($args);
	$results = [];

	if ($products_query->have_posts()) {
		while ($products_query->have_posts()) {
			$products_query->the_post();
			$product = wc_get_product(get_the_ID());
			if (!$product) continue;

			$image_id = $product->get_image_id();
			$image_url = wp_get_attachment_image_url($image_id, 'thumbnail');

			$results[] = [
				'id'    => get_the_ID(),
				'title' => get_the_title(),
				'url'   => get_permalink(),
				'image' => $image_url ? $image_url : wc_placeholder_img_src(),
			];
		}
	}

	wp_reset_postdata();
	wp_send_json_success($results);
}

/*--- WOOCOMMERCE RESULTS ---*/

add_filter('woocommerce_redirect_single_search_result', '__return_false');


/*--- DYNAMICZNE FRAGMENTY DLA KOSZYKA (SLAJD DRAWER) ---*/

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    // 1. Renderujemy ikonę na pulpit z pliku Blade (jeśli chcemy, lub trzymamy prosty kod w filters)
    ob_start();
    ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative hover:opacity-80 transition-opacity cart-custom-location-desktop">
        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart.svg" alt="Koszyk" />
        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
            <span class="absolute -top-2 -right-2 bg-secondary text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-custom-location-desktop'] = ob_get_clean();

    // 2. Renderujemy ikonę na komórkę
    ob_start();
    ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative p-2 text-white hover:opacity-80 transition-opacity cart-custom-location-mobile">
        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart.svg" class="w-6 h-6" alt="Koszyk" />
        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
            <span class="absolute top-1 right-1 bg-secondary text-primary text-[9px] font-bold w-4.5 h-4.5 flex items-center justify-center rounded-full cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-custom-location-mobile'] = ob_get_clean();

    // 3. RENDER ZAWARTOSCI SZUFLADY PROSTO Z BLADE! (BEZ ODPALANIA HTML)
    $fragments['div.cart-drawer-ajax-content'] = '<div class="flex-1 flex flex-col overflow-hidden cart-drawer-ajax-content">' . \Roots\view('partials.cart-drawer-content')->render() . '</div>';

    // 4. Cyferka przy nagłówku Drawera
    $fragments['span.cart-count-badge'] = '<span class="bg-secondary/15 text-secondary text-xs px-2.5 py-0.5 rounded-full cart-count-badge">' . WC()->cart->get_cart_contents_count() . '</span>';

    return $fragments;
});


/*--- WYKRYWANIE DODANIA DO KOSZYKA (DLA EMBEDDED REFRESH / POST) ---*/

add_action('woocommerce_add_to_cart', function () {
    if (!defined('JUST_ADDED_TO_CART')) {
        define('JUST_ADDED_TO_CART', true);
    }
}, 10);


add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_woocommerce')) {
        wp_enqueue_script('wc-cart-fragments');
    }
}, 99);


/*--- CHANGE VARIABLE PRICE HTML TO MINIMUM VARIATION PRICE ONLY ---*/
add_filter('woocommerce_variable_sale_price_html', 'App\\custom_variation_price_format', 10, 2);
add_filter('woocommerce_variable_price_html', 'App\\custom_variation_price_format', 10, 2);

function custom_variation_price_format($price, $product) {
    // Pobieramy minimalne ceny brutto wariantów
    $min_reg_price  = $product->get_variation_regular_price('min', true);
    $min_sale_price = $product->get_variation_sale_price('min', true);
    $min_price      = $product->get_variation_price('min', true);

    // Formatujemy kwotę za pomocą wbudowanej funkcji WooCommerce
    if ($product->is_on_sale() && $min_reg_price !== $min_sale_price) {
        // Jeśli najniższy wariant jest w promocji, wyświetlamy starą przekreśloną i nową cenę
        $price = '<del>' . wc_price($min_reg_price) . '</del> <ins>' . wc_price($min_sale_price) . '</ins>';
    } else {
        // Standardowa cena najtańszego wariantu
        $price = wc_price($min_price);
    }

    return $price;
}


/*--- BEZPIECZNIK DLA WOOCOMMERCE HPOS (ZAPOBIEGANIE BŁĘDOM NA NOWYCH/OSIEROCONYCH ZAMÓWIENIACH) ---*/

add_filter('map_meta_cap', function ($caps, $cap, $user_id, $args) {
    if (in_array($cap, ['delete_post', 'delete_shop_order', 'edit_post', 'edit_shop_order'], true)) {
        $id = !empty($args[0]) ? (int) $args[0] : 0;
        
        // Blokada sprawdzania uprawnień dla ID 0 (nowo tworzone zamówienia)
        if ($id === 0) {
            return ['do_not_allow'];
        }

        // Dodatkowe zabezpieczenie dla trybu HPOS - jeśli zamówienie fizycznie nie istnieje w bazie (np. osierocone rekordy)
        if (class_exists(\Automattic\WooCommerce\Utilities\OrderUtil::class) && \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled()) {
            if (function_exists('wc_get_order') && !wc_get_order($id)) {
                return ['do_not_allow'];
            }
        }
    }
    return $caps;
}, 10, 4);