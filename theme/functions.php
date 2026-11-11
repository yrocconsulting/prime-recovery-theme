<?php
/**
 * Prime Recovery theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( 'inc/content.php' );
require_once get_theme_file_path( 'inc/routes.php' );
require_once get_theme_file_path( 'inc/schema.php' );
require_once get_theme_file_path( 'inc/template-tags.php' );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	register_nav_menus( array( 'primary' => __( 'Primary Menu', 'prime-recovery' ) ) );
} );

/**
 * Whether the home page design is being rendered: the front page, or any
 * page using the "Home" template.
 */
function prime_recovery_is_home_design() {
	return is_front_page() || ( is_page() && 'page-templates/home.php' === get_page_template_slug( get_queried_object_id() ) );
}

add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'pr-site';
	if ( prime_recovery_is_home_design() ) {
		$classes[] = 'pr-home';
	}
	$route = prime_recovery_current_route();
	if ( $route ) {
		$classes[] = 'pr-route-' . sanitize_html_class( str_replace( '/', '-', $route ) );
	}
	return $classes;
} );

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'prime-recovery-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'prime-recovery-base', get_theme_file_uri( 'assets/css/base.css' ), array(), $ver );
	wp_enqueue_style( 'prime-recovery-site', get_theme_file_uri( 'assets/css/site.css' ), array( 'prime-recovery-base' ), $ver );
	if ( ! prime_recovery_is_home_design() ) {
		wp_enqueue_style( 'prime-recovery-pages', get_theme_file_uri( 'assets/css/pages.css' ), array( 'prime-recovery-site' ), $ver );
	}
	wp_enqueue_script( 'prime-recovery-site', get_theme_file_uri( 'assets/js/site.js' ), array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

// The theme styles everything itself; the block library CSS is only needed where editor content is shown.
add_action( 'wp_enqueue_scripts', function () {
	if ( prime_recovery_is_home_design() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'global-styles' );
	}
}, 100 );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

/**
 * Search and AI snippet for the current page (no SEO plugin required).
 */
function prime_recovery_meta_description() {
	if ( prime_recovery_is_home_design() ) {
		return 'Prime Recovery delivers at-home recovery devices and DonJoy bracing, including the NICE1 iceless cold + compression system, to patients and providers across Minnesota and Wisconsin. Based in Corcoran, MN.';
	}
	$route = prime_recovery_route();
	if ( $route ) {
		return $route['description'];
	}
	if ( is_singular() && has_excerpt( get_queried_object_id() ) ) {
		return wp_strip_all_tags( get_the_excerpt( get_queried_object_id() ) );
	}
	return '';
}

add_action( 'wp_head', function () {
	$description = prime_recovery_meta_description();
	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
	// WordPress prints the canonical link for real pages; routes served by the theme need their own.
	$route = prime_recovery_route();
	if ( $route && ! is_singular() ) {
		echo '<link rel="canonical" href="' . esc_url( prime_recovery_route_url( $route['key'] ) ) . '">' . "\n";
	}
}, 1 );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( prime_recovery_is_home_design() ) {
		return array(
			'title' => 'At-Home Recovery Devices and DonJoy Bracing in Minnesota and Wisconsin',
			'site'  => 'Prime Recovery',
		);
	}
	$route = prime_recovery_route();
	if ( $route ) {
		return array(
			'title' => $route['seo_title'],
			'site'  => 'Prime Recovery',
		);
	}
	return $parts;
} );
