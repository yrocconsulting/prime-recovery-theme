<?php
/**
 * Template Name: Home – Option C (Bold Performance)
 *
 * Dark, athletic look. Full-bleed NICE1 hero ("Ditch the ice"), big product
 * stats, a three-step how-it-works, a product rail and a Resource Library
 * preview organized by body area.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b        = prime_recovery_business();
$links    = prime_recovery_links();
$products = prime_recovery_products();
$nice     = $products['nice1'];
$quotes   = prime_recovery_testimonials();

$marquee = array( 'No ice. Ever.', 'Programmable compression', '9 lbs', 'Touch screen simple', 'Delivered and set up at home', 'Minnesota and Wisconsin' );

$topics = array(
	array( 'title' => 'Knee', 'text' => 'ACL, meniscus and knee replacement recovery.' ),
	array( 'title' => 'Shoulder', 'text' => 'Rotator cuff and shoulder surgery recovery.' ),
	array( 'title' => 'Hip', 'text' => 'Hip replacement and hip arthroscopy recovery.' ),
	array( 'title' => 'Ankle and foot', 'text' => 'Sprains, fractures and Achilles recovery.' ),
	array( 'title' => 'Back', 'text' => 'Bracing and support for back injuries.' ),
	array( 'title' => 'Device how-tos', 'text' => 'Videos for NICE1, PlasmaFlow and ManaFlexx 2.' ),
);

prime_recovery_document_open();
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

<main id="main">
	<section class="c-hero" aria-labelledby="c-hero-title">
		<div class="c-hero__bg" aria-hidden="true">
			<img src="<?php echo esc_url( prime_recovery_img( 'nice1-knee-seated.jpg' ) ); ?>" alt="" width="1200" height="675" fetchpriority="high">
		</div>
		<div class="wrap c-hero__inner">
			<p class="c-hero__kicker"><span>NICE1</span> Iceless cold + compression therapy</p>
			<h1 id="c-hero-title">Ditch the ice.<br><span>Own your recovery.</span></h1>
			<p class="c-hero__lead">The gold standard for at-home recovery after injury or surgery. NICE1 delivers long-lasting cold and programmable compression with zero ice, delivered and set up by Prime Recovery.</p>
			<div class="btn-row">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $nice['url'] ); ?>">Discover iceless therapy <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
				<a class="btn btn--ghost-light btn--lg" href="#how">How it works</a>
			</div>
			<figure class="quote c-hero__quote">
				<blockquote>“<?php echo esc_html( $quotes[0]['quote'] ); ?>”</blockquote>
				<figcaption><strong><?php echo esc_html( $quotes[0]['author'] ); ?></strong> · <?php echo esc_html( $quotes[0]['role'] ); ?></figcaption>
			</figure>
		</div>
	</section>

	<div class="c-marquee" aria-hidden="true">
		<div class="c-marquee__track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<?php foreach ( $marquee as $m ) : ?>
					<span><?php echo esc_html( $m ); ?></span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>

	<section class="c-stats" aria-labelledby="c-stats-title">
		<div class="wrap">
			<h2 id="c-stats-title" class="c-section-title">NICE1 by the numbers</h2>
			<ul class="c-stats__grid">
				<li><strong>0</strong><span>Bags of ice to buy, store or refill</span></li>
				<li><strong>9<small>lbs</small></strong><span>Smallest and lightest cold + compression device on the market</span></li>
				<li><strong>8<small>×</small>8<small>×</small>8</strong><span>Inches. Fits on a nightstand.</span></li>
				<li><strong>2</strong><span>Compression modes: intermittent and constant</span></li>
			</ul>
		</div>
	</section>

	<section class="c-how" id="how" aria-labelledby="c-how-title">
		<div class="wrap">
			<p class="eyebrow">How it works</p>
			<h2 id="c-how-title">From surgery to home in three steps</h2>
			<ol class="c-steps">
				<li>
					<span class="c-steps__icon"><?php echo prime_recovery_icon( 'stetho' ); // phpcs:ignore ?></span>
					<h3>Your provider orders it</h3>
					<p>We partner with your surgeon or medical provider to get the right device into your recovery plan.</p>
				</li>
				<li>
					<span class="c-steps__icon"><?php echo prime_recovery_icon( 'truck' ); // phpcs:ignore ?></span>
					<h3>We deliver and set it up</h3>
					<p>A Prime Recovery technician brings it to you and shows you exactly how it works.</p>
				</li>
				<li>
					<span class="c-steps__icon"><?php echo prime_recovery_icon( 'home' ); // phpcs:ignore ?></span>
					<h3>You recover at home</h3>
					<p>Cold and compression on your schedule, with our team a phone call away.</p>
				</li>
			</ol>
		</div>
	</section>

	<section class="c-products" aria-labelledby="c-products-title">
		<div class="wrap">
			<div class="c-head">
				<div>
					<p class="eyebrow">The full recovery lineup</p>
					<h2 id="c-products-title">More ways we help you heal</h2>
				</div>
				<a class="btn btn--ghost-light" href="<?php echo esc_url( $links['shop']['url'] ); ?>">Shop all products <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<ul class="c-rail">
				<?php
				foreach ( $products as $key => $p ) :
					if ( 'nice1' === $key ) {
						continue;
					}
					?>
					<li class="c-prod">
						<a href="<?php echo esc_url( $p['url'] ); ?>">
							<span class="c-prod__media">
								<?php if ( $p['image'] ) : ?>
									<img src="<?php echo esc_url( prime_recovery_img( $p['image'] ) ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" width="650" height="650" loading="lazy">
								<?php else : ?>
									<span class="c-prod__placeholder"><?php echo prime_recovery_icon( 'brace' ); // phpcs:ignore ?></span>
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
		</div>
	</section>

	<section class="c-library" aria-labelledby="c-library-title">
		<div class="wrap">
			<div class="c-head">
				<div>
					<p class="eyebrow">Resource Library</p>
					<h2 id="c-library-title">Know your injury. Plan your recovery.</h2>
				</div>
				<a class="btn btn--dark" href="<?php echo esc_url( $links['resources']['url'] ); ?>">Browse the library</a>
			</div>
			<ul class="c-topics">
				<?php foreach ( $topics as $i => $t ) : ?>
					<li>
						<a href="<?php echo esc_url( $links['resources']['url'] ); ?>">
							<span class="c-topics__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<span class="c-topics__title"><?php echo esc_html( $t['title'] ); ?></span>
							<span class="c-topics__text"><?php echo esc_html( $t['text'] ); ?></span>
							<?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="c-team" aria-labelledby="c-team-title">
		<div class="c-team__media" aria-hidden="true">
			<img src="<?php echo esc_url( prime_recovery_img( 'runners.jpg' ) ); ?>" alt="" width="1400" height="956" loading="lazy">
		</div>
		<div class="wrap c-team__inner">
			<div class="c-team__card">
				<p class="eyebrow">Our mission</p>
				<h2 id="c-team-title">Get back to the life you love.</h2>
				<p>Prime Recovery partners with medical professionals to offer patients the gold standard of care during recovery. With 30+ years of healthcare experience and technicians across Minnesota and Wisconsin, we make sure you are fully equipped to get back to normal, daily life.</p>
				<figure class="quote c-team__quote">
					<blockquote>“<?php echo esc_html( $quotes[1]['quote'] ); ?>”</blockquote>
					<figcaption><strong><?php echo esc_html( $quotes[1]['author'] ); ?></strong> · <?php echo esc_html( $quotes[1]['role'] ); ?></figcaption>
				</figure>
				<div class="btn-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $links['team']['url'] ); ?>">Meet the team</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( $links['about']['url'] ); ?>">About us</a>
				</div>
			</div>
		</div>
	</section>

	<section class="c-connect" aria-labelledby="c-connect-title">
		<div class="wrap c-connect__inner">
			<div>
				<h2 id="c-connect-title">Let’s talk recovery.</h2>
				<p>Patients, families and providers: call <a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo esc_html( $b['phone'] ); ?></a>, set up a meeting, or follow along on social.</p>
			</div>
			<div class="c-connect__actions">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( $links['connect']['url'] ); ?>">Set up a meeting</a>
				<?php prime_recovery_social_links( 'social social--c' ); ?>
			</div>
		</div>
	</section>

	<?php prime_recovery_faq_section( 'Straight answers about NICE1 and at-home recovery' ); ?>
</main>

<?php
prime_recovery_site_footer();
prime_recovery_document_close();
