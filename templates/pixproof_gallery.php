<?php
/**
 * Template used to display the pixproof gallery
 *
 * Available vars:
 * string       $ids_string         A string with attachments ids separated by coma
 * array        $gallery_ids        An array with all attachments ids
 * object       $attachments        An object with all the attachments
 * string       $number_of_images   Count attachments
 * string       $columns            Number of columns
 */

?>

<div id="pixproof_gallery"  class="pixproof-lens-gallery  masonry  masonry--gallery js-pixproof-lens-gallery"  data-columns="4">
	<?php
		$idx = 1;
		foreach ( $attachments as $attachment ) {
		if ( 'selected' == self::get_attachment_class($attachment) ) {
			$select_label = esc_html__('Deselect', 'cmb' );
		} else {
			$select_label = esc_html__('Select', 'cmb' );
		}

        $thumb_img = $thumb_img = wp_get_attachment_image_src($attachment->ID, 'blog-medium');
		$image_full = wp_get_attachment_image_src($attachment->ID, 'full-size');

        $thumb_img_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
        if (isset($thumb_img[1]) && isset($thumb_img[2]) && $thumb_img[1] > 0) {
            $thumb_img_ratio = $thumb_img[2] * 100/$thumb_img[1];
        }

		//lets determine what should we display under each image according to settings
		// also what id should we assign to that image so the auto comments linking works
		$image_name = '';
		$image_id_tag = '';
		if (isset($photo_display_name)) {
			switch ($photo_display_name) {
				case 'unique_ids':
					$image_name = '#'.$attachment->ID;
					$image_id_tag = 'item-'.$attachment->ID;
					break;
				case 'consecutive_ids':
					$image_name = '#'.$idx;
					$image_id_tag = 'item-'.$idx;
					break;
				case 'file_name':
					$image_name = '#'.$attachment->post_name;
					$image_id_tag = 'item-'.$attachment->post_name;
					break;
				case 'unique_ids_photo_title':
					$image_name = '#'.$attachment->ID.' '.$attachment->post_title;
					$image_id_tag = 'item-'.$attachment->ID;
					break;
				case 'consecutive_ids_photo_title':
					$image_name = '#'.$idx.' '.$attachment->post_title;
					$image_id_tag = 'item-'.$idx;
					break;
			}
		} else {
			//default to unique ids aka attachment id
			$image_name =  '#'.$attachment->ID;
			$image_id_tag = 'item-'.$attachment->ID;
		}

	?>
		<div class="masonry__item-image  mosaic__item  proof-photo  <?php self::attachment_class($attachment); ?>" itemscope itemtype="http://schema.org/ImageObject" <?php self::attachment_data($attachment); ?>  id="<?php echo $image_id_tag; ?>">
			<div class="background-container">
			<span class="mfp-image image__item-link" data-effect="mfp-zoom-in" itemprop="contentURL">
			    <div class="image__item-wrapper"  style="padding-top: <?php echo $thumb_img_ratio; ?>%;">
			        <img
			            class="js-lazy-load"
			            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
			            data-src="<?php echo $thumb_img[0]; ?>"
			            alt=""
			            />
			    </div>
			    <div class="image__item-meta">
			        <div class="image_item-table">
			            <div class="image_item-cell">
				            <ul class="actions-nav  nav  nav--stacked">
				            	<li class="item--action">
				        			<a class="meta__action  zoom-action" href="<?php echo $image_full[0]; ?>"  data-photoid="<?php echo $image_id_tag; ?>">
					        			<span class="flexbox"><span class="flexbox__item">
					        				<span class="button-text"><?php esc_html_e('Zoom', 'cmb' ); ?></span>
					        			</span></span>
				        			</a>
				            	</li>
				            	<li class="item--separator">
									<div class="flexbox">
										<div class="flexbox__item">
				            				<hr class="separator" />
										</div>
									</div>
								</li>
				            	<li class="item--action">
									<a class="meta__action  select-action" href="#"  data-photoid="<?php echo $image_id_tag; ?>">
										<span class="flexbox"><span class="flexbox__item">
											<span class="button-text"><?php echo $select_label; ?></span>
										</span></span>
									</a>
				            	</li>
				            </ul>
			            </div>
			        </div>
			    </div>
			</span>
			<div class="proof-photo__status">
				<span class="ticker">&check;</span>
				<span class="spinner"></span>
			</div>
			<span class="proof-photo__id"><?php echo $image_name; ?></span>
			</div>  	
		</div>
		<?php if ($columns == 1) echo '<br style="clear: both">'; ?>
	<?php
		$idx++;
	} ?>
</div>
<hr class="separator  separator--dotted  separator--data" />
