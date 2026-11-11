<?php
/**
 * Template Name: Home
 *
 * Dark, athletic home page (client-selected Option C). Brand-wide hero
 * ("Your partner in the circle of recovery"), product lineup up top, a
 * DonJoy bracing section, partners, testimonials and FAQ.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b        = prime_recovery_business();
$links    = prime_recovery_links();
$products = prime_recovery_products();
$quotes   = prime_recovery_testimonials();
$hero     = prime_recovery_hero_image();

$marquee = array( 'DonJoy bracing', 'Custom fittings', 'Cold + compression therapy', 'Delivered and set up at home', 'Minnesota and Wisconsin', 'Partners in patient recovery' );

$topics = array_slice( prime_recovery_topics(), 0, 5, true );
$topics['videos'] = array( 'title' => 'Bracing and device how-tos', 'text' => 'Videos for wearing your brace and using your device.' );

$partners = array(
	array( 'name' => 'DonJoy', 'note' => 'Enovis / DJO bracing' ),
	array( 'name' => 'NICE Recovery Systems', 'note' => 'NICE1 cold + compression' ),
	array( 'name' => 'Regeomedix', 'note' => 'Recovery partner' ),
);

prime_recovery_document_open();
?>
<?php prime_recovery_site_header(); ?>

<main id="main">
	<section class="c-hero" aria-labelledby="c-hero-title">
		<div class="c-hero__bg" aria-hidden="true">
			<?php // Stand-in until the DonJoy photo arrives: see prime_recovery_hero_image(). ?>
			<img src="<?php echo esc_url( prime_recovery_img( $hero ) ); ?>" alt="" width="1400" height="956" fetchpriority="high">
		</div>
		<div class="wrap c-hero__inner">
			<p class="c-hero__kicker"><span>Prime Recovery</span> At-home recovery in MN &amp; WI</p>
			<h1 id="c-hero-title">Your partner in the <span>circle of recovery.</span></h1>
			<p class="c-hero__lead">DonJoy bracing, cold + compression therapy and recovery devices, delivered, fit and supported at home by our team. We work alongside patients and the medical professionals who care for them.</p>
			<div class="btn-row">
				<a class="btn btn--primary btn--lg" href="#products">Explore our products <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
				<a class="btn btn--ghost-light btn--lg" href="<?php echo esc_url( $links['team']['url'] ); ?>">Meet the team</a>
			</div>
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

	<section class="c-products" id="products" aria-labelledby="c-products-title">
		<div class="wrap">
			<div class="c-head">
				<div>
					<p class="eyebrow">Our products</p>
					<h2 id="c-products-title">Everything your recovery plan calls for</h2>
				</div>
				<a class="btn btn--ghost-light" href="<?php echo esc_url( $links['shop']['url'] ); ?>">Shop all products <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<?php prime_recovery_product_rail(); ?>
		</div>
	</section>

	<section class="c-bracing" aria-labelledby="c-bracing-title">
		<div class="wrap c-bracing__grid">
			<div>
				<p class="eyebrow">DonJoy bracing</p>
				<h2 id="c-bracing-title">The right brace, fit by people who know bracing.</h2>
				<p class="c-bracing__lead">Prime Recovery carries DonJoy bracing from Enovis/DJO, from off-the-shelf support to custom braces. Our bracing team, led by Jared Winship with more than 15 years in DME bracing, fits each brace and teaches patients and providers how to get the most from it.</p>
				<div class="btn-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $products['bracing']['url'] ); ?>">Explore DonJoy bracing</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( $links['connect']['url'] ); ?>">Talk to our bracing team</a>
				</div>
			</div>
			<ul class="c-bracing__list">
				<?php foreach ( prime_recovery_bracing_points() as $pt ) : ?>
					<li>
						<span class="c-bracing__icon"><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $pt['title'] ); ?></h3>
						<p><?php echo esc_html( $pt['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="c-stats" aria-labelledby="c-stats-title">
		<div class="wrap">
			<h2 id="c-stats-title" class="c-section-title">Prime Recovery by the numbers</h2>
			<ul class="c-stats__grid">
				<li><strong><?php echo esc_html( rtrim( $b['years'], '+' ) ); ?><small>+</small></strong><span>Years of healthcare experience</span></li>
				<li><strong><?php echo esc_html( count( $b['offices'] ) + 1 ); ?></strong><span>Offices across Minnesota and Wisconsin</span></li>
				<li><strong><?php echo esc_html( count( $products ) ); ?></strong><span>Partner brands, including DonJoy</span></li>
			</ul>
		</div>
	</section>

	<section class="c-how" id="how" aria-labelledby="c-how-title">
		<div class="wrap">
			<p class="eyebrow">How it works</p>
			<h2 id="c-how-title">From surgery to home in three steps</h2>
			<?php prime_recovery_how_steps(); ?>
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
				<?php $i = 0; foreach ( $topics as $slug => $t ) : ?>
					<li>
						<a href="<?php echo esc_url( $links['resources']['url'] . '#' . $slug ); ?>">
							<span class="c-topics__num"><?php echo esc_html( sprintf( '%02d', ++$i ) ); ?></span>
							<span class="c-topics__title"><?php echo esc_html( $t['title'] ); ?></span>
							<span class="c-topics__text"><?php echo esc_html( $t['text'] ); ?></span>
							<?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="c-partners" aria-labelledby="c-partners-title">
		<div class="wrap">
			<h2 id="c-partners-title" class="c-section-title">Brands we work with</h2>
			<ul class="c-partners__list">
				<?php foreach ( $partners as $pt ) : ?>
					<li><strong><?php echo esc_html( $pt['name'] ); ?></strong><span><?php echo esc_html( $pt['note'] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="c-voices" aria-labelledby="c-voices-title">
		<div class="wrap">
			<p class="eyebrow">Testimonials</p>
			<h2 id="c-voices-title">Recovery that fits real life</h2>
			<div class="c-voices__grid">
				<?php foreach ( $quotes as $q ) : ?>
					<figure class="quote c-voice">
						<blockquote>“<?php echo esc_html( $q['quote'] ); ?>”</blockquote>
						<figcaption><strong><?php echo esc_html( $q['author'] ); ?></strong> · <?php echo esc_html( $q['role'] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="c-team" aria-labelledby="c-team-title">
		<div class="c-team__media" aria-hidden="true">
			<img src="<?php echo esc_url( prime_recovery_img( 'care-at-home.jpg' ) ); ?>" alt="" width="1400" height="933" loading="lazy">
		</div>
		<div class="wrap c-team__inner">
			<div class="c-team__card">
				<p class="eyebrow">Our mission</p>
				<h2 id="c-team-title">Get back to the life you love.</h2>
				<p>Prime Recovery partners with medical professionals to offer patients the gold standard of care during recovery. With 30+ years of healthcare experience and technicians across Minnesota and Wisconsin, we make sure you are fully equipped to get back to normal, daily life.</p>
				<div class="btn-row">
					<a class="btn btn--primary" href="<?php echo esc_url( $links['team']['url'] ); ?>">Meet the team</a>
					<a class="btn btn--ghost" href="<?php echo esc_url( $links['about']['url'] ); ?>">About us</a>
				</div>
			</div>
		</div>
	</section>

	<?php prime_recovery_connect_band(); ?>

	<?php prime_recovery_faq_section( 'Questions, answered' ); ?>
</main>

<?php
prime_recovery_site_footer();
prime_recovery_document_close();
