<?php

add_action('the_password_form', 'wpgrade_callback_the_password_form');

function wpgrade_callback_the_password_form($form){
	global $post;
	$post = get_post( $post );
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="comment-respond">
	<p>' . esc_html__("This post is password protected. To view it please enter your password below:", 'lens') . '</p>
	<div class="row"><div class="col-6 hand-span-6"><input name="post_password" id="' . $label . '" type="password" size="20" placeholder="' . esc_html__('Password..', 'lens') .'" /></div> <div class="col-6 hand-span-6"><input class="btn btn--huge post-password-submit" type="submit" name="Access" value="' . esc_attr__("Submit", 'lens') . '" /></div></div>
</form>';

	return $output;
}
