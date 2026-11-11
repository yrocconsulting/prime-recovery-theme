<?php
/**
 * Meet the Team.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$team       = prime_recovery_team();
$leadership = array_intersect_key( $team, array_flip( array( 'chad', 'jared', 'braydon', 'mike' ) ) );
$care       = array_intersect_key( $team, array_flip( array( 'paul', 'sam', 'ashley', 'martha' ) ) );

foreach ( $team as $key => $person ) {
	prime_recovery_add_schema( prime_recovery_person_schema( $key, $person ) );
}

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Our knowledgeable staff',
	'title'   => 'Meet the team',
	'lead'    => 'Injury at work, in sports or in daily life can mean lingering pain or even surgery. Our team brings convenient, proven recovery products to your home, then fits them, explains them and stays with you while you heal.',
	'buttons' => array(
		array( 'label' => 'Contact the team', 'url' => prime_recovery_route_url( 'contact' ), 'style' => 'primary' ),
		array( 'label' => 'Our products', 'url' => prime_recovery_route_url( 'products' ), 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light" aria-labelledby="leaders-title">
	<div class="wrap">
		<p class="eyebrow">Leadership</p>
		<h2 id="leaders-title">Decades of orthopedic and bracing experience</h2>
		<div class="people">
			<?php foreach ( $leadership as $key => $person ) : ?>
				<div id="<?php echo esc_attr( $key ); ?>"><?php prime_recovery_person_card( $person ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="p-section p-section--alt" aria-labelledby="care-title">
	<div class="wrap">
		<p class="eyebrow">Home recovery patient care</p>
		<h2 id="care-title">The people who bring recovery home</h2>
		<p class="lead">Our patient care team delivers every device, makes sure it fits and shows you exactly how it works, from the Twin Cities to Northern and Southern Minnesota.</p>
		<div class="people">
			<?php foreach ( $care as $key => $person ) : ?>
				<div id="<?php echo esc_attr( $key ); ?>"><?php prime_recovery_person_card( $person ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="c-team" aria-labelledby="mission-title">
	<div class="c-team__media" aria-hidden="true">
		<img src="<?php echo esc_url( prime_recovery_img( 'care-at-home.jpg' ) ); ?>" alt="" width="1400" height="933" loading="lazy">
	</div>
	<div class="wrap c-team__inner">
		<div class="c-team__card">
			<p class="eyebrow">Our mission</p>
			<h2 id="mission-title">Get back to the life you love.</h2>
			<p>We partner with medical professionals to give patients the gold standard of care during recovery, with 30+ years of healthcare experience behind every delivery.</p>
			<a class="btn btn--primary" href="<?php echo esc_url( prime_recovery_route_url( 'about' ) ); ?>">Read our mission</a>
		</div>
	</div>
</section>
<?php
prime_recovery_editor_content();
prime_recovery_page_close();
