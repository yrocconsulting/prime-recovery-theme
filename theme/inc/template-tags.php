<?php
/**
 * Markup shared by every page.
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
	$current  = prime_recovery_current_route();
	$item     = function ( $url, $label, $key, $children = '' ) use ( $current ) {
		$active  = $key && ( $current === $key || 0 === strpos( $current, $key . '/' ) );
		$classes = 'menu-item' . ( $children ? ' menu-item-has-children' : '' ) . ( $active ? ' current-menu-item' : '' );
		return '<li class="' . $classes . '"><a href="' . esc_url( $url ) . '"' . ( $current === $key ? ' aria-current="page"' : '' ) . '>' . esc_html( $label ) . '</a>' . $children . '</li>';
	};
	$sub = '<ul class="sub-menu">';
	foreach ( $products as $key => $p ) {
		$sub .= $item( $p['url'], $p['name'], 'products/' . ( 'nice1' === $key ? 'nice' : $key ) );
	}
	$sub .= '</ul>';
	echo '<ul class="' . esc_attr( $class ) . '">';
	echo $item( prime_recovery_route_url( 'products' ), 'Products', 'products', $sub ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	foreach ( array( 'resources' => 'resources', 'team' => 'meet-the-team', 'about' => 'about' ) as $key => $route ) {
		echo $item( $links[ $key ]['url'], $links[ $key ]['label'], $route ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo $item( prime_recovery_route_url( 'contact' ), 'Contact', 'contact' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

function prime_recovery_faq_section( $heading = 'Questions, answered', $faqs = null, $class = '' ) {
	$faqs = null === $faqs ? prime_recovery_faqs() : $faqs;
	?>
	<section class="faq<?php echo $class ? ' ' . esc_attr( $class ) : ''; ?>" id="faq" aria-labelledby="faq-title">
		<div class="wrap wrap--narrow">
			<p class="eyebrow">FAQ</p>
			<h2 id="faq-title"><?php echo esc_html( $heading ); ?></h2>
			<div class="faq__list">
				<?php foreach ( $faqs as $i => $f ) : ?>
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
					<li><a href="<?php echo esc_url( prime_recovery_route_url( 'locations' ) ); ?>">Locations</a></li>
				</ul>
			</div>
		</div>
		<div class="wrap site-footer__legal">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Prime Recovery. All rights reserved.</p>
			<p>Devices are used under the direction of your medical provider.<?php if ( get_privacy_policy_url() ) : ?> · <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy policy</a><?php endif; ?></p>
		</div>
	</footer>
	<?php
}

/**
 * Site header (dark, fixed), shared by every page.
 */
function prime_recovery_site_header() {
	$links = prime_recovery_links();
	?>
	<header class="c-header" data-scroll-header>
		<div class="wrap c-header__inner">
			<?php prime_recovery_logo( 'reverse' ); ?>
			<nav class="c-nav" id="c-nav" aria-label="Primary">
				<?php prime_recovery_menu( 'menu menu--c' ); ?>
				<div class="c-nav__actions">
					<?php prime_recovery_social_links( 'social social--c' ); ?>
					<a class="btn btn--primary" href="<?php echo esc_url( $links['shop']['url'] ); ?>"><?php echo prime_recovery_icon( 'cart' ); // phpcs:ignore ?> Shop</a>
				</div>
			</nav>
			<?php prime_recovery_menu_toggle( 'c-nav' ); ?>
		</div>
	</header>
	<?php
}

/**
 * Breadcrumb trail for the current route: Home > parent > page.
 * Mirrored in BreadcrumbList JSON-LD (see inc/schema.php).
 *
 * @return array[] Each item has 'name' and 'url'.
 */
