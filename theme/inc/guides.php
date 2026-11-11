<?php
/**
 * Recovery Guides: a simple post type for Resource Library articles, written
 * in the normal WordPress editor (no page builder). Each guide can be tagged
 * with a topic whose slug matches a library topic (knee, shoulder, hip,
 * ankle, back, wrist) to appear under it.
 *
 * Guides live at /resources/guides/<slug>/. After the first guide is added,
 * visit Settings > Permalinks and click Save once so WordPress learns the URL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_post_type( 'pr_guide', array(
		'labels'        => array(
			'name'          => 'Recovery Guides',
			'singular_name' => 'Recovery Guide',
			'add_new_item'  => 'Add New Guide',
			'edit_item'     => 'Edit Guide',
			'menu_name'     => 'Recovery Guides',
		),
		'public'        => true,
		'has_archive'   => false,
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-book-alt',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		'rewrite'       => array( 'slug' => 'resources/guides', 'with_front' => false ),
	) );
	register_taxonomy( 'pr_topic', 'pr_guide', array(
		'labels'            => array( 'name' => 'Topics', 'singular_name' => 'Topic' ),
		'public'            => false,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'rewrite'           => false,
	) );
} );

/**
 * Published guides, optionally for one topic slug.
 */
function prime_recovery_guides( $topic = '' ) {
	$args = array(
		'post_type'      => 'pr_guide',
		'post_status'    => 'publish',
		'posts_per_page' => 50,
		'no_found_rows'  => true,
	);
	if ( $topic ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'pr_topic', 'field' => 'slug', 'terms' => $topic ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	}
	return get_posts( $args );
}
