<?php
/**
 * DonJoy Bracing (Enovis/DJO).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$p     = prime_recovery_products()['bracing'];
$jared = prime_recovery_team()['jared'];
$faqs  = prime_recovery_bracing_faqs();
$url   = $p['url'];

$areas = array(
	array( 'title' => 'Knee', 'text' => 'Ligament, post-op and osteoarthritis knee braces.' ),
	array( 'title' => 'Ankle', 'text' => 'Ankle braces and walking boots for sprains and fractures.' ),
	array( 'title' => 'Shoulder', 'text' => 'Slings and shoulder braces after injury or surgery.' ),
	array( 'title' => 'Back', 'text' => 'Back braces for support and recovery.' ),
);

$node                = prime_recovery_product_node( $p );
$node['description'] = 'Off-the-shelf and custom DonJoy bracing from Enovis/DJO for the knee, ankle, shoulder, back and more, measured and fit by Prime Recovery.';
prime_recovery_add_schema( $node );
prime_recovery_add_schema( array(
	'@type'       => 'Service',
	'@id'         => $url . '#fitting',
	'name'        => 'DonJoy brace fitting and education',
	'serviceType' => 'Orthopedic brace fitting',
	'description' => 'Prime Recovery measures, fits and teaches patients to use off-the-shelf and custom DonJoy braces, and educates providers on bracing.',
	'provider'    => array( '@id' => home_url( '/' ) . '#organization' ),
	'areaServed'  => array( array( '@type' => 'State', 'name' => 'Minnesota' ), array( '@type' => 'State', 'name' => 'Wisconsin' ) ),
) );
prime_recovery_add_schema( array(
	'@type'    => 'Person',
	'@id'      => prime_recovery_route_url( 'meet-the-team' ) . '#jared',
	'name'     => $jared['name'],
	'jobTitle' => $jared['role'],
	'email'    => 'mailto:' . $jared['email'],
	'worksFor' => array( '@id' => home_url( '/' ) . '#organization' ),
) );
prime_recovery_add_schema( prime_recovery_faq_schema( $faqs, $url . '#faq' ) );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Enovis / DJO',
	'title'   => 'DonJoy bracing, fit by people who know bracing',
	'lead'    => 'Prime Recovery carries DonJoy bracing from Enovis/DJO, from off-the-shelf support to custom braces. Our bracing team fits each brace and teaches patients and providers how to get the most from it.',
	'buttons' => array(
		array( 'label' => 'Talk to our bracing team', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'primary' ),
		array( 'label' => 'Bracing questions', 'url' => '#faq', 'style' => 'ghost-light' ),
	),
	'image'   => file_exists( get_theme_file_path( 'assets/img/hero-donjoy.jpg' ) ) ? 'hero-donjoy.jpg' : '',
	'alt'     => 'DonJoy brace fitted by Prime Recovery',
) );
?>
<section class="p-section p-section--light" aria-labelledby="services-title">
	<div class="wrap">
		<div class="split">
			<div>
				<p class="eyebrow">What we do</p>
				<h2 id="services-title">From the right brace to the right fit</h2>
				<p class="lead">A brace only works when it fits. Our team handles bracing from the order to the fitting, and stays with you through recovery.</p>
			</div>
			<ul class="feat-grid feat-grid--2">
				<?php foreach ( prime_recovery_bracing_points() as $pt ) : ?>
					<li class="feat">
						<span class="feat__icon"><?php echo prime_recovery_icon( 'check' ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $pt['title'] ); ?></h3>
						<p><?php echo esc_html( $pt['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<section class="p-section p-section--alt" aria-labelledby="areas-title">
	<div class="wrap">
		<p class="eyebrow">Bracing by body area</p>
		<h2 id="areas-title">Support for the knee, ankle, shoulder, back and more</h2>
		<ul class="area-grid">
			<?php foreach ( $areas as $i => $a ) : ?>
				<li>
					<span class="area-grid__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $a['title'] ); ?></h3>
					<p><?php echo esc_html( $a['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
		<p class="area-grid__more">Need something else? <a href="<?php echo esc_url( prime_recovery_route_url( 'contact' ) ); ?>">Ask our bracing team</a> about the full DonJoy line.</p>
	</div>
</section>

<section class="p-section p-section--light" aria-labelledby="who-title">
	<div class="wrap">
		<h2 id="who-title" class="screen-reader-text">Who we work with</h2>
		<div class="duo">
			<div class="duo__card">
				<span class="feat__icon"><?php echo prime_recovery_icon( 'home' ); // phpcs:ignore ?></span>
				<h3>For patients</h3>
				<p>Your surgeon or provider orders your brace. We fit it, show you how to put it on and take it off, and answer questions as you recover. Call <a href="tel:<?php echo esc_attr( prime_recovery_business()['phone_e164'] ); ?>"><?php echo esc_html( prime_recovery_business()['phone'] ); ?></a> any time.</p>
			</div>
			<div class="duo__card duo__card--dark">
				<span class="feat__icon"><?php echo prime_recovery_icon( 'stetho' ); // phpcs:ignore ?></span>
				<h3>For providers</h3>
				<p>Our Enovis/DJO team educates clinics and surgical teams on bracing, including custom bracing and fittings, and coordinates bracing for your patients across Minnesota and Wisconsin.</p>
			</div>
		</div>
		<div class="contact-person">
			<p class="eyebrow">Your bracing contact</p>
			<?php prime_recovery_person_card( $jared ); ?>
		</div>
	</div>
</section>

<?php
prime_recovery_editor_content();
prime_recovery_faq_section( 'Bracing questions', $faqs );
prime_recovery_page_close();
