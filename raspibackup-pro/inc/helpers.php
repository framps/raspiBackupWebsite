<?php
/**
 * Helpers: language detection (Polylang), language switcher, icons, GitHub stats.
 *
 * @package raspibackup-pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Current language: 'de' or 'en'. Uses Polylang if available.
 */
function rbp_lang() {
	if ( function_exists( 'pll_current_language' ) ) {
		$slug = pll_current_language( 'slug' );
		if ( $slug ) {
			return 'de' === $slug ? 'de' : 'en';
		}
	}
	return 0 === strpos( determine_locale(), 'de' ) ? 'de' : 'en';
}

/**
 * Languages for the switcher: [ [slug, name, url, current], ... ].
 */
function rbp_languages() {
	$out = array();
	if ( function_exists( 'pll_the_languages' ) ) {
		$langs = pll_the_languages(
			array(
				'raw'           => 1,
				'hide_if_empty' => 0,
			)
		);
		if ( is_array( $langs ) ) {
			foreach ( $langs as $l ) {
				$out[] = array(
					'slug'    => $l['slug'],
					'name'    => $l['name'],
					'url'     => $l['url'],
					'current' => ! empty( $l['current_lang'] ),
				);
			}
		}
	}
	if ( empty( $out ) ) {
		$cur = rbp_lang();
		$out = array(
			array(
				'slug'    => 'en',
				'name'    => 'English',
				'url'     => home_url( '/en/home/' ),
				'current' => 'en' === $cur,
			),
			array(
				'slug'    => 'de',
				'name'    => 'Deutsch',
				'url'     => home_url( '/de/home-deutsch/' ),
				'current' => 'de' === $cur,
			),
		);
	}
	return $out;
}

/**
 * Inline SVG icon (stroke icons, 24×24, inherit currentColor).
 *
 * @param string $name Icon name.
 * @param int    $size Pixel size.
 */
