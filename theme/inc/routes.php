<?php
/**
 * Site map and page routing.
 *
 * Every page the theme designs is listed here with its URL, heading and
 * search/AI snippet. A route renders its theme template whether or not a
 * WordPress page exists at that URL yet:
 *
 * - If a published page exists at the path (e.g. a page "Bracing" whose
 *   parent is "Products"), it uses the route's template, and any text typed
 *   into the page editor is added to the template.
 * - If no page exists, the theme serves the route itself so it can be
 *   previewed on staging before pages are created in WP admin.
 *
 * Only routes whose template file exists are served.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function prime_recovery_routes() {
	return array(
		'products'            => array(
			'title'       => 'Products',
			'seo_title'   => 'At-Home Recovery Products: DonJoy Bracing and NICE1',
			'description' => 'Recovery products from Prime Recovery: DonJoy bracing from Enovis/DJO, the NICE1 iceless cold + compression system and Regeomedix, delivered and fit at home in Minnesota and Wisconsin.',
			'template'    => 'templates/products.php',
		),
		'products/bracing'    => array(
			'title'       => 'DonJoy Bracing',
			'seo_title'   => 'DonJoy Bracing, Custom Braces and Fittings in Minnesota and Wisconsin',
			'description' => 'Off-the-shelf and custom DonJoy bracing from Enovis/DJO, measured and fit by the Prime Recovery bracing team, with education for patients and providers in Minnesota and Wisconsin.',
			'template'    => 'templates/product-bracing.php',
		),
		'products/nice'       => array(
			'title'       => 'NICE1 Cold + Compression Therapy',
			'seo_title'   => 'NICE1 Iceless Cold + Compression Therapy System',
			'description' => 'NICE1 is an iceless cold + compression therapy system for recovery after injury or surgery. Features, specs and how-to videos from Prime Recovery.',
			'template'    => 'templates/product-nice.php',
		),
		'products/regeomedix' => array(
			'title'       => 'Regeomedix',
			'seo_title'   => 'Regeomedix Recovery Products',
			'description' => 'Recovery products from Prime Recovery partner Regeomedix, delivered and supported by our team in Minnesota and Wisconsin.',
			'template'    => 'templates/product-regeomedix.php',
			// Kept out of search until the client confirms which Regeomedix products we carry.
			'noindex'     => true,
		),
		'shop'                => array(
			'title'       => 'Shop',
			'seo_title'   => 'Shop Recovery Products',
			'description' => 'Browse Prime Recovery products and request DonJoy bracing, NICE1 cold + compression and recovery supplies for delivery in Minnesota and Wisconsin.',
			'template'    => 'templates/shop.php',
		),
		'resources'           => array(
			'title'       => 'Resource Library',
			'seo_title'   => 'Resource Library: Recovery Guides and How-To Videos',
			'description' => 'Recovery guides, injury information and how-to videos for DonJoy braces and the NICE1 cold + compression system, from Prime Recovery.',
			'template'    => 'templates/resources.php',
		),
		'meet-the-team'       => array(
			'title'       => 'Meet the Team',
			'seo_title'   => 'Meet the Team',
			'description' => 'Meet the Prime Recovery team: bracing specialists and home recovery patient care staff serving patients and providers across Minnesota and Wisconsin.',
			'template'    => 'templates/team.php',
		),
		'about'               => array(
			'title'       => 'Our Mission',
			'seo_title'   => 'Our Mission: The Gold Standard of At-Home Recovery',
			'description' => 'Prime Recovery partners with medical professionals to bring patients the gold standard of care during recovery at home, backed by 30+ years of healthcare experience.',
			'template'    => 'templates/about.php',
			'schema_type' => 'AboutPage',
		),
		'contact'             => array(
			'title'       => 'Connect With Us',
			'seo_title'   => 'Contact Prime Recovery',
			'description' => 'Contact Prime Recovery in Corcoran, MN: call (651) 374-9026, send us a message or set up a meeting with our team.',
			'template'    => 'templates/contact.php',
		),
		'locations'           => array(
			'title'       => 'Locations',
			'seo_title'   => 'Locations in Minnesota and Wisconsin',
			'description' => 'Prime Recovery is based in Corcoran, Minnesota, with offices in Duluth, Brainerd and Rochester, Minnesota, and Madison and Eau Claire, Wisconsin.',
			'template'    => 'templates/locations.php',
		),
	);
}

/**
 * Path of the current request relative to the site root, without slashes.
 */
