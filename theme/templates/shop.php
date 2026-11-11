<?php
/**
 * Shop: product catalog with order requests (no cart or online payments).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items   = prime_recovery_shop_items();
$cats    = array( 'all' => 'All products', 'cold' => 'Cold + compression', 'bracing' => 'DonJoy bracing' );
$contact = prime_recovery_route_url( 'contact' );
$b       = prime_recovery_business();

$list = array();
foreach ( $items as $i => $item ) {
	$list[] = array(
		'@type'    => 'ListItem',
		'position' => $i + 1,
		'item'     => array(
			'@type'       => 'Product',
			'name'        => $item['name'],
			'description' => $item['text'],
			'brand'       => array( '@type' => 'Brand', 'name' => $item['brand'] ),
			'url'         => $item['url'],
		) + ( $item['image'] ? array( 'image' => prime_recovery_img( $item['image'] ) ) : array() ),
	);
}
prime_recovery_add_schema( array( '@type' => 'ItemList', '@id' => prime_recovery_route_url( 'shop' ) . '#catalog', 'name' => 'Prime Recovery product catalog', 'itemListElement' => $list ) );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Shop',
	'title'   => 'Recovery products, delivered',
	'lead'    => 'Browse our DonJoy bracing and NICE1 cold + compression products. Request what you need and our team will confirm the details with you and your provider, then deliver and fit it at home.',
	'buttons' => array(
		array( 'label' => 'Call ' . $b['phone'], 'url' => 'tel:' . $b['phone_e164'], 'style' => 'primary' ),
		array( 'label' => 'How ordering works', 'url' => '#how', 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light" aria-labelledby="catalog-title">
	<div class="wrap">
		<div class="c-head">
			<h2 id="catalog-title">Products</h2>
			<div class="chips" role="group" aria-label="Filter products">
				<?php foreach ( $cats as $key => $label ) : ?>
					<button type="button" class="chip" data-filter="<?php echo esc_attr( $key ); ?>" aria-pressed="<?php echo 'all' === $key ? 'true' : 'false'; ?>"><?php echo esc_html( $label ); ?></button>
				<?php endforeach; ?>
			</div>
		</div>
		<ul class="shop-grid" data-filter-list>
			<?php foreach ( $items as $item ) : ?>
				<li class="shop-item" data-cat="<?php echo esc_attr( $item['cat'] ); ?>">
					<div class="shop-item__media">
						<?php if ( $item['image'] ) : ?>
							<img src="<?php echo esc_url( prime_recovery_img( $item['image'] ) ); ?>" alt="" width="675" height="675" loading="lazy">
						<?php else : ?>
							<span class="shop-item__placeholder" aria-hidden="true"><?php echo prime_recovery_icon( 'bracing' === $item['cat'] ? 'brace' : 'snow' ); // phpcs:ignore ?></span>
						<?php endif; ?>
					</div>
					<div class="shop-item__body">
						<p class="shop-item__brand"><?php echo esc_html( $item['brand'] ); ?></p>
						<h3><?php echo esc_html( $item['name'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>
						<div class="shop-item__actions">
							<a class="btn btn--primary" href="<?php echo esc_url( add_query_arg( array( 'topic' => 'order', 'item' => $item['name'] ), $contact ) . '#contact-form' ); ?>">Request <span class="screen-reader-text"><?php echo esc_html( $item['name'] ); ?></span></a>
							<a class="shop-item__more" href="<?php echo esc_url( $item['url'] ); ?>">Details<span class="screen-reader-text"> about <?php echo esc_html( $item['name'] ); ?></span></a>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="p-section p-section--alt" id="how" aria-labelledby="how-title">
	<div class="wrap">
		<p class="eyebrow">How ordering works</p>
		<h2 id="how-title">From request to recovery at home</h2>
		<?php prime_recovery_how_steps(); ?>
	</div>
</section>
<?php
prime_recovery_editor_content();
prime_recovery_page_close();
