<?php
/**
 * raspiBackup Pro – child theme of Zakra.
 *
 * Activate:   Appearance → Themes → "raspiBackup Pro"  → new design
 * Roll back:  Appearance → Themes → "Zakra"            → classic layout (unchanged)
 *
 * @package raspibackup-pro
 */

defined( 'ABSPATH' ) || exit;

define( 'RBP_VERSION', '1.0.0' );
define( 'RBP_DIR', get_stylesheet_directory() );
define( 'RBP_URI', get_stylesheet_directory_uri() );

require_once RBP_DIR . '/inc/content.php';
require_once RBP_DIR . '/inc/helpers.php';
require_once RBP_DIR . '/inc/customizer.php';
require_once RBP_DIR . '/inc/migrate.php';

/**
 * Should the current request render the new landing page?
 */
function rbp_is_landing() {
	if ( is_admin() || is_feed() || is_search() || is_404() ) {
		return false;
	}
	if ( isset( $_GET['rbp_classic'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- read-only preview switch.
		return false;
	}
	if ( is_page() && 'templates/landing.php' === get_page_template_slug() ) {
		return true;
	}
	return is_front_page() && (bool) get_theme_mod( 'rbp_landing_enabled', true );
}

/**
 * Use the landing template for the (Polylang-translated) front page.
 */
add_filter(
	'template_include',
	function ( $template ) {
		if ( rbp_is_landing() ) {
			return RBP_DIR . '/templates/landing.php';
		}
		return $template;
	},
	99
);

/**
 * Make sure Zakra's own stylesheet is loaded even when Zakra enqueues
 * get_stylesheet_uri() (which points at this child theme's style.css).
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		$styles = wp_styles();
		if ( isset( $styles->registered['zakra-style'] ) ) {
			$src = (string) $styles->registered['zakra-style']->src;
			if ( false !== strpos( $src, get_stylesheet_directory_uri() ) ) {
				$parent = wp_get_theme( get_template() );
				wp_register_style( 'rbp-parent-style', get_template_directory_uri() . '/style.css', array(), $parent->get( 'Version' ) );
				$styles->registered['zakra-style']->deps[] = 'rbp-parent-style';
			}
		}
	},
	50
);

/**
 * Assets.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( rbp_is_landing() ) {
			wp_enqueue_style( 'rbp-landing', RBP_URI . '/assets/css/landing.css', array(), RBP_VERSION );
			wp_enqueue_script( 'rbp-landing', RBP_URI . '/assets/js/landing.js', array(), RBP_VERSION, true );
			wp_script_add_data( 'rbp-landing', 'strategy', 'defer' );

			// The landing page brings its own markup and styles: drop Zakra/BlockArt CSS there.
			wp_dequeue_style( 'zakra-style' );
			wp_dequeue_style( 'rbp-parent-style' );
			foreach ( wp_styles()->queue as $handle ) {
				$src = isset( wp_styles()->registered[ $handle ] ) ? (string) wp_styles()->registered[ $handle ]->src : '';
				if ( preg_match( '#/themes/zakra/|/plugins/blockart-blocks/|fonts\.googleapis\.com#', $src ) ) {
					wp_dequeue_style( $handle );
				}
			}
			foreach ( wp_scripts()->queue as $handle ) {
				$src = isset( wp_scripts()->registered[ $handle ] ) ? (string) wp_scripts()->registered[ $handle ]->src : '';
				if ( false !== strpos( $src, '/themes/zakra/' ) ) {
					wp_dequeue_script( $handle );
				}
			}
			return;
		}

		if ( get_theme_mod( 'rbp_inner_styling', true ) ) {
			wp_enqueue_style( 'rbp-inner', RBP_URI . '/assets/css/inner.css', array( 'zakra-style' ), RBP_VERSION );

			// Privacy (DSGVO): no fonts from Google servers – a system font stack is used instead.
			if ( get_theme_mod( 'rbp_no_google_fonts', true ) ) {
				foreach ( wp_styles()->queue as $handle ) {
					$src = isset( wp_styles()->registered[ $handle ] ) ? (string) wp_styles()->registered[ $handle ]->src : '';
					if ( false !== strpos( $src, 'fonts.googleapis.com' ) ) {
						wp_dequeue_style( $handle );
					}
				}
			}
		}
	},
	100
);

/**
 * Privacy (DSGVO): Zakra prints <link rel="preconnect" href="https://fonts.gstatic.com">,
 * which makes every visitor's browser contact Google even though no Google Font is loaded.
 * Remove it wherever this theme drops the Google Fonts.
 */
add_action(
	'wp_head',
	function () {
		if ( ! class_exists( 'Zakra_Enqueue_Scripts' ) ) {
			return;
		}
		$no_google = rbp_is_landing()
			|| ( get_theme_mod( 'rbp_inner_styling', true ) && get_theme_mod( 'rbp_no_google_fonts', true )
				&& ! get_theme_mod( 'zakra_load_google_fonts_locally', false ) );
		if ( $no_google ) {
			remove_action( 'wp_head', array( Zakra_Enqueue_Scripts::get_instance(), 'preload_web_fonts' ), 1 );
		}
	},
	0
);

add_filter(
	'body_class',
	function ( $classes ) {
		if ( rbp_is_landing() ) {
			$classes[] = 'rbp-landing';
		} elseif ( get_theme_mod( 'rbp_inner_styling', true ) ) {
			$classes[] = 'rbp-inner';
		}
		return $classes;
	}
);

/**
 * Inner pages: show the high-resolution logo (the uploaded custom logo is only 32 px wide).
 */
add_filter(
	'get_custom_logo',
	function ( $html ) {
		if ( ! get_theme_mod( 'rbp_inner_styling', true ) || '' === $html ) {
			return $html;
		}
		$html = preg_replace( '/\s(srcset|sizes)="[^"]*"/', '', $html );
		return preg_replace( '/\ssrc="[^"]*"/', ' src="' . esc_url( rbp_logo_url() ) . '"', $html, 1 );
	}
);