function prime_recovery_request_path() {
	$path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$base = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( $base && 0 === strpos( $path, $base ) ) {
		$path = substr( $path, strlen( $base ) );
	}
	return trim( rawurldecode( $path ), '/' );
}

/**
 * The route key for this request, or '' when the request is not a route.
 */
function prime_recovery_current_route() {
	static $route = null;
	if ( null !== $route && did_action( 'wp' ) ) {
		return $route;
	}
	$found  = '';
	$routes = prime_recovery_routes();
	if ( is_page() && get_queried_object() ) {
		$uri = get_page_uri( get_queried_object_id() );
		if ( isset( $routes[ $uri ] ) ) {
			$found = $uri;
		}
	} elseif ( ! empty( $GLOBALS['prime_recovery_virtual_route'] ) ) {
		$found = $GLOBALS['prime_recovery_virtual_route'];
	}
	if ( $found && ! file_exists( get_theme_file_path( $routes[ $found ]['template'] ) ) ) {
		$found = '';
	}
	if ( did_action( 'wp' ) ) {
		$route = $found;
	}
	return $found;
}

function prime_recovery_route( $key = null ) {
	$key    = null === $key ? prime_recovery_current_route() : $key;
	$routes = prime_recovery_routes();
	return ( $key && isset( $routes[ $key ] ) ) ? $routes[ $key ] + array( 'key' => $key ) : null;
}

function prime_recovery_route_url( $key ) {
	return home_url( '/' . $key . '/' );
}

// Serve a route when no WordPress page exists at its path yet.
add_filter( 'pre_handle_404', function ( $handled, $query ) {
	if ( $handled || is_admin() || ! $query->is_main_query() ) {
		return $handled;
	}
	if ( $query->have_posts() && ! $query->is_404() ) {
		return $handled;
	}
	$path   = prime_recovery_request_path();
	$routes = prime_recovery_routes();
	if ( ! isset( $routes[ $path ] ) || ! file_exists( get_theme_file_path( $routes[ $path ]['template'] ) ) ) {
		return $handled;
	}
	$GLOBALS['prime_recovery_virtual_route'] = $path;
	// The request was parsed as a page that doesn't exist; render it as the theme route instead.
	$query->init_query_flags();
	status_header( 200 );
	return true;
}, 10, 2 );

add_filter( 'template_include', function ( $template ) {
	$route = prime_recovery_route();
	return $route ? get_theme_file_path( $route['template'] ) : $template;
}, 99 );

// Retired product pages from the old site go to the products hub.
add_action( 'template_redirect', function () {
	if ( ! is_404() ) {
		return;
	}
	$retired = array( 'products/plasmaflow', 'products/manaflexx2' );
	if ( in_array( prime_recovery_request_path(), $retired, true ) ) {
		wp_safe_redirect( prime_recovery_route_url( 'products' ), 301 );
		exit;
	}
} );

/**
 * Add theme routes to the WordPress XML sitemap (wp-sitemap.xml) while no
 * real page exists at their path, so search and AI crawlers find them.
 */
add_action( 'init', function () {
	if ( ! function_exists( 'wp_register_sitemap_provider' ) || ! class_exists( 'WP_Sitemaps_Provider' ) ) {
		return;
	}
	if ( ! class_exists( 'Prime_Recovery_Sitemap_Provider' ) ) {
		class Prime_Recovery_Sitemap_Provider extends WP_Sitemaps_Provider {
			public function __construct() {
				$this->name        = 'prime';
				$this->object_type = 'prime';
			}
			public function get_url_list( $page_num, $object_subtype = '' ) {
				$urls = array();
				foreach ( prime_recovery_routes() as $path => $route ) {
					if ( ! empty( $route['noindex'] ) || ! file_exists( get_theme_file_path( $route['template'] ) ) || get_page_by_path( $path ) ) {
						continue;
					}
					$urls[] = array( 'loc' => prime_recovery_route_url( $path ) );
				}
				return $urls;
			}
			public function get_max_num_pages( $object_subtype = '' ) {
				return 1;
			}
		}
	}
	wp_register_sitemap_provider( 'prime', new Prime_Recovery_Sitemap_Provider() );
} );
