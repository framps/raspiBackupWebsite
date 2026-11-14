<?php
/**
 * Template Name: raspiBackup Landing
 *
 * Bilingual landing page. Used automatically for the front page (EN + DE via Polylang)
 * and available as page template for any other page.
 *
 * @package raspibackup-pro
 */

defined( 'ABSPATH' ) || exit;

$rbp_lang  = rbp_lang();
$c         = rbp_content( $rbp_lang );
$L         = $c['links'];
$h         = $c['hero'];
$stats     = get_theme_mod( 'rbp_github_stats', true ) ? rbp_github_stats() : array( 'release' => '', 'stars' => 0 );
$yt_id     = rbp_youtube_id( get_theme_mod( 'rbp_youtube_' . $rbp_lang, '' ) );
$imprint   = rbp_translated_url( get_theme_mod( 'rbp_imprint_url', '' ) );
$privacy   = get_theme_mod( 'rbp_privacy_url', '' );
$privacy   = rbp_translated_url( $privacy ? $privacy : get_privacy_policy_url() );
$languages = rbp_languages();
$logo      = rbp_logo_url();
$home      = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
$kses      = static function ( $s ) {
	return wp_kses( $s, array( 'a' => array( 'href' => true ), 'strong' => array(), 'em' => array() ) );
};
$ext       = ' target="_blank" rel="noopener"';
$doc_icons = array( 'install5' => 'terminal', 'doc' => 'book', 'faq' => 'help', 'config' => 'sliders', 'errors' => 'alert', 'documents' => 'file' );

// Title + meta for this page (only if no SEO plugin handles it).
add_filter(
	'pre_get_document_title',
	static function ( $t ) use ( $c ) {
		return ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) ? $t : $c['meta_title'];
	},
	20
);
add_action(
	'wp_head',
	static function () use ( $c, $logo, $rbp_lang ) {
		if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
			return;
		}
		$url = get_permalink();
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $c['meta_description'] ) );
		printf( '<meta property="og:type" content="website"><meta property="og:title" content="%s"><meta property="og:description" content="%s"><meta property="og:url" content="%s"><meta property="og:image" content="%s"><meta property="og:locale" content="%s"><meta name="twitter:card" content="summary">' . "\n", esc_attr( $c['meta_title'] ), esc_attr( $c['meta_description'] ), esc_url( $url ), esc_url( $logo ), 'de' === $rbp_lang ? 'de_DE' : 'en_US' );
		printf( '<meta name="theme-color" content="#14152b">' . "\n" );
		$ld = array(
			'@context'            => 'https://schema.org',
			'@type'               => 'SoftwareApplication',
			'name'                => 'raspiBackup',
			'operatingSystem'     => 'Raspberry Pi OS, Ubuntu',
			'applicationCategory' => 'UtilitiesApplication',
			'license'             => 'https://www.gnu.org/licenses/gpl-3.0.html',
			'url'                 => $url,
			'downloadUrl'         => 'https://github.com/framps/raspiBackup',
			'description'         => $c['meta_description'],
			'offers'              => array(
				'@type'         => 'Offer',
				'price'         => '0',
				'priceCurrency' => 'EUR',
			),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $ld ) . '</script>' . "\n";
	},
	1
);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="rbp-skip" href="#rbp-main"><?php echo esc_html( $c['nav']['skip'] ); ?></a>

