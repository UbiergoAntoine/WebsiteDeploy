<?php

function wpgrade_callback_enqueue_rtl_support() {
	wp_style_add_data( 'wpgrade-main-style', 'rtl', 'replace' );
}