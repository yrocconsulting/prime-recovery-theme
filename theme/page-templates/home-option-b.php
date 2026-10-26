<?php
/**
 * Template Name: Home – Option B (Recovery Circle)
 *
 * Left-side navigation, an interactive "circle of recovery" with NICE1 at the
 * center and the other products around it, then full-width info menu bars
 * for the client's five key links.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b        = prime_recovery_business();
$links    = prime_recovery_links();
$products = prime_recovery_products();
$nice     = $products['nice1'];
$quotes   = prime_recovery_testimonials();

// Nodes around the circle. NICE1 sits in the center.
$nodes = array(
	'nice1'      => array( 'label' => 'NICE1', 'icon' => 'snow', 'pos' => 'center' ),
	'plasmaflow' => array( 'label' => 'PlasmaFlow', 'icon' => 'pulse', 'pos' => 'n' ),
	'manaflexx'  => array( 'label' => 'ManaFlexx 2', 'icon' => 'feather', 'pos' => 'e' ),
	'bracing'    => array( 'label' => 'Bracing', 'icon' => 'brace', 'pos' => 's' ),
	'team'       => array( 'label' => 'Your Care Team', 'icon' => 'people', 'pos' => 'w' ),
);

prime_recovery_document_open();
?>
<div class="b-layout">
	<header class="b-sidebar">
		<div class="b-sidebar__top">
			<?php prime_recovery_logo(); ?>
			<?php prime_recovery_menu_toggle( 'b-drawer' ); ?>
		</div>
		<div class="b-drawer" id="b-drawer">
			<nav class="b-nav" aria-label="Primary">
				<?php prime_recovery_menu( 'menu menu--side' ); ?>
			</nav>
			<a class="btn btn--primary b-sidebar__shop" href="<?php echo esc_url( $links['shop']['url'] ); ?>"><?php echo prime_recovery_icon( 'cart' ); // phpcs:ignore ?> Shop now</a>
			<div class="b-sidebar__foot">
				<a class="b-sidebar__phone" href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo prime_recovery_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( $b['phone'] ); ?></a>
				<?php prime_recovery_social_links(); ?>
			</div>
		</div>
	</header>

	<div class="b-content">
		<main id="main">
			<section class="b-hero" aria-labelledby="b-hero-title">
				<div class="b-hero__intro">
					<p class="eyebrow">Welcome to the gold standard for at-home recovery</p>
					<h1 id="b-hero-title">Your partner in the <span>circle of recovery</span></h1>
					<p class="lead">Prime Recovery helps patients recover at home after injury or surgery, and supports the medical professionals who care for them. Start at the center with NICE1, our iceless cold + compression system.</p>
				</div>

				<div class="b-circle" data-recovery-circle data-active="nice1">
					<div class="b-circle__stage">
						<div class="b-circle__ring" aria-hidden="true"></div>
						<div class="b-circle__tabs" role="tablist" aria-label="Recovery products and services">
							<?php foreach ( $nodes as $key => $node ) : ?>
								<button class="b-node b-node--<?php echo esc_attr( $node['pos'] ); ?>" type="button" role="tab" id="tab-<?php echo esc_attr( $key ); ?>" aria-controls="panel-<?php echo esc_attr( $key ); ?>" aria-selected="<?php echo 'nice1' === $key ? 'true' : 'false'; ?>" data-key="<?php echo esc_attr( $key ); ?>">
									<?php if ( 'nice1' === $key ) : ?>
										<span class="b-node__img"><img src="<?php echo esc_url( prime_recovery_img( $nice['image'] ) ); ?>" alt="" width="773" height="762" fetchpriority="high"></span>
										<span class="b-node__badge">Featured</span>
									<?php else : ?>
										<span class="b-node__icon"><?php echo prime_recovery_icon( $node['icon'] ); // phpcs:ignore ?></span>
									<?php endif; ?>
									<span class="b-node__label"><?php echo esc_html( $node['label'] ); ?></span>
								</button>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="b-circle__panels">
						<?php
						foreach ( $nodes as $key => $node ) :
							if ( 'team' === $key ) {
								$p = array(
									'name'    => 'Your Care Team',
									'kicker'  => 'Delivery, setup and support',
									'summary' => 'Our technicians deliver your device, show you how it works and partner with you through recovery. We work alongside your surgeon and care team so you are fully equipped to get back to daily life.',
									'url'     => $links['team']['url'],
									'cta'     => 'Meet the team',
								);
							} else {
								$p = $products[ $key ];
							}
							?>
							<div class="b-panel" role="tabpanel" id="panel-<?php echo esc_attr( $key ); ?>" aria-labelledby="tab-<?php echo esc_attr( $key ); ?>" tabindex="0">
								<p class="eyebrow"><?php echo esc_html( $p['kicker'] ); ?></p>
								<h2><?php echo esc_html( $p['name'] ); ?></h2>
								<p><?php echo esc_html( $p['summary'] ); ?></p>
								<?php if ( 'nice1' === $key ) : ?>
									<ul class="b-panel__stats">
										<li><strong>0</strong> ice</li>
										<li><strong>9 lbs</strong> light</li>
										<li><strong>8×8×8</strong> inches</li>
									</ul>
								<?php endif; ?>
								<a class="btn btn--primary" href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['cta'] ); ?> <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
							</div>
						<?php endforeach; ?>
						<p class="b-circle__hint" aria-hidden="true">Select any point on the circle to learn more.</p>
					</div>
				</div>
			</section>

			<nav class="b-bars" aria-labelledby="b-bars-title">
				<div class="b-pad">
					<h2 id="b-bars-title" class="b-bars__title">Find what you need</h2>
					<ul class="b-bars__list">
						<?php
						$n = 0;
						foreach ( $links as $key => $l ) :
							$n++;
							?>
							<li>
								<a class="b-bar" href="<?php echo esc_url( $l['url'] ); ?>">
									<span class="b-bar__num"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
									<span class="b-bar__icon"><?php echo prime_recovery_icon( $l['icon'] ); // phpcs:ignore ?></span>
									<span class="b-bar__label"><?php echo esc_html( $l['label'] ); ?></span>
									<span class="b-bar__blurb"><?php echo esc_html( $l['blurb'] ); ?></span>
									<span class="b-bar__arrow"><?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</nav>

			<section class="b-spot" aria-labelledby="b-spot-title">
				<div class="b-pad b-spot__grid">
					<div class="b-spot__media">
						<img src="<?php echo esc_url( prime_recovery_img( 'nice1-thigh-wrap.jpg' ) ); ?>" alt="NICE1 cold and compression wrap fitted around the thigh and knee" width="675" height="675" loading="lazy">
					</div>
					<div class="b-spot__copy">
						<p class="eyebrow">Why patients choose NICE1</p>
						<h2 id="b-spot-title">No more buying, storing and filling machines with ice.</h2>
						<p>NICE1 delivers long-lasting cold and programmable compression in one small, easy-to-use device. It is the smallest and lightest cold + compression system on the market.</p>
						<ul class="b-spot__features">
							<?php foreach ( prime_recovery_nice1_features() as $f ) : ?>
								<li><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?> <span><strong><?php echo esc_html( $f['title'] ); ?>.</strong> <?php echo esc_html( $f['text'] ); ?></span></li>
							<?php endforeach; ?>
						</ul>
						<div class="btn-row">
							<a class="btn btn--light" href="<?php echo esc_url( $nice['url'] ); ?>"><?php echo esc_html( $nice['cta'] ); ?></a>
							<a class="btn btn--ghost-light" href="<?php echo esc_url( $links['shop']['url'] ); ?>">Shop NICE1</a>
						</div>
					</div>
				</div>
			</section>

			<section class="b-voices" aria-labelledby="b-voices-title">
				<div class="b-pad">
					<p class="eyebrow">In their words</p>
					<h2 id="b-voices-title">Recovery that fits real life</h2>
					<div class="b-voices__grid">
						<?php foreach ( $quotes as $q ) : ?>
							<figure class="quote b-voice">
								<blockquote>“<?php echo esc_html( $q['quote'] ); ?>”</blockquote>
								<figcaption><strong><?php echo esc_html( $q['author'] ); ?></strong>, <?php echo esc_html( $q['role'] ); ?></figcaption>
							</figure>
						<?php endforeach; ?>
					</div>
				</div>
			</section>

			<section class="b-mission" aria-labelledby="b-mission-title">
				<div class="b-pad b-mission__grid">
					<div>
						<p class="eyebrow">Our mission</p>
						<h2 id="b-mission-title">The gold standard of care, at home</h2>
					</div>
					<div>
						<p>Prime Recovery partners with medical professionals to give patients the gold standard of care during recovery. With more than 30 years of healthcare experience and offices in Corcoran, Duluth, Bemidji, Madison and Green Bay, our team delivers devices, education and support wherever you recover.</p>
						<div class="btn-row">
							<a class="btn btn--dark" href="<?php echo esc_url( $links['about']['url'] ); ?>">Read our story</a>
							<a class="btn btn--ghost" href="<?php echo esc_url( $links['connect']['url'] ); ?>">Set up a meeting</a>
						</div>
					</div>
				</div>
			</section>

			<?php prime_recovery_faq_section( 'Questions about recovering at home' ); ?>
		</main>
		<?php prime_recovery_site_footer(); ?>
	</div>
</div>
<?php
prime_recovery_document_close();
