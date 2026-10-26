<?php
/**
 * JSON-LD for the home page designs.
 *
 * Follows the ai-search-optimization-framework guidance: declare the entity
 * (MedicalBusiness), its locations, its offerings and plain-language answers,
 * using exactly the same facts that appear in the visible copy.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function prime_recovery_schema_graph() {
	$b        = prime_recovery_business();
	$home     = home_url( '/' );
	$org_id   = $home . '#organization';
	$products = prime_recovery_products();

	$address = array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => $b['street'],
		'addressLocality' => $b['city'],
		'addressRegion'   => $b['region'],
		'postalCode'      => $b['postal'],
		'addressCountry'  => $b['country'],
	);

	$departments = array();
	foreach ( $b['offices'] as $office ) {
		$departments[] = array(
			'@type'   => 'MedicalBusiness',
			'name'    => $b['name'] . ' ' . $office['city'],
			'address' => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => $office['city'],
				'addressRegion'   => $office['region'],
				'addressCountry'  => $b['country'],
			),
		);
	}

	$offers = array();
	foreach ( $products as $key => $p ) {
		$offers[] = array(
			'@type'       => 'Offer',
			'itemOffered' => array( '@id' => $home . '#product-' . $key ),
		);
	}

	$org = array(
		'@type'              => 'MedicalBusiness',
		'@id'                => $org_id,
		'name'               => $b['name'],
		'slogan'             => $b['tagline'],
		'description'        => $b['description'],
		'url'                => $home,
		'logo'               => prime_recovery_img( 'logo-color.png' ),
		'image'              => prime_recovery_img( 'nice1-overhead.jpg' ),
		'telephone'          => $b['phone_e164'],
		'faxNumber'          => $b['fax'],
		'address'            => $address,
		'areaServed'         => array(
			array( '@type' => 'State', 'name' => 'Minnesota' ),
			array( '@type' => 'State', 'name' => 'Wisconsin' ),
		),
		'department'         => $departments,
		'founder'            => array( '@type' => 'Person', 'name' => 'Chad Robran', 'jobTitle' => 'Owner' ),
		'knowsAbout'         => array( 'Cold therapy', 'Compression therapy', 'DVT prevention', 'Neuromuscular electrical stimulation', 'Orthopedic bracing', 'Post-surgical recovery at home' ),
		'makesOffer'         => $offers,
	);
	$same_as = array_values( array_filter( $b['social'] ) );
	if ( $same_as ) {
		$org['sameAs'] = $same_as;
	}

	$graph = array(
		$org,
		array(
			'@type'     => 'WebSite',
			'@id'       => $home . '#website',
			'url'       => $home,
			'name'      => $b['name'],
			'publisher' => array( '@id' => $org_id ),
		),
	);

	$brands = array(
		'nice1'      => 'NICE Recovery Systems',
		'plasmaflow' => 'ManaMed',
		'manaflexx'  => 'ManaMed',
		'bracing'    => 'DonJoy',
	);
	foreach ( $products as $key => $p ) {
		$item = array(
			'@type'       => 'bracing' === $key ? 'ProductGroup' : 'Product',
			'@id'         => $home . '#product-' . $key,
			'name'        => $p['name'],
			'category'    => $p['kicker'],
			'description' => $p['summary'],
			'url'         => $p['url'],
			'brand'       => array( '@type' => 'Brand', 'name' => $brands[ $key ] ),
		);
		if ( $p['image'] ) {
			$item['image'] = prime_recovery_img( $p['image'] );
		}
		$graph[] = $item;
	}

	$faq = array();
	foreach ( prime_recovery_faqs() as $f ) {
		$faq[] = array(
			'@type'          => 'Question',
			'name'           => $f['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $f['a'] ),
		);
	}
	$graph[] = array(
		'@type'      => 'FAQPage',
		'@id'        => $home . '#faq',
		'about'      => array( '@id' => $org_id ),
		'mainEntity' => $faq,
	);

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
}

add_action( 'wp_head', function () {
	if ( ! prime_recovery_home_option() ) {
		return;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( prime_recovery_schema_graph(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
} );
