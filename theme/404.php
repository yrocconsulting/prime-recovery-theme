<?php
/**
 * Not found.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$links = prime_recovery_links();

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Page not found',
	'title'   => 'We couldn’t find that page.',
	'lead'    => 'The page may have moved when we rebuilt our site. These are the places most people are looking for.',
	'buttons' => array(
		array( 'label' => 'Back to home', 'url' => home_url( '/' ), 'style' => 'primary' ),
		array( 'label' => 'Contact us', 'url' => $links['connect']['url'], 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light">
	<div class="wrap">
		<ul class="p-cards">
			<li><a class="p-card" href="<?php echo esc_url( prime_recovery_route_url( 'products' ) ); ?>"><?php echo prime_recovery_icon( 'brace' ); // phpcs:ignore ?><strong>Products</strong><span>DonJoy bracing, NICE1 and more.</span></a></li>
			<?php foreach ( array( 'resources', 'team', 'about', 'connect' ) as $key ) : ?>
				<li><a class="p-card" href="<?php echo esc_url( $links[ $key ]['url'] ); ?>"><?php echo prime_recovery_icon( $links[ $key ]['icon'] ); // phpcs:ignore ?><strong><?php echo esc_html( $links[ $key ]['label'] ); ?></strong><span><?php echo esc_html( $links[ $key ]['blurb'] ); ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php
prime_recovery_page_close();