<header class="rbp-header" id="rbp-header">
	<div class="rbp-container rbp-header__inner">
		<a class="rbp-brand" href="<?php echo esc_url( $home ); ?>">
			<span class="rbp-brand__tile"><img src="<?php echo esc_url( $logo ); ?>" alt="" width="26" height="40"></span>
			<span>raspi<b>Backup</b></span>
		</a>
		<nav class="rbp-nav" id="rbp-nav" aria-label="<?php echo esc_attr( $c['nav']['menu'] ); ?>">
			<ul>
				<li><a href="#opensource"><?php echo esc_html( $c['nav']['opensource'] ); ?></a></li>
				<li><a href="#features"><?php echo esc_html( $c['nav']['features'] ); ?></a></li>
				<li><a href="#demo"><?php echo esc_html( $c['nav']['demo'] ); ?></a></li>
				<li><a href="#compat"><?php echo esc_html( $c['nav']['compat'] ); ?></a></li>
				<li><a href="#docs"><?php echo esc_html( $c['nav']['docs'] ); ?></a></li>
				<li><a href="#community"><?php echo esc_html( $c['nav']['community'] ); ?></a></li>
			</ul>
			<div class="rbp-lang" role="group" aria-label="<?php echo esc_attr( $c['nav']['language'] ); ?>">
				<?php foreach ( $languages as $l ) : ?>
					<a href="<?php echo esc_url( $l['url'] ); ?>" hreflang="<?php echo esc_attr( $l['slug'] ); ?>" lang="<?php echo esc_attr( $l['slug'] ); ?>" title="<?php echo esc_attr( $l['name'] ); ?>"<?php echo $l['current'] ? ' aria-current="true" class="is-current"' : ''; ?>><?php echo esc_html( strtoupper( $l['slug'] ) ); ?></a>
				<?php endforeach; ?>
			</div>
			<a class="rbp-btn rbp-btn--primary rbp-btn--sm" href="<?php echo esc_url( $L['install5'] ); ?>"><?php echo esc_html( $c['nav']['cta'] ); ?></a>
		</nav>
		<button class="rbp-menu-toggle" type="button" aria-expanded="false" aria-controls="rbp-nav">
			<span class="rbp-menu-toggle__open"><?php echo rbp_icon( 'menu' ); // phpcs:ignore ?></span>
			<span class="rbp-menu-toggle__close"><?php echo rbp_icon( 'close' ); // phpcs:ignore ?></span>
			<span class="rbp-sr"><?php echo esc_html( $c['nav']['menu'] ); ?></span>
		</button>
	</div>
</header>

