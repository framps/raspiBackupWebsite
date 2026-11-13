<?php
/**
 * All texts of the landing page, in English and German.
 * Edit this file to change wording. Simple HTML (links, <strong>, <em>) is allowed.
 *
 * @package raspibackup-pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the content for one language ('en' or 'de').
 *
 * @param string $lang Language slug.
 * @return array
 */
function rbp_content( $lang ) {
	$gh   = 'https://github.com/framps/raspiBackup';
	$doc  = 'de' === $lang ? 'https://framps.github.io/raspiBackupDoc/de/' : 'https://framps.github.io/raspiBackupDoc/';
	$yt   = 'https://www.youtube.com/channel/UCnFHtfMXVpWy6mzMazqyINg';
	$fb   = 'https://www.facebook.com/raspiBackup';
	$rd   = 'https://www.reddit.com/r/raspiBackup/';
	$tw   = 'https://twitter.com/linuxframp';
	$lnk  = static function ( $url, $text ) {
		return '<a href="' . esc_url( $url ) . '">' . $text . '</a>';
	};

	$common = array(
		'install_cmd' => 'curl -sSLO --fail https://raw.githubusercontent.com/framps/raspiBackup/master/published/raspiBackupInstallUI.sh && sudo bash ./raspiBackupInstallUI.sh',
		'links'       => array(
			'github'      => $gh,
			'discussions' => $gh . '/discussions',
			'issues'      => $gh . '/issues',
			'releases'    => $gh . '/releases',
			'helper'      => $gh . '/tree/master/helper#readme',
			'youtube'     => $yt,
			'facebook'    => $fb,
			'reddit'      => $rd,
			'twitter'     => $tw,
			'doc'         => $doc . 'introduction.html',
			'install5'    => $doc . 'installation-in-5-minutes.html',
			'faq'         => $doc . 'faq.html',
			'config'      => $doc . 'configuration-examples.html',
			'nfs'         => $doc . 'nfs-as-backuptarget.html',
			'errors'      => $doc . 'error-messages.html',
			'smart'       => $doc . 'smart-recycle.html',
			'donate'      => $doc . ( 'de' === $lang ? 'introduction.html#trinkgeld' : 'introduction.html#donations' ),
			'documents'   => home_url( '/en/documents-about-raspibackup/' ),
			'rpios'       => 'https://www.raspberrypi.com/software/operating-systems/',
			'ubuntu'      => 'https://ubuntu.com/download/raspberry-pi',
		),
	);

	if ( 'de' === $lang ) {
		return $common + array(
			'meta_title'       => 'raspiBackup – Automatische Sicherung Deiner Raspberries',
			'meta_description' => 'raspiBackup erstellt regelmäßig und unbeaufsichtigt vollständige Systemsicherungen Deiner Raspberry Pi und verwaltet eine konfigurierbare Sicherungshistorie. Open Source, in 5 Minuten installiert.',
			'nav'              => array(
				'opensource' => 'Open Source',
				'features'  => 'Funktionen',
				'how'       => 'So funktioniert’s',
				'demo'      => 'Demo',
				'compat'    => 'Hardware',
				'docs'      => 'Dokumentation',
				'community' => 'Community',
				'cta'       => 'Jetzt installieren',
				'menu'      => 'Menü',
				'skip'      => 'Zum Inhalt springen',
				'language'  => 'Sprache',
			),
			'hero'             => array(
				'eyebrow'   => 'Freie Software · GPL-3.0 · seit 2013',
				'title'     => 'Backups für Deinen Raspberry Pi.',
				'accent'    => 'Kostenlos & Open Source.',
				'lead'      => 'raspiBackup sichert Deine Raspberries regelmäßig und unbeaufsichtigt und verwaltet eine konfigurierbare Sicherungshistorie. Nach einer Wiederherstellung startet das System sofort wieder. Ein Open-Source-Projekt von framp, entwickelt mit Hilfe der Community – ohne Abo, ohne Cloud, ohne Haken.',
				'cta'       => 'Erste Sicherung in 5 Minuten',
				'cta2'      => 'Auf GitHub ansehen',
				'cmd_label' => 'Installation – einfach im Terminal ausführen:',
				'copy'      => 'Kopieren',
				'copied'    => 'Kopiert!',
				'release'   => 'Aktuelle Version',
				'stars'     => 'GitHub Sterne',
			),
			'stats'            => array(
				array( 'Raspberry Pi 1 – 5', 'inkl. Zero, 400, 500 und Compute Module 4 und 5' ),
				array( 'SD · eMMC · USB · SSD · NVMe', 'Unterstützte Bootgeräte' ),
				array( 'dd · tar · rsync', 'Voll- und inkrementelle Sicherungen' ),
				array( 'Raspberry Pi OS & Ubuntu', 'Unterstützte Betriebssysteme' ),
			),
			'history'          => array( array( 0, 'täglich', 'day' ), array( 1, 'täglich', 'day' ), array( 2, 'täglich', 'day' ), array( 7, 'wöchentlich', 'week' ), array( 14, 'wöchentlich', 'week' ), array( 31, 'monatlich', 'month' ), array( 365, 'jährlich', 'year' ) ),
			'toast'            => 'Sicherung erfolgreich beendet',
			'opensource_title' => 'Frei, offen und von der Community getragen',
			'opensource_lead'  => 'raspiBackup ist kein Produkt einer Firma, sondern ein Open-Source-Projekt: seit 2013 von framp entwickelt, auf echten Raspberries getestet und durch Ideen, Fehlermeldungen und Betatests vieler Nutzer immer besser geworden.',
			'opensource_facts' => array(
				'since' => array( 'seit 2013', 'in Entwicklung' ),
				'stars' => 'GitHub Sterne',
				'forks' => 'Forks auf GitHub',
				'lic'   => array( 'GPL-3.0', 'freie Lizenz' ),
			),
			'opensource'       => array(
				array( 'heart', 'Kostenlos – für immer', 'Keine Lizenzkosten, kein Abo, keine Werbung und keine eingeschränkte „Free“-Version. Alle Funktionen stehen jedem zur Verfügung.' ),
				array( 'code', 'Offener Quellcode', 'Jede Zeile ist ' . $lnk( $gh, 'auf GitHub' ) . ' einsehbar. Du siehst genau, was raspiBackup mit Deinem System macht – und kannst es prüfen, anpassen und verbessern.' ),
				array( 'lock', 'Deine Daten bleiben bei Dir', 'Keine Cloud, kein Benutzerkonto, kein Tracking. Die Sicherungen landen dort, wo Du willst: auf einer USB Platte, einer SSD oder Deinem NAS.' ),
				array( 'unlock', 'Kein Lock-in', 'raspiBackup nutzt bewährte Standardwerkzeuge: dd, tar und rsync. dd-Sicherungen lassen sich sogar mit jedem Image-Tool zurückspielen.' ),
				array( 'users', 'Gemeinsam mit der Community entwickelt', 'Viele Funktionen sind aus Vorschlägen von Nutzern entstanden und wurden von der Community getestet, bevor sie veröffentlicht wurden. Support gibt framp persönlich in den ' . $lnk( $gh . '/discussions', 'GitHub Discussions' ) . ' und ' . $lnk( $gh . '/issues', 'Issues' ) . ', Neuigkeiten auch auf ' . $lnk( $fb, 'Facebook' ) . ', ' . $lnk( $rd, 'Reddit' ) . ' und ' . $lnk( $tw, 'X' ) . '.' ),
				array( 'branch', 'Mitmachen erwünscht', 'Ideen, Betatests, Übersetzungen oder Code – jeder Beitrag hilft. ' . $lnk( $doc . 'introduction.html#trinkgeld', 'Trinkgelder' ) . ' finanzieren in erster Linie SD Karten und USB Platten für Entwicklung und Tests – und, wenn es reicht, auch neue Raspberry Hardware, um raspiBackup darauf zu testen und zu unterstützen.' ),
			),
			'opensource_thanks' => '<strong>Danke, rpi-simonz!</strong> Ein besonderer Dank geht an ' . $lnk( 'https://github.com/rpi-simonz', 'rpi-simonz' ) . ' für den Aufbau der ' . $lnk( $doc . 'introduction.html', 'raspiBackup Dokumentation' ) . ' auf GitHub, die Übertragung aller Seiten von framps Homepage und die intensive Unterstützung bei ihrer Überarbeitung.',
			'opensource_cta'   => 'Quellcode auf GitHub',
			'opensource_cta2'  => 'Mitmachen',
			'features_title'   => 'Was raspiBackup alles kann',
			'features_lead'    => 'Von der ersten Installation bis zur Wiederherstellung im Notfall – raspiBackup kümmert sich um den kompletten Lebenszyklus Deiner Sicherungen.',
			'highlights'       => array(
				array(
					'icon'  => 'clock',
					'title' => 'Regelmäßig und vollautomatisch',
					'text'  => 'Keine manuelle Sicherung mehr notwendig – eine Sicherung wird nie mehr vergessen. Gesichert werden entweder die beiden Raspberry Pi OS Partitionen (normaler Backupmodus) oder beliebig konfigurierbare Partitionen (partitionsorientierter Backupmodus), so dass auch Datenpartitionen gesichert werden.',
				),
				array(
					'icon'  => 'terminal',
					'title' => 'Menügeführter Installer',
					'text'  => 'Die wichtigsten Optionen werden wie bei raspi-config in Deutsch, Englisch, Finnisch, Chinesisch oder Französisch konfiguriert – die erste Sicherung ist in 5 Minuten erstellt. Alle weiteren, z.T. sehr mächtigen Optionen sind in der ' . $lnk( $doc . 'introduction.html', 'Dokumentation' ) . ' beschrieben.',
				),
				array(
					'icon'  => 'layers',
					'title' => 'Voll- und inkrementelle Sicherungen',
					'text'  => 'Die Backuptypen dd und tar erstellen vollständige Sicherungen. Der Backuptyp rsync sichert inkrementell und spart damit Zeit und Platz. Unabhängig vom Backuptyp startet das System nach einer Wiederherstellung sofort.',
				),
				array(
					'icon'  => 'rotate',
					'title' => 'Intelligente Rotation (GVS)',
					'text'  => 'Entweder wird eine feste Anzahl von Sicherungen vorgehalten oder die ' . $lnk( $doc . 'smart-recycle.html', 'Großvater-Vater-Sohn Strategie' ) . ' (Smart Recycle) verwendet. So bleibt eine beliebig lange Sicherungshistorie erhalten.',
				),
				array(
					'icon'  => 'copy',
					'title' => 'Klon für den Notfall',
					'text'  => 'Seit Release 0.7.3 kann nach jeder Sicherung automatisch ein Klon auf einem lokal angeschlossenen Gerät erstellt werden (Option --clone). Fällt das System aus, wird einfach vom Klon gestartet – ganz ohne zeitaufwändige Wiederherstellung. Mit rsync ist der Klon in kürzester Zeit aktualisiert. ' . $lnk( $doc . 'how-to-enable-clone.html', 'So richtest Du den Klon ein' ) . '.',
				),
				array(
					'icon'  => 'camera',
					'title' => 'Snapshots',
					'text'  => 'Vor wichtigen Updates oder Installationen einen Snapshot mit Beschreibung erstellen. Geht etwas schief oder startet das System nicht mehr, setzt Du einfach dort wieder auf – statt ganz von vorne anzufangen.',
				),
			),
			'more_title'       => 'Und noch viel mehr',
			'more'             => array(
				array( 'bell', 'Benachrichtigungen', 'Ergebnis jedes Sicherungslaufs per eMail, Telegram, Pushover oder Slack. Smilies zeigen sofort Erfolg 🙂 oder Misserfolg 🙁 – und erinnern an neue Releases oder den nächsten Restoretest.' ),
				array( 'windows', 'Wiederherstellung unter Windows', 'dd-Sicherungen lassen sich mit win32diskimager o.ä. unter Windows zurückspielen. tar und rsync benötigen ein Linuxsystem – z.B. einen Raspberry mit vorkonfigurierter SD Karte.' ),
				array( 'move', 'Einfacher Systemumzug', 'Jede Sicherung kann auf SD Karte, USB Platte, USB Stick, SSD oder NVMe zurückgespielt werden – schon ist das System umgezogen.' ),
				array( 'drive', 'NVMe Unterstützung', 'NVMe Speicher des Raspberry Pi 5 und 500 sowie der Compute Module 4 und 5 (CM4, CM5) wird unterstützt.' ),
				array( 'plug', 'Erweiterungspunkte', 'Eigener Code kann vor und nach Sicherung und Wiederherstellung ausgeführt werden – z.B. stoppt eine Extension alle Docker Container vor dem Backup und startet sie danach wieder.' ),
				array( 'download', 'Update-Benachrichtigungen', 'Sobald eine Beta oder ein neues Release verfügbar ist, meldet sich raspiBackup. Upgrade und Downgrade sind jederzeit einfach möglich.' ),
				array( 'shield', 'Automatische Regressionstests', 'Sicherung und Wiederherstellung werden für alle Backuptypen und -modi automatisch getestet – jedes Release arbeitet so zuverlässig wie das vorherige.' ),
				array( 'code', 'Hilfs- und Beispielscripte', 'Verschiedene ' . $lnk( $gh . '/tree/master/helper#readme', 'Hilfs- und Beispielscripte' ) . ' stehen auf GitHub zur Verfügung.' ),
			),
			'how_title'        => 'In drei Schritten zur ersten Sicherung',
			'how'              => array(
				array( 'Installieren', 'Den Installer mit einem einzigen Befehl starten – menügeführt wie raspi-config.' ),
				array( 'Konfigurieren', 'Backupziel, Backuptyp, Anzahl der Sicherungen und Benachrichtigungen auswählen.' ),
				array( 'Zurücklehnen', 'raspiBackup sichert ab jetzt automatisch und informiert Dich über jeden Lauf.' ),
			),
			'demo_title'       => 'Die Installation in Aktion',
			'demo_lead'        => 'So einfach wird raspiBackup installiert und konfiguriert. Hinweis: Finnisch, Französisch, Englisch und Chinesisch werden ebenfalls unterstützt.',
			'demo_alt'         => 'Animierte Demo der menügeführten raspiBackup Installation',
			'demo_yt'          => 'Weitere Videos auf YouTube',
			'video_consent'    => 'Mit dem Abspielen wird das Video von YouTube geladen. Dabei gelten die Datenschutzbestimmungen von Google.',
			'video_play'       => 'Video abspielen',
			'compat_title'     => 'Gemacht für den Raspberry Pi',
			'compat_lead'      => 'raspiBackup wird speziell für Raspberry Pi Hardware und Raspberry Pi OS entwickelt und auf echten Raspberries getestet.',
			'hardware'         => array(
				array( 'Raspberry Pi 5', 'SD Karte · USB Boot · NVMe' ),
				array( 'Raspberry Pi 500', 'SD Karte · USB Boot · NVMe' ),
				array( 'Raspberry Pi 4 · 400', 'SD Karte · USB Boot' ),
				array( 'Raspberry Pi 3', 'SD Karte · USB Boot' ),
				array( 'Raspberry Pi 1 · 2 · Zero', 'SD Karte · Hybrid USB Boot' ),
				array( 'Compute Module 4 · 5', 'SD Karte · eMMC · USB Boot · NVMe' ),
			),
			'hardware_note'    => 'Andere Boards wie Banana Pi, Odroid oder Beagle Board funktionieren eventuell mit der Option --unsupportedEnvironment – unterstützt wird aber nur Raspberry Pi Hardware.',
			'compat'           => array(
				array(
					'title' => 'Alle Bootmodi',
					'items' => array(
						'<strong>SD Karte:</strong> Booten und Rootfilesystem auf der SD Karte (alle Modelle mit SD Kartenslot)',
						'<strong>Hybrid USB Boot:</strong> Booten von der SD Karte, Rootfilesystem auf einem USB Gerät (Raspberry Pi 1, 2 und Zero)',
						'<strong>USB Boot:</strong> Booten direkt von einem USB Gerät (alle Modelle ab Raspberry Pi 3)',
					),
				),
				array(
					'title' => 'Betriebssysteme',
					'items' => array(
						$lnk( 'https://www.raspberrypi.com/software/operating-systems/', 'Raspberry Pi OS / Raspbian' ),
						$lnk( 'https://ubuntu.com/download/raspberry-pi', 'Ubuntu' ),
					),
				),
				array(
					'title' => 'Bootgeräte',
					'items' => array(
						'SD Karte',
						'eMMC (Compute Module 4 und 5)',
						'USB Platte und SSD',
						'NVMe (Raspberry Pi 5, 500, CM4, CM5)',
					),
				),
				array(
					'title' => 'Backupziele',
					'items' => array(
						'USB Platte und USB Stick',
						'Netzwerklaufwerke per NFS, SMB oder WebDAV – z.B. eine ' . $lnk( $doc . 'nfs-as-backuptarget.html', 'Synology mit NFS' ),
						'<strong>Kurz:</strong> alles, was sich unter Linux mounten lässt',
					),
				),
			),
			'docs_title'       => 'Dokumentation & Ressourcen',
			'docs_lead'        => 'Eine vollständige Dokumentation beantwortet (fast) jede Frage.',
			'docs'             => array(
				array( 'install5', 'Installation in 5 Minuten', 'Schritt für Schritt zur ersten Sicherung' ),
				array( 'doc', 'Dokumentation', 'Alle Optionen und Konzepte im Detail' ),
				array( 'faq', 'FAQ', 'Antworten auf häufige Fragen' ),
				array( 'config', 'Konfigurationsbeispiele', 'Fertige Konfigurationen zum Übernehmen' ),
				array( 'errors', 'Fehlermeldungen', 'Was sie bedeuten und wie man sie beseitigt' ),
				array( 'documents', 'PDF Dokumente', 'Präsentationen und Übersichten zum Download' ),
			),
			'community_title'  => 'Fragen, Ideen, Austausch',
			'community_lead'   => 'Support gibt es direkt von framp – am besten über die GitHub Discussions oder Issues. Neuigkeiten und Austausch findest Du außerdem auf Facebook, Reddit und X. Die Anmeldung bei GitHub ist kostenlos; Beiträge möglichst auf Englisch, Deutsch wird aber auch akzeptiert. ' . $lnk( $doc . 'introduction.html#trinkgeld', 'Trinkgelder' ) . ' sind gern gesehen 😉',
			'community'        => array(
				array( 'github', 'Fragen stellen', 'GitHub Discussions', 'discussions' ),
				array( 'bug', 'Fehler melden', 'GitHub Issues', 'issues' ),
				array( 'youtube', 'Videos ansehen', 'YouTube Kanal', 'youtube' ),
				array( 'facebook', 'Neuigkeiten', 'Facebook', 'facebook' ),
				array( 'reddit', 'Diskutieren', 'Reddit r/raspiBackup', 'reddit' ),
				array( 'x', 'Folgen', 'X / Twitter', 'twitter' ),
			),
			'cta_title'        => 'Dann lass uns anfangen.',
			'cta_lead'         => 'Erstelle Deine erste Sicherung in 5 Minuten 🙂',
			'cta_button'       => 'Zur Installationsanleitung',
			'footer_tagline'   => 'Das perfekte Open-Source-Tool, um Raspberries zu sichern.',
			'footer_project'   => 'Projekt',
			'footer_resources' => 'Ressourcen',
			'footer_community' => 'Community',
			'footer_imprint'   => 'Impressum',
			'footer_privacy'   => 'Datenschutz',
			'footer_releases'  => 'Releases',
			'footer_donate'    => 'Trinkgeld',
		);
	}

	return $common + array(
		'meta_title'       => 'raspiBackup – Automatic backups for your Raspberry Pi',
		'meta_description' => 'raspiBackup reliably creates regular, unattended full system backups of your Raspberry Pi and maintains a configurable backup history. Open source, installed in 5 minutes.',
		'nav'              => array(
			'opensource' => 'Open source',
			'features'  => 'Features',
			'how'       => 'How it works',
			'demo'      => 'Demo',
			'compat'    => 'Hardware',
			'docs'      => 'Docs',
			'community' => 'Community',
			'cta'       => 'Get started',
			'menu'      => 'Menu',
			'skip'      => 'Skip to content',
			'language'  => 'Language',
		),
		'hero'             => array(
			'eyebrow'   => 'Free software · GPL-3.0 · since 2013',
			'title'     => 'Backups for your Raspberry Pi.',
			'accent'    => 'Free & open source.',
			'lead'      => 'raspiBackup backs up your Raspberries regularly and unattended and maintains a configurable backup history. Restore a backup and your system boots right away. An open source project by framp, developed with the help of the community – no subscription, no cloud, no catch.',
			'cta'       => 'Your first backup in 5 minutes',
			'cta2'      => 'View on GitHub',
			'cmd_label' => 'Install – just run this in a terminal:',
			'copy'      => 'Copy',
			'copied'    => 'Copied!',
			'release'   => 'Latest release',
			'stars'     => 'GitHub stars',
		),
		'stats'            => array(
			array( 'Raspberry Pi 1 – 5', 'including Zero, 400, 500 and Compute Module 4 and 5' ),
			array( 'SD · eMMC · USB · SSD · NVMe', 'Supported boot devices' ),
			array( 'dd · tar · rsync', 'Full and incremental backups' ),
			array( 'Raspberry Pi OS & Ubuntu', 'Supported operating systems' ),
		),
		'history'          => array( array( 0, 'daily', 'day' ), array( 1, 'daily', 'day' ), array( 2, 'daily', 'day' ), array( 7, 'weekly', 'week' ), array( 14, 'weekly', 'week' ), array( 31, 'monthly', 'month' ), array( 365, 'yearly', 'year' ) ),
		'toast'            => 'Backup finished successfully',
		'opensource_title' => 'Free, open and community-driven',
		'opensource_lead'  => 'raspiBackup is not a company’s product but an open source project: developed by framp since 2013, tested on real Raspberries, and improved by the ideas, bug reports and beta tests of many users.',
		'opensource_facts' => array(
			'since' => array( 'since 2013', 'in development' ),
			'stars' => 'GitHub stars',
			'forks' => 'forks on GitHub',
			'lic'   => array( 'GPL-3.0', 'free license' ),
		),
		'opensource'       => array(
			array( 'heart', 'Free – forever', 'No license fees, no subscription, no ads and no limited “free” edition. Every feature is available to everyone.' ),
			array( 'code', 'Open source code', 'Every line is ' . $lnk( $gh, 'on GitHub' ) . '. You see exactly what raspiBackup does to your system – and you can review, adapt and improve it.' ),
			array( 'lock', 'Your data stays with you', 'No cloud, no account, no tracking. Your backups go where you want them: a USB disk, an SSD or your NAS.' ),
			array( 'unlock', 'No lock-in', 'raspiBackup uses proven standard tools: dd, tar and rsync. dd backups can even be restored with any image tool.' ),
			array( 'users', 'Developed with the community', 'Many features started as suggestions from users and were tested by the community before their release. Support is given by framp personally in ' . $lnk( $gh . '/discussions', 'GitHub Discussions' ) . ' and ' . $lnk( $gh . '/issues', 'issues' ) . ', news also on ' . $lnk( $fb, 'Facebook' ) . ', ' . $lnk( $rd, 'Reddit' ) . ' and ' . $lnk( $tw, 'X' ) . '.' ),
			array( 'branch', 'Contributions welcome', 'Ideas, beta tests, translations or code – every contribution helps. ' . $lnk( $doc . 'introduction.html#donations', 'Donations' ) . ' mainly pay for the SD cards and USB disks used for development and testing – and, if there is enough, for new Raspberry hardware to test and support raspiBackup on.' ),
		),
		'opensource_thanks' => '<strong>Thank you, rpi-simonz!</strong> Special thanks go to ' . $lnk( 'https://github.com/rpi-simonz', 'rpi-simonz' ) . ' for setting up the ' . $lnk( $doc . 'introduction.html', 'raspiBackup documentation' ) . ' on GitHub, moving all pages over from framp’s homepage, and the intensive support during their revision.',
		'opensource_cta'   => 'Source code on GitHub',
		'opensource_cta2'  => 'Get involved',
		'features_title'   => 'What raspiBackup can do',
		'features_lead'    => 'From the first installation to a restore in an emergency – raspiBackup takes care of the complete lifecycle of your backups.',
		'highlights'       => array(
			array(
				'icon'  => 'clock',
				'title' => 'Regular, fully automatic backups',
				'text'  => 'No more manual backups – a regular backup is never forgotten again. Either the two Raspberry Pi OS partitions are saved (normal backup mode) or any configurable set of partitions (partition-oriented backup mode), so dedicated data partitions can be included as well.',
			),
			array(
				'icon'  => 'terminal',
				'title' => 'Menu-driven installer',
				'text'  => 'Install and configure the major options just like raspi-config – in English, German, Finnish, Chinese or French – and create your first backup in 5 minutes. All the more sophisticated options are described in the ' . $lnk( $doc . 'introduction.html', 'documentation' ) . '.',
			),
			array(
				'icon'  => 'layers',
				'title' => 'Full and incremental backups',
				'text'  => 'Backup types dd and tar create full backups. Backup type rsync creates incremental backups and saves time and space. Whatever type you use, a restored system boots immediately.',
			),
			array(
				'icon'  => 'rotate',
				'title' => 'Smart rotation (GFS)',
				'text'  => 'Keep a fixed number of recent backups, or use the ' . $lnk( $doc . 'smart-recycle.html', 'grandfather-father-son strategy' ) . ' (smart recycle) to maintain a long backup history with minimal space.',
			),
			array(
				'icon'  => 'copy',
				'title' => 'Standby clone',
				'text'  => 'Since release 0.7.3, raspiBackup can create a clone on a locally connected device after every backup (option --clone). If your system fails, simply boot from the clone – no time-consuming restore required, minimal downtime. With rsync the clone is updated in no time. ' . $lnk( $doc . 'how-to-enable-clone.html', 'How to set up the clone' ) . '.',
			),
			array(
				'icon'  => 'camera',
				'title' => 'Snapshots',
				'text'  => 'Create a snapshot with a comment before major updates or installations. If something goes wrong or the system no longer boots, restore the snapshot and continue from there instead of starting from scratch.',
			),
		),
		'more_title'       => 'And much more',
		'more'             => array(
			array( 'bell', 'Notifications', 'Receive the result of every backup run by e-mail, Telegram, Pushover or Slack. Smileys show success 🙂 or failure 🙁 at a glance – and remind you of new releases or your next restore test.' ),
			array( 'windows', 'Restore on Windows', 'dd backups can be restored on Windows with win32diskimager or similar tools. tar and rsync backups need a Linux system – which can be a Raspberry 🙂' ),
			array( 'move', 'Easy system migration', 'Restore any backup to an SD card, USB disk, USB flash drive, SSD or NVMe drive – and your system has moved to a new device.' ),
			array( 'drive', 'NVMe support', 'NVMe storage on the Raspberry Pi 5 and 500 and on Compute Modules 4 and 5 (CM4, CM5) is supported.' ),
			array( 'plug', 'Extension points', 'Run your own logic at various steps of backup and restore – for example, an extension stops all Docker containers before the backup and restarts them afterwards.' ),
			array( 'download', 'Update notifications', 'raspiBackup tells you when a new release or beta is available. Upgrading – and downgrading again – is easy.' ),
			array( 'shield', 'Automated regression tests', 'Backup and restore are regression-tested for all backup types and modes, so every new release works as reliably as the last.' ),
			array( 'code', 'Helper and sample scripts', 'Various ' . $lnk( $gh . '/tree/master/helper#readme', 'helper and sample scripts' ) . ' are available on GitHub.' ),
		),
		'how_title'        => 'Your first backup in three steps',
		'how'              => array(
			array( 'Install', 'Start the installer with a single command – menu-driven, just like raspi-config.' ),
			array( 'Configure', 'Choose backup target, backup type, how many backups to keep and how to be notified.' ),
			array( 'Relax', 'raspiBackup now backs up automatically and reports every run to you.' ),
		),
		'demo_title'       => 'See the installation in action',
		'demo_lead'        => 'This is how easily raspiBackup is installed and configured. Chinese, Finnish, French and German are supported too.',
		'demo_alt'         => 'Animated demo of the menu-driven raspiBackup installer',
		'demo_yt'          => 'More videos on YouTube',
		'video_consent'    => 'Playing the video loads it from YouTube. Google’s privacy policy applies.',
		'video_play'       => 'Play video',
		'compat_title'     => 'Made for the Raspberry Pi',
		'compat_lead'      => 'raspiBackup is developed specifically for Raspberry Pi hardware and Raspberry Pi OS, and tested on real Raspberries.',
		'hardware'         => array(
			array( 'Raspberry Pi 5', 'SD card · USB boot · NVMe' ),
			array( 'Raspberry Pi 500', 'SD card · USB boot · NVMe' ),
			array( 'Raspberry Pi 4 · 400', 'SD card · USB boot' ),
			array( 'Raspberry Pi 3', 'SD card · USB boot' ),
			array( 'Raspberry Pi 1 · 2 · Zero', 'SD card · hybrid USB boot' ),
			array( 'Compute Module 4 · 5', 'SD card · eMMC · USB boot · NVMe' ),
		),
		'hardware_note'    => 'Other boards such as Banana Pi, Odroid or Beagle Board may work with the option --unsupportedEnvironment – but only Raspberry Pi hardware is supported.',
		'compat'           => array(
			array(
				'title' => 'All boot modes',
				'items' => array(
					'<strong>SD card:</strong> boot and root filesystem on the SD card (all models with an SD card slot)',
					'<strong>Hybrid USB boot:</strong> boot from the SD card, root filesystem on a USB device (Raspberry Pi 1, 2 and Zero)',
					'<strong>USB boot:</strong> boot directly from a USB device (all models from Raspberry Pi 3)',
				),
			),
			array(
				'title' => 'Operating systems',
				'items' => array(
					$lnk( 'https://www.raspberrypi.com/software/operating-systems/', 'Raspberry Pi OS / Raspbian' ),
					$lnk( 'https://ubuntu.com/download/raspberry-pi', 'Ubuntu' ),
				),
			),
			array(
				'title' => 'Boot devices',
				'items' => array(
					'SD card',
					'eMMC (Compute Module 4 and 5)',
					'USB disk and SSD',
					'NVMe (Raspberry Pi 5, 500, CM4, CM5)',
				),
			),
			array(
				'title' => 'Backup targets',
				'items' => array(
					'USB disk and USB flash drive',
					'Network drives via NFS, SMB or WebDAV – e.g. a ' . $lnk( $doc . 'nfs-as-backuptarget.html', 'Synology via NFS' ),
					'<strong>In short:</strong> anything that can be mounted on Linux',
				),
			),
		),
		'docs_title'       => 'Documentation & resources',
		'docs_lead'        => 'Complete documentation answers (almost) every question.',
		'docs'             => array(
			array( 'install5', 'Install in 5 minutes', 'Step by step to your first backup' ),
			array( 'doc', 'Documentation', 'All options and concepts in detail' ),
			array( 'faq', 'FAQ', 'Answers to frequently asked questions' ),
			array( 'config', 'Configuration examples', 'Ready-to-use configurations' ),
			array( 'errors', 'Error messages', 'What they mean and how to fix them' ),
			array( 'documents', 'PDF documents', 'Presentations and overviews to download' ),
		),
		'community_title'  => 'Questions, ideas, conversation',
		'community_lead'   => 'Support comes directly from framp – preferably via GitHub Discussions or issues. You will also find news and conversation on Facebook, Reddit and X. Registration on GitHub is free – just use it. ' . $lnk( $doc . 'introduction.html#donations', 'Donations' ) . ' are welcome 😉',
		'community'        => array(
			array( 'github', 'Ask questions', 'GitHub Discussions', 'discussions' ),
			array( 'bug', 'Report bugs', 'GitHub Issues', 'issues' ),
			array( 'youtube', 'Watch videos', 'YouTube channel', 'youtube' ),
			array( 'facebook', 'Get news', 'Facebook', 'facebook' ),
			array( 'reddit', 'Discuss', 'Reddit r/raspiBackup', 'reddit' ),
			array( 'x', 'Follow', 'X / Twitter', 'twitter' ),
		),
		'cta_title'        => 'Let’s go.',
		'cta_lead'         => 'Create your first backup in 5 minutes 🙂',
		'cta_button'       => 'Open the installation guide',
		'footer_tagline'   => 'The perfect open source tool to back up Raspberries.',
		'footer_project'   => 'Project',
		'footer_resources' => 'Resources',
		'footer_community' => 'Community',
		'footer_imprint'   => 'Imprint',
		'footer_privacy'   => 'Privacy',
		'footer_releases'  => 'Releases',
		'footer_donate'    => 'Donate',
	);
}
