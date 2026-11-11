<?php
/**
 * Customizer: Appearance → Customize → "raspiBackup Pro".
 *
 * @package raspibackup-pro
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_section(
			'rbp_section',
			array(
				'title'       => 'raspiBackup Pro',
				'priority'    => 1,
				'description' => 'Einstellungen für das neue Layout. / Settings for the new layout.<br><br>Zurück zum alten Layout: Design → Themes → „Zakra“ aktivieren. / Back to the classic layout: Appearance → Themes → activate “Zakra”.',
			)
		);

		$bool = static function ( $v ) {
			return (bool) $v;
		};

		$checkboxes = array(
			'rbp_landing_enabled'   => array( 'Neue Startseite verwenden / Use new home page', true ),
			'rbp_inner_styling'     => array( 'Modernisiertes Design für alle anderen Seiten / Refreshed styling for all other pages', true ),
			'rbp_no_google_fonts'   => array( 'Keine Google Fonts laden (DSGVO) / Do not load Google Fonts (GDPR)', true ),
			'rbp_github_stats'      => array( 'Aktuelle Version und GitHub Sterne anzeigen / Show latest release and GitHub stars', true ),
			'rbp_show_page_content' => array( 'Inhalt aus dem Seiteneditor unter der neuen Startseite anzeigen / Show page editor content below the new home page', false ),
		);
		foreach ( $checkboxes as $id => $cfg ) {
			list( $label, $default ) = $cfg;
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $default,
					'sanitize_callback' => $bool,
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'type'    => 'checkbox',
					'section' => 'rbp_section',
					'label'   => $label,
				)
			);
		}

		foreach ( array(
			'en' => 'Demo GIF / Bild (English)',
			'de' => 'Demo GIF / Bild (Deutsch)',
		) as $lang => $label ) {
			$wp_customize->add_setting(
				'rbp_demo_' . $lang,
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'rbp_demo_' . $lang,
					array(
						'section'     => 'rbp_section',
						'label'       => $label,
						'description' => 'Leer = raspiBackupInstall_' . $lang . '.gif aus der Mediathek. / Empty = raspiBackupInstall_' . $lang . '.gif from the media library.',
					)
				)
			);
		}

		$wp_customize->add_setting(
			'rbp_logo',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'rbp_logo',
				array(
					'section'     => 'rbp_section',
					'label'       => 'Logo (neues Design / new design)',
					'description' => 'Leer = Original Icon_rot_blau_final.png. Eine Datei assets/img/logo.svg im Theme hat Vorrang. / Empty = original Icon_rot_blau_final.png. A file assets/img/logo.svg in the theme takes precedence.',
				)
			)
		);

		foreach ( array(
			'en' => 'YouTube video (English)',
			'de' => 'YouTube Video (Deutsch)',
		) as $lang => $label ) {
			$wp_customize->add_setting(
				'rbp_youtube_' . $lang,
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'rbp_youtube_' . $lang,
				array(
					'type'        => 'text',
					'section'     => 'rbp_section',
					'label'       => $label,
					'description' => 'Optional: URL oder ID. Wird datenschutzfreundlich erst nach Klick geladen und neben dem Demo GIF angezeigt. / Optional: URL or ID. Privacy-friendly, loaded only after a click.',
				)
			);
		}

		foreach ( array(
			'rbp_imprint_url' => 'Impressum URL / Imprint URL',
			'rbp_privacy_url' => 'Datenschutz URL / Privacy URL (leer = WordPress Datenschutzseite)',
		) as $id => $label ) {
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'type'    => 'url',
					'section' => 'rbp_section',
					'label'   => $label,
				)
			);
		}
	}
);

/**
 * Clear the cached GitHub numbers whenever the customizer is saved.
 */
add_action(
	'customize_save_after',
	function () {
		delete_transient( 'rbp_github_stats' );
	}
);