function prime_recovery_breadcrumb_trail() {
	$trail = array( array( 'name' => 'Home', 'url' => home_url( '/' ) ) );
	$route = prime_recovery_route();
	if ( $route ) {
		$parts = explode( '/', $route['key'] );
		$path  = '';
		foreach ( $parts as $part ) {
			$path  = ltrim( $path . '/' . $part, '/' );
			$crumb = prime_recovery_route( $path );
			if ( $crumb ) {
				$trail[] = array( 'name' => $crumb['title'], 'url' => prime_recovery_route_url( $path ) );
			}
		}
	} elseif ( is_singular( 'pr_guide' ) ) {
		$trail[] = array( 'name' => 'Resource Library', 'url' => prime_recovery_route_url( 'resources' ) );
		$trail[] = array( 'name' => get_the_title( get_queried_object_id() ), 'url' => get_permalink( get_queried_object_id() ) );
	} elseif ( is_singular() ) {
		foreach ( array_reverse( get_post_ancestors( get_queried_object_id() ) ) as $ancestor ) {
			$trail[] = array( 'name' => get_the_title( $ancestor ), 'url' => get_permalink( $ancestor ) );
		}
		$trail[] = array( 'name' => get_the_title( get_queried_object_id() ), 'url' => get_permalink( get_queried_object_id() ) );
	}
	return $trail;
}

