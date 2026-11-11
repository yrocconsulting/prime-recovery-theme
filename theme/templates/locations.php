<?php
/**
 * Locations: main office and satellite offices.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$b    = prime_recovery_business();
$map  = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $b['name'] . ', ' . $b['street'] . ', ' . $b['city'] . ', ' . $b['region'] . ' ' . $b['postal'] );
$by_state = array( 'MN' => 'Minnesota', 'WI' => 'Wisconsin' );

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Locations',
	'title'   => 'Recovery support across Minnesota and Wisconsin',
	'lead'    => 'Prime Recovery is based in Corcoran, Minnesota, with offices in Duluth, Brainerd and Rochester, Minnesota, and Madison and Eau Claire, Wisconsin. Our technicians deliver to patients’ homes across both states.',
	'buttons' => array(
		array( 'label' => 'Call ' . $b['phone'], 'url' => 'tel:' . $b['phone_e164'], 'style' => 'primary' ),
		array( 'label' => 'Contact us', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light" aria-labelledby="hq-title">
	<div class="wrap">
		<div class="hq">
			<div>
				<p class="eyebrow">Main office</p>
				<h2 id="hq-title"><?php echo esc_html( $b['name'] . ' ' . $b['city'] ); ?></h2>
				<address class="hq__address"><?php echo esc_html( $b['street'] ); ?><br><?php echo esc_html( $b['city'] . ', ' . $b['region'] . ' ' . $b['postal'] ); ?></address>
				<p>Office: <a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo esc_html( $b['phone'] ); ?></a><br>Fax: <?php echo esc_html( $b['fax'] ); ?></p>
				<a class="btn btn--dark" href="<?php echo esc_url( $map ); ?>" rel="noopener" target="_blank">Get directions</a>
			</div>
			<div class="hq__mark" aria-hidden="true"><?php echo prime_recovery_icon( 'pin' ); // phpcs:ignore ?></div>
		</div>
	</div>
</section>

<section class="p-section p-section--alt" aria-labelledby="offices-title">
	<div class="wrap">
		<p class="eyebrow">Satellite offices</p>
		<h2 id="offices-title">Closer to home</h2>
		<?php foreach ( $by_state as $code => $state ) : ?>
			<h3 class="state-title"><?php echo esc_html( $state ); ?></h3>
			<ul class="office-grid">
				<?php foreach ( $b['offices'] as $o ) : ?>
					<?php if ( $o['region'] !== $code ) { continue; } ?>
					<li>
						<?php echo prime_recovery_icon( 'pin' ); // phpcs:ignore ?>
						<strong><?php echo esc_html( $o['city'] . ', ' . $o['region'] ); ?></strong>
						<span>Call <a href="tel:<?php echo esc_attr( $b['phone_e164'] ); ?>"><?php echo esc_html( $b['phone'] ); ?></a></span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endforeach; ?>
	</div>
</section>
<?php
prime_recovery_editor_content();
prime_recovery_page_close();
