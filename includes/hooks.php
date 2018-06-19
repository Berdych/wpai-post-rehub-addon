<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (is_plugin_active('wp-all-import/plugin.php')){
	
	if(!function_exists('rhwpai_woo_admin_script')){
		function rhwpai_wp_admin_style() {
			//wp_enqueue_style( 'rhwpai_admin_css', RH_WPAI_URI . 'static/css/admin.css', RH_WPAI_VERSION );
			wp_enqueue_script('rhwpai_admin-script', RH_WPAI_URI . '/static/js/admin.js', array('jquery'), RH_WPAI_VERSION );
		}
	}

	function rhwpai_images_section_enabled( $bool, $post_type ){
		if( $post_type == 'post' )
			return false;
		return true;
	}

	add_action( 'admin_enqueue_scripts', 'rhwpai_wp_admin_style' );
	add_filter( 'wp_all_import_is_images_section_enabled', 'rhwpai_images_section_enabled', 10, 2 );
}

?>