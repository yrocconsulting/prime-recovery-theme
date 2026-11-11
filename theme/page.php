<?php
/**
 * Standard page (privacy policy, notices and any page without its own template).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

prime_recovery_page_open();
while ( have_posts() ) :
	the_post();
	prime_recovery_page_hero( array(
		'title' => get_the_title(),
		'lead'  => has_excerpt() ? get_the_excerpt() : '',
	) );
	?>
	<section class="p-section p-section--light">
		<div class="wrap wrap--narrow prose">
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;
prime_recovery_page_close();
