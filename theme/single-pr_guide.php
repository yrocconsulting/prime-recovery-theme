<?php
/**
 * A Recovery Guide (Resource Library article).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$id = get_queried_object_id();
prime_recovery_add_schema( array(
	'@type'            => 'Article',
	'@id'              => get_permalink( $id ) . '#article',
	'headline'         => get_the_title( $id ),
	'description'      => wp_strip_all_tags( get_the_excerpt( $id ) ),
	'datePublished'    => get_the_date( 'c', $id ),
	'dateModified'     => get_the_modified_date( 'c', $id ),
	'author'           => array( '@id' => home_url( '/' ) . '#organization' ),
	'publisher'        => array( '@id' => home_url( '/' ) . '#organization' ),
	'mainEntityOfPage' => get_permalink( $id ),
	'image'            => has_post_thumbnail( $id ) ? get_the_post_thumbnail_url( $id, 'large' ) : prime_recovery_img( 'care-at-home.jpg' ),
) );

prime_recovery_page_open();
while ( have_posts() ) :
	the_post();
	prime_recovery_page_hero( array(
		'eyebrow' => 'Recovery guide',
		'title'   => get_the_title(),
		'lead'    => has_excerpt() ? get_the_excerpt() : '',
	) );
	?>
	<section class="p-section p-section--light">
		<article class="wrap wrap--narrow prose">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'guide__img' ) ); ?>
			<?php endif; ?>
			<?php the_content(); ?>
			<p class="guide__meta">Updated <?php echo esc_html( get_the_modified_date() ); ?>. This guide is general information. Always follow your provider’s instructions.</p>
			<p><a class="btn btn--dark" href="<?php echo esc_url( prime_recovery_route_url( 'resources' ) ); ?>">Back to the Resource Library</a></p>
		</article>
	</section>
	<?php
endwhile;
prime_recovery_page_close();
