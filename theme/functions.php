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
 * Home page design options. Each one is a page template, and can also be
 * previewed without creating a page via ?pr_home=a|b|c.
 */
function prime_recovery_home_templates() {
	return array(
		'a' => 'page-templates/home-option-a.php',
		'b' => 'page-templates/home-option-b.php',
		'c' => 'page-templates/home-option-c.php',
	);
}

/**
 * Which home design is being rendered ('a', 'b', 'c'), or null.
 */
function prime_recovery_home_option() {
	static $option = false;
	if ( false !== $option ) {
		return $option;
	}
	$option = null;
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only preview switch.
	$preview = isset( $_GET['pr_home'] ) ? sanitize_key( wp_unslash( $_GET['pr_home'] ) ) : '';
	$map     = prime_recovery_home_templates();
	if ( isset( $map[ $preview ] ) ) {
		$option = $preview;
	} elseif ( is_page() ) {
		$found = array_search( get_page_template_slug( get_queried_object_id() ), $map, true );
		$option = false === $found ? null : $found;
	}
	return $option;
}

add_filter( 'template_include', function ( $template ) {
	$option = prime_recovery_home_option();
	if ( $option && ( is_front_page() || is_home() ) ) {
		$preview = locate_template( prime_recovery_home_templates()[ $option ] );
		if ( $preview ) {
			return $preview;
		}
	}
	return $template;
} );

// Preview URLs and the design chooser should never be indexed.
add_filter( 'wp_robots', function ( $robots ) {
	if ( isset( $_GET['pr_home'] ) || defined( 'PRIME_RECOVERY_CHOOSER' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
} );

add_filter( 'body_class', function ( $classes ) {
	$option = prime_recovery_home_option();
	if ( $option ) {
		$classes[] = 'pr-home';
		$classes[] = 'pr-home-' . $option;
	} elseif ( defined( 'PRIME_RECOVERY_CHOOSER' ) ) {
		$classes[] = 'pr-home';
	}
	return $classes;
} );

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'prime-recovery', get_stylesheet_uri(), array(), $ver );

	$option  = prime_recovery_home_option();
	$chooser = defined( 'PRIME_RECOVERY_CHOOSER' );
	if ( ! $option && ! $chooser ) {
		return;
	}
	wp_enqueue_style( 'prime-recovery-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'prime-recovery-base', get_theme_file_uri( 'assets/css/base.css' ), array(), $ver );
	if ( $chooser ) {
		wp_enqueue_style( 'prime-recovery-chooser', get_theme_file_uri( 'assets/css/chooser.css' ), array( 'prime-recovery-base' ), $ver );
		return;
	}
	wp_enqueue_style( 'prime-recovery-home-' . $option, get_theme_file_uri( 'assets/css/home-' . $option . '.css' ), array( 'prime-recovery-base' ), $ver );
	wp_enqueue_script( 'prime-recovery-home', get_theme_file_uri( 'assets/js/home.js' ), array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation && prime_recovery_home_option() ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

// Home page description for search and AI snippets (no SEO plugin required).
add_action( 'wp_head', function () {
	if ( prime_recovery_home_option() ) {
		echo '<meta name="description" content="' . esc_attr( 'Prime Recovery delivers the NICE1 iceless cold + compression therapy system and other at-home recovery devices to patients across Minnesota and Wisconsin. Based in Corcoran, MN.' ) . '">' . "\n";
	}
}, 1 );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( prime_recovery_home_option() ) {
		$parts = array(
			'title' => 'At-Home Recovery Devices | NICE1 Iceless Cold + Compression Therapy',
			'site'  => 'Prime Recovery',
		);
	}
	return $parts;
} );