function prime_recovery_breadcrumbs() {
	$trail = prime_recovery_breadcrumb_trail();
	if ( count( $trail ) < 2 ) {
		return;
	}
	echo '<nav class="crumbs" aria-label="Breadcrumb"><ol>';
	$last = count( $trail ) - 1;
	foreach ( $trail as $i => $c ) {
		if ( $i === $last ) {
			echo '<li><span aria-current="page">' . esc_html( $c['name'] ) . '</span></li>';
		} else {
			echo '<li><a href="' . esc_url( $c['url'] ) . '">' . esc_html( $c['name'] ) . '</a></li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * Inner page hero: dark band with breadcrumbs, eyebrow, H1, lead and buttons.
 *
 * @param array $args {
 *     @type string $eyebrow Small label above the heading.
 *     @type string $title   H1 text. Defaults to the route title.
 *     @type string $lead    Intro paragraph.
 *     @type array  $buttons Each: label, url, style (primary|ghost-light).
 *     @type string $image   Optional theme image file shown at the right.
 *     @type string $alt     Alt text for the image ('' when decorative).
 * }
 */
function prime_recovery_page_hero( $args = array() ) {
	$route = prime_recovery_route();
	$args  = wp_parse_args( $args, array(
		'eyebrow' => '',
		'title'   => $route ? $route['title'] : get_the_title(),
		'lead'    => '',
		'buttons' => array(),
		'image'   => '',
		'alt'     => '',
	) );
	?>
	<section class="p-hero<?php echo $args['image'] ? ' p-hero--media' : ''; ?>" aria-labelledby="p-title">
		<div class="wrap p-hero__inner">
			<div class="p-hero__text">
				<?php prime_recovery_breadcrumbs(); ?>
				<?php if ( $args['eyebrow'] ) : ?>
					<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
				<?php endif; ?>
				<h1 id="p-title"><?php echo esc_html( $args['title'] ); ?></h1>
				<?php if ( $args['lead'] ) : ?>
					<p class="p-hero__lead"><?php echo esc_html( $args['lead'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['buttons'] ) : ?>
					<div class="btn-row">
						<?php foreach ( $args['buttons'] as $btn ) : ?>
							<a class="btn btn--<?php echo esc_attr( isset( $btn['style'] ) ? $btn['style'] : 'primary' ); ?> btn--lg" href="<?php echo esc_url( $btn['url'] ); ?>"><?php echo esc_html( $btn['label'] ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( $args['image'] ) : ?>
				<div class="p-hero__media">
					<img src="<?php echo esc_url( prime_recovery_img( $args['image'] ) ); ?>" alt="<?php echo esc_attr( $args['alt'] ); ?>" width="675" height="675" fetchpriority="high">
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Text typed into the WordPress editor for the current page, if any.
 * Lets the client add or update copy without touching the templates.
 */
function prime_recovery_editor_content( $class = 'p-section p-section--light' ) {
	if ( ! is_singular() ) {
		return;
	}
	$post = get_queried_object();
	if ( ! $post || '' === trim( (string) $post->post_content ) ) {
		return;
	}
	?>
	<section class="<?php echo esc_attr( $class ); ?>">
		<div class="wrap wrap--narrow prose">
			<?php echo apply_filters( 'the_content', $post->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
	<?php
}

/**
 * "Let's talk recovery" call-to-action band, shown above the footer.
 */
function prime_recovery_connect_band() {
	$b     = prime_recovery_business();
	$links = prime_recovery_links();
	?>
	<section class="c-connect" aria-labelledby="c-connect-title">
		<div class="wrap c-connect__inner">
			<div>
				<h2 id="c-connect-title">Let’s talk recovery.</h2>
				<p>Patients, families and providers: call <a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo esc_html( $b['phone'] ); ?></a>, set up a meeting, or follow along on social.</p>
			</div>
			<div class="c-connect__actions">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( add_query_arg( 'topic', 'meeting', $links['connect']['url'] ) . '#contact-form' ); ?>">Set up a meeting</a>
				<?php prime_recovery_social_links( 'social social--c' ); ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Opens a standard inner page: document, header and <main>.
 */
function prime_recovery_page_open() {
	prime_recovery_document_open();
	prime_recovery_site_header();
	echo '<main id="main" class="p-main">';
}

/**
 * Closes a standard inner page: connect band, </main>, footer, document.
 */
function prime_recovery_page_close( $connect = true ) {
	if ( $connect ) {
		prime_recovery_connect_band();
	}
	echo '</main>';
	prime_recovery_site_footer();
	prime_recovery_document_close();
}

/**
 * Seconds to "1:05" and to ISO 8601 ("PT1M5S").
 */
function prime_recovery_duration( $seconds, $iso = false ) {
	$m = intdiv( (int) $seconds, 60 );
	$s = (int) $seconds % 60;
	return $iso ? sprintf( 'PT%dM%dS', $m, $s ) : sprintf( '%d:%02d', $m, $s );
}

/**
 * Video grid. Each card shows the thumbnail and loads the Vimeo player only
 * when clicked, so a page of videos stays fast.
 *
 * @param array  $videos From prime_recovery_nice_videos().
 * @param string $prefix Title prefix for the player's accessible name.
 */
function prime_recovery_video_grid( $videos, $prefix = '' ) {
	echo '<ul class="v-grid">';
	foreach ( $videos as $v ) {
		$title = trim( $prefix . ' ' . $v['title'] );
		$src   = add_query_arg( array( 'h' => $v['hash'], 'dnt' => 1, 'autoplay' => 1 ), 'https://player.vimeo.com/video/' . $v['id'] );
		?>
		<li class="v-card" id="video-<?php echo esc_attr( $v['id'] ); ?>">
			<button type="button" class="v-card__play" data-video-src="<?php echo esc_url( $src ); ?>" data-video-title="<?php echo esc_attr( $title ); ?>">
				<img src="<?php echo esc_url( $v['thumb'] ); ?>" alt="" width="640" height="360" loading="lazy">
				<span class="v-card__icon" aria-hidden="true"></span>
				<span class="screen-reader-text">Play video: </span>
			</button>
			<p class="v-card__title"><?php echo esc_html( $v['title'] ); ?> <span><?php echo esc_html( prime_recovery_duration( $v['seconds'] ) ); ?></span></p>
		</li>
		<?php
	}
	echo '</ul>';
}

/**
 * VideoObject nodes for JSON-LD.
 */
function prime_recovery_video_schema( $videos, $prefix = '' ) {
	$nodes = array();
	foreach ( $videos as $v ) {
		$nodes[] = array(
			'@type'        => 'VideoObject',
			'name'         => trim( $prefix . ' ' . $v['title'] ),
			'description'  => trim( $prefix . ' how-to video: ' . $v['title'] . '.' ),
			'thumbnailUrl' => $v['thumb'],
			'uploadDate'   => $v['date'],
			'duration'     => prime_recovery_duration( $v['seconds'], true ),
			'embedUrl'     => 'https://player.vimeo.com/video/' . $v['id'] . '?h=' . $v['hash'],
			'publisher'    => array( '@id' => home_url( '/' ) . '#organization' ),
		);
	}
	return $nodes;
}

/**
 * Person card for a team member from prime_recovery_team().
 */
function prime_recovery_person_card( $person, $show_bio = true ) {
	$initials = implode( '', array_map( function ( $w ) {
		return mb_substr( $w, 0, 1 );
	}, explode( ' ', $person['name'] ) ) );
	?>
	<article class="person">
		<span class="person__avatar" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
		<div>
			<h3 class="person__name"><?php echo esc_html( $person['name'] ); ?></h3>
			<p class="person__role"><?php echo esc_html( $person['role'] ); ?><?php echo ! empty( $person['area'] ) ? ' · ' . esc_html( $person['area'] ) : ''; ?></p>
			<?php if ( $show_bio ) : ?>
				<p class="person__bio"><?php echo esc_html( $person['bio'] ); ?></p>
			<?php endif; ?>
			<a class="person__email" href="mailto:<?php echo esc_attr( $person['email'] ); ?>"><?php echo esc_html( $person['email'] ); ?></a>
		</div>
	</article>
	<?php
}

/**
 * Product cards (dark), one per entry of prime_recovery_products().
 */
function prime_recovery_product_rail() {
	$products = prime_recovery_products();
	?>
	<ul class="c-rail">
		<?php foreach ( $products as $key => $p ) : ?>
			<li class="c-prod c-prod--<?php echo esc_attr( $key ); ?>">
				<a href="<?php echo esc_url( $p['url'] ); ?>">
					<span class="c-prod__media">
						<?php if ( $p['image'] ) : ?>
							<img src="<?php echo esc_url( prime_recovery_img( $p['image'] ) ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" width="675" height="675" loading="lazy">
						<?php else : ?>
							<span class="c-prod__placeholder"><?php echo prime_recovery_icon( 'bracing' === $key ? 'brace' : 'heart' ); // phpcs:ignore ?><span><?php echo esc_html( $p['name'] ); ?></span></span>
						<?php endif; ?>
					</span>
					<span class="c-prod__body">
						<span class="c-prod__kicker"><?php echo esc_html( $p['kicker'] ); ?></span>
						<span class="c-prod__name"><?php echo esc_html( $p['name'] ); ?></span>
						<span class="c-prod__text"><?php echo esc_html( $p['summary'] ); ?></span>
						<span class="c-prod__cta"><?php echo esc_html( $p['cta'] ); ?> <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></span>
					</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * "From surgery to home in three steps".
 */
function prime_recovery_how_steps() {
	?>
	<ol class="c-steps">
		<li>
			<span class="c-steps__icon"><?php echo prime_recovery_icon( 'stetho' ); // phpcs:ignore ?></span>
			<h3>Your provider orders it</h3>
			<p>We partner with your surgeon or medical provider to get the right brace or device into your recovery plan.</p>
		</li>
		<li>
			<span class="c-steps__icon"><?php echo prime_recovery_icon( 'truck' ); // phpcs:ignore ?></span>
			<h3>We deliver and fit it</h3>
			<p>A Prime Recovery technician brings it to you, fits it and shows you exactly how it works.</p>
		</li>
		<li>
			<span class="c-steps__icon"><?php echo prime_recovery_icon( 'home' ); // phpcs:ignore ?></span>
			<h3>You recover at home</h3>
			<p>Recover on your schedule, with our team a phone call away.</p>
		</li>
	</ol>
	<?php
}
