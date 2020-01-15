<?php
//<editor-fold desc=">>> IMPORTANT. READ ME.">
	// This is the main file for this theme. This file is automatically loaded by WordPress when the
	// theme is active. Normally, you should never edit this file as it will be overridden by future updates.
	// All changes should be implemented in the child theme's functions.php file.
//</editor-fold desc=">>> IMPORTANT. READ ME.">

//<editor-fold desc=">>> CONSTANTS">

/*** INCLUDE THE NEW FRAMEWORK **/
global $zn_config;
require get_template_directory().'/framework/zn-framework.php'; // FRAMEWORK FILE

	/**
	 * Theme's constants
	 */
	define( 'OPTIONS', 'zn_kallyas_options' );

//</editor-fold desc=">>> CONSTANTS">


//<editor-fold desc=">>> GLOBAL VARIABLES">

/**
 * Set the content width.
 * @global
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

//</editor-fold desc=">>> GLOBAL VARIABLES">


//<editor-fold desc=">>> LOAD CUSTOM CLASSES & WIDGETS & HOOKS">

	// Load helper functions
	include( THEME_BASE . '/wpk/function-vt-resize.php' );

	locate_template('wpk/wpk-functions.php', true, true); // can bo overridden in child themes
	include( THEME_BASE . '/wpk/WpkPageHelper.php' );
	include( THEME_BASE . '/wpk/wpk-notifications/wpk-notifications.php' );
	locate_template('theme-functions-override.php', true, true ); // can be overridden in child themes

	// Load Widgets
	include( THEME_BASE . '/template_helpers/widgets/widget-blog-categories.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-archive.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-menu.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-twitter.php');
	include( THEME_BASE . '/template_helpers/widgets/widget-contact-details.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-mailchimp.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-tag-cloud.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-latest_posts.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-social_buttons.php' );
	include( THEME_BASE . '/template_helpers/widgets/widget-flickr.php' );

	// Load shortcodes
	include( THEME_BASE . '/template_helpers/shortcodes/shortcodes.php' );

	// Actions
	locate_template('th-action-hooks.php', true, true);

	// Filters
	locate_template('th-filter-hooks.php', true, true);

	// Custom Hooks
	locate_template('th-custom-hooks.php', true, true);

//</editor-fold desc=">>> LOAD CUSTOM CLASSES & WIDGETS & HOOKS">


/**
 * Adjust content width
 * @uses global $content_width
 */
if ( ! isset( $content_width ) ) {
	$content_width = zget_option( 'zn_width', 'layout_options', false, '1170' );
}


/* TO BE MOVED ELSEWHERE */
function zn_get_sidebar_class( $type , $sidebar_pos = false ) {

	if ( !$sidebar_pos ){
		$sidebar_pos = get_post_meta( zn_get_the_id(), 'zn_page_layout', true );
	}

	if ( $sidebar_pos === 'default' || ! $sidebar_pos ) {
		$sidebar_data = zget_option( $type, 'unlimited_sidebars' , false , array('layout' => 'right_sidebar' , 'sidebar' => 'defaultsidebar' ) );
		$sidebar_pos = $sidebar_data['layout'];
	}

	if ( $sidebar_pos !== 'no_sidebar' ) {
		$sidebar_pos .= ' col-md-9 ';
	}
	else{
		$sidebar_pos = 'col-md-12';
	}

	return $sidebar_pos;
}

/*** JUST FOR DEBUGGING ***/
//add_action( 'admin_bar_menu', 'zn_show_convert_button', 999 );
//function zn_show_convert_button( $wp_admin_bar ){
//    /** @var $wp_admin_bar WP_Admin_Bar */
//	if ( is_singular() ) {
//		global $post;
//		$args = array(
//			'id'    => 'zn_edit_button_run_convert',
//			'title' => 'Run FULL CONVERT',
//			'href'  => add_query_arg( array('zn_run_convert' => true ), get_permalink( $post->ID ) ),
//			'meta'  => array( 'class' => 'zn_edit_button' )
//		);
//		$wp_admin_bar->add_node( $args );
//	}
//}
//add_action( 'init', 'zn_force_run_convert' );
//function zn_force_run_convert(){
//	if( isset( $_GET['zn_run_convert'] ) ){
//
//		// include necessary files
//		include( FW_PATH .'/classes/functions-backend.php' );
//		include( FW_PATH .'/classes/class-theme-setup.php' );
//		include( FW_PATH .'/classes/class-metaboxes.php' );
//
//		ZN()->theme_options = new Zn_Theme_Setup();
//		ZN()->metabox = new ZnMetabox();
//
//
//		// Setup variables
//		$theme_name = 'zn_'.ZN()->theme_data['theme_id'];
//		$theme_db_version = $theme_name.'_db_version';
//		$theme_version = ZN()->version;
//
//
//
//		$update_config = THEME_BASE .'/template_helpers/update/update_config.php';
//		if( file_exists($update_config) ){
//			require( $update_config );
//		}
//		else{
//			return false;
//		}
//
//		$current_db_version = '3.6.9';
//		$db_updates         = apply_filters( 'zn_theme_update_scripts', array() );
//
//		foreach ( $db_updates as $version => $updater ) {
//
//			if ( version_compare( $current_db_version, $version, '<' ) ) {
//				include( $updater['file'] );
//
//				zn_cnv_v4_convert_theme_options();
//				zn_cnv_remove_comments_options();
//				$posts_data = zn_cnv_v4_get_posts_to_convert( 0, 100000 );
//				zn_cnv_v4_convert_pb_data( false, $posts_data );
//
//				zn_cnv_v4_convert_widgets();
//
//				// Set the DB version to the current script - in case of errors, the updater will continue from the last script version
//				delete_option( $theme_db_version );
//				add_option( $theme_db_version, $version );
//			}
//		}
//
//		// Set the DB version to the current theme installed
//		delete_option( $theme_db_version );
//		add_option( $theme_db_version, $theme_version );
//	}
//	// zn_run_convert
//    return false;
//}

/** ADD PB ELEMENTS TO EMPTY PAGES  */
add_filter( 'znpb_empty_page_layout', 'znpb_add_kallyas_template', 10, 3 );
function znpb_add_kallyas_template( $current_layout, $post, $post_id ){
	// We will add the new elements here
	$textbox    = ZNPB()->add_module_to_layout( 'TH_TextBox', array( 'stb_title' => $post->post_title, 'stb_content' => $post->post_content ) );
	$column     = ZNPB()->add_module_to_layout( 'ZnColumn',  array() , array( $textbox ), 'col-sm-12' );
	$sections    = array( ZNPB()->add_module_to_layout( 'ZnSection', array() , array( $column ), 'col-sm-12' ) );

	return $sections;
}