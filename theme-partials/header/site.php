<?php
/**
 * The template for the site header.
 *
 * @package Lens
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="header" data-smoothscrolling>
    <header class="site-header">
        <div class="site-header__branding">
            <?php
            $main_logo = wpgrade::image_src( 'main_logo' );
            if ( ! empty( $main_logo ) ): ?>
                <div class="site-logo site-logo--image">
                    <a class="site-home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo('name') ) ?>">
                        <img src="<?php echo esc_url( $main_logo ); ?>" rel="logo" alt="<?php echo esc_attr( get_bloginfo('name') ) ?>"/>
                    </a>
                </div>
            <?php else: ?>
                <div class="site-logo site-logo--text">
                    <a class="site-home-link" href="<?php echo esc_url( home_url( '/' ) ) ?>">
                        <span><?php echo get_bloginfo('name') ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <!-- <span class="site-navigation__trigger js-nav-trigger"><i class="icon-reorder"></i><i class="icon-remove"></i></span> -->
        <div class="site-navigation__trigger js-nav-trigger"><span class="nav-icon"></span></div>
        <div class="header__inner-wrap">
            <div id="navigation" class="djax-updatable">
                <?php
                wpgrade_main_nav();
                ?>
            </div>
        </div>
    </header>
    <?php
    //because the sidebar gets loaded before in the mobile navigation
    //we need to call it differently because get_sidebar will NOT load it again
    lens::get_sidebar('header', false); ?>
    <footer id="colophon" class="site-footer" role="contentinfo">
        <?php wpgrade_social_nav(); ?>

        <div class="site-info text--right">
	        <?php echo pixelgrade_footer_get_copyright_content(); ?>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- .header -->