<main id="rbp-main">

	<!-- Hero -->
	<section class="rbp-hero">
		<div class="rbp-hero__glow" aria-hidden="true"></div>
		<div class="rbp-container rbp-hero__grid">
			<div class="rbp-hero__copy">
				<p class="rbp-eyebrow">
					<span class="rbp-dot" aria-hidden="true"></span><?php echo esc_html( $h['eyebrow'] ); ?>
					<?php if ( $stats['release'] ) : ?>
						<a class="rbp-eyebrow__tag" href="<?php echo esc_url( $L['releases'] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo esc_html( $h['release'] . ' ' . $stats['release'] ); ?></a>
					<?php endif; ?>
				</p>
				<h1 class="rbp-hero__title"><?php echo esc_html( $h['title'] ); ?> <span><?php echo esc_html( $h['accent'] ); ?></span></h1>
				<p class="rbp-hero__lead"><?php echo esc_html( $h['lead'] ); ?></p>
				<div class="rbp-hero__actions">
					<a class="rbp-btn rbp-btn--primary rbp-btn--lg" href="<?php echo esc_url( $L['install5'] ); ?>"><?php echo esc_html( $h['cta'] ); ?> <?php echo rbp_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
					<a class="rbp-btn rbp-btn--ghost rbp-btn--lg" href="<?php echo esc_url( $L['github'] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo rbp_icon( 'github', 18 ); // phpcs:ignore ?> <?php echo esc_html( $h['cta2'] ); ?>
						<?php if ( $stats['stars'] ) : ?><span class="rbp-btn__badge" title="<?php echo esc_attr( $h['stars'] ); ?>"><?php echo rbp_icon( 'star', 14 ); // phpcs:ignore ?> <?php echo esc_html( rbp_short_number( $stats['stars'] ) ); ?></span><?php endif; ?>
					</a>
				</div>
				<div class="rbp-cmd">
					<p class="rbp-cmd__label" id="rbp-cmd-label"><?php echo esc_html( $h['cmd_label'] ); ?></p>
					<div class="rbp-cmd__box">
						<code aria-labelledby="rbp-cmd-label"><span class="rbp-cmd__prompt" aria-hidden="true">$</span> <span class="rbp-cmd__text"><?php echo esc_html( $c['install_cmd'] ); ?></span></code>
						<button type="button" class="rbp-copy" data-copy="<?php echo esc_attr( $c['install_cmd'] ); ?>" data-done="<?php echo esc_attr( $h['copied'] ); ?>"><?php echo rbp_icon( 'copy', 16 ); // phpcs:ignore ?><span><?php echo esc_html( $h['copy'] ); ?></span></button>
					</div>
				</div>
			</div>
			<div class="rbp-hero__visual" aria-hidden="true">
				<div class="rbp-logo-card">
					<img src="<?php echo esc_url( $logo ); ?>" alt="" width="104" height="160" decoding="async">
				</div>
				<div class="rbp-window rbp-history">
					<div class="rbp-window__bar"><i></i><i></i><i></i><span>/backup/raspberrypi</span></div>
					<ul>
						<?php
						$now = current_time( 'timestamp' ); // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
						foreach ( $c['history'] as $row ) :
							$ts = strtotime( '-' . $row[0] . ' days 03:00', $now );
							?>
							<li>
								<span class="rbp-history__ok"><?php echo rbp_icon( 'check', 14 ); // phpcs:ignore ?></span>
								<code>raspberrypi-rsync-backup-<?php echo esc_html( gmdate( 'Ymd-Hi', $ts ) ); ?>00</code>
								<span class="rbp-history__tag rbp-history__tag--<?php echo esc_attr( $row[2] ); ?>"><?php echo esc_html( $row[1] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="rbp-toast">
					<span class="rbp-toast__icon">🙂</span>
					<span><strong>raspiBackup</strong><?php echo esc_html( $c['toast'] ); ?></span>
				</div>
			</div>
		</div>
		<div class="rbp-container">
			<ul class="rbp-stats">
				<?php foreach ( $c['stats'] as $s ) : ?>
					<li><strong><?php echo esc_html( $s[0] ); ?></strong><span><?php echo esc_html( $s[1] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- Open source -->
	<section class="rbp-section rbp-oss" id="opensource">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['opensource'] ); ?></p>
				<h2><?php echo esc_html( $c['opensource_title'] ); ?></h2>
				<p><?php echo esc_html( $c['opensource_lead'] ); ?></p>
			</header>
			<?php
			$of    = $c['opensource_facts'];
			$facts = array( $of['since'] );
			if ( $stats['stars'] ) {
				$facts[] = array( '★ ' . number_format_i18n( $stats['stars'] ), $of['stars'] );
			}
			if ( ! empty( $stats['forks'] ) ) {
				$facts[] = array( number_format_i18n( $stats['forks'] ), $of['forks'] );
			}
			$facts[] = $of['lic'];
			?>
			<ul class="rbp-oss__facts">
				<?php foreach ( $facts as $fa ) : ?>
					<li><strong><?php echo esc_html( $fa[0] ); ?></strong><span><?php echo esc_html( $fa[1] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
			<div class="rbp-grid rbp-grid--3 rbp-oss__grid">
				<?php foreach ( $c['opensource'] as $f ) : ?>
					<div class="rbp-oss__item">
						<div class="rbp-oss__icon"><?php echo rbp_icon( $f[0], 22 ); // phpcs:ignore ?></div>
						<h3><?php echo esc_html( $f[1] ); ?></h3>
						<p><?php echo $kses( $f[2] ); // phpcs:ignore ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="rbp-oss__thanks"><span class="rbp-oss__thanks-icon"><?php echo rbp_icon( 'heart', 20 ); // phpcs:ignore ?></span><span><?php echo $kses( $c['opensource_thanks'] ); // phpcs:ignore ?></span></p>
			<div class="rbp-oss__actions">
				<a class="rbp-btn rbp-btn--green" href="<?php echo esc_url( $L['github'] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo rbp_icon( 'github', 18 ); // phpcs:ignore ?> <?php echo esc_html( $c['opensource_cta'] ); ?></a>
				<a class="rbp-btn rbp-btn--outline" href="#community"><?php echo rbp_icon( 'users', 18 ); // phpcs:ignore ?> <?php echo esc_html( $c['opensource_cta2'] ); ?></a>
			</div>
		</div>
	</section>

	<!-- Features -->
	<section class="rbp-section" id="features">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['features'] ); ?></p>
				<h2><?php echo esc_html( $c['features_title'] ); ?></h2>
				<p><?php echo esc_html( $c['features_lead'] ); ?></p>
			</header>
			<div class="rbp-grid rbp-grid--3">
				<?php foreach ( $c['highlights'] as $f ) : ?>
					<article class="rbp-card">
						<div class="rbp-card__icon"><?php echo rbp_icon( $f['icon'] ); // phpcs:ignore ?></div>
						<h3><?php echo esc_html( $f['title'] ); ?></h3>
						<p><?php echo $kses( $f['text'] ); // phpcs:ignore ?></p>
					</article>
				<?php endforeach; ?>
			</div>

			<h3 class="rbp-subhead"><?php echo esc_html( $c['more_title'] ); ?></h3>
			<div class="rbp-grid rbp-grid--4 rbp-more">
				<?php foreach ( $c['more'] as $f ) : ?>
					<div class="rbp-more__item">
						<div class="rbp-more__icon"><?php echo rbp_icon( $f[0], 20 ); // phpcs:ignore ?></div>
						<h4><?php echo esc_html( $f[1] ); ?></h4>
						<p><?php echo $kses( $f[2] ); // phpcs:ignore ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- How it works -->
	<section class="rbp-section rbp-section--tint" id="how">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['how'] ); ?></p>
				<h2><?php echo esc_html( $c['how_title'] ); ?></h2>
			</header>
			<ol class="rbp-steps">
				<?php foreach ( $c['how'] as $i => $s ) : ?>
					<li class="rbp-step">
						<span class="rbp-step__num"><?php echo (int) $i + 1; ?></span>
						<h3><?php echo esc_html( $s[0] ); ?></h3>
						<p><?php echo esc_html( $s[1] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- Demo -->
	<section class="rbp-section rbp-section--dark" id="demo">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['demo'] ); ?></p>
				<h2><?php echo esc_html( $c['demo_title'] ); ?></h2>
				<p><?php echo esc_html( $c['demo_lead'] ); ?></p>
			</header>
			<div class="rbp-demo<?php echo $yt_id ? ' rbp-demo--two' : ''; ?>">
				<div class="rbp-window rbp-window--lg">
					<div class="rbp-window__bar" aria-hidden="true"><i></i><i></i><i></i><span title="<?php echo esc_attr( $c['install_cmd'] ); ?>">$ <?php echo esc_html( $c['install_cmd'] ); ?></span></div>
					<img src="<?php echo esc_url( rbp_demo_url( $rbp_lang ) ); ?>" alt="<?php echo esc_attr( $c['demo_alt'] ); ?>" loading="lazy" decoding="async">
				</div>
				<?php if ( $yt_id ) : ?>
					<div class="rbp-video" data-yt="<?php echo esc_attr( $yt_id ); ?>">
						<button type="button" class="rbp-video__play"><?php echo rbp_icon( 'play', 28 ); // phpcs:ignore ?><span><?php echo esc_html( $c['video_play'] ); ?></span></button>
						<p class="rbp-video__note"><?php echo esc_html( $c['video_consent'] ); ?></p>
					</div>
				<?php endif; ?>
			</div>
			<p class="rbp-center">
				<a class="rbp-btn rbp-btn--ghost" href="<?php echo esc_url( $L['youtube'] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo rbp_icon( 'youtube', 18 ); // phpcs:ignore ?> <?php echo esc_html( $c['demo_yt'] ); ?></a>
			</p>
		</div>
	</section>

	<!-- Compatibility -->
	<section class="rbp-section" id="compat">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['compat'] ); ?></p>
				<h2><?php echo esc_html( $c['compat_title'] ); ?></h2>
				<p><?php echo esc_html( $c['compat_lead'] ); ?></p>
			</header>
			<ul class="rbp-hw">
				<?php foreach ( $c['hardware'] as $hw ) : ?>
					<li class="rbp-hw__item">
						<span class="rbp-hw__icon"><?php echo rbp_icon( 'board', 30 ); // phpcs:ignore ?></span>
						<strong><?php echo esc_html( $hw[0] ); ?></strong>
						<span><?php echo esc_html( $hw[1] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="rbp-grid rbp-grid--4 rbp-compat">
				<?php foreach ( $c['compat'] as $col ) : ?>
					<div class="rbp-card rbp-card--list">
						<h3><?php echo esc_html( $col['title'] ); ?></h3>
						<ul class="rbp-checks">
							<?php foreach ( $col['items'] as $it ) : ?>
								<li><?php echo rbp_icon( 'check', 18 ); // phpcs:ignore ?><span><?php echo $kses( $it ); // phpcs:ignore ?></span></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="rbp-hw__note"><?php echo rbp_icon( 'help', 16 ); // phpcs:ignore ?> <span><?php echo str_replace( '--unsupportedEnvironment', '<code>--unsupportedEnvironment</code>', esc_html( $c['hardware_note'] ) ); // phpcs:ignore ?></span></p>
		</div>
	</section>

	<!-- Docs -->
	<section class="rbp-section rbp-section--tint" id="docs">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['docs'] ); ?></p>
				<h2><?php echo esc_html( $c['docs_title'] ); ?></h2>
				<p><?php echo esc_html( $c['docs_lead'] ); ?></p>
			</header>
			<div class="rbp-grid rbp-grid--3">
				<?php foreach ( $c['docs'] as $d ) : ?>
					<a class="rbp-link-card" href="<?php echo esc_url( $L[ $d[0] ] ); ?>"<?php echo 'documents' === $d[0] ? '' : $ext; // phpcs:ignore ?>>
						<span class="rbp-link-card__icon"><?php echo rbp_icon( $doc_icons[ $d[0] ], 20 ); // phpcs:ignore ?></span>
						<span class="rbp-link-card__body"><strong><?php echo esc_html( $d[1] ); ?></strong><span><?php echo esc_html( $d[2] ); ?></span></span>
						<span class="rbp-link-card__arrow"><?php echo rbp_icon( 'arrow', 18 ); // phpcs:ignore ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Community -->
	<section class="rbp-section" id="community">
		<div class="rbp-container">
			<header class="rbp-section__head">
				<p class="rbp-kicker"><?php echo esc_html( $c['nav']['community'] ); ?></p>
				<h2><?php echo esc_html( $c['community_title'] ); ?></h2>
				<p><?php echo $kses( $c['community_lead'] ); // phpcs:ignore ?></p>
			</header>
			<div class="rbp-grid rbp-grid--3">
				<?php foreach ( $c['community'] as $s ) : ?>
					<a class="rbp-link-card rbp-link-card--<?php echo esc_attr( $s[0] ); ?>" href="<?php echo esc_url( $L[ $s[3] ] ); ?>"<?php echo $ext; // phpcs:ignore ?>>
						<span class="rbp-link-card__icon"><?php echo rbp_icon( $s[0], 20 ); // phpcs:ignore ?></span>
						<span class="rbp-link-card__body"><strong><?php echo esc_html( $s[1] ); ?></strong><span><?php echo esc_html( $s[2] ); ?></span></span>
						<span class="rbp-link-card__arrow"><?php echo rbp_icon( 'external', 16 ); // phpcs:ignore ?></span>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="rbp-oss__thanks rbp-oss__thanks--tips" id="<?php echo 'de' === $rbp_lang ? 'trinkgeld' : 'tips'; ?>"><span class="rbp-oss__thanks-icon"><?php echo rbp_icon( 'star', 20 ); // phpcs:ignore ?></span><span><?php echo $kses( $c['opensource_tips'] ); // phpcs:ignore ?></span></p>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="rbp-cta">
		<div class="rbp-container rbp-cta__inner">
			<div>
				<h2><?php echo esc_html( $c['cta_title'] ); ?></h2>
				<p><?php echo esc_html( $c['cta_lead'] ); ?></p>
			</div>
			<a class="rbp-btn rbp-btn--light rbp-btn--lg" href="<?php echo esc_url( $L['install5'] ); ?>"><?php echo esc_html( $c['cta_button'] ); ?> <?php echo rbp_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
		</div>
	</section>

	<?php
	// Anything written in the page editor is shown below the landing page (optional).
	while ( have_posts() ) :
		the_post();
		if ( get_theme_mod( 'rbp_show_page_content', false ) && '' !== trim( get_the_content() ) ) :
			?>
			<section class="rbp-section rbp-page-content"><div class="rbp-container rbp-prose"><?php the_content(); ?></div></section>
			<?php
		endif;
	endwhile;
	?>
