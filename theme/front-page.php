<?php
/**
 * Front page.
 *
 * If the static front page uses one of the home templates, render it.
 * Otherwise show the three home page design options for client review.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$prime_recovery_slug = is_page() ? get_page_template_slug() : '';
if ( $prime_recovery_slug && locate_template( $prime_recovery_slug ) ) {
	require locate_template( $prime_recovery_slug );
	return;
}

$prime_recovery_options = array(
	'a' => array( 'name' => 'Option A: Clean Clinical', 'text' => 'Bright and airy with top navigation, a NICE1 split hero, quick-link tiles for Shop, Resource Library, Team, Mission and Connect, and clear paths for patients and providers.' ),
	'b' => array( 'name' => 'Option B: Recovery Circle', 'text' => 'Left-side navigation and an interactive circle of products with NICE1 at the center. Click any point for details, then full-width info menu bars for the key pages.' ),
	'c' => array( 'name' => 'Option C: Bold Performance', 'text' => 'Dark and athletic. A full-screen “Ditch the ice” NICE1 hero, big product numbers, a three-step how-it-works and a Resource Library preview by body area.' ),
);

define( 'PRIME_RECOVERY_CHOOSER', true );
prime_recovery_document_open();
?>
<main id="main" class="chooser">
	<div class="wrap">
		<?php prime_recovery_logo(); ?>
		<p class="eyebrow">Design review</p>
		<h1>Choose a home page direction</h1>
		<p class="lead">Three home page designs for Prime Recovery. Each one features the NICE1 iceless cold + compression system and links to Shop, Resource Library, Meet the Team, Our Mission and Connect With Us.</p>
		<ul class="chooser__grid">
			<?php foreach ( $prime_recovery_options as $key => $o ) : ?>
				<li>
					<a class="chooser__card" href="<?php echo esc_url( add_query_arg( 'pr_home', $key, home_url( '/' ) ) ); ?>">
						<img src="<?php echo esc_url( prime_recovery_img( 'preview-option-' . $key . '.jpg' ) ); ?>" alt="" width="720" height="540" loading="lazy">
						<span class="chooser__body">
							<strong><?php echo esc_html( $o['name'] ); ?></strong>
							<span><?php echo esc_html( $o['text'] ); ?></span>
							<span class="chooser__cta">View this design <?php echo prime_recovery_icon( 'arrow' ); // phpcs:ignore ?></span>
						</span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</main>
<?php
prime_recovery_document_close();
