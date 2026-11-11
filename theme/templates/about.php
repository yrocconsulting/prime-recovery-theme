<?php
/**
 * Our Mission (about).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b      = prime_recovery_business();
$chad   = prime_recovery_team()['chad'];
$faqs   = prime_recovery_about_faqs();
$quotes = prime_recovery_testimonials();

$pillars = array(
	array( 'icon' => 'stetho', 'title' => 'Partner with providers', 'text' => 'We work alongside surgeons, clinics and surgical teams so the right brace or device is part of every recovery plan.' ),
	array( 'icon' => 'truck', 'title' => 'Bring it home', 'text' => 'Our technicians deliver, fit and set up each device in the comfort and privacy of the patient’s home.' ),
	array( 'icon' => 'heart', 'title' => 'Stay with you', 'text' => 'We teach patients and families how everything works, and we are a phone call away until recovery is done.' ),
);

prime_recovery_add_schema( prime_recovery_person_schema( 'chad', $chad ) );
prime_recovery_add_schema( prime_recovery_faq_schema( $faqs, prime_recovery_route_url( 'about' ) . '#faq' ) );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Our mission',
	'title'   => 'Get back to the life you love.',
	'lead'    => 'Prime Recovery partners with medical professionals to offer patients the gold standard of care during recovery, so you are fully equipped to get back to normal, daily life.',
	'buttons' => array(
		array( 'label' => 'Meet the team', 'url' => prime_recovery_route_url( 'meet-the-team' ), 'style' => 'primary' ),
		array( 'label' => 'Connect with us', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'ghost-light' ),
	),
	'image'   => 'care-at-home.jpg',
	'alt'     => 'A Prime Recovery technician helping a patient recover at home',
) );
?>
<section class="p-section p-section--tight" aria-label="Prime Recovery by the numbers">
	<div class="wrap">
		<ul class="c-stats__grid">
			<li><strong><?php echo esc_html( rtrim( $b['years'], '+' ) ); ?><small>+</small></strong><span>Years of healthcare experience</span></li>
			<li><strong><?php echo esc_html( count( $b['offices'] ) + 1 ); ?></strong><span>Offices across Minnesota and Wisconsin</span></li>
			<li><strong><?php echo esc_html( count( prime_recovery_products() ) ); ?></strong><span>Partner brands, including DonJoy</span></li>
		</ul>
	</div>
</section>

<section class="p-section p-section--light" aria-labelledby="story-title">
	<div class="wrap split">
		<div>
			<p class="eyebrow">Our story</p>
			<h2 id="story-title">Built to bring better recovery home</h2>
		</div>
		<div class="prose">
			<p>Prime Recovery was launched to expand patient access to top-quality medical products in the comfort of their homes. Healing after an injury or surgery is hard enough. Getting the right equipment, and knowing how to use it, should not be.</p>
			<p>Our owner, <?php echo esc_html( $chad['name'] ); ?>, has worked in the medical field since 1996 as an orthopedic sales representative and manager. He co-founded BoneFoam, a global leader in perioperative patient positioning, and owned Excel Medical Solutions, a distributor for leading orthopedic companies.</p>
			<p>Today our team serves patients and providers from our main office in <?php echo esc_html( $b['city'] . ', ' . $b['region'] ); ?> and offices across Minnesota and Wisconsin, with DonJoy bracing from Enovis/DJO, the NICE1 iceless cold + compression system and products from our partners.</p>
		</div>
	</div>
</section>

<section class="p-section p-section--alt" aria-labelledby="pillars-title">
	<div class="wrap">
		<p class="eyebrow">How we work</p>
		<h2 id="pillars-title">Your partner in the circle of recovery</h2>
		<ul class="feat-grid">
			<?php foreach ( $pillars as $f ) : ?>
				<li class="feat">
					<span class="feat__icon"><?php echo prime_recovery_icon( $f['icon'] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $f['title'] ); ?></h3>
					<p><?php echo esc_html( $f['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="c-voices" aria-labelledby="voices-title">
	<div class="wrap">
		<p class="eyebrow">Testimonials</p>
		<h2 id="voices-title">Recovery that fits real life</h2>
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

<?php
prime_recovery_editor_content();
prime_recovery_faq_section( 'About Prime Recovery', $faqs );
prime_recovery_page_close();
