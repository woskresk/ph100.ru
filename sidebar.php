<?php
		
	global $zn_config;
	
	// Check to see on what type of page we are on
	$layout = 'blog_sidebar';
	if ( !empty( $zn_config['force_sidebar'] ) ) {
		$layout = $zn_config['force_sidebar'];
	}
	else{
		if( is_page() || is_search() || is_404() || is_attachment() ) $layout = 'page_sidebar';
		elseif( is_archive() ) $layout = 'archive_sidebar';
		elseif( is_singular() ) $layout = 'single_sidebar';
	}

	// Get the sidebar position
	$sidebar_pos 	 = zn_get_sidebar_class( $layout );
	$has_sidebar 	 = false;

	if(strpos($sidebar_pos, 'left_sidebar')  !== false) $has_sidebar = true;
	if(strpos($sidebar_pos, 'right_sidebar')  !== false) $has_sidebar = true;

	// Return if we do not have a sidebar
	if( !$has_sidebar ) return;

	// Show the sidebar already :)
	echo '<aside class="col-md-3">';
		echo '<div class="zn_sidebar sidebar">';

			// Check to see if this is a page and has a custom sidebar
			if( ! empty( $zn_config['forced_sidebar_id'] ) ){

				$sidebar = $zn_config['forced_sidebar_id'];

				if( $sidebar == 'default' ){
					$sidebar = zget_option( $layout, 'unlimited_sidebars');
					$sidebar_selected = ! empty( $sidebar['sidebar'] ) ? $sidebar['sidebar'] : 'defaultsidebar' ;
					dynamic_sidebar( $sidebar_selected );
				}
				else{
					dynamic_sidebar( $sidebar );
				}

			}
			elseif ( is_singular() && $sidebar = get_post_meta( get_the_ID(), 'zn_sidebar_select', true ) ){
				
				if( $sidebar == 'default' ){
					$sidebar = zget_option( $layout, 'unlimited_sidebars');
					$sidebar_selected = ! empty( $sidebar['sidebar'] ) ? $sidebar['sidebar'] : 'defaultsidebar' ;
					dynamic_sidebar( $sidebar_selected );
				}
				else{
					dynamic_sidebar( $sidebar );
				}
			}
			else {
				// Get the sidebar set in the theme options
				$sidebar = zget_option( $layout, 'unlimited_sidebars' );
				$sidebar_selected = ! empty( $sidebar['sidebar'] ) ? $sidebar['sidebar'] : 'defaultsidebar' ;
				dynamic_sidebar( $sidebar_selected );
			}

		echo '</div>';
	echo '</aside>';

?>