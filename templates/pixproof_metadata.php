<?php
/**
 * Template used to display the pixproof gallery
 * Available vars:
 * string       $client_name
 * string       $event_date
 * int          $number_of_images
 */
?>
	<div id="pixproof_data" class="pixproof-data  push--bottom">
		<div class="row">
			<?php if ( ! empty( $client_name ) ) { ?>
				<div class="col-12  hand-col-3">
					<div class="entry__meta-box">
						<span class="meta-box__box-title"><?php esc_html_e( 'Client', 'lens' ); ?></span>
						<span class="meta-box__box-content"><?php echo $client_name; ?></span>
					</div>
				</div>
			<?php
			}
			if ( ! empty( $event_date ) ) {
				?>
				<div class="col-12  hand-col-3">
					<div class="entry__meta-box">
						<span class="meta-box__box-title"><?php esc_html_e( 'Event date', 'lens' ); ?></span>
						<span class="meta-box__box-content"><?php echo $event_date; ?></span>
					</div>
				</div>
			<?php
			}
			if ( ! empty( $number_of_images ) ) {
				?>
				<div class="col-12  hand-col-3">
					<div class="entry__meta-box">
						<span class="meta-box__box-title"><?php esc_html_e( 'Images', 'lens' ); ?></span>
						<span class="meta-box__box-content"><?php echo $number_of_images; ?></span>
					</div>
				</div>
			<?php
			}

			if ( ! empty( $file ) ) { ?>
				<div class="col-12  hand-col-3">
					<div class="entry__meta-box">
						<button class="button-download  js-download  btn  btn--medium  btn--secondary" onclick="window.open('<?php echo $file; ?>')"><?php esc_html_e( 'Download', 'lens' ); ?></button>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<hr class="separator  separator--striped  separator--data"/>

<?php
