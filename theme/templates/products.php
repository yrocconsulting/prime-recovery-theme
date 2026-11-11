<?php
/**
 * Products hub: every product line, how ordering works, and product FAQs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$products = prime_recovery_products();
$faqs     = array_values( array_intersect_key( prime_recovery_faqs(), array_flip( array( 0, 1, 2, 5 ) ) ) );
$url      = prime_recovery_route_url( 'products' );

$list = array();
foreach ( array_values( $products ) as $i => $p ) {
	$list[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'url' => $p['url'], 'name' => $p['name'] );
	if ( $p['schema'] ) {
		prime_recovery_add_schema( prime_recovery_product_node( $p ) );
	}
}
prime_recovery_add_schema( array( '@type' => 'ItemList', '@id' => $url . '#products', 'name' => 'Prime Recovery products', 'itemListElement' => $list ) );
prime_recovery_add_schema( prime_recovery_faq_schema( $faqs, $url . '#faq' ) );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Our products',
	'title'   => 'Everything your recovery plan calls for',
	'lead'    => 'Prime Recovery provides DonJoy bracing, the NICE1 iceless cold + compression system and recovery products from our partners. Our team delivers, fits and supports each one at home across Minnesota and Wisconsin.',
	'buttons' => array(
		array( 'label' => 'Talk to our team', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'primary' ),
		array( 'label' => 'Shop', 'url' => prime_recovery_route_url( 'shop' ), 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--tight" aria-label="Product lines">
	<div class="wrap">
		<?php prime_recovery_product_rail(); ?>
	</div>
</section>

<section class="p-section p-section--light" aria-labelledby="how-title">
	<div class="wrap">
		<p class="eyebrow">How it works</p>
		<h2 id="how-title">From surgery to home in three steps</h2>
		<?php prime_recovery_how_steps(); ?>
	</div>
</section>

<?php
prime_recovery_editor_content();
prime_recovery_faq_section( 'Product questions', $faqs );
prime_recovery_page_close();
