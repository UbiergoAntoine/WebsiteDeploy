<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpgrade_private_post; ?>
<div id="main" class="content djax-updatable">
	<div class="page-content">
		<div class="page-main">
			<header class="entry__header">
				<h1 class="entry__title"><?php esc_html__( 'Password ', 'lens' );
					the_title(); ?></h1>
				<div class="bleed--left">
					<hr class="separator separator--dotted grow">
				</div>
			</header>
			<div class="entry__body">
				<form method="post"
				      action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) ?>"
				      class="comment-respond">
					<?php wp_nonce_field( 'password_protection', 'submit_password_nonce' ); ?>
					<input type="hidden" name="submit_password" value="1"/>

					<?php
					if ( $wpgrade_private_post['error'] ) {
						echo $wpgrade_private_post['error'];
						echo '<p>' . esc_html__( 'Please enter your password again:', 'lens' ) . '</p>';
					} else {
						echo '<p>' . esc_html__( 'To view it please enter your password below:', 'lens' ) . '</p>';
					} ?>

					<div class="row">
						<div class="col-12 hand-col-6">
							<input type="password" required="required" size="20" id="pwbox-531" name="post_password" placeholder="<?php esc_attr_e( 'Password..', 'lens' ); ?>"/></label><br/>
						</div>
						<div class="col-12 hand-col-6">
							<input type="submit" name="Submit" value="<?php esc_attr_e( 'Access', 'lens' ); ?>" class="btn btn--huge post-password-submit"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
