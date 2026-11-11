<?php
/**
 * Resource Library: injury topics, recovery guides and how-to videos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$topics  = prime_recovery_topics();
$videos  = prime_recovery_nice_videos();
$by_name = array();
foreach ( $videos as $v ) {
	$by_name[ $v['title'] ] = $v;
}
$guides  = prime_recovery_guides();
$bracing = prime_recovery_products()['bracing']['url'];

foreach ( prime_recovery_video_schema( $videos, 'NICE1' ) as $node ) {
	prime_recovery_add_schema( $node );
}

prime_recovery_page_open();
prime_recovery_page_hero( array(
	'eyebrow' => 'Resource Library',
	'title'   => 'Know your injury. Plan your recovery.',
	'lead'    => 'How-to videos, recovery guides and injury information for patients and families, organized by body area. Questions about your device or brace? Our team is a phone call away.',
	'buttons' => array(
		array( 'label' => 'Browse by body area', 'url' => '#topics', 'style' => 'primary' ),
		array( 'label' => 'How-to videos', 'url' => '#videos', 'style' => 'ghost-light' ),
	),
) );
?>
<section class="p-section p-section--light" id="topics" aria-labelledby="topics-title">
	<div class="wrap">
		<p class="eyebrow">By body area</p>
		<h2 id="topics-title">Find help for your recovery</h2>
		<ul class="topic-grid">
			<?php $i = 0; foreach ( $topics as $slug => $t ) : ?>
				<?php $topic_guides = $guides ? prime_recovery_guides( $slug ) : array(); ?>
				<li class="topic" id="<?php echo esc_attr( $slug ); ?>">
					<span class="topic__num"><?php echo esc_html( sprintf( '%02d', ++$i ) ); ?></span>
					<h3><?php echo esc_html( $t['title'] ); ?></h3>
					<p><?php echo esc_html( $t['text'] ); ?></p>
					<ul class="topic__links">
						<?php foreach ( $topic_guides as $g ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $g ) ); ?>"><?php echo prime_recovery_icon( 'book' ); // phpcs:ignore ?> <?php echo esc_html( get_the_title( $g ) ); ?></a></li>
						<?php endforeach; ?>
						<?php foreach ( $t['videos'] as $name ) : ?>
							<?php if ( isset( $by_name[ $name ] ) ) : ?>
								<li><a href="#video-<?php echo esc_attr( $by_name[ $name ]['id'] ); ?>"><?php echo prime_recovery_icon( 'snow' ); // phpcs:ignore ?> NICE1 <?php echo esc_html( strtolower( $name ) ); ?> video</a></li>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php if ( $t['bracing'] ) : ?>
							<li><a href="<?php echo esc_url( $bracing ); ?>"><?php echo prime_recovery_icon( 'brace' ); // phpcs:ignore ?> DonJoy <?php echo esc_html( strtolower( $t['title'] ) ); ?> bracing</a></li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php if ( $guides ) : ?>
<section class="p-section p-section--alt" id="guides" aria-labelledby="guides-title">
	<div class="wrap">
		<p class="eyebrow">Recovery guides</p>
		<h2 id="guides-title">Read before and after surgery</h2>
		<ul class="p-cards">
			<?php foreach ( $guides as $g ) : ?>
				<li><a class="p-card" href="<?php echo esc_url( get_permalink( $g ) ); ?>"><?php echo prime_recovery_icon( 'book' ); // phpcs:ignore ?><strong><?php echo esc_html( get_the_title( $g ) ); ?></strong><span><?php echo esc_html( wp_trim_words( get_the_excerpt( $g ), 20 ) ); ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<section class="p-section p-section--light<?php echo $guides ? '' : ' p-section--flush'; ?>" id="videos" aria-labelledby="videos-title">
	<div class="wrap">
		<div class="c-head">
			<div>
				<p class="eyebrow">How-to videos</p>
				<h2 id="videos-title">NICE1 cold + compression</h2>
			</div>
			<a class="btn btn--dark" href="<?php echo esc_url( prime_recovery_products()['nice1']['url'] ); ?>">About NICE1</a>
		</div>
		<?php prime_recovery_video_grid( $videos, 'NICE1' ); ?>
	</div>
</section>

<?php
prime_recovery_editor_content();
prime_recovery_faq_section( 'Recovery questions', array_merge( array_slice( prime_recovery_faqs(), 2, 1 ), array_slice( prime_recovery_nice_faqs(), 1, 2 ) ) );
prime_recovery_page_close();
