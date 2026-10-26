<?php
/**
 * Markup shared by the home page designs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function prime_recovery_document_open() {
	?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
	<?php
}

function prime_recovery_document_close() {
	wp_footer();
	echo "\n</body>\n</html>\n";
}

function prime_recovery_logo( $variant = 'color' ) {
	$file = 'reverse' === $variant ? 'logo-reverse.png' : 'logo-color.png';
	printf(
		'<a class="site-logo" href="%1$s" rel="home"><img src="%2$s" alt="Prime Recovery home" width="230" height="150"></a>',
		esc_url( home_url( '/' ) ),
		esc_url( prime_recovery_img( $file ) )
	);
}

/**
 * Primary menu. Uses the WordPress menu when one is assigned, otherwise a
 * fallback with the pages the client asked for.
 */
function prime_recovery_menu( $class = 'menu' ) {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => $class,
			'depth'          => 2,
		) );
		return;
	}
	$links    = prime_recovery_links();
	$products = prime_recovery_products();
	echo '<ul class="' . esc_attr( $class ) . '">';
	echo '<li class="menu-item menu-item-has-children"><a href="' . esc_url( home_url( '/products/' ) ) . '">Products</a><ul class="sub-menu">';
	foreach ( $products as $p ) {
		echo '<li class="menu-item"><a href="' . esc_url( $p['url'] ) . '">' . esc_html( $p['name'] ) . '</a></li>';
	}
	echo '</ul></li>';
	foreach ( array( 'resources', 'team', 'about' ) as $key ) {
		echo '<li class="menu-item"><a href="' . esc_url( $links[ $key ]['url'] ) . '">' . esc_html( $links[ $key ]['label'] ) . '</a></li>';
	}
	echo '<li class="menu-item"><a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a></li>';
	echo '</ul>';
}

function prime_recovery_social_links( $class = 'social' ) {
	$social = prime_recovery_business()['social'];
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( array( 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn' ) as $key => $label ) {
		$url = $social[ $key ] ? $social[ $key ] : '#';
		printf(
			'<li><a href="%1$s" aria-label="Prime Recovery on %2$s"%3$s>%4$s</a></li>',
			esc_url( $url ),
			esc_attr( $label ),
			'#' === $url ? '' : ' rel="noopener" target="_blank"',
			prime_recovery_icon( $key ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
		);
	}
	echo '</ul>';
}

function prime_recovery_menu_toggle( $controls ) {
	printf(
		'<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="%s"><span class="menu-toggle__bars" aria-hidden="true"></span><span class="screen-reader-text">Menu</span></button>',
		esc_attr( $controls )
	);
}

function prime_recovery_faq_section( $heading = 'Questions, answered' ) {
	?>
	<section class="faq" id="faq" aria-labelledby="faq-title">
		<div class="wrap wrap--narrow">
			<p class="eyebrow">FAQ</p>
			<h2 id="faq-title"><?php echo esc_html( $heading ); ?></h2>
			<div class="faq__list">
				<?php foreach ( prime_recovery_faqs() as $i => $f ) : ?>
					<details class="faq__item"<?php echo 0 === $i ? ' open' : ''; ?>>
						<summary><?php echo esc_html( $f['q'] ); ?></summary>
						<p><?php echo esc_html( $f['a'] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Site footer with consistent name, address and phone (NAP).
 */
function prime_recovery_site_footer() {
	$b     = prime_recovery_business();
	$links = prime_recovery_links();
	?>
	<footer class="site-footer">
		<div class="wrap site-footer__grid">
			<div class="site-footer__brand">
				<?php prime_recovery_logo( 'reverse' ); ?>
				<p><?php echo esc_html( $b['tagline'] ); ?>. At-home recovery devices, delivered and supported by our technicians across Minnesota and Wisconsin.</p>
				<?php prime_recovery_social_links( 'social social--footer' ); ?>
			</div>
			<div itemscope itemtype="https://schema.org/PostalAddress">
				<h2 class="site-footer__title">Main Office</h2>
				<address>
					<span itemprop="streetAddress"><?php echo esc_html( $b['street'] ); ?></span><br>
					<span itemprop="addressLocality"><?php echo esc_html( $b['city'] ); ?></span>, <span itemprop="addressRegion"><?php echo esc_html( $b['region'] ); ?></span> <span itemprop="postalCode"><?php echo esc_html( $b['postal'] ); ?></span><br>
					Office: <a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo esc_html( $b['phone'] ); ?></a><br>
					Fax: <?php echo esc_html( $b['fax'] ); ?>
				</address>
			</div>
			<div>
				<h2 class="site-footer__title">Satellite Offices</h2>
				<ul class="plain-list">
					<?php foreach ( $b['offices'] as $o ) : ?>
						<li><?php echo esc_html( $o['city'] . ', ' . $o['region'] ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<h2 class="site-footer__title">Explore</h2>
				<ul class="plain-list">
					<?php foreach ( $links as $l ) : ?>
						<li><a href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="wrap site-footer__legal">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Prime Recovery. All rights reserved.</p>
			<p>Devices are used under the direction of your medical provider.</p>
		</div>
	</footer>
	<?php
}
