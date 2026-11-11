<?php
/**
 * NICE1 cold + compression therapy system.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$p      = prime_recovery_products()['nice1'];
$specs  = prime_recovery_nice_specs();
$videos = prime_recovery_nice_videos();
$faqs   = prime_recovery_nice_faqs();
$quotes = prime_recovery_testimonials();
$url    = $p['url'];

$node                = prime_recovery_product_node( $p );
$node['description'] = 'NICE1 is an iceless cold + compression therapy system with programmable intermittent and constant compression, in an 8 x 8 x 8 inch, 9 lb unit with a touch screen.';
$node['image']       = array( prime_recovery_img( 'nice1-thigh-wrap.jpg' ), prime_recovery_img( 'nice1-knee-seated.jpg' ), prime_recovery_img( 'nice1-overhead.jpg' ) );
$node['additionalProperty'] = array();
foreach ( $specs as $name => $value ) {
	$node['additionalProperty'][] = array( '@type' => 'PropertyValue', 'name' => $name, 'value' => $value );
}
$node['subjectOf'] = array();
foreach ( prime_recovery_video_schema( $videos, 'NICE1' ) as $v ) {
	$node['subjectOf'][] = $v;
}
$node['review'] = array();
foreach ( $quotes as $q ) {
	$node['review'][] = array(
		'@type'      => 'Review',
		'reviewBody' => $q['quote'],
		'author'     => array( '@type' => 'Person', 'name' => $q['author'] ),
	);
}
prime_recovery_add_schema( $node );
prime_recovery_add_schema( prime_recovery_faq_schema( $faqs, $url . '#faq' ) );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Cold + compression therapy system',
	'title'   => 'NICE1: cold + compression without the ice',
	'lead'    => 'NICE1 delivers precise cold therapy without ice, plus programmable compression proven to reduce swelling and speed recovery, in a small, 9 lb unit with an easy touch screen.',
	'buttons' => array(
		array( 'label' => 'Watch how-to videos', 'url' => '#videos', 'style' => 'primary' ),
		array( 'label' => 'Ask about NICE1', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'ghost-light' ),
	),
	'image'   => 'nice1-knee-seated.jpg',
	'alt'     => 'Patient seated with the NICE1 cold and compression wrap on the knee',
) );
?>
<section class="p-section p-section--tight" aria-label="NICE1 at a glance">
	<div class="wrap">
		<ul class="c-stats__grid">
			<li><strong>8<small>×</small>8<small>×</small>8</strong><span>Inches. The smallest cold + compression unit on the market.</span></li>
			<li><strong>9<small>lbs</small></strong><span>Light enough to move from room to room.</span></li>
			<li><strong>0</strong><span>Bags of ice to buy, store or refill.</span></li>
		</ul>
	</div>
</section>

<section class="p-section p-section--light" aria-labelledby="features-title">
	<div class="wrap">
		<p class="eyebrow">Product features</p>
		<h2 id="features-title">Two proven therapies in one simple device</h2>
		<ul class="feat-grid">
			<?php foreach ( prime_recovery_nice_features() as $f ) : ?>
				<li class="feat">
					<span class="feat__icon"><?php echo prime_recovery_icon( $f['icon'] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $f['title'] ); ?></h3>
					<p><?php echo esc_html( $f['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="p-section p-section--alt" aria-labelledby="specs-title">
	<div class="wrap split split--media">
		<img class="split__img" src="<?php echo esc_url( prime_recovery_img( 'nice1-thigh-wrap.jpg' ) ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" width="675" height="675" loading="lazy">
		<div>
			<p class="eyebrow">Specifications</p>
			<h2 id="specs-title">NICE1 at a glance</h2>
			<table class="spec-table">
				<tbody>
					<?php foreach ( $specs as $name => $value ) : ?>
						<tr><th scope="row"><?php echo esc_html( $name ); ?></th><td><?php echo esc_html( $value ); ?></td></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<section class="c-voices" aria-labelledby="voices-title">
	<div class="wrap">
		<p class="eyebrow">What patients say</p>
		<h2 id="voices-title">No more ice runs</h2>
		<div class="c-voices__grid">
			<?php foreach ( $quotes as $q ) : ?>
				<figure class="quote c-voice">
					<blockquote>“<?php echo esc_html( $q['quote'] ); ?>”</blockquote>
					<figcaption><strong><?php echo esc_html( $q['author'] ); ?></strong> · <?php echo esc_html( $q['role'] ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="p-section p-section--light" id="videos" aria-labelledby="videos-title">
	<div class="wrap">
		<div class="c-head">
			<div>
				<p class="eyebrow">How-to videos</p>
				<h2 id="videos-title">Set up, wrap, clean and pack NICE1</h2>
			</div>
			<a class="btn btn--dark" href="<?php echo esc_url( prime_recovery_route_url( 'resources' ) ); ?>">More in the Resource Library</a>
		</div>
		<?php prime_recovery_video_grid( $videos, 'NICE1' ); ?>
	</div>
</section>

<?php
prime_recovery_editor_content();
prime_recovery_faq_section( 'NICE1 questions', $faqs );
prime_recovery_page_close();
