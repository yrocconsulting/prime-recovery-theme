<?php
/**
 * Contact form: posts to admin-post.php and emails the office with wp_mail().
 * No plugin needed. Spam checks: nonce, hidden honeypot field and a minimum
 * fill time.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Where messages go. Defaults to the WordPress admin email; override with
 * the "prime_recovery_contact_to" filter or by setting this option.
 */
function prime_recovery_contact_recipient() {
	$to = get_option( 'prime_recovery_contact_to' );
	$to = $to ? $to : get_option( 'admin_email' );
	return apply_filters( 'prime_recovery_contact_to', $to );
}

function prime_recovery_contact_topics() {
	return array(
		'meeting'  => 'Set up a meeting',
		'device'   => 'Question about a device or brace',
		'provider' => 'I’m a provider or clinic',
		'other'    => 'Something else',
	);
}

function prime_recovery_contact_handle() {
	$back = wp_get_referer() ? wp_get_referer() : prime_recovery_route_url( 'contact' );
	$back = remove_query_arg( 'sent', $back );

	if ( ! isset( $_POST['pr_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pr_contact_nonce'] ) ), 'pr_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $back ) . '#contact-form' );
		exit;
	}
	// Bots fill the hidden field or submit instantly; pretend it worked.
	$started = isset( $_POST['pr_t'] ) ? (int) $_POST['pr_t'] : 0;
	if ( ! empty( $_POST['pr_website'] ) || ( time() - $started ) < 3 ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#contact-form' );
		exit;
	}

	$topics = prime_recovery_contact_topics();
	$first  = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last   = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email  = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone  = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$key    = isset( $_POST['topic'] ) ? sanitize_key( wp_unslash( $_POST['topic'] ) ) : '';
	$topic  = isset( $topics[ $key ] ) ? $topics[ $key ] : $topics['other'];
	$notes  = isset( $_POST['notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['notes'] ) ) : '';

	if ( '' === $first || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'invalid', $back ) . '#contact-form' );
		exit;
	}

	$name    = trim( $first . ' ' . $last );
	$subject = sprintf( 'Website message: %s from %s', $topic, $name );
	$body    = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nTopic: {$topic}\n\n{$notes}\n\nSent from " . home_url( '/' );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	$sent    = wp_mail( prime_recovery_contact_recipient(), $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'sent', $sent ? '1' : 'error', $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_pr_contact', 'prime_recovery_contact_handle' );
add_action( 'admin_post_pr_contact', 'prime_recovery_contact_handle' );

function prime_recovery_contact_form( $default_topic = '' ) {
	$status = isset( $_GET['sent'] ) ? sanitize_key( wp_unslash( $_GET['sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$phone  = prime_recovery_business()['phone'];
	$topic  = isset( $_GET['topic'] ) ? sanitize_key( wp_unslash( $_GET['topic'] ) ) : $default_topic; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<form class="form" id="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( '1' === $status ) : ?>
			<p class="form__notice form__notice--ok" role="status">Thanks, your message is on its way. Our team will get back to you soon.</p>
		<?php elseif ( 'invalid' === $status ) : ?>
			<p class="form__notice form__notice--err" role="alert">Please add your first name and a valid email address.</p>
		<?php elseif ( 'error' === $status ) : ?>
			<p class="form__notice form__notice--err" role="alert">Sorry, your message didn’t send. Please call us at <?php echo esc_html( $phone ); ?>.</p>
		<?php endif; ?>
		<input type="hidden" name="action" value="pr_contact">
		<input type="hidden" name="pr_t" value="<?php echo esc_attr( time() ); ?>">
		<?php wp_nonce_field( 'pr_contact', 'pr_contact_nonce', false ); ?>
		<div class="form__hp" aria-hidden="true"><label>Website <input type="text" name="pr_website" tabindex="-1" autocomplete="off"></label></div>
		<div class="form__row">
			<p class="form__field"><label for="cf-first">First name <span aria-hidden="true">*</span></label><input id="cf-first" name="first_name" type="text" autocomplete="given-name" required></p>
			<p class="form__field"><label for="cf-last">Last name</label><input id="cf-last" name="last_name" type="text" autocomplete="family-name"></p>
		</div>
		<div class="form__row">
			<p class="form__field"><label for="cf-email">Email <span aria-hidden="true">*</span></label><input id="cf-email" name="email" type="email" autocomplete="email" required></p>
			<p class="form__field"><label for="cf-phone">Phone</label><input id="cf-phone" name="phone" type="tel" autocomplete="tel"></p>
		</div>
		<p class="form__field">
			<label for="cf-topic">How can we help?</label>
			<select id="cf-topic" name="topic">
				<option value="">Choose a topic</option>
				<?php foreach ( prime_recovery_contact_topics() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>"<?php selected( $topic, $key ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p class="form__field"><label for="cf-notes">Message</label><textarea id="cf-notes" name="notes" rows="5"></textarea></p>
		<p class="form__help">Please don’t include medical details here. We’ll follow up by phone or email.</p>
		<button class="btn btn--primary btn--lg" type="submit">Send message</button>
	</form>
	<?php
}
