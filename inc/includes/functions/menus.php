<?php

/*
 * Register custom menus.
 * This works on 3.1+
 */
function wpgrade_register_custom_menus() {

	add_theme_support( 'menus' );
	$menus = array(
		// main nav in header
		'main_menu'   => esc_html__( 'Header Menu', 'lens' ),
		'social_menu' => esc_html__( 'Social Footer Menu', 'lens' ),
	);

	if ( ! empty( $menus ) ) {
		foreach ( $menus as $key => $value ) {
			register_nav_menu( $key, wpgrade::themename() . ' ' . $value );
		}
	}
}

add_action( "after_setup_theme", "wpgrade_register_custom_menus" );

function wpgrade_main_nav() {
	// test if there are menu locations to prevent errors
	$theme_locations = get_nav_menu_locations();

	if ( isset( $theme_locations["main_menu"] ) && ( $theme_locations["main_menu"] != 0 ) ) {
		$defaults = array
		(
			'theme_location'  => 'main_menu',
			'menu'            => '',
			'container'       => 'nav',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'site-navigation site-navigation--main',
			'menu_id'         => 'wpgrade-main-nav-desktop',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => new WPGrade_Lens_Walker_Nav_Menu()
		);

		$menu = wp_nav_menu( $defaults );
		echo $menu;
	}
}

function wpgrade_main_nav_mobile() {
	// test if there are menu locations to prevent errors
	$theme_locations = get_nav_menu_locations();

	if ( isset( $theme_locations["main_menu"] ) && ( $theme_locations["main_menu"] != 0 ) ) {
		$defaults = array
		(
			'theme_location'  => 'main_menu',
			'menu'            => '',
			'container'       => 'nav',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'site-navigation site-navigation--main site-navigation--mobile',
			'menu_id'         => 'wpgrade-main-nav-mobile',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0
			// 'walker'          => new WPGrade_Lens_Walker_Nav_Menu()
		);

		$menu = wp_nav_menu( $defaults );
		echo $menu;
	}
}

function wpgrade_footer_nav() {
	$theme_locations = get_nav_menu_locations();

	if ( isset( $theme_locations["footer_menu"] ) && ( $theme_locations["footer_menu"] != 0 ) ) {
		$menu = wp_nav_menu
		(
			array
			(
				'theme_location' => 'footer_menu',
				'container'      => 'div',
				'container_id'   => 'menu-main-navigation',
				'depth'          => 1,
				'echo'           => false
			)
		);

		echo $menu;
	}
}

/*
 * Function for displaying The Social Menu
 */
function wpgrade_social_nav() {
	$theme_locations = get_nav_menu_locations();

	if ( isset( $theme_locations["social_menu"] ) && ( $theme_locations["social_menu"] != 0 ) ) {
		$args = array
		(
			'theme_location' => 'social_menu',
			'menu'           => '',
			'container'      => 'div',
			'container_class'   => 'header__social-section',
			'container_id'   => '',
//          'menu_class'      => 'site-navigation site-navigation--footer site-navigation--secondary flush--bottom',
			'menu_class'     => 'social-menu',
			'fallback_cb'    => null,
			'menu_id'        => '',
			'depth'          => 1,
			'items_wrap'     => '<ul id="%1$s" class="%2$s site-social-links">%3$s</ul>',
		);

		echo wp_nav_menu( $args );
	}
}