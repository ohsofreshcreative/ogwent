<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'*', // działa globalnie
	];

	/**
	 * Dane dostępne we wszystkich widokach Blade.
	 */
	public function with(): array
	{
		return [
			'siteName' => $this->siteName(),
			'logo' => get_field('logo', 'option'),
			'logo_footer' => get_field('logo_footer', 'option'),
			'footer_contact' => get_field('footer_contact', 'option'),
			'headerBg' => $this->headerBg(),
		];
	}

	/**
	 * Zwraca nazwę strony.
	 */
	public function siteName(): string
	{
		return get_bloginfo('name', 'display');
	}

	/**
	 * Zwraca URL obrazka tła headera (WebGL glass).
	 * Kolejność: ACF option > featured image bieżącej strony > null (fallback CSS glass).
	 */
	public function headerBg(): ?string
	{
		$bg = get_field('header_bg_image', 'option');
		if ($bg) {
			return is_array($bg) ? $bg['url'] : $bg;
		}

		if (has_post_thumbnail()) {
			return get_the_post_thumbnail_url(null, 'full') ?: null;
		}

		return null;
	}
}
