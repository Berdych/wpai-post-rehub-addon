<?php
/*
Plugin Name: WP All Import - REHub Add-On
Description: Import data to certain REHub Post / Product meta fields.
Version: 2.0
Requires at least:    4.4.0
Tested up to:         4.9.4
WC requires at least: 3.0.0
WC tested up to: 	 3.2.6
Author: WPsoul.com
Author URI: https://wpsoul.com/
Text Domain: wpairehubaddon
Domain Path: /languages/
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* 
 * Constants
 */
define( 'RH_WPAI_ROOT', dirname(__FILE__) ); 
define( 'RH_WPAI_URI', plugin_dir_url( __FILE__ ) ); 
define( 'RH_WPAI_VERSION', '2.0' );

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/* 
 * Import class WPAI
 */
include "rapid-addon.php";

/* 
 * Post Featured image Object
 */
if ( is_plugin_active('wp-all-import/plugin.php') ){
	$rehub_wpai_featured = new RapidAddon( __( "Featured Image", "wpairehubaddon" ), 'rehub_wpai_featured' );
	$rehub_wpai_featured->add_field( 'post_thumbnail', __( "Post thumbnail URL", "wpairehubaddon" ), 'image', null );
	$rehub_wpai_featured->set_import_function( 'rehub_wpai_featured_import' );
	$rehub_wpai_featured->run(	array(
			"themes" => array( "Rehub theme" ),
			"post_types" => array( "post" )
		)
	);
}
/* 
 * Post Layout Object 
 */
$rehub_wpai_post_layout = new RapidAddon( __( "REHub Post Layout", "wpairehubaddon" ), 'rehub_wpai_post_layout' );
$rehub_wpai_postlayout = array( 
	'default' => __( "Simple", "wpairehubaddon" ), 
	'meta_outside' => __( "Title is outside content", "wpairehubaddon" ),
	'meta_center' => __( "Center aligned (Rething style)", "wpairehubaddon" ),
	'default_text_opt' => __( "Full width, optimized for reading", "wpairehubaddon" ),
	'meta_compact' => __( "Compact (Recash style)", "wpairehubaddon" ),
	'meta_compact_dir' => __( "Compact (Redirect style)", "wpairehubaddon" ),
	'corner_offer' => __( "Button in corner (Repick style)", "wpairehubaddon" ),
	'meta_in_image' => __( "Title Inside image", "wpairehubaddon" ),
	'meta_in_imagefull' => __( "Title Inside full image", "wpairehubaddon" ),
	'big_post_offer' => __( "Big post offer block in top", "wpairehubaddon" ),
	'offer_and_review' => __( "Offer and review score", "wpairehubaddon" ),
);
if( is_plugin_active('content-egg/content-egg.php') ){
	$rehub_wpai_postlayoutce = array(
		'meta_ce_compare' => __( "Price comparison CE (compact)", "wpairehubaddon" ),
		'meta_ce_compare_full' => __( "Price comparison CE (full width)", "wpairehubaddon" ),
		'meta_ce_compare_auto_sec' => __( "Auto content CE", "wpairehubaddon" ),
	);
	$rehub_wpai_postlayout = array_merge($rehub_wpai_postlayout, $rehub_wpai_postlayoutce);
}
$rehub_wpai_post_layout->add_field( 'rh_layout_post', __( "Choose one", "wpairehubaddon" ), 'radio', $rehub_wpai_postlayout );
$rehub_wpai_post_layout->set_import_function( 'rehub_wpai_postlayout_import' );
$rehub_wpai_post_layout->run(	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "post" )
	)
);
/* 
 * Product Layout Object
 */