function rbp_icon( $name, $size = 24 ) {
	$p = array(
		'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'terminal' => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="m7 9 3 3-3 3M13 15h4"/>',
		'layers'   => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 13 9 5 9-5"/>',
		'rotate'   => '<path d="M21 12a9 9 0 0 1-15.5 6.2M3 12a9 9 0 0 1 15.5-6.2"/><path d="M19 2v4h-4M5 22v-4h4"/>',
		'copy'     => '<rect x="8" y="8" width="13" height="13" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"/>',
		'camera'   => '<path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/><circle cx="12" cy="13.5" r="3.5"/>',
		'bell'     => '<path d="M6 8a6 6 0 1 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a2 2 0 0 0 3.4 0"/>',
		'windows'  => '<rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/>',
		'move'     => '<rect x="2" y="6" width="7" height="12" rx="1.5"/><rect x="15" y="6" width="7" height="12" rx="1.5"/><path d="M10 12h4m-2-2 2 2-2 2"/>',
		'drive'    => '<rect x="2" y="7" width="20" height="10" rx="2"/><path d="M6 12h.01M10 12h.01M14 17v2M18 17v2M6 17v2M10 17v2"/>',
		'plug'     => '<path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0V7ZM12 17v5"/>',
		'download' => '<path d="M12 3v12m-5-5 5 5 5-5"/><path d="M4 19h16"/>',
		'shield'   => '<path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
		'code'     => '<path d="m8 7-5 5 5 5M16 7l5 5-5 5M14 4l-4 16"/>',
		'check'    => '<path d="m5 12 5 5 9-10"/>',
		'arrow'    => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
		'external' => '<path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
		'book'     => '<path d="M4 4.5A1.5 1.5 0 0 1 5.5 3H20v16H5.5A1.5 1.5 0 0 0 4 20.5v-16Z"/><path d="M4 20.5A1.5 1.5 0 0 0 5.5 22H20"/>',
		'bug'      => '<rect x="7" y="7" width="10" height="13" rx="5"/><path d="M9 7a3 3 0 0 1 6 0M3 13h4M17 13h4M4 7l3 2M20 7l-3 2M4 19l3-2M20 19l-3-2M12 11v9"/>',
		'menu'     => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
		'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
		'play'     => '<path d="M8 5v14l11-7L8 5Z"/>',
		'star'     => '<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1 6.2-5.5-2.9-5.5 2.9 1-6.2L3 9.6l6.2-.9L12 3Z"/>',
		'help'     => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 1 1 3.5 2.3c-.6.3-1 .9-1 1.6v.6M12 17h.01"/>',
		'sliders'  => '<path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/>',
		'alert'    => '<path d="M12 3 2 20h20L12 3Z"/><path d="M12 10v4M12 17h.01"/>',
		'file'     => '<path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8l-5-5Z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
		'tag'      => '<path d="M3 12V4a1 1 0 0 1 1-1h8l9 9-9 9-9-9Z"/><circle cx="7.5" cy="7.5" r="1.5"/>',
		'heart'    => '<path d="M12 20s-7.5-4.6-7.5-10.2A4.2 4.2 0 0 1 12 7.2a4.2 4.2 0 0 1 7.5 2.6C19.5 15.4 12 20 12 20Z"/>',
		'lock'     => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3M12 15v2"/>',
		'unlock'   => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 7.7-1.5M12 15v2"/>',
		'users'    => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.6a3.5 3.5 0 0 1 0 6.8M18 14.2a6.5 6.5 0 0 1 3.5 5.8"/>',
		'branch'   => '<circle cx="6" cy="5" r="2"/><circle cx="6" cy="19" r="2"/><circle cx="18" cy="7" r="2"/><path d="M6 7v10M18 9c0 5-6 4-11 8.5"/>',
		'board'    => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M5 8h11" stroke-dasharray="1 1.5"/><rect x="7" y="11" width="5" height="5" rx=".6"/><path d="M22 9h-3v3h3M22 13.5h-3v3h3M14.5 16h2"/>',
	);
	// Brand marks (filled).
	$f = array(
		'github'   => '<path d="M12 .5a11.5 11.5 0 0 0-3.6 22.4c.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.7 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.2 1.2a11 11 0 0 1 5.8 0c2.2-1.5 3.2-1.2 3.2-1.2.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.4-2.7 5.4-5.3 5.7.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6A11.5 11.5 0 0 0 12 .5Z"/>',
		'youtube'  => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8ZM9.6 15.6V8.4l6.2 3.6-6.2 3.6Z"/>',
		'facebook' => '<path d="M24 12a12 12 0 1 0-13.9 11.9v-8.4H7.1V12h3V9.4c0-3 1.8-4.7 4.5-4.7 1.3 0 2.7.2 2.7.2v3h-1.5c-1.5 0-2 .9-2 1.9V12h3.4l-.5 3.5h-2.9v8.4A12 12 0 0 0 24 12Z"/>',
		'reddit'   => '<path d="M24 12a2.6 2.6 0 0 0-4.4-1.9 12.8 12.8 0 0 0-6.9-2.2l1.2-5.5 3.8.8a1.8 1.8 0 1 0 .2-1.2l-4.3-.9a.6.6 0 0 0-.7.5l-1.3 6.3a12.8 12.8 0 0 0-7 2.2A2.6 2.6 0 1 0 1.7 14v.8c0 4 4.7 7.3 10.4 7.3s10.4-3.3 10.4-7.3V14A2.6 2.6 0 0 0 24 12ZM6 14a1.8 1.8 0 1 1 3.6 0A1.8 1.8 0 0 1 6 14Zm10.1 4.8c-1.2 1.2-3.6 1.3-4.1 1.3s-2.9-.1-4.1-1.3a.4.4 0 1 1 .6-.6c.8.8 2.4 1 3.5 1s2.7-.2 3.5-1a.4.4 0 1 1 .6.6Zm-.3-3a1.8 1.8 0 1 1 0-3.6 1.8 1.8 0 0 1 0 3.6Z"/>',
		'x'        => '<path d="M18.2 2.3h3.4l-7.4 8.4 8.7 11.5h-6.8l-5.3-7-6.1 7H1.3l7.9-9L.8 2.3h7l4.8 6.4 5.6-6.4Zm-1.2 17.9h1.9L7 4.2H5l12 16Z"/>',
	);
	$size = (int) $size;
	if ( isset( $f[ $name ] ) ) {
		return '<svg class="rbp-icon" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">' . $f[ $name ] . '</svg>';
	}
	$path = isset( $p[ $name ] ) ? $p[ $name ] : $p['check'];
	return '<svg class="rbp-icon" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $path . '</svg>';
}

/**
 * Latest release tag + star count from GitHub, cached 12 hours.
 * The request is made by the server, never by the visitor's browser.
 *
 * @return array{release:string,stars:int,forks:int}
 */
