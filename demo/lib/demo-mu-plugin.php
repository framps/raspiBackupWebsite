<?php
/**
 * Plugin Name: raspiBackup demo – live site styling
 * Description: Demo only. Adds the CSS captured from the live site (Zakra customizer output and
 *              BlockArt block styles) so the classic layout looks like raspibackup.linux-tips-and-tricks.de.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_enqueue_scripts',
	function () {
		if ( function_exists( 'rbp_is_landing' ) && rbp_is_landing() ) {
			return; // The new landing page brings its own design.
		}
		$css = get_option( 'rbp_demo_css' );
		if ( ! is_array( $css ) ) {
			return;
		}
		// Zakra customizer output of the live site: attached to Zakra's stylesheet.
		if ( wp_style_is( 'zakra-style', 'enqueued' ) || wp_style_is( 'zakra-style', 'registered' ) ) {
			wp_add_inline_style( 'zakra-style', $css['zakra'] . "\n" . $css['custom'] );
		}
		// BlockArt global + per-page block styles.
		wp_register_style( 'rbp-demo-blockart', false, array(), '1' );
		wp_enqueue_style( 'rbp-demo-blockart' );
		$page_css = '';
		if ( is_singular() && isset( $css['pages'][ get_queried_object_id() ] ) ) {
			$page_css = $css['pages'][ get_queried_object_id() ];
		}
		wp_add_inline_style( 'rbp-demo-blockart', $css['global'] . "\n" . $css['widgets'] . "\n" . $page_css );

		// Fonts of the live site – only for the classic look (the new design deliberately avoids Google Fonts).
		if ( 'zakra' === get_stylesheet() && ! empty( $css['fonts'] ) ) {
			foreach ( $css['fonts'] as $i => $href ) {
				wp_enqueue_style( 'rbp-demo-font-' . $i, $href, array(), null ); // phpcs:ignore
			}
		}
	},
	200
);

// Small banner so it is always clear which design is shown.
add_action(
	'wp_footer',
	function () {
		$pro   = 'raspibackup-pro' === get_stylesheet();
		$label = $pro ? 'NEW design · raspiBackup Pro' : 'CLASSIC layout · Zakra';
		if ( $pro && isset( $_GET['rbp_classic'] ) ) { // phpcs:ignore
			$label = 'CLASSIC home preview (?rbp_classic=1)';
		}
		printf(
			'<div style="position:fixed;left:12px;bottom:12px;z-index:99999;padding:6px 12px;border-radius:999px;font:600 12px/1.4 system-ui,sans-serif;background:%s;color:#fff;box-shadow:0 4px 14px rgba(0,0,0,.3);pointer-events:none">DEMO · %s</div>',
			$pro ? '#c8124b' : '#4b5563',
			esc_html( $label )
		);
	}
);