$rehub_wpai_product_layout = new RapidAddon( __( "REHub Product Layout", "wpairehubaddon" ), 'rehub_wpai_product_layout' );
$rehub_wpai_productlayout = array( 
	'global' => __( "Global from Theme option - Shop", "wpairehubaddon" ),
	'default_sidebar' => __( "Default with sidebar", "wpairehubaddon" ), 
	'default_no_sidebar' => __( "Default without sidebar", "wpairehubaddon" ),
	'full_width_extended' => __( "Full width Extended", "wpairehubaddon" ),
	'sections_w_sidebar' => __( "Sections with sidebar", "wpairehubaddon" ),
	'vendor_woo_list' => __( "Compare prices", "wpairehubaddon" ),
	'full_photo_booking' => __( "Full width Photo", "wpairehubaddon" ),
);
if( is_plugin_active('content-egg/content-egg.php') ){
	$rehub_wpai_productlayoutce = array(
		'ce_woo_blocks' => __( "Review with Blocks", "wpairehubaddon" ),
		'ce_woo_list' => __( "Content Egg List", "wpairehubaddon" ),
		'ce_woo_sections' => __( "Content Egg Auto Sections", "wpairehubaddon" ),
	);
	$rehub_wpai_productlayout = array_merge($rehub_wpai_productlayout, $rehub_wpai_productlayoutce);
}
$rehub_wpai_product_layout->add_field( 'rh_woo_product_layout', __( "Choose one", "wpairehubaddon" ), 'radio', $rehub_wpai_productlayout );
$rehub_wpai_product_layout->set_import_function( 'rehub_wpai_productlayout_import' );
$rehub_wpai_product_layout->run(	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "product" )
	)
);
/* 
 * Post Offer Object
 */
$rehub_wpai_offer = new RapidAddon( __( "REHub Post Offer", "wpairehubaddon" ), 'rehub_wpai_offer' );
$rehub_wpai_offer->add_field( 'offer_name', __( "Post Offer Name", "wpairehubaddon" ), 'text' );
$rehub_wpai_offer->add_field( 'offer_product_url', __( "Offer URL", "wpairehubaddon" ), 'text' );
$rehub_wpai_offer->add_field( 'offer_product_desc', __( "Short description", "wpairehubaddon" ), 'textarea' );
$rehub_wpai_offer->add_field( 'offer_product_price', __( "Offer sale price", "wpairehubaddon" ), 'text', null, __( "Insert sale price of offer (example, $55). Please, choose your price pattern in theme options - localizations", "wpairehubaddon" ) );
$rehub_wpai_offer->add_field( 'offer_product_price_old', __( "Offer old price", "wpairehubaddon" ), 'text' );
$rehub_wpai_offer->add_field( 'offer_product_thumb', __( "Product thumbnail URL", "wpairehubaddon" ), 'image', null, __(  "Upload thumbnail of product or leave blank to use post thumbnail", "wpairehubaddon" ) );	
$rehub_wpai_offer->add_field( 'offer_btn_text', __( "Button text", "wpairehubaddon" ), 'text', null, __( "Insert text on button or leave blank to use default text. Use short names (not more than 14 symbols)", "wpairehubaddon" ) );
$rehub_wpai_offer->add_field(
        'store_logo_url',
        __( "Store logo URL", "wpairehubaddon" ), 
        'radio', 
        array(
                'no' => array(
                        __( "Use remote logo URL", "wpairehubaddon" ),
                        $rehub_wpai_offer->add_field( 'store_logo_url_rem', '', 'text')
                ),
                'yes' => array(
                        __( "Download logo from URL", "wpairehubaddon" ),
                        $rehub_wpai_offer->add_field( 'store_logo_url_dl', '', 'image')
                ),
        ),
		__( "WPAI saves images by file name. This means that two different files with different links but the same file name will be saved only as one file. You can enable option to save direct external URLs on logo files in the first case or download file in the second one.", "wpairehubaddon" )
);
$rehub_wpai_offer->add_field( 'store_name', __( "Store name", "wpairehubaddon" ), 'text', null, __( "Assign the same name to Deal store in Taxonomy Tab (if this is available). Add only one deal store to each deal", "wpairehubaddon" ));
$rehub_wpai_offer->add_field( 'rehub_main_product_currency', __( "Offer currency", "wpairehubaddon" ), 'text', null, __( "Currency in ISO 4217. This is only for schema markup. Example: USD or EUR", "wpairehubaddon" ));
$rehub_wpai_offer->set_import_function( 'rehub_wpai_offer_import' );
$rehub_wpai_offer->run(	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "post" )
	)
);

