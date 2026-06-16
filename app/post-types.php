<?php

/*--- CPT - Produkty ---*/

add_action('init', function () {
	register_post_type('product', [
		'label'         => 'Produkty',
		'labels'        => [
			'name'               => 'Produkty',
			'singular_name'      => 'Produkt',
			'menu_name'          => 'Produkty',
			'all_items'          => 'Wszystkie produkty',
			'add_new'            => 'Dodaj nowy',
			'add_new_item'       => 'Dodaj nowy produkt',
			'edit_item'          => 'Edytuj produkt',
			'new_item'           => 'Nowy produkt',
			'view_item'          => 'Zobacz produkt',
			'view_items'         => 'Zobacz produkty',
			'search_items'       => 'Szukaj produktów',
			'not_found'          => 'Nie znaleziono produktów',
			'not_found_in_trash' => 'Brak produktów w koszu',
			'parent_item_colon'  => 'Produkt nadrzędny:',
		],
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-cart',
		'menu_position' => 20,
		'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
		'show_in_rest'  => true,
		'rewrite'       => ['slug' => 'produkty', 'with_front' => false],
	]);
});

add_action('init', function () {
	register_taxonomy('product_category', ['product'], [
		'label'        => 'Kategorie produktów',
		'labels'       => [
			'name'              => 'Kategorie produktów',
			'singular_name'     => 'Kategoria produktu',
			'search_items'      => 'Szukaj kategorii',
			'all_items'         => 'Wszystkie kategorie',
			'parent_item'       => 'Kategoria nadrzędna',
			'parent_item_colon' => 'Kategoria nadrzędna:',
			'edit_item'         => 'Edytuj kategorię',
			'update_item'       => 'Aktualizuj kategorię',
			'add_new_item'      => 'Dodaj nową kategorię',
			'new_item_name'     => 'Nazwa nowej kategorii',
			'menu_name'         => 'Kategorie',
		],
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => ['slug' => 'kategoria-produktu', 'with_front' => false],
	]);
});
