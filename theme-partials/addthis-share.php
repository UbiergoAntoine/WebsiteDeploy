<?php
/*
* Get the comma delimited string from Theme Options and generate the a tags that are needed to make AddThis sharing work
*
* @package Lens
* @since   Lens 2.3.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$share_buttons_types = pixelgrade_option( 'share_buttons_settings' );

if ( ! empty( $share_buttons_types ) || $share_buttons_types !== 'false' ) :
	//lets go through each button type and create the needed markup
	//but first some cleaning - remove all whitespaces
	$share_buttons_types = preg_replace( '/\s+/', '', $share_buttons_types );
	//now take each setting
	$buttons = explode( ',', $share_buttons_types );
	//the preferred buttons need to have numbering appended to them
	$preferred_count     = 0; ?>

	<div class="social-links  share-box">
		<span class="social-links__message"><?php esc_html_e( 'Share: ', 'lens' ); ?></span>

		<div class="addthis_toolbox addthis_default_style addthis_32x32_style social-links-list  social-links__list"
		     addthis:url="<?php echo esc_attr( lens_get_current_canonical_url() ) ?>"
		     addthis:title="<?php wp_title('|', true, 'right') ?>"
		     addthis:description="<?php echo esc_attr( trim(strip_tags(get_the_excerpt())) ) ?>">
			<?php if ( ! empty( $buttons ) ) {
				for ( $k = 0; $k < count( $buttons ); $k ++ ) {
					$button_markup = '';
					switch ( $buttons[ $k ] ) {
						case 'preferred':
							$preferred_count ++;
							$button_markup = '<a class="addthis_button_' . $buttons[ $k ] . '_' . $preferred_count . '"></a>' . PHP_EOL;
							break;
						case 'more':
							$button_markup = '<a class="addthis_button_compact"></a>' . PHP_EOL;
							break;
						case 'counter':
							$button_markup = '<a class="addthis_counter addthis_bubble_style"></a>' . PHP_EOL;
							break;
						default :
							$button_markup = '<a class="addthis_button_' . $buttons[ $k ] . '"></a>' . PHP_EOL;
					}

					echo $button_markup;
				}
			} ?>

		</div>
		<!-- .addthis_toolbox -->
	</div><!-- .share-box -->
<?php endif;
