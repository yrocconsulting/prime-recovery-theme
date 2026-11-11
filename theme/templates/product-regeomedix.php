<?php
/**
 * Regeomedix (partner). Placeholder until the client confirms the products;
 * the route is noindex until then (see inc/routes.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$p = prime_recovery_products()['regeomedix'];

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Partner',
	'title'   => 'Regeomedix',
	'lead'    => $p['summary'],
	'buttons' => array(
		array( 'label' => 'Ask about Regeomedix', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'primary' ),
		array( 'label' => 'All products', 'url' => prime_recovery_route_url( 'products' ), 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light">
	<div class="wrap wrap--narrow">
		<p class="eyebrow">Coming soon</p>
		<h2>Product details are on the way</h2>
		<p class="lead">We are adding the Regeomedix products we carry to this page. In the meantime, our team can tell you what is available and whether it fits your recovery plan.</p>
		<div class="btn-row">
			<a class="btn btn--primary" href="tel:<?php echo esc_attr( prime_recovery_business()['phone_e164'] ); ?>">Call <?php echo esc_html( prime_recovery_business()['phone'] ); ?></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( prime_recovery_route_url( 'contact' ) ); ?>">Send us a message</a>
		</div>
	</div>
</section>
<?php
prime_recovery_editor_content();
prime_recovery_page_close();