/* 
 * Post Coupon Object 
 */
$rehub_wpai_coupon = new RapidAddon( __( "REHub Post Coupon", "wpairehubaddon" ), 'rehub_wpai_coupon' );
$rehub_wpai_coupon->add_field( 'offer_product_coupon', __( "Offer Coupon Code", "wpairehubaddon" ), 'text' );
$rehub_wpai_coupon->add_field( 'offer_coupon_date', __( "Coupon End Date. Must be in format yyyy-mm-dd", "wpairehubaddon" ), 'text', null, __( "Choose expiration date of coupon or leave blank", "wpairehubaddon" ) );
$rehub_wpai_coupon->add_field( 'gb_date_format', __( "Convert from British format:", "wpairehubaddon" ), 'radio', array( '0' => __( "No", "wpairehubaddon" ), '1' => __( "From dd/mm/yyyy", "wpairehubaddon" ),  '2' => __( "From dd/mm/yy", "wpairehubaddon" ) ) );
$rehub_wpai_coupon->add_field( 'offer_coupon_mask', __( "Mask coupon code?", "wpairehubaddon" ), 'radio', array( '0' => __( "No", "wpairehubaddon" ), '1' => __( "Yes", "wpairehubaddon" ) ), __( "If choose Yes, all coupon codes will be hidden", "wpairehubaddon" ) );
$rehub_wpai_coupon->set_import_function( 'rehub_wpai_coupon_import' );
$rehub_wpai_coupon->run(	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "post" )
	)
);

/* 
 * GMW Location Object
 */
$rehub_wpai_gmw_map = new RapidAddon( __( "REHub Location field for GMW", "wpairehubaddon" ), 'rehub_wpai_gmw_map' );
$rehub_wpai_gmw_map->add_field( 'rehub_gmw_map', __( "Address field", "wpairehubaddon" ), 'text', null, 'Use this field if you need to import adress for GMW plugin. Only text address is allowed, which will be converted to geo coded google map address when this possible' );
$rehub_wpai_gmw_map->set_import_function( 'rehub_wpai_gmwmap_import' );
$rehub_wpai_gmw_map->run(array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "post" )
	)
);

/* 
 * Post Review Object
 */