</main>

<footer class="rbp-footer">
	<div class="rbp-container rbp-footer__grid">
		<div class="rbp-footer__brand">
			<a class="rbp-brand" href="<?php echo esc_url( $home ); ?>"><span class="rbp-brand__tile"><img src="<?php echo esc_url( $logo ); ?>" alt="" width="26" height="40"></span><span>raspi<b>Backup</b></span></a>
			<p><?php echo esc_html( $c['footer_tagline'] ); ?></p>
			<div class="rbp-footer__social">
				<?php foreach ( array( 'github', 'youtube', 'facebook', 'reddit', 'twitter' ) as $s ) : ?>
					<a href="<?php echo esc_url( $L[ $s ] ); ?>" aria-label="<?php echo esc_attr( ucfirst( $s ) ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo rbp_icon( 'twitter' === $s ? 'x' : $s, 18 ); // phpcs:ignore ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div>
			<h2><?php echo esc_html( $c['footer_project'] ); ?></h2>
			<ul>
				<li><a href="#features"><?php echo esc_html( $c['nav']['features'] ); ?></a></li>
				<li><a href="#demo"><?php echo esc_html( $c['nav']['demo'] ); ?></a></li>
				<li><a href="<?php echo esc_url( $L['releases'] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo esc_html( $c['footer_releases'] ); ?></a></li>
				<li><a href="<?php echo esc_url( $L['donate'] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo esc_html( $c['footer_donate'] ); ?></a></li>
			</ul>
		</div>
		<div>
			<h2><?php echo esc_html( $c['footer_resources'] ); ?></h2>
			<ul>
				<?php foreach ( array_slice( $c['docs'], 0, 4 ) as $d ) : ?>
					<li><a href="<?php echo esc_url( $L[ $d[0] ] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo esc_html( $d[1] ); ?></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( $L['documents'] ); ?>"><?php echo esc_html( $c['docs'][5][1] ); ?></a></li>
			</ul>
		</div>
		<div>
			<h2><?php echo esc_html( $c['footer_community'] ); ?></h2>
			<ul>
				<?php foreach ( array_slice( $c['community'], 0, 4 ) as $s ) : ?>
					<li><a href="<?php echo esc_url( $L[ $s[3] ] ); ?>"<?php echo $ext; // phpcs:ignore ?>><?php echo esc_html( $s[2] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="rbp-container rbp-footer__bottom">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> raspiBackup · framp · GPL-3.0</p>
		<ul>
			<?php if ( $imprint ) : ?><li><a href="<?php echo esc_url( $imprint ); ?>"><?php echo esc_html( $c['footer_imprint'] ); ?></a></li><?php endif; ?>
			<?php if ( $privacy ) : ?><li><a href="<?php echo esc_url( $privacy ); ?>"><?php echo esc_html( $c['footer_privacy'] ); ?></a></li><?php endif; ?>
			<?php foreach ( $languages as $l ) : ?>
				<li><a href="<?php echo esc_url( $l['url'] ); ?>" hreflang="<?php echo esc_attr( $l['slug'] ); ?>" lang="<?php echo esc_attr( $l['slug'] ); ?>"<?php echo $l['current'] ? ' aria-current="true"' : ''; ?>><?php echo rbp_icon( 'globe', 14 ); // phpcs:ignore ?> <?php echo esc_html( $l['name'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
