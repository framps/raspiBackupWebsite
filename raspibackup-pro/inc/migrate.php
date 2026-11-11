<?php
/**
 * Seamless switching between Zakra and raspiBackup Pro.
 *
 * WordPress stores customizer settings (logo, colors, menu locations, …) per theme.
 * When this child theme is activated, Zakra's settings are copied over once so that
 * logo, menus and the Polylang language menus keep working. Zakra's own settings are
 * never modified, so switching back to Zakra restores the classic site exactly.
 *
 * @package raspibackup-pro
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_switch_theme',
	function () {
		$child  = get_stylesheet();
		$parent = get_template();
		if ( $child === $parent ) {
			return;
		}

		// 1. Theme mods: copy every Zakra setting the child does not have yet (child values win).
		$parent_mods = get_option( 'theme_mods_' . $parent, array() );
		$child_mods  = get_option( 'theme_mods_' . $child, array() );
		if ( is_array( $parent_mods ) ) {
			// Widgets are mapped by WordPress itself; "Additional CSS" stays bound to Zakra
			// (otherwise editing it here would change the classic layout, too).
			unset( $parent_mods['sidebars_widgets'], $parent_mods['custom_css_post_id'] );
			$child_mods = is_array( $child_mods ) ? $child_mods : array();
			update_option( 'theme_mods_' . $child, $child_mods + $parent_mods );
		}

		// 2. Polylang stores menu locations per theme and language.
		$pll = get_option( 'polylang' );
		if ( is_array( $pll ) && ! empty( $pll['nav_menus'][ $parent ] ) && empty( $pll['nav_menus'][ $child ] ) ) {
			$pll['nav_menus'][ $child ] = $pll['nav_menus'][ $parent ];
			update_option( 'polylang', $pll );
		}

		delete_transient( 'rbp_github_stats' );
	}
);