$review_count = 8; $i = 0; $k = 1;
$rehub_wpai_review = new RapidAddon( __( "REHub Post Review", "wpairehubaddon" ), 'rehub_wpai_review' );
$rehub_wpai_review->add_field( 'makereview', __( "Make post as review format? Choose yes if you want to fill fields below", "wpairehubaddon" ), 'radio', array( '0' => __( "No", "wpairehubaddon" ), '1' => __( "Yes", "wpairehubaddon" ) ) );
$rehub_wpai_review->add_field( 'review_heading', __("Review Heading", "wpairehubaddon"), 'text' );
$rehub_wpai_review->add_field( 'review_summary', __("Summary Text", "wpairehubaddon"), 'textarea' );
$rehub_wpai_review->add_field( 'review_post_pros', __("PROS. Place each from separate line (optional)", 'wpairehubaddon'), 'textarea' );
$rehub_wpai_review->add_field( 'review_post_cons', __("CONS. Place each from separate line (optional)", 'wpairehubaddon'), 'textarea' );
$rehub_wpai_review->add_field( 'review_shortcode', __( "Disable auto review box?", "wpairehubaddon" ), 'radio', array( '0' => __( "No", "wpairehubaddon" ), '1' => __( "Yes", "wpairehubaddon" ) ), __( "If choose Yes, review box will be hidden in post. You can insert it with shortcodes [review] or [wpsm_scorebox]", "wpairehubaddon" ) );
$rehub_wpai_review->add_field( 'review_post_score_manual', __("<b>Set overall score</b>", "wpairehubaddon"), 'text', null, __( "Enter overall score of review (e.g. 5.5) or leave blank to auto calculation based on criterias score", "wpairehubaddon" ) );
$rehub_wpai_review->add_field( 'review_name_'. $i, sprintf(__("Criteria Name %d", "wpairehubaddon"), $k), 'text', null, __("Input name of a criteria or leave blank", "wpairehubaddon") );
$rehub_wpai_review->add_field( 'review_score_'. $i,sprintf(__("Criteria Score %d", "wpairehubaddon"), $k), 'text', null, __("Range between 0 and 10 (with step 0.5)", "wpairehubaddon") );
for( $i = 1; $i < $review_count; $i++ ){
	$k++;
	$rehub_wpai_review->add_field( 'review_name_'. $i, sprintf(__("Criteria Name %d", "wpairehubaddon"), $k), 'text' );
	$rehub_wpai_review->add_field( 'review_score_'. $i, sprintf(__("Criteria Score %d", "wpairehubaddon"), $k), 'text' );
}
$rehub_wpai_review->set_import_function( 'rehub_wpai_review_import' );
$rehub_wpai_review->run(	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "post" )
	)
);

/* 
 * Product Coupon Object
 */
$rehub_woo_coupon = new RapidAddon( __( "REHub Product Coupon", "wpairehubaddon" ), 'rehub_woo_coupon' );
$rehub_woo_coupon->add_field( 'woo_coupon_code', __( "Set coupon code", "wpairehubaddon" ), 'text' );
$rehub_woo_coupon->add_field( 'woo_coupon_date', __( "Coupon End Date. Must be in format yyyy-mm-dd", "wpairehubaddon" ), 'text', null, __( 'Choose expiration date of coupon or leave blank', 'wpairehubaddon' ) );
$rehub_woo_coupon->add_field( 'end_date_format', __( "Convert from British format:", "wpairehubaddon" ), 'radio', array( '0' => __( "No", "wpairehubaddon" ), '1' => __( "From dd/mm/yyyy", "wpairehubaddon" ),  '2' => __( "From dd/mm/yy", "wpairehubaddon" ) ) );
$rehub_woo_coupon->add_field( 'woo_coupon_mask', __( "Mask coupon code?", "wpairehubaddon" ), 'radio', array( '' => __( 'No' ), 'on' => __( 'Yes' ) ), __( "If choose Yes, all coupon codes will be hidden", "wpairehubaddon" ) );
$rehub_woo_coupon->set_import_function( 'rehub_woo_coupon_import' );
$rehub_woo_coupon->run(
	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "product" )
	)
);

/* 
 * Store Taxonomy Product Object
 */
$rehub_store_logo = new RapidAddon( __( "REHub Store Taxonomy", "wpairehubaddon" ), 'rehub_store_logo' );
$rehub_store_logo->add_field(
		'store_logo_url',
		__( "Store logo URL", "wpairehubaddon" ), 
		'radio', 
		array(
			'no' => array(
				__( "Use remote logo URL", "wpairehubaddon" ),
				$rehub_store_logo->add_field( 'store_logo_url_rem', '', 'text')
			),
			'yes' => array(
				__( "Download logo from URL", "wpairehubaddon" ),
				$rehub_store_logo->add_field( 'store_logo_url_dl', '', 'image')
			),
		),
		__( "WPAI saves images by file name. This means that two different files with different links but the same file name will be saved only as one file. You can enable option to save direct external URLs on logo files in the first case or download file in the second one.", "wpairehubaddon" )
);
$rehub_store_logo->add_field( 'store_name', __( "Store name", "wpairehubaddon" ), 'text', null, __( "Assign the same name to Deal store in Taxonomy Tab. Add only one deal store to each deal", "wpairehubaddon" ));
$rehub_store_logo->set_import_function( 'rehub_store_logo_import' );
$rehub_store_logo->run(
	array(
		"themes" => array( "Rehub theme" ),
		"post_types" => array( "product" )
	)
); 

