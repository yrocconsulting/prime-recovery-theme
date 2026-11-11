<?php
/**
 * Fallback template: posts, archives and search results.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

prime_recovery_page_open();

if ( is_singular() ) :
	while ( have_posts() ) :
		the_post();
		prime_recovery_page_hero( array( 'title' => get_the_title() ) );
		?>
		<section class="p-section p-section--light">
			<article class="wrap wrap--narrow prose">
				<?php the_content(); ?>
			</article>
		</section>
		<?php
	endwhile;
else :
	prime_recovery_page_hero( array( 'title' => wp_strip_all_tags( get_the_archive_title() ) ) );
	?>
	<section class="p-section p-section--light">
		<div class="wrap wrap--narrow">
			<?php if ( have_posts() ) : ?>
				<ul class="p-list">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<li>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php the_excerpt(); ?>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p>Nothing here yet.</p>
			<?php endif; ?>
		</div>
	</section>
	<?php
endif;

prime_recovery_page_close();
