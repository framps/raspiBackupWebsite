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
				'features'  => 'Eigenschaften',
				'how'       => 'So funktioniert’s',
				'demo'      => 'Demo',
				'compat'    => 'Unterstützung',
				'docs'      => 'Dokumentation',
				'community' => 'Community',
				'cta'       => 'Jetzt installieren',
				'menu'      => 'Menü',
				'skip'      => 'Zum Inhalt springen',
				'language'  => 'Sprache',
			),
			'hero'             => array(
				'eyebrow'   => 'Open Source · GPL-3.0',
				'title'     => 'Sichere Deine Raspberries.',
				'accent'    => 'Automatisch. Zuverlässig.',
				'lead'      => 'raspiBackup erstellt regelmäßig, unbeaufsichtigt und schnell vollständige Systemsicherungen Deiner Raspberries und verwaltet eine konfigurierbare Sicherungshistorie. Nach einer Wiederherstellung startet das System sofort wieder.',
				'cta'       => 'Erste Sicherung in 5 Minuten',
				'cta2'      => 'Auf GitHub ansehen',
				'cmd_label' => 'Installation – einfach im Terminal ausführen:',
				'copy'      => 'Kopieren',
				'copied'    => 'Kopiert!',
				'release'   => 'Aktuelle Version',
				'stars'     => 'GitHub Sterne',
			),
			'stats'            => array(
				array( 'dd · tar · rsync', 'Voll- und inkrementelle Sicherungen' ),
				array( 'SD · USB · SSD · NVMe', 'Alle Bootmodi unterstützt' ),
				array( '5 Sprachen', 'DE · EN · FI · FR · ZH' ),
				array( 'Raspberry Pi OS & Ubuntu', 'Unterstützte Betriebssysteme' ),
			),
			'history'          => array( array( 0, 'täglich', 'day' ), array( 1, 'täglich', 'day' ), array( 2, 'täglich', 'day' ), array( 7, 'wöchentlich', 'week' ), array( 14, 'wöchentlich', 'week' ), array( 31, 'monatlich', 'month' ), array( 365, 'jährlich', 'year' ) ),
			'toast'            => 'Sicherung erfolgreich beendet',
			'features_title'   => 'Alles, was eine professionelle Sicherung braucht',
			'features_lead'    => 'Von der ersten Installation bis zur Wiederherstellung im Notfall – raspiBackup deckt den kompletten Lebenszyklus Deiner Sicherungen ab.',
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
					'text'  => 'Das letzte Backup kann nach jeder erfolgreichen Sicherung automatisch auf ein beliebiges Gerät synchronisiert werden. Bei einem Systemausfall wird einfach davon gestartet – ganz ohne zeitaufwändige Wiederherstellung.',
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
				array( 'drive', 'NVMe Unterstützung', 'NVMe Speicher des Raspberry 5 und des Compute Module 4 (CM4) wird unterstützt.' ),
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
			'compat_title'     => 'Läuft dort, wo Dein Raspberry läuft',
			'compat'           => array(
				array(
					'title' => 'Alle Bootmodi',
					'items' => array(
						'<strong>SD Karte:</strong> beide Partitionen auf der SD Karte (jedes Modell)',
						'<strong>Hybrid:</strong> Boot von SD Karte, Rootpartition auf USB – für ältere Modelle ohne USB Boot (2A, 2B)',
						'<strong>USB Boot:</strong> beide Partitionen auf USB Gerät oder SSD (3B, 4, 400, 5)',
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
					'title' => 'Speichermedien',
					'items' => array(
						'SD Karte, USB Stick, USB Platte und SSD',
						'NVMe (Raspberry 5, CM4)',
						'Lokale Platten oder Netzwerkfreigaben – z.B. eine ' . $lnk( $doc . 'nfs-as-backuptarget.html', 'Synology mit NFS' ),
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
			'community_title'  => 'Open Source mit aktiver Community',
			'community_lead'   => 'raspiBackup ist unter der GNU Lizenz kostenlos verfügbar. ' . $lnk( $doc . 'introduction.html#trinkgeld', 'Trinkgelder' ) . ' sind trotzdem gern gesehen 😉 Die Anmeldung bei GitHub ist kostenlos; Beiträge möglichst auf Englisch, Deutsch wird aber auch akzeptiert.',
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
			'features'  => 'Features',
			'how'       => 'How it works',
			'demo'      => 'Demo',
			'compat'    => 'Compatibility',
			'docs'      => 'Docs',
			'community' => 'Community',
			'cta'       => 'Get started',
			'menu'      => 'Menu',
			'skip'      => 'Skip to content',
			'language'  => 'Language',
		),
		'hero'             => array(
			'eyebrow'   => 'Open source · GPL-3.0',
			'title'     => 'Back up your Raspberries.',
			'accent'    => 'Automatically. Reliably.',
			'lead'      => 'raspiBackup creates regular, unattended full system backups of your Raspberries and maintains a configurable backup history. Restore a backup and your system boots right away.',
			'cta'       => 'Your first backup in 5 minutes',
			'cta2'      => 'View on GitHub',
			'cmd_label' => 'Install – just run this in a terminal:',
			'copy'      => 'Copy',
			'copied'    => 'Copied!',
			'release'   => 'Latest release',
			'stars'     => 'GitHub stars',
		),
		'stats'            => array(
			array( 'dd · tar · rsync', 'Full and incremental backups' ),
			array( 'SD · USB · SSD · NVMe', 'All boot modes supported' ),
			array( '5 languages', 'EN · DE · FI · FR · ZH' ),
			array( 'Raspberry Pi OS & Ubuntu', 'Supported operating systems' ),
		),
		'history'          => array( array( 0, 'daily', 'day' ), array( 1, 'daily', 'day' ), array( 2, 'daily', 'day' ), array( 7, 'weekly', 'week' ), array( 14, 'weekly', 'week' ), array( 31, 'monthly', 'month' ), array( 365, 'yearly', 'year' ) ),
		'toast'            => 'Backup finished successfully',
		'features_title'   => 'Everything a professional backup needs',
		'features_lead'    => 'From the first installation to a restore in an emergency – raspiBackup covers the complete lifecycle of your backups.',
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
				'text'  => 'After every successful backup the latest backup can be synchronized to any device. If your system fails, simply boot from that device – no time-consuming restore required, minimal downtime.',
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
			array( 'drive', 'NVMe support', 'NVMe storage on the Raspberry Pi 5 and Compute Module 4 (CM4) is supported.' ),
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
		'compat_title'     => 'Runs wherever your Raspberry runs',
		'compat'           => array(
			array(
				'title' => 'All boot modes',
				'items' => array(
					'<strong>SD card:</strong> both partitions on the SD card (any model)',
					'<strong>Hybrid:</strong> boot from SD card, root partition on USB – for older models without USB boot (2A, 2B)',
					'<strong>USB boot:</strong> both partitions on a USB device or SSD (3B, 4, 400, 5)',
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
				'title' => 'Storage',
				'items' => array(
					'SD card, USB flash drive, USB disk and SSD',
					'NVMe (Raspberry Pi 5, CM4)',
					'Local disks or network shares – e.g. a ' . $lnk( $doc . 'nfs-as-backuptarget.html', 'Synology via NFS' ),
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
		'community_title'  => 'Open source with an active community',
		'community_lead'   => 'raspiBackup is published under the GNU license and free to use. ' . $lnk( $doc . 'introduction.html#donations', 'Donations' ) . ' are welcome and support further development. Registration on GitHub is free – just use it.',
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
