<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//determine what page we are on, if any
$paged = 1;
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
}
if ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
}

if ( pixelgrade_option( 'galleries_enable_pagination' ) && pixelgrade_option( 'galleries_per_page' ) ) {
	$projects_number = pixelgrade_option( 'galleries_per_page' );
} else {
	$projects_number = - 1;
}

if ( is_front_page() ) {
	$projects_number_meta = get_post_meta( lens::lang_page_id( get_the_ID() ), wpgrade::prefix() . 'homepage_projects_number', true );
	if ( ! empty( $projects_number_meta ) && is_numeric( $projects_number_meta ) ) {
		$projects_number = $projects_number_meta;
	} else {
		$projects_number = - 1;
	}
}

$args = array(
	'post_type'      => 'lens_gallery',
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
//	'order' => 'DESC',
	'paged'          => $paged,
	'posts_per_page' => $projects_number,
	'meta_query'     => array(
		'relation' => 'OR',
		array(
			'key'     => wpgrade::prefix() . 'exclude_gallery',
			'value'   => true,
			'compare' => '!=',
		),
		array(
			'key'     => wpgrade::prefix() . 'exclude_gallery',
			'compare' => 'NOT EXISTS',
			'value'   => '',
		),
	),
);

$query = new WP_Query( $args );

//infinite scrolling
$mosaic_classes = '';
$classes        = '';
if ( pixelgrade_option( 'galleries_infinitescroll' ) ) {
	$mosaic_classes .= ' infinite_scroll';
	$classes        .= ' inf_scroll';

//	if (pixelgrade_option('galleries_infinitescroll_show_button')) {
//		$mosaic_classes .= ' infinite_scroll_with_button';
//	}
}

