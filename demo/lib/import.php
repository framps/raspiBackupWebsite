<?php
/**
 * Demo import – run via: wp eval-file import.php <snapshot-dir>
 * Recreates the live site's pages (EN/DE home, Documents), Polylang setup, menu,
 * logo and styling from HTML snapshots of https://raspibackup.linux-tips-and-tricks.de.
 *
 * @package raspibackup-demo
 */

$snap = isset( $args[0] ) ? rtrim( $args[0], '/' ) : '';
if ( ! is_dir( $snap ) ) {
	WP_CLI::error( "Snapshot directory missing: $snap" );
}

/**
 * Text between two markers.
 */
function rbpd_between( $s, $start_re, $end ) {
	if ( ! preg_match( $start_re, $s, $m, PREG_OFFSET_CAPTURE ) ) {
		return '';
	}
	$from = $m[0][1] + strlen( $m[0][0] );
	$to   = strpos( $s, $end, $from );
	return false === $to ? '' : trim( substr( $s, $from, $to - $from ) );
}

function rbpd_style( $s, $id_re ) {
	return preg_match( '#<style id="' . $id_re . '">(.*?)</style>#s', $s, $m ) ? $m[1] : '';
}

$en_html  = file_get_contents( "$snap/home-en.html" );
$de_html  = file_get_contents( "$snap/home-de.html" );
$doc_html = file_get_contents( "$snap/documents-en.html" );

$en_content  = rbpd_between( $en_html, '#<div class="entry-content">#', '</div><!-- .entry-content -->' );
$de_content  = rbpd_between( $de_html, '#<div id="primary" class="zak-primary pagebuilder-content">#', '</div><!-- zak-primary -->' );
$doc_content = rbpd_between( $doc_html, '#<div class="entry-content">#', '</div><!-- .entry-content -->' );
foreach ( array( 'EN home' => $en_content, 'DE home' => $de_content, 'Documents' => $doc_content ) as $k => $v ) {
	if ( '' === $v ) {
		WP_CLI::warning( "Could not extract content for $k – the live page markup may have changed." );
	}
}

// Keep the HTML exactly as captured (wp-cli has no user with unfiltered_html).
kses_remove_filters();

// ---------- Site basics ----------
update_option( 'blogname', 'How to backup your Raspberries' );
update_option( 'blogdescription', 'raspiBackup is the perfect opensource tool to create backups on Raspberries' );

// ---------- Polylang ----------
$model = PLL()->model;
foreach ( array( array( 'English', 'en', 'en_US', 0 ), array( 'Deutsch', 'de', 'de_DE', 1 ) ) as $l ) {
	if ( ! $model->get_language( $l[1] ) ) {
		$r = $model->add_language( array( 'name' => $l[0], 'slug' => $l[1], 'locale' => $l[2], 'rtl' => 0, 'term_group' => $l[3] ) );
		if ( is_wp_error( $r ) ) {
			WP_CLI::error( $r->get_error_message() );
		}
	}
}
$o = PLL()->options;
$o->set( 'default_lang', 'en' );
$o->set( 'force_lang', 1 );       // Language as directory: /en/…, /de/…
$o->set( 'hide_default', false ); // Also /en/ for English (like the live site).
$o->set( 'rewrite', true );
$o->set( 'redirect_lang', true ); // Front page URL contains the page name: /en/home/.
$o->set( 'browser', false );

// ---------- Pages ----------
$wrap = static function ( $html ) {
	return "<!-- wp:html -->\n" . $html . "\n<!-- /wp:html -->";
};
$page = static function ( $title, $slug, $content ) {
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( $id->get_error_message() );
	}
	return $id;
};

$en  = $page( 'Home', 'home', $wrap( $en_content ) );
$de  = $page( 'Home Deutsch', 'home-deutsch', $wrap( $de_content ) );
$doc = $page( 'Documents about raspiBackup', 'documents-about-raspibackup', $wrap( $doc_content ) );

// Same Zakra page settings as on the live site.
update_post_meta( $en, 'zakra_page_container_layout', 'stretched' );
update_post_meta( $en, 'zakra_page_sidebar_layout', 'no_sidebar' );
update_post_meta( $en, 'zakra_remove_content_margin', 1 );
update_post_meta( $de, '_wp_page_template', 'page-templates/pagebuilder.php' );
update_post_meta( $en, 'zakra_page_header', 0 );
update_post_meta( $de, 'zakra_page_header', 0 );

// Header like the live site: menu left, logo right, no site title text.
set_theme_mod( 'zakra_main_header_layout_1_style', 'style-3' );
set_theme_mod( 'header_textcolor', 'blank' );

pll_set_post_language( $en, 'en' );
pll_set_post_language( $de, 'de' );
pll_set_post_language( $doc, 'en' );
pll_save_post_translations( array( 'en' => $en, 'de' => $de ) );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $en );

// Remove WordPress sample content.
foreach ( get_posts( array( 'post_type' => array( 'post', 'page' ), 'numberposts' => -1, 'post_status' => 'any' ) ) as $p ) {
	if ( ! in_array( $p->ID, array( $en, $de, $doc ), true ) && in_array( $p->post_name, array( 'hello-world', 'sample-page' ), true ) ) {
		wp_delete_post( $p->ID, true );
	}
}

// ---------- Menu (like the live site: Home, language switcher, Documents) ----------
$menu = wp_create_nav_menu( 'Primary' );
wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => 'Home', 'menu-item-object' => 'page', 'menu-item-object-id' => $en, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
$sw = wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => 'Languages', 'menu-item-url' => '#pll_switcher', 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' ) );
update_post_meta( $sw, '_pll_menu_item', array( 'hide_if_no_translation' => 0, 'hide_current' => 0, 'force_home' => 0, 'show_flags' => 0, 'show_names' => 1, 'dropdown' => 0 ) );
wp_update_nav_menu_item( $menu, 0, array( 'menu-item-title' => 'Documents', 'menu-item-object' => 'page', 'menu-item-object-id' => $doc, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
set_theme_mod( 'nav_menu_locations', array( 'menu-primary' => $menu ) );
$o->set( 'nav_menus', array( get_stylesheet() => array( 'menu-primary' => array( 'en' => $menu, 'de' => $menu ) ) ) );

// ---------- Logo ----------
$logo_rel  = '2023/09/Icon_rot_blau_final_32.png';
$logo_file = wp_upload_dir()['basedir'] . '/' . $logo_rel;
if ( file_exists( $logo_file ) ) {
	$att = wp_insert_attachment( array( 'post_mime_type' => 'image/png', 'post_title' => 'raspiBackup logo', 'post_status' => 'inherit' ), $logo_file );
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $logo_file ) );
	set_theme_mod( 'custom_logo', $att );
	update_option( 'site_icon', $att );
}

// ---------- Live site CSS for the classic look ----------
update_option(
	'rbp_demo_css',
	array(
		'zakra'   => rbpd_style( $en_html, 'zakra-style-inline-css' ),
		'custom'  => rbpd_style( $en_html, 'wp-custom-css' ),
		'global'  => rbpd_style( $en_html, 'blockart-global-styles-inline-css' ),
		'widgets' => rbpd_style( $en_html, 'blockart-blocks-css-widgets-inline-css' ),
		'fonts'   => array_values(
			array_unique(
				array_map(
					'html_entity_decode',
					preg_match_all( "#<link rel='stylesheet' id='[^']*' href='(https://fonts\.googleapis\.com/[^']+)'#", $en_html . $de_html, $fm ) ? $fm[1] : array()
				)
			)
		),
		'pages'   => array(
			$en => rbpd_style( $en_html, 'blockart-blocks-css-\d+-inline-css' ),
			$de => rbpd_style( $de_html, 'blockart-blocks-css-\d+-inline-css' ),
		),
	),
	false
);

WP_CLI::success( "Imported: EN home #$en, DE home #$de, Documents #$doc, menu #$menu" );