/* 
 * Post Featured image callback function
 */
if ( !function_exists( 'rehub_wpai_featured_import' ) ) {
	function rehub_wpai_featured_import( $post_id, $data, $import_options ) {
		global $rehub_wpai_featured;
		if ( $rehub_wpai_featured->can_update_image( $import_options ) ) {
			$post_thumbnail_id = $data['post_thumbnail']['attachment_id'];
			if (!empty($post_thumbnail_id)){
				$success = set_post_thumbnail($post_id, $post_thumbnail_id);
				if($success){
					$rehub_wpai_featured->log( '- Featured image was added to Post.' );
				}
			}			
		}
	}
}
/* 
 * Post layout callback function
 */
if ( !function_exists( 'rehub_wpai_postlayout_import' ) ) {
	function rehub_wpai_postlayout_import( $post_id, $data, $import_options ) {
		global $rehub_wpai_post_layout;
		if( !empty( $data['rh_layout_post'] ) ) {
			update_post_meta($post_id, '_layout_post', $data['rh_layout_post']);
		}
	}
}
/* 
 * Post layout callback function
 */
if ( !function_exists( 'rehub_wpai_productlayout_import' ) ) {
	function rehub_wpai_productlayout_import( $post_id, $data, $import_options ) {
		global $rehub_wpai_post_layout;
		if( !empty( $data['rh_woo_product_layout'] ) ) {
			update_post_meta($post_id, '_rh_woo_product_layout', $data['rh_woo_product_layout']);
		}
	}
}
/* 
 * Post Offer callback function
 */
if ( !function_exists( 'rehub_wpai_offer_import' ) ) {
	function rehub_wpai_offer_import( $post_id, $data, $import_options ) {
		global $rehub_wpai_offer;
		if ($rehub_wpai_offer->can_update_meta('rehub_offer_name', $import_options)) {
			if (!empty($data['offer_name'])){
				update_post_meta($post_id, 'rehub_offer_name', $data['offer_name']);			
			}		
		}
		if ($rehub_wpai_offer->can_update_meta('rehub_offer_product_url', $import_options)) {
			if (!empty($data['offer_product_url'])){
				update_post_meta($post_id, 'rehub_offer_product_url', esc_url($data['offer_product_url']));		
			}					
		}
		if ($rehub_wpai_offer->can_update_meta('rehub_offer_product_desc', $import_options)) {
			if (!empty($data['offer_product_desc'])){
				update_post_meta($post_id, 'rehub_offer_product_desc', $data['offer_product_desc']);	
			}			
		}
		if ($rehub_wpai_offer->can_update_meta('rehub_offer_product_price', $import_options)) {
			if (!empty($data['offer_product_price'])){
				update_post_meta($post_id, 'rehub_offer_product_price', $data['offer_product_price']);
				if (function_exists('rehub_price_clean')){
					$offer_price_clean = rehub_price_clean($data['offer_product_price']); 
					update_post_meta($post_id, 'rehub_main_product_price', $offer_price_clean); 
				}
			}			
		}
		if ($rehub_wpai_offer->can_update_meta('rehub_offer_product_price_old', $import_options)) {
			if (!empty($data['offer_product_price_old'])){
				update_post_meta($post_id, 'rehub_offer_product_price_old', $data['offer_product_price_old']);
			}			
		}
		if ($rehub_wpai_offer->can_update_meta('rehub_main_product_currency', $import_options)) {
			if (!empty($data['rehub_main_product_currency'])){
				update_post_meta($post_id, 'rehub_main_product_currency', $data['rehub_main_product_currency']);
			}			
		}
		if ( $rehub_wpai_offer->can_update_image( $import_options ) ) {
			$offer_product_thumb = wp_get_attachment_url( $data['offer_product_thumb']['attachment_id'] );
			if (!empty($offer_product_thumb)){
				update_post_meta( $post_id, 'rehub_offer_product_thumb', $offer_product_thumb );
			}			
		}
		if ( $rehub_wpai_offer->can_update_image( $import_options ) ) {
			if( $data['store_logo_url'] == 'yes' ) {
				$store_logo_url = wp_get_attachment_url( $data['store_logo_url_dl']['attachment_id'] );
			} else {
				$store_logo_url = $data['store_logo_url_rem'];
			}
			if (!empty($store_logo_url)){
				if (!empty($data['store_name'])){
					$termobj = get_term_by('name', $data['store_name'], 'dealstore');
					if (!empty($termobj)) {
						$termid = (int) $termobj->term_id;
						if (!empty($termid)) {
							update_term_meta($termid, 'brandimage', esc_url($store_logo_url));
							$rehub_wpai_offer->log( '- Store logo '. $store_logo_url .' was added to : ' . $data['store_name'] .'' );
						}				
					}
				}
				else{
					update_post_meta($post_id, 'rehub_offer_logo_url', esc_url($store_logo_url));
				}
			}
		}
	}
}

/* 
 * Post Coupon callback function
 */
if ( !function_exists( 'rehub_wpai_coupon_import' ) ) {
	function rehub_wpai_coupon_import( $post_id, $data, $import_options ) {
		global $rehub_wpai_coupon;
		if ($rehub_wpai_coupon->can_update_meta('rehub_offer_product_coupon', $import_options)) {
			if (!empty($data['offer_product_coupon'])){
				update_post_meta($post_id, 'rehub_offer_product_coupon', $data['offer_product_coupon']);
			}				
		}
		if ($rehub_wpai_coupon->can_update_meta('rehub_offer_coupon_date', $import_options)) {
			$new_offer_coupon_date = rh_change_date_format( $data['offer_coupon_date'], $data['gb_date_format'] );
			if (!empty($new_offer_coupon_date)){
				update_post_meta($post_id, 'rehub_offer_coupon_date', $new_offer_coupon_date );
			}				
		}
		if ($rehub_wpai_coupon->can_update_meta('rehub_offer_coupon_mask', $import_options)) {
			if (!empty($data['offer_coupon_mask'])){
				update_post_meta($post_id, 'rehub_offer_coupon_mask', $data['offer_coupon_mask']);
			}			
		}
		if ($rehub_wpai_coupon->can_update_meta('rehub_offer_btn_text', $import_options)) {
			if (!empty($data['offer_btn_text'])){
				update_post_meta($post_id, 'rehub_offer_btn_text', $data['offer_btn_text']);
			}			
		}
	}
}

/* 
 * GMW Location callback function
 */
if ( !function_exists( 'rehub_wpai_gmwmap_import' ) ) {
	function rehub_wpai_gmwmap_import( $post_id, $data, $import_options ) {
		global $rehub_wpai_gmw_map;
		if ($rehub_wpai_gmw_map->can_update_meta('rehub_gmw_map', $import_options)) {
			if ( !empty($data['rehub_gmw_map'] ) && defined( 'GMW_PT_PATH' ) ) {
				include_once( GMW_PT_PATH .'/includes/gmw-pt-update-location.php' );
				if ( function_exists( 'gmw_pt_update_location' ) ) {
					$args = array(
						'post_id' => $post_id, //Post Id of the post 
						'address' => $data['rehub_gmw_map'] // the address we pull from the custom field above
					);
					gmw_pt_update_location( $args );
					update_post_meta($post_id, 'medafi_rhmap', $data['rehub_gmw_map']);
				}				
			}		
		}
	}
}

/* 
 * Post Review callback function
 */
if ( !function_exists( 'rehub_wpai_review_import' ) ) {
	function rehub_wpai_review_import($post_id, $data, $import_options) {
		global $rehub_wpai_review, $review_count;
		if ($data['makereview'] == 1) {
			if ($rehub_wpai_review->can_update_meta('rehub_framework_post_type', $import_options)) {
				update_post_meta( $post_id, 'rehub_framework_post_type', 'review' );
				$rehub_wpai_review->log( '- Post type is updated for post ID: ' . $post_id .' to "review"' );
			}
			if ($rehub_wpai_review->can_update_meta('rehub_post_fields', $import_options)) {
				$data_post_fields = array( 'rehub_framework_post_type', 'video_post', 'gallery_post', 'review_post', 'music_post' ); //add array from post_type.php
				update_post_meta( $post_id, 'rehub_post_fields', rh_serialize_data_review( $data_post_fields ) );
				$rehub_wpai_review->log( '- Post type fields are added...' );
			}
			$review_post_criteria = array();
			$review_criteria_overall = $total_counter = 0;
			$postscore = '';
			for( $i = 0; $i < $review_count; $i++ ) {
				$review_name = 'review_name_' . $i;
				$review_score = 'review_score_' . $i;
				if ( !empty( $data[$review_name] ) ) {
					if ( $data[$review_score] == '' || $data[$review_score] == ' ' ) 
						$data[$review_score] = '0';
					$review_post_criteria[] = array( 'review_post_name' => $data[$review_name], 'review_post_score' => $data[$review_score] );
					$review_criteria_overall += $data[$review_score];
					$total_counter ++;
				} else {
					break;
				}
			}
			if ( !empty( $data['review_post_score_manual'] ) ) {
				$postscore = $data['review_post_score_manual'];
				
				if ( $review_post_criteria[0]  == '' ) {
					$review_post_criteria[] = array( 'review_post_name' => '', 'review_post_score' => '' );
				}
			} else {			
				if ( $review_criteria_overall !=0 && $total_counter !=0 ) {
					$postscore =  $review_criteria_overall / $total_counter ;			
				} 		
			}
			$review_post_array = array (
			  array (
				'rehub_review_slider' => '0',
				'rehub_review_slider_resize' => '0',
				'rehub_review_slider_images' => 
				array ( 
				  array (
					'review_post_image' => '',
					'review_post_image_caption' => '',
					'review_post_image_url' => '',
					'review_post_video' => ''
				  )
				),
				'review_post_schema_type' => 'review_post_review_simple',
				'review_post_product' => 
				array (
				  array (
					'review_aff_link' => '',
					'review_aff_link_preview' => '',
					'review_post_offer_shortcode' => '0'
				  )
				),
				'review_woo_product' => 
				array (
				  array (
					'review_woo_link' => '',
					'review_woo_slider' => '0',
					'review_woo_slider_resize' => '0',
					'review_woo_offer_shortcode' => '0'
				  )
				),
				'review_woo_list' => 
				array (
				  array (
					'review_woo_list_links' => '',
					'review_woo_list_shortcode' => '0'
				  )
				),
				'review_aff_product' => 
				array (
				  array (
					'review_aff_product_name' => '',
					'review_aff_product_desc' => '',
					'review_aff_product_thumb' => '',
					'review_aff_offer_shortcode' => '0'
				  )
				),
				'review_post_heading' => $data['review_heading'],
				'review_post_summary_text' => $data['review_summary'],
				'review_post_pros_text' => $data['review_post_pros'],
				'review_post_cons_text' => $data['review_post_cons'],
				'review_post_product_shortcode' => $data['review_shortcode'],
				'review_post_score_manual' => $data['review_post_score_manual'],
				'review_post_criteria' => $review_post_criteria
			  )
			);
			if ( $rehub_wpai_review->can_update_meta( 'review_post', $import_options ) ) {
				$review_post_s_array = rh_serialize_data_review( $review_post_array );
				update_post_meta( $post_id, 'review_post', $review_post_s_array );
				$rehub_wpai_review->log( '- Review criteria data is updated...');
				if (!empty($postscore)) {
					update_post_meta( $post_id, 'rehub_review_overall_score', $postscore );
					$rehub_wpai_review->log( '- Overall score of review is: ' . $postscore );
				}		
			}
		}
	}
}

