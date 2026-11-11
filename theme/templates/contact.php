<?php
/**
 * Connect With Us: contact form, phone, office, meeting and social.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b      = prime_recovery_business();
$map    = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $b['name'] . ', ' . $b['street'] . ', ' . $b['city'] . ', ' . $b['region'] . ' ' . $b['postal'] );

prime_recovery_add_schema( array(
	'@type'      => 'ContactPage',
	'@id'        => prime_recovery_route_url( 'contact' ) . '#contact',
	'url'        => prime_recovery_route_url( 'contact' ),
	'name'       => 'Contact Prime Recovery',
	'mainEntity' => array(
		'@id'          => home_url( '/' ) . '#organization',
		'contactPoint' => array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer service',
			'telephone'         => $b['phone_e164'],
			'areaServed'        => array( 'US-MN', 'US-WI' ),
			'availableLanguage' => 'English',
		),
	),
) );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Connect with us',
	'title'   => 'Let’s talk recovery.',
	'lead'    => 'Patients, families and providers: call us, send a message or set up a meeting with our team. We serve Minnesota and Wisconsin from Corcoran and five satellite offices.',
	'buttons' => array(
		array( 'label' => 'Call ' . $b['phone'], 'url' => 'tel:' . $b['phone_e164'], 'style' => 'primary' ),
		array( 'label' => 'Send a message', 'url' => '#contact-form', 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light" aria-labelledby="form-title">
	<div class="wrap contact-grid">
		<div>
			<p class="eyebrow">Get in touch</p>
			<h2 id="form-title">Send us a message</h2>
			<p class="lead">Ask about a device or brace, set up a meeting, or tell us about your clinic. We’ll get back to you by phone or email.</p>
			<?php prime_recovery_contact_form(); ?>
		</div>
		<aside class="contact-aside" aria-label="Contact details">
			<div class="contact-box">
				<h3><?php echo prime_recovery_icon( 'phone' ); // phpcs:ignore ?> Call or fax</h3>
				<p>Office: <a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo esc_html( $b['phone'] ); ?></a><br>Fax: <?php echo esc_html( $b['fax'] ); ?></p>
			</div>
			<div class="contact-box">
				<h3><?php echo prime_recovery_icon( 'pin' ); // phpcs:ignore ?> Main office</h3>
				<address><?php echo esc_html( $b['street'] ); ?><br><?php echo esc_html( $b['city'] . ', ' . $b['region'] . ' ' . $b['postal'] ); ?></address>
				<p><a href="<?php echo esc_url( $map ); ?>" rel="noopener" target="_blank">Get directions</a> · <a href="<?php echo esc_url( prime_recovery_route_url( 'locations' ) ); ?>">All locations</a></p>
			</div>
			<div class="contact-box">
				<h3><?php echo prime_recovery_icon( 'chat' ); // phpcs:ignore ?> Follow along</h3>
				<p>Find us on Facebook and LinkedIn.</p>
				<?php prime_recovery_social_links( 'social social--light' ); ?>
			</div>
		</aside>
	</div>
</section>
<?php
prime_recovery_editor_content();
prime_recovery_page_close( false );