?>
<div id="main" class="content djax-updatable <?php echo esc_attr( $classes ); ?>">
	<?php
	if ( pixelgrade_option( 'galleries_archive_filtering' ) ) {
		lens::display_filter_box( 'lens_gallery_categories' );
	} ?>
	<div class="mosaic <?php echo $mosaic_classes ?>" data-maxpages="<?php echo $query->max_num_pages ?>">
		<?php
		$thumb_orientation = '';
		if ( pixelgrade_option( 'galleries_thumb_orientation' ) == 'portrait' ) {
			$thumb_orientation = ' mosaic__item--portrait ';
		}

		// let's grab the page title first
		$title = get_the_title();

		$has_post_thumbnail = has_post_thumbnail();
		if ( $has_post_thumbnail ) {
			$post_featured_image_id = get_post_thumbnail_id( $post->ID );
			if ( $thumb_orientation ) {
				$post_featured_image = wp_get_attachment_image_src( $post_featured_image_id, 'portfolio-big-v', true );
			} else {
				$post_featured_image = wp_get_attachment_image_src( $post_featured_image_id, 'portfolio-big', true );
			}
			$post_featured_image = $post_featured_image[0];
		} ?>
		<?php if ( pixelgrade_option( 'galleries_show_archive_title' ) && $paged == 1 ): ?>
			<div class="mosaic__item  mosaic__item--page-title-mobile <?php echo $thumb_orientation;
			echo $has_post_thumbnail ? "" : " js--is-loaded ";
			echo lens::get_terms_as_string( 'lens_gallery_categories', 'slug' ); ?> ">
				<div class="image__item-link">
					<div class="image__item-wrapper">
						<?php if ( $has_post_thumbnail ) : ?>
							<img
									class="js-lazy-load"
									src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
									data-src="<?php echo esc_url( $post_featured_image ); ?>"
									alt="<?php echo esc_attr( lens::get_img_alt( $post_featured_image_id ) ) ?>"
							/>
						<?php endif; ?>
					</div>
					<div class="image__item-meta">
						<div class="image_item-table">
							<div class="image_item-cell">
								<h1><?php echo $title; ?></h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $query->have_posts() ) :

			$idx = 0;
			while ( $query->have_posts() ) : $query->the_post();
				$idx ++;
				$gallery_ids = array();
				$gallery_ids = get_post_meta( $post->ID, wpgrade::prefix() . 'main_gallery', true );
				if ( ! empty( $gallery_ids ) ) {
					$gallery_ids = explode( ',', $gallery_ids );
				}

				$attachments = get_posts( array(
					'post_type'      => 'attachment',
					'posts_per_page' => - 1,
					'orderby'        => "post__in",
					'post__in'       => $gallery_ids,
				) );

				$featured_image   = "";
				$feature_image_id = null;

				if ( has_post_thumbnail() ) {
					$feature_image_id = get_post_thumbnail_id( $post->ID );
					if ( $thumb_orientation ) {
						$featured_image = wp_get_attachment_image_src( $feature_image_id, 'portfolio-big-v' );
					} else {
						$featured_image = wp_get_attachment_image_src( $feature_image_id, 'portfolio-big' );
					}
					$featured_image = $featured_image[0];
				} else {
					if ( $gallery_ids != "" ) {
						$attachments = get_posts( array(
							'post_type'      => 'attachment',
							'posts_per_page' => - 1,
							'orderby'        => "post__in",
							'post__in'       => $gallery_ids,
						) );
					} else {
						$attachments = get_posts( array(
							'post_type'      => 'attachment',
							'posts_per_page' => - 1,
							'post_status'    => 'any',
							'post_parent'    => $post->ID,
						) );
					}

					if ( $attachments ) {
						foreach ( $attachments as $attachment ) {
							if ( $thumb_orientation ) {
								$featured_image = wp_get_attachment_image_src( $attachment->ID, 'portfolio-big-v' );
							} else {
								$featured_image = wp_get_attachment_image_src( $attachment->ID, 'portfolio-big' );
							}
							$featured_image   = $featured_image[0];
							$feature_image_id = $attachment->ID;
							break;
						}
					}
				}

				$categories = get_the_terms( $post->ID, 'lens_gallery_categories' ); ?>
				<div class="mosaic__item <?php echo esc_attr( $thumb_orientation ) . ' ';
				if ( $categories ) {
					foreach ( $categories as $cat ) {
						echo esc_attr( strtolower( $cat->slug ) ) . ' ';
					}
				} ?> ">
					<a href="<?php the_permalink(); ?>" class="image__item-link">
						<div class="image__item-wrapper">
							<?php if ( $featured_image != "" ): ?>
								<img
										class="js-lazy-load"
										src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
										data-src="<?php echo $featured_image; ?>"
										alt="<?php echo lens::get_img_alt( $feature_image_id ) ?>"
								/>
							<?php else: ?>
								<img
										class="js-lazy-load"
										src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
										data-src="<?php
										if ( $thumb_orientation ) {
											echo get_template_directory_uri() . '/assets/img/camera-v.png';
										} else {
											echo get_template_directory_uri() . '/assets/img/camera.png';
										}
										?>"
										alt=""
								/>
							<?php endif ?>
						</div>
						<div class="image__item-meta image_item-meta--portfolio">
							<div class="image_item-table">
								<div class="image_item-cell image_item--block image_item-cell--top">
									<h3 class="image_item-title"><?php the_title(); ?></h3>
									<span class="image_item-description"><?php echo wpgrade_better_excerpt(); ?></span>
								</div>
								<div class="image_item-cell image_item--block image_item-cell--bottom">
									<div class="image_item-meta">
										<ul class="image_item-categories">
											<?php $categories = get_the_terms( $post->ID, 'lens_gallery_categories' );
											if ( $categories ): ?>
												<li class="image_item-cat-icon"><i class="icon-folder-open"></i></li>
												<?php
												$categories_index = 1;
												foreach ( $categories as $cat ):
													if ( $categories_index < 3 ) :
														?>
														<li class="image_item-category"><?php echo $cat->name; ?></li>
													<?php
													else : break;
													endif;
													$categories_index ++;
												endforeach;
											endif; ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				<?php
				// if we added 3 it's now time to add the page title box
				if ( $idx == 3 && pixelgrade_option( 'galleries_show_archive_title' ) && $paged == 1 ) : ?>
					<div class="mosaic__item  mosaic__item--page-title <?php echo $thumb_orientation;
					echo $has_post_thumbnail ? "" : " js--is-loaded ";
					echo lens::get_terms_as_string( 'lens_gallery_categories', 'slug' ); ?>">
						<div class="image__item-link">
							<div class="image__item-wrapper">
								<?php if ( $has_post_thumbnail ) : ?>
									<img
											class="js-lazy-load"
											src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
											data-src="<?php echo esc_url( $post_featured_image ); ?>"
											alt="<?php echo esc_attr( lens::get_img_alt( $post_featured_image_id ) ) ?>"
									/>
								<?php endif; ?>
							</div>
							<div class="image__item-meta">
								<div class="image_item-table">
									<div class="image_item-cell">
										<h1><?php echo $title; ?></h1>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif;

			endwhile;

			// if there were less than 3 items, still add the title box
			if ( $idx < 3 && pixelgrade_option( 'galleries_show_archive_title' ) && $paged == 1 ) : ?>
				<div class="mosaic__item  mosaic__item--page-title <?php echo esc_attr( $thumb_orientation );
				echo $has_post_thumbnail ? "" : " js--is-loaded ";
				echo lens::get_terms_as_string( 'lens_gallery_categories', 'slug' ); ?>">
					<div class="image__item-link">
						<div class="image__item-wrapper">
							<?php if ( $has_post_thumbnail ) : ?>
								<img
										class="js-lazy-load"
										src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
										data-src="<?php echo esc_url( $post_featured_image ); ?>"
										alt="<?php echo esc_attr( lens::get_img_alt( $post_featured_image_id ) ) ?>"
								/>
							<?php endif; ?>
						</div>
						<div class="image__item-meta">
							<div class="image_item-table">
								<div class="image_item-cell">
									<h1><?php echo $title; ?></h1>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif;
		endif;
		/* Restore original Post Data */
		wp_reset_postdata(); ?>
	</div><!-- .mosaic -->
	<?php
	$pagination = wpgrade::pagination( $query, 'galleries' );
	if ( ! empty( $pagination ) ) {
		echo '<div class="mosaic__pagination">' . $pagination . '</div>';
	} ?>
</div><!-- .content -->