/* 
 * Product Coupon callback function
 */
if ( !function_exists( 'rehub_woo_coupon_import' ) ) {
	function rehub_woo_coupon_import($post_id, $data, $import_options) {
		global $rehub_woo_coupon;
		if ($rehub_woo_coupon->can_update_meta('rehub_woo_coupon_code', $import_options)) {
			update_post_meta($post_id, 'rehub_woo_coupon_code', $data['woo_coupon_code']);
		}
		if ($rehub_woo_coupon->can_update_meta('rehub_woo_coupon_date', $import_options)) {
			$new_offer_coupon_date = rh_change_date_format( $data['woo_coupon_date'], $data['end_date_format'] );
			update_post_meta($post_id, 'rehub_woo_coupon_date', $new_offer_coupon_date );
		}
		if ($rehub_woo_coupon->can_update_meta('rehub_woo_coupon_mask', $import_options)) {
			update_post_meta($post_id, 'rehub_woo_coupon_mask', $data['woo_coupon_mask']);
		}
		if ($rehub_woo_coupon->can_update_meta('re_post_expired', $import_options)) {
			update_post_meta($post_id, 're_post_expired', 0);
		}
	}
}

/* 
 * Store Taxonomy Product callback function
 */
if ( !function_exists( 'rehub_store_logo_import' ) ) {
	function rehub_store_logo_import($post_id, $data, $import_options) {
		global $rehub_store_logo;
		if ( $rehub_store_logo->can_update_image( $import_options ) ) {
			if( $data['store_logo_url'] == 'yes' ) {
				$store_logo_url = wp_get_attachment_url( $data['store_logo_url_dl']['attachment_id'] );
			} else {
				$store_logo_url = $data['store_logo_url_rem'];
			}
			if ( !empty( $store_logo_url ) ) {
				if ( !empty( $data['store_name'] ) ) {
					$termobj = get_term_by('name', $data['store_name'], 'store');
					if ( !empty( $termobj ) ) {
						$termid = (int) $termobj->term_id;
						if ( !empty( $termid ) ) {
							update_term_meta( $termid, 'brandimage', esc_url( $store_logo_url ) );
							$rehub_store_logo->log( '- Store logo '. $store_logo_url .' was added to : ' . $data['store_name'] .'' );
						}				
					}
				} else{
					update_post_meta( $post_id, 'rehub_woo_coupon_logo_url', esc_url( $store_logo_url ) );
				}
			}
		}
	}
}

/* 
 * Convert format date from import data to standart Y-m-d
 */
if ( !function_exists( 'rh_change_date_format' ) ) {
	function rh_change_date_format( $date, $gbf ) {
		if ( $date == '' || $date == ' ' ) {
			return '';
		} else {
			if ( $gbf == 1 ) {
				$new_date = date_create_from_format( 'd/m/Y', $date );
				if( !$new_date ) return '';
			} elseif( $gbf == 2 ) {
				$new_date = date_create_from_format( 'd/m/y', $date );
				if( !$new_date ) return '';			
			} else {
				$new_date = date_create( $date );
				if ( ! $new_date ) return '';	
			}
			$date = date_format( $new_date, 'Y-m-d' );
		}
		return $date;
	}
}

/* 
 * Serialize help function
 */
if ( !function_exists( 'rh_serialize_data_review' ) ) {
	function rh_serialize_data_review( $array_data ) {
		if( empty( $array_data ) )
			return array();
		serialize( $array_data );
		return $array_data;
	}
}

/* 
 * Hooks
 */
require_once( RH_WPAI_ROOT .'/includes/hooks.php');