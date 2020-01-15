<?php if(! defined('ABSPATH')) { return; }

/**
 * This file holds all methods hooked to custom actions
 *
 * @package    Kallyas
 * @category   Custom Hooks
 * @author     Team Hogash
 * @since      3.8.0
 */

//<editor-fold desc=">>> WP HOOKS - CUSTOM">

    /**
     * Add page loading
     */
    add_action( 'zn_after_body', 'zn_add_page_loading', 10 );
    /**
     * Add the Support Panel
     */
    add_action( 'zn_after_body', 'zn_add_hidden_panel', 10 );
    /**
     * Display the login form
     */
    add_action( 'zn_after_body', 'zn_add_login_form', 10 );
    /**
     * Open Graph
     */
    add_action( 'zn_after_body', 'zn_add_open_graph', 10 );

/**
 *  Hooks for site-header (styles-1 to styles-6)
 */
    // Show header social icons
    add_action( 'zn_head_right_area', 'zn_header_social_icons', 2 );
    // WPML language switcher
    add_action( 'zn_head_right_area', 'zn_wpml_language_switcher', 3 );
    // Login Form - Login/logout text
    add_action( 'zn_head_right_area', 'zn_login_text', 20 );
    // Add Right content to action
    add_action( 'zn_head_right_area', 'zn_hidden_pannel_link', 30 );
    // Add navigation menu to the Top Area
    add_action( 'zn_head_right_area', 'zn_add_navigation', 40 );

/**
 *  Hooks for site-header (style 7) !!
 */
    // Show header social icons
    add_action( 'zn_head_left_area_s7', 'zn_header_social_icons', 10 );
    // Add navigation menu to the Top Area
    add_action( 'zn_head_right_area_s7', 'zn_add_navigation', 40 );
    // Add Right content to action
    add_action( 'zn_head_right_area_s7', 'zn_hidden_pannel_link', 30 );
    // Login Form - Login/logout text
    add_action( 'zn_head_right_area_s7', 'zn_login_text', 20 );
    // WPML language switcher
    add_action( 'zn_head_right_area_s7', 'zn_wpml_language_switcher', 50 );


/**
 *  Hooks for site-header (style 8) !!
 */
    // WPML language switcher
    add_action( 'zn_head_right1_area_s8', 'zn_wpml_language_switcher', 20 );
    // Show header social icons
    add_action( 'zn_head_right1_area_s8', 'zn_header_social_icons', 10 );
    // Add navigation menu to the Top Area
    add_action( 'zn_head_right2_area_s8', 'zn_add_navigation', 40 );
    // Add Right content to action
    add_action( 'zn_head_right2_area_s8', 'zn_hidden_pannel_link', 30 );
    // Login Form - Login/logout text
    add_action( 'zn_head_right2_area_s8', 'zn_login_text', 20 );


/**
 *  Hooks for site-header (style 9) !!
 */
    // Show header social icons
    add_action( 'zn_head_right_area_s9', 'zn_header_social_icons', 20 );
    // WPML language switcher
    add_action( 'zn_head_left_area_s9', 'zn_wpml_language_switcher', 10 );
    // Add navigation menu to the Top Area
    add_action( 'zn_head_left_area_s9', 'zn_add_navigation', 20 );
    // Login Form - Login/logout text
    add_action( 'zn_head_left_area_s9', 'zn_login_text', 30 );
        // Add Right content to action
    add_action( 'zn_head_left_area_s9', 'zn_hidden_pannel_link', 40 );

    /**
     * Display the Info Card when you hover over the logo.
     */
    add_action( 'zn_show_infocard', 'kfn_showInfoCard' );

    /**
     * Remove the scripts added to the page footer by the nextgen-gallery plugin
     */
    if(class_exists('C_Photocrati_Resource_Manager')) {
        remove_action('wp_print_footer_scripts', array('C_Photocrati_Resource_Manager', 'get_resources'), 1);
    }


/*
 * @since 4.0
 *
 * Page Header hooks
 */

add_action('th_display_site_header', array('WpkPageHelper', 'displaySiteHeader'), 10);

/*
 * @since 4.0
 * Fixes issue with JetPack Comments
 */
add_filter( 'comment_form_default_fields' , 'zn_wp_comment_filter', 98 );
add_filter( 'comment_form_field_comment' , 'zn_wp_comment_form_field_comment', 98 );

if ( !function_exists('zn_wp_comment_filter') ){
    function zn_wp_comment_filter( $fields )
    {
        $fields['author'] = str_replace( '<input ', '<input class="form-control" placeholder="'.__('Name','zn_framework').'" ', $fields['author'] );
        $fields['email'] = str_replace( '<input ', '<input class="form-control" placeholder="'.__('Email','zn_framework').'" ', $fields['email'] );
        $fields['url'] = str_replace( '<input ', '<input class="form-control" placeholder="'.__('Website','zn_framework').'" ', $fields['url'] );

        $fields['author'] = '<div class="row"><div class="form-group col-sm-4">' .$fields['author'].'</div>';
        $fields['email'] = '<div class="form-group col-sm-4">' .$fields['email'].'</div>';
        $fields['url'] = '<div class="form-group col-sm-4">' .$fields['url'].'</div></div>';

        return $fields;
    }
}

if ( !function_exists('zn_wp_comment_form_field_comment') ){
    function zn_wp_comment_form_field_comment( $textarea ){
        $textarea = str_replace( '<textarea ', '<textarea class="form-control" placeholder="'.__('Message:','zn_framework').'" ',$textarea );
        $textarea = '<div class="row"><div class="form-group col-sm-12">'. $textarea .'</div></div>';
        return $textarea;
    }
}


//</editor-fold desc=">>> WP HOOKS - CUSTOM">
