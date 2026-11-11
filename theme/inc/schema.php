<?php
/**
 * JSON-LD for every page.
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

	$products = array_filter( $products, function ( $p ) {
		return $p['schema'];
	} );

	$offers = array();
	foreach ( $products as $p ) {
		$offers[] = array(
			'@type'       => 'Offer',
			'itemOffered' => array( '@id' => prime_recovery_product_id( $p ) ),
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
		'image'              => prime_recovery_img( prime_recovery_hero_image() ),
		'telephone'          => $b['phone_e164'],
		'faxNumber'          => $b['fax'],
		'address'            => $address,
		'areaServed'         => array(
			array( '@type' => 'State', 'name' => 'Minnesota' ),
			array( '@type' => 'State', 'name' => 'Wisconsin' ),
		),
		'department'         => $departments,
		'founder'            => array( '@type' => 'Person', 'name' => 'Chad Robran', 'jobTitle' => 'Owner' ),
		'knowsAbout'         => array( 'Orthopedic bracing', 'Custom brace fitting', 'DonJoy bracing', 'Cold therapy', 'Compression therapy', 'Post-surgical recovery at home' ),
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

	if ( ! prime_recovery_is_home_design() ) {
		return prime_recovery_page_schema( $graph, $org_id );
	}

	foreach ( $products as $p ) {
		$graph[] = prime_recovery_product_node( $p );
	}
	$faq          = prime_recovery_faq_schema( prime_recovery_faqs(), $home . '#faq' );
	$faq['about'] = array( '@id' => $org_id );
	$graph[]      = $faq;

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
}

function prime_recovery_product_id( $p ) {
	return $p['url'] . '#product';
}

/**
 * Product or ProductGroup node for one entry of prime_recovery_products().
 */
function prime_recovery_product_node( $p ) {
	$item = array(
		'@type'       => $p['group'] ? 'ProductGroup' : 'Product',
		'@id'         => prime_recovery_product_id( $p ),
		'name'        => $p['name'],
		'category'    => $p['kicker'],
		'description' => $p['summary'],
		'url'         => $p['url'],
		'brand'       => array( '@type' => 'Brand', 'name' => $p['brand'] ),
	);
	if ( $p['image'] ) {
		$item['image'] = prime_recovery_img( $p['image'] );
	}
	return $item;
}

/**
 * Templates call this before prime_recovery_page_open() to add nodes
 * (products, people, FAQs) to the page's JSON-LD.
 */
function prime_recovery_add_schema( $node ) {
	$GLOBALS['prime_recovery_schema_nodes'][] = $node;
}

/**
 * FAQPage node from a list of q/a pairs, so on-page FAQs and JSON-LD match.
 */
function prime_recovery_faq_schema( $faqs, $id ) {
	$items = array();
	foreach ( $faqs as $f ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => $f['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $f['a'] ),
		);
	}
	return array(
		'@type'      => 'FAQPage',
		'@id'        => $id,
		'mainEntity' => $items,
	);
}

/**
 * Inner pages: the organization and website, a WebPage with breadcrumbs,
 * and whatever the template added.
 */
function prime_recovery_page_schema( $graph, $org_id ) {
	$url   = prime_recovery_route() ? prime_recovery_route_url( prime_recovery_current_route() ) : ( is_singular() ? get_permalink() : home_url( add_query_arg( array() ) ) );
	$trail = prime_recovery_breadcrumb_trail();
	$crumbs = array();
	foreach ( $trail as $i => $c ) {
		$crumbs[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $c['name'],
			'item'     => $c['url'],
		);
	}
	$route = prime_recovery_route();
	$page  = array(
		'@type'     => isset( $route['schema_type'] ) ? $route['schema_type'] : 'WebPage',
		'@id'       => $url . '#webpage',
		'url'       => $url,
		'name'      => $route ? $route['seo_title'] : wp_get_document_title(),
		'isPartOf'  => array( '@id' => home_url( '/' ) . '#website' ),
		'about'     => array( '@id' => $org_id ),
		'publisher' => array( '@id' => $org_id ),
	);
	$description = prime_recovery_meta_description();
	if ( $description ) {
		$page['description'] = $description;
	}
	if ( count( $crumbs ) > 1 ) {
		$page['breadcrumb'] = array( '@id' => $url . '#breadcrumb' );
		$graph[]            = array(
			'@type'           => 'BreadcrumbList',
			'@id'             => $url . '#breadcrumb',
			'itemListElement' => $crumbs,
		);
	}
	$graph[] = $page;
	if ( ! empty( $GLOBALS['prime_recovery_schema_nodes'] ) ) {
		$graph = array_merge( $graph, $GLOBALS['prime_recovery_schema_nodes'] );
	}
	return array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
}

add_action( 'wp_head', function () {
	echo '<script type="application/ld+json">' . wp_json_encode( prime_recovery_schema_graph(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
} );

/**
 * Person node for a team member from prime_recovery_team().
 */
function prime_recovery_person_schema( $key, $person ) {
	$node = array(
		'@type'       => 'Person',
		'@id'         => prime_recovery_route_url( 'meet-the-team' ) . '#' . $key,
		'name'        => $person['name'],
		'jobTitle'    => $person['role'],
		'description' => $person['bio'],
		'email'       => 'mailto:' . $person['email'],
		'worksFor'    => array( '@id' => home_url( '/' ) . '#organization' ),
	);
	if ( ! empty( $person['area'] ) ) {
		$node['areaServed'] = $person['area'];
	}
	return $node;
}