function rbp_github_stats() {
	$cached = get_transient( 'rbp_github_stats' );
	if ( is_array( $cached ) && isset( $cached['forks'] ) ) {
		return $cached;
	}
	$stats = array(
		'release' => '',
		'stars'   => 0,
		'forks'   => 0,
	);
	$args  = array(
		'timeout' => 3,
		'headers' => array( 'Accept' => 'application/vnd.github+json' ),
	);
	$rel   = wp_remote_get( 'https://api.github.com/repos/framps/raspiBackup/releases/latest', $args );
	if ( ! is_wp_error( $rel ) && 200 === wp_remote_retrieve_response_code( $rel ) ) {
		$body             = json_decode( wp_remote_retrieve_body( $rel ), true );
		$stats['release'] = isset( $body['tag_name'] ) ? sanitize_text_field( $body['tag_name'] ) : '';
	}
	$repo = wp_remote_get( 'https://api.github.com/repos/framps/raspiBackup', $args );
	if ( ! is_wp_error( $repo ) && 200 === wp_remote_retrieve_response_code( $repo ) ) {
		$body           = json_decode( wp_remote_retrieve_body( $repo ), true );
		$stats['stars'] = isset( $body['stargazers_count'] ) ? (int) $body['stargazers_count'] : 0;
		$stats['forks'] = isset( $body['forks_count'] ) ? (int) $body['forks_count'] : 0;
	}
	$ok = '' !== $stats['release'] || $stats['stars'] > 0;
	set_transient( 'rbp_github_stats', $stats, $ok ? 12 * HOUR_IN_SECONDS : HOUR_IN_SECONDS );
	return $stats;
}

/**
 * Format star count: 1041 → "1.0k".
 *
 * @param int $n Count.
 */
function rbp_short_number( $n ) {
	return $n >= 1000 ? number_format_i18n( $n / 1000, 1 ) . 'k' : number_format_i18n( $n );
}

/**
 * Best available logo for the new design, in this order:
 * 1. assets/img/logo.svg (or logo.png) inside this theme
 * 2. Customizer → raspiBackup Pro → Logo
 * 3. the original high-resolution upload Icon_rot_blau_final.png (450×693)
 * 4. the WordPress custom logo
 */
function rbp_logo_url() {
	foreach ( array( 'logo.svg', 'logo.png' ) as $f ) {
		if ( file_exists( RBP_DIR . '/assets/img/' . $f ) ) {
			return RBP_URI . '/assets/img/' . $f;
		}
	}
	$mod = get_theme_mod( 'rbp_logo', '' );
	if ( $mod ) {
		return $mod;
	}
	$orig = '/uploads/2023/09/Icon_rot_blau_final.png';
	if ( file_exists( WP_CONTENT_DIR . $orig ) ) {
		return content_url( $orig );
	}
	$id  = get_theme_mod( 'custom_logo' );
	$url = $id ? wp_get_attachment_image_url( $id, 'full' ) : '';
	return $url ? $url : content_url( '/uploads/2023/09/Icon_rot_blau_final_64.png' );
}

/**
 * Demo media URL for the current language.
 *
 * @param string $lang Language.
 */
function rbp_demo_url( $lang ) {
	$defaults = array(
		'en' => content_url( '/uploads/2026/11/install_en.gif' ),
		'de' => content_url( '/uploads/2026/11/install_de.gif' ),
	);
	$url = get_theme_mod( 'rbp_demo_' . $lang, '' );
	return $url ? $url : $defaults[ $lang ];
}

/**
 * Extracts a YouTube video ID from an ID or URL.
 *
 * @param string $value ID or URL.
 */
function rbp_youtube_id( $value ) {
	$value = trim( (string) $value );
	if ( preg_match( '~(?:youtu\.be/|v=|embed/|shorts/)([A-Za-z0-9_-]{11})~', $value, $m ) ) {
		return $m[1];
	}
	return preg_match( '~^[A-Za-z0-9_-]{11}$~', $value ) ? $value : '';
}

/**
 * Returns the URL of the Polylang translation of a page in the current language,
 * e.g. the English imprint when the setting points to the German one.
 * External URLs and pages without a translation are returned unchanged.
 */
function rbp_translated_url( $url ) {
	if ( ! $url || ! function_exists( 'pll_get_post' ) ) {
		return $url;
	}
	$id = url_to_postid( $url );
	if ( ! $id ) {
		return $url;
	}
	$tr = pll_get_post( $id );
	return $tr ? get_permalink( $tr ) : $url;
}
