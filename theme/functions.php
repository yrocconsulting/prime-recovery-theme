<?php
/**
 * Prime Recovery theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( 'inc/content.php' );
require_once get_theme_file_path( 'inc/schema.php' );
require_once get_theme_file_path( 'inc/template-tags.php' );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
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
	if ( prime_recovery_is_home_design() ) {
		$classes[] = 'pr-home';
	}
	return $classes;
} );

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'prime-recovery', get_stylesheet_uri(), array(), $ver );

	if ( ! prime_recovery_is_home_design() ) {
		return;
	}
	wp_enqueue_style( 'prime-recovery-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'prime-recovery-base', get_theme_file_uri( 'assets/css/base.css' ), array(), $ver );
	wp_enqueue_style( 'prime-recovery-home', get_theme_file_uri( 'assets/css/home.css' ), array( 'prime-recovery-base' ), $ver );
	wp_enqueue_script( 'prime-recovery-home', get_theme_file_uri( 'assets/js/home.js' ), array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation && prime_recovery_is_home_design() ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

// Home page description for search and AI snippets (no SEO plugin required).
add_action( 'wp_head', function () {
	if ( prime_recovery_is_home_design() ) {
		echo '<meta name="description" content="' . esc_attr( 'Prime Recovery delivers at-home recovery devices and DonJoy bracing, including the NICE1 iceless cold + compression system, to patients and providers across Minnesota and Wisconsin. Based in Corcoran, MN.' ) . '">' . "\n";
	}
}, 1 );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( prime_recovery_is_home_design() ) {
		$parts = array(
			'title' => 'At-Home Recovery Devices and DonJoy Bracing in Minnesota and Wisconsin',
			'site'  => 'Prime Recovery',
		);
	}
	return $parts;
} );
