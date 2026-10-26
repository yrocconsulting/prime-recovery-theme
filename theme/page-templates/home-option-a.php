<?php
/**
 * Template Name: Home – Option A (Clean Clinical)
 *
 * Top navigation with a utility bar, a split NICE1 hero, quick-link tiles
 * for the client's five key links, and a clear patient / provider path.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b        = prime_recovery_business();
$links    = prime_recovery_links();
$products = prime_recovery_products();
$nice     = $products['nice1'];
$quotes   = prime_recovery_testimonials();

prime_recovery_document_open();
?>
<div class="utility-bar">
	<div class="wrap utility-bar__inner">
		<p class="utility-bar__msg"><?php echo prime_recovery_icon( 'truck' ); // phpcs:ignore ?> Delivered and set up at home across Minnesota and Wisconsin</p>
		<ul class="utility-bar__links">
			<li><a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo prime_recovery_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( $b['phone'] ); ?></a></li>
			<li><a href="<?php echo esc_url( $links['resources']['url'] ); ?>">Resource Library</a></li>
			<li><a href="<?php echo esc_url( $links['connect']['url'] ); ?>">Schedule a meeting</a></li>
		</ul>
		<?php prime_recovery_social_links( 'social social--mini' ); ?>
	</div>
</div>

<header class="site-header">
	<div class="wrap site-header__inner">
		<?php prime_recovery_logo(); ?>
		<nav class="primary-nav" id="primary-nav" aria-label="Primary">
			<?php prime_recovery_menu( 'menu menu--top' ); ?>
			<a class="btn btn--primary primary-nav__shop" href="<?php echo esc_url( $links['shop']['url'] ); ?>"><?php echo prime_recovery_icon( 'cart' ); // phpcs:ignore ?> Shop</a>
		</nav>
		<?php prime_recovery_menu_toggle( 'primary-nav' ); ?>
	</div>
</header>

<main id="main">
	<section class="a-hero">
		<div class="wrap a-hero__grid">
			<div class="a-hero__copy">
				<p class="eyebrow">The gold standard for at-home recovery</p>
				<h1>Iceless cold + compression therapy, delivered to your door.</h1>
				<p class="lead">Prime Recovery brings the <strong>NICE1</strong> cold + compression system home after injury or surgery. No ice to buy, store or refill. Just consistent cold, programmable compression and a local technician who sets it up with you.</p>
				<div class="btn-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $nice['url'] ); ?>">Discover NICE1 <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
					<a class="btn btn--ghost" href="<?php echo esc_url( $links['connect']['url'] ); ?>">Talk to our team</a>
				</div>
				<ul class="a-hero__proof">
					<li><strong><?php echo esc_html( $b['years'] ); ?></strong> years of healthcare experience</li>
					<li><strong>5</strong> offices in MN &amp; WI</li>
					<li><strong>0</strong> bags of ice</li>
				</ul>
			</div>
			<div class="a-hero__media">
				<div class="a-hero__circle">
					<img src="<?php echo esc_url( prime_recovery_img( $nice['image'] ) ); ?>" alt="<?php echo esc_attr( $nice['alt'] ); ?>" width="773" height="762" fetchpriority="high">
				</div>
				<span class="chip chip--1"><?php echo prime_recovery_icon( 'snow' ); // phpcs:ignore ?> Cold without ice</span>
				<span class="chip chip--2"><?php echo prime_recovery_icon( 'pulse' ); // phpcs:ignore ?> Programmable compression</span>
				<span class="chip chip--3"><?php echo prime_recovery_icon( 'feather' ); // phpcs:ignore ?> Just 9 lbs</span>
			</div>
		</div>
	</section>

	<nav class="a-tiles" aria-label="Quick links">
		<div class="wrap">
			<ul class="a-tiles__list">
				<?php foreach ( $links as $key => $l ) : ?>
					<li>
						<a class="a-tile a-tile--<?php echo esc_attr( $key ); ?>" href="<?php echo esc_url( $l['url'] ); ?>">
							<span class="a-tile__icon"><?php echo prime_recovery_icon( $l['icon'] ); // phpcs:ignore ?></span>
							<span class="a-tile__label"><?php echo esc_html( $l['label'] ); ?></span>
							<span class="a-tile__blurb"><?php echo esc_html( $l['blurb'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</nav>

	<section class="section a-nice" aria-labelledby="nice-title">
		<div class="wrap a-nice__grid">
			<div class="a-nice__media">
				<img src="<?php echo esc_url( prime_recovery_img( 'nice1-knee-seated.jpg' ) ); ?>" alt="Man seated on the floor using the NICE1 wrap on his knee with the compact NICE1 unit beside him" width="1200" height="675" loading="lazy">
				<figure class="quote a-nice__quote">
					<blockquote>“<?php echo esc_html( $quotes[0]['quote'] ); ?>”</blockquote>
					<figcaption><strong><?php echo esc_html( $quotes[0]['author'] ); ?></strong>, <?php echo esc_html( $quotes[0]['role'] ); ?></figcaption>
				</figure>
			</div>
			<div class="a-nice__copy">
				<p class="eyebrow">Featured product</p>
				<h2 id="nice-title">NICE1 is the cold + compression system that never needs ice.</h2>
				<p>NICE1 delivers precise cold therapy without ice and programmable pneumatic compression, which helps reduce swelling and speed recovery. It is a clear point of difference from ice-based machines.</p>
				<ul class="a-features">
					<?php
					$icons = array( 'snow', 'pulse', 'feather', 'touch' );
					foreach ( prime_recovery_nice1_features() as $i => $f ) :
						?>
						<li>
							<span class="a-features__icon"><?php echo prime_recovery_icon( $icons[ $i ] ); // phpcs:ignore ?></span>
							<h3><?php echo esc_html( $f['title'] ); ?></h3>
							<p><?php echo esc_html( $f['text'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
				<a class="btn btn--primary" href="<?php echo esc_url( $nice['url'] ); ?>"><?php echo esc_html( $nice['cta'] ); ?> <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
		</div>
	</section>

	<section class="section section--alt a-compare" aria-labelledby="compare-title">
		<div class="wrap wrap--narrow">
			<p class="eyebrow">Why iceless</p>
			<h2 id="compare-title">Recovery without the ice routine</h2>
			<table class="a-compare__table">
				<thead>
					<tr><th scope="col"><span class="screen-reader-text">Feature</span></th><th scope="col">Ice-based machines</th><th scope="col" class="is-nice">NICE1</th></tr>
				</thead>
				<tbody>
					<tr><th scope="row">Buying, storing and refilling ice</th><td>Every couple of hours</td><td class="is-nice"><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?> Never</td></tr>
					<tr><th scope="row">Consistent, long-lasting cold</th><td>Warms as ice melts</td><td class="is-nice"><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?> Yes</td></tr>
					<tr><th scope="row">Programmable compression</th><td>Varies</td><td class="is-nice"><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?> Intermittent and constant</td></tr>
					<tr><th scope="row">Size and weight</th><td>Cooler-sized</td><td class="is-nice"><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?> 8 x 8 x 8 in, 9 lbs</td></tr>
				</tbody>
			</table>
		</div>
	</section>

	<section class="section a-products" aria-labelledby="products-title">
		<div class="wrap">
			<div class="section-head">
				<div>
					<p class="eyebrow">More recovery products</p>
					<h2 id="products-title">Everything your recovery plan calls for</h2>
				</div>
				<a class="btn btn--ghost" href="<?php echo esc_url( $links['shop']['url'] ); ?>">Shop all products</a>
			</div>
			<ul class="a-cards">
				<?php
				foreach ( $products as $key => $p ) :
					if ( 'nice1' === $key ) {
						continue;
					}
					?>
					<li class="a-card">
						<div class="a-card__media">
							<?php if ( $p['image'] ) : ?>
								<img src="<?php echo esc_url( prime_recovery_img( $p['image'] ) ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" width="650" height="650" loading="lazy">
							<?php else : ?>
								<span class="a-card__placeholder"><?php echo prime_recovery_icon( 'brace' ); // phpcs:ignore ?></span>
							<?php endif; ?>
						</div>
						<div class="a-card__body">
							<p class="a-card__kicker"><?php echo esc_html( $p['kicker'] ); ?></p>
							<h3><?php echo esc_html( $p['name'] ); ?></h3>
							<p><?php echo esc_html( $p['summary'] ); ?></p>
							<a class="a-card__link" href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['cta'] ); ?> <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="a-paths" aria-label="Patients and providers">
		<div class="wrap a-paths__grid">
			<div class="a-path a-path--patients">
				<span class="a-path__icon"><?php echo prime_recovery_icon( 'home' ); // phpcs:ignore ?></span>
				<h2>For patients</h2>
				<p>Recover in the comfort of home. Our technicians deliver your device, show you how it works and stay with you through recovery.</p>
				<a class="btn btn--primary" href="<?php echo esc_url( $links['resources']['url'] ); ?>">Visit the Resource Library</a>
			</div>
			<div class="a-path a-path--providers">
				<span class="a-path__icon"><?php echo prime_recovery_icon( 'stetho' ); // phpcs:ignore ?></span>
				<h2>For providers</h2>
				<p>Partner with a local team that handles delivery, fitting and patient education for cold + compression, DVT prevention, NMES and bracing.</p>
				<a class="btn btn--ghost-light" href="<?php echo esc_url( $links['connect']['url'] ); ?>">Set up a meeting</a>
			</div>
		</div>
	</section>

	<section class="section a-about" aria-labelledby="about-title">
		<div class="wrap a-about__grid">
			<img class="a-about__img" src="<?php echo esc_url( prime_recovery_img( 'care-at-home.jpg' ) ); ?>" alt="A caregiver in scrubs holding a patient's hand at home" width="1400" height="933" loading="lazy">
			<div>
				<p class="eyebrow">Who we are</p>
				<h2 id="about-title">Partners in patient recovery</h2>
				<p>Prime Recovery partners with medical professionals to offer patients the gold standard of care during recovery. With more than 30 years of healthcare experience, our team delivers the highest level of service, and takes pride in making sure you are fully equipped to get back to daily life.</p>
				<div class="btn-row">
					<a class="btn btn--dark" href="<?php echo esc_url( $links['about']['url'] ); ?>">Our mission</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( $links['team']['url'] ); ?>">Meet the team</a>
				</div>
			</div>
		</div>
	</section>

	<section class="a-testimonial" aria-label="Patient testimonial">
		<div class="wrap wrap--narrow">
			<figure class="quote">
				<blockquote>“<?php echo esc_html( $quotes[1]['quote'] ); ?>”</blockquote>
				<figcaption><strong><?php echo esc_html( $quotes[1]['author'] ); ?></strong>, <?php echo esc_html( $quotes[1]['role'] ); ?></figcaption>
			</figure>
		</div>
	</section>

	<?php prime_recovery_faq_section( 'Common questions about at-home recovery' ); ?>
</main>

<?php
prime_recovery_site_footer();
prime_recovery_document_close();
