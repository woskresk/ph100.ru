<?php if(! defined('ABSPATH')){ return; }
/**
 * All functions in this file can be overridden in a child theme.
 * This file is loaded in functions.php
 *
 * @package  Kallyas
 * @category Page Builder
 * @author   Team Hogash
 * @since    3.8.0
 */

/**
 * Load custom functions after the theme loads
 */
if ( ! function_exists( 'wpk_zn_on_init' ) ) {
    /**
     * Load custom functions after the theme loads
     * @hooked to after_setup_theme
     * @see functions.php
     */
    function wpk_zn_on_init(){

        // LOAD WOOCOMMERCE CONFIG FILE
        if ( znfw_is_woocommerce_active() ) {
            locate_template( array ( 'woocommerce/zn-woocommerce-init.php' ), true, false );
        }

        if ( is_admin() ) {
            include_once( THEME_BASE . '/wpk/portfolio_slugs.php' );
            include_once( THEME_BASE . '/template_helpers/shortcodes/shortcodes-init.php' );
        }
        else {
            include( THEME_BASE . '/template_helpers/content-page.php' );
        }
    }
}

/**
 * Add theme support
 */
if ( ! function_exists( 'wpk_zn_on_after_setup_theme' ) ) {
    /**
     * Add theme support
     *
     * @hooked to after_setup_theme
     * @see functions.php
     */
    function wpk_zn_on_after_setup_theme(){
        load_theme_textdomain( 'zn_framework', THEME_BASE . '/languages' );
        add_theme_support( 'woocommerce' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'nav-menus' );
        add_theme_support( 'title-tag' );
/*        add_theme_support('post-formats',
            array('aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));*/

        // Add image sizes
        set_post_thumbnail_size( 280, 187 );
        add_image_size( 'full-width-image', 1170 );

        add_theme_support( 'post-thumbnails' );
        add_image_size( 'lp_bi_image', 750, 350, true );


    }
}

/**
 * Shortcodes fixer
 */
if ( ! function_exists( 'shortcode_empty_paragraph_fix' ) ) {
    /**
     * Shortcodes fixer
     *
     * @param $content
     * @hooked to the_content
     * @see functions.php
     * @return string
     */
    function shortcode_empty_paragraph_fix( $content ){
        $array = array ('<p>[' => '[', ']</p>' => ']', ']<br />' => ']');
        return $content = strtr( $content, $array );
    }
}

/**
 * Check if we are on the taxonomy archive page. We will display all items if it is selected
 */
if ( ! function_exists( 'zn_portfolio_taxonomy_pagination' ) ) {
    /**
     * Check if we are on the taxonomy archive page. We will display all items if it is selected
     * @param $query
     * @hooked to pre_get_posts
     * @see functions.php
     */
    function zn_portfolio_taxonomy_pagination( $query ){

        $portfolio_style = zget_option( 'portfolio_style', 'portfolio_options', false, 'portfolio_sortable' );
        $portfolio_per_page_show = zget_option( 'portfolio_per_page_show', 'portfolio_options', false, '4' );

        if ( ( is_tax( 'project_category' ) || is_post_type_archive( 'portfolio' ) ) && $query->is_main_query() && $portfolio_style != 'portfolio_sortable' )  {
           set_query_var( 'posts_per_page', $portfolio_per_page_show );
        }
        elseif( ( is_tax( 'project_category' ) || is_post_type_archive( 'portfolio' ) ) && $query->is_main_query() && $portfolio_style === 'portfolio_sortable' ) {
            set_query_var( 'posts_per_page', '-1' );
        }

    }
}

/**
 * Calculate proper layout size
 */
if ( ! function_exists( 'zn_get_size' ) ) {
    /**
     * Calculate proper layout size
     * @param      $size
     * @param null $sidebar
     * @param int  $extra
     * @return array
     */
    function zn_get_size( $size, $sidebar = null, $extra = 0 ){

        $new_size = array ();

        $span_sizes = array (
            "four"               => "col-sm-3",
            "one-third"          => "col-sm-4",
            "span5"              => "col-sm-5",
            "eight"              => "col-sm-6",

            // wpk - custom sizes
            // @see: image Box 2
            "span7" => 'col-sm-7',
            "span10" => 'col-sm-10',
            "span11" => 'col-sm-11',

            "two-thirds"         => "col-sm-8",
            "twelve"             => "col-sm-9",
            "sixteen"            => "col-sm-12",
            "portfolio_sortable" => 'portfolio_sortable',

            'span3'  => 'col-sm-3',
            'span4'  => 'col-sm-4',
            'span6'  => 'col-sm-6',
            'span8'  => 'col-sm-8',
            'span9'  => 'col-sm-9',
            'span11' => 'col-sm-11',
            'span12' => 'col-sm-12',

        );

        // Image sizes for: 1170 LAYOUT
        $zn_width = zget_option( 'zn_width', 'layout_options', false, '1170' );
        if ( $zn_width == '1170' ) {
            $image_width = array (
                "four"               => 270, // col-sm-3
                "one-third"          => 370, // col-sm-4
                "span5"              => 470, // col-sm-5
                "eight"              => 570, // col-sm-6
                "two-thirds"         => 770, // col-sm-8
                "twelve"             => 870, // col-sm-9
                "sixteen"            => 1170, // col-sm-12
                "span2"              => 170, // col-sm-2
                "span3"              => 270, // col-sm-3
                "span4"              => 370, // col-sm-4
                "span6"              => 570, // col-sm-6
                "span7"              => 670, // col-sm-7
                "span8"              => 770, // col-sm-8
                "span9"              => 870, // col-sm-9
                "span10"             => 970, // col-sm-10
                "span11"             => 1070, // col-sm-11
                "span12"             => 1170, // col-sm-12
                "portfolio_sortable" => 260   // col-sm-*?
            );
        }

        // Image sizes for anything but 1170 LAYOUT
        else {
            $image_width = array (
                "four"               => 220, // DONE
                "one-third"          => 370,
                "eight"              => 460, // DONE
                "two-thirds"         => 770,
                "twelve"             => 870,
                "sixteen"            => 960, // DONE
                "span3"              => 220, // DONE
                "span4"              => 300, // DONE
                "span5"              => 460,
                "span6"              => 460, // DONE
                "span7"              => 670,
                "span8"              => 770,
                "span9"              => 870,
                "span10"             => 970,
                "span11"             => 1070,
                "span12"             => 960, // DONE
                "portfolio_sortable" => 210
            );
        }

        if ( $sidebar ) {
            $image_width[ $size ] = $image_width[ $size ] - 300 - $extra;
        }

        elseif ( isset ( $extra ) ) {
            $image_width[ $size ] = $image_width[ $size ] - $extra;
        }

        $n_height = $image_width[ $size ] / ( 16 / 9 );

        if ( isset ( $span_sizes[ $size ] ) ) {
            $new_size['sizer'] = $span_sizes[ $size ];
        }

        if ( isset ( $image_width[ $size ] ) ) {
            $new_size['width'] = $image_width[ $size ];
        }

        $new_size['height'] = $n_height;

        return $new_size;
    }
}

/**
 * Add the "gallery" shortcode
 */
if ( ! function_exists( 'zn_custom_gallery' ) ) {
    /**
     * Add the "gallery" shortcode
     * @param array $attr
     * @hooked to add_shortcode
     * @see functions.php
     * @return mixed|string|void
     */

    function zn_custom_gallery( $attr ){
        global $post;

        static $instance = 0;

        $instance ++;

        if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) ) {
                $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
        }

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( ! $attr['orderby'] ) {
                unset( $attr['orderby'] );
            }
        }

        // declare vars
        $id      = 0;
        $order   = 'RAND';
        $orderby = 'none';
        $size    = 0;
        $itemtag = $captiontag = $icontag = '';
        $columns = 0;

        extract( shortcode_atts( array (
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post->ID,
            'itemtag'    => 'dl',
            'icontag'    => 'dt',
            'captiontag' => 'dd',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => ''
        ), $attr ) );

        $id = intval( $id );

        if ( 'RAND' == $order ) {
            $orderby = 'none';
        }

        if ( ! empty( $include ) ) {
            $_attachments = get_posts( array (
                'include'        => $include,
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $order,
                'orderby'        => $orderby
            ) );
            $attachments = array ();
            foreach ( $_attachments as $key => $val ) {
                $attachments[ $val->ID ] = $_attachments[ $key ];
            }
        }
        elseif ( ! empty( $exclude ) ) {
            $attachments = get_children( array (
                'post_parent'    => $id,
                'exclude'        => $exclude,
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $order,
                'orderby'        => $orderby
            ) );
        }
        else {
            $attachments = get_children( array (
                'post_parent'    => $id,
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $order,
                'orderby'        => $orderby
            ) );
        }

        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
            }
            return $output;
        }

        $itemtag = tag_escape( $itemtag );
        $captiontag = tag_escape( $captiontag );
        $icontag = tag_escape( $icontag );
        $valid_tags = wp_kses_allowed_html( 'post' );

        if ( ! isset( $valid_tags[ $itemtag ] ) ) {
            $itemtag = 'dl';
        }
        if ( ! isset( $valid_tags[ $captiontag ] ) ) {
            $captiontag = 'dd';
        }
        if ( ! isset( $valid_tags[ $icontag ] ) ) {
            $icontag = 'dt';
        }

        $columns = intval( $columns );
        $itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
        $float = is_rtl() ? 'right' : 'left';
        $selector = "gallery-{$instance}";
        $gallery_style = $gallery_div = '';

        if ( apply_filters( 'use_default_gallery_style', true ) )
        {
            $gallery_style = "<style type=\"text/css\">
                #{$selector} {
                    margin: auto;
                }
                #{$selector} .gallery-item {
                    float: {$float};
                    margin-top: 10px;
                    text-align: center;
                    width: {$itemwidth}%;
                }
                #{$selector} .gallery-caption {
                    margin-left: 0;
                }
            </style><!-- see gallery_shortcode() in wp-includes/media.php -->
            ";
        }

        $size_class = sanitize_html_class( $size );
        $gallery_div = "<div id=\"$selector\" class=\"gallery galleryid-{$id} mfp-gallery mfp-gallery--images gallery-columns-{$columns} gallery-size-{$size_class}\">";
        $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
        $num_ids = count( $attachments );
        $i = 1;
        $c = 1;
        $num_columns = 12 / $columns;
        $uid = uniqid( 'pp_' );

        foreach ( $attachments as $id => $attachment ) {
            if ( $c == 1 || $c % ( $columns + 1 ) == 0 ) {
                $output .= '<div class="row zn_image_gallery ">';
                $c = 1;
            }

            if ( $captiontag && trim( $attachment->post_excerpt ) ) {
                $title_caption = wptexturize( $attachment->post_excerpt );
            }
            else {
                $title_caption = '';
            }

            $output .= '<div class="col-sm-' . $num_columns . '">';
            $output .= '<a href="' . wp_get_attachment_url( $id ) . '" title="' . $title_caption . '" class="hoverBorder">';
            $output .= wp_get_attachment_image( $id, $size, 0, $attr );

            // Show caption
            $output .= '<span class="gallery_caption">';
            $output .= $title_caption;
            $output .= '</span>';

            $output .= '</a>';
            $output .= '</div>';

            if ( ( $columns > 0 && $i % $columns == 0 ) || $i == $num_ids ) {
                $output .= '</div>';
            }

            $i ++;
            $c ++;
        }
        $output .= '</div>';
        return $output;
    }
}
remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'zn_custom_gallery' );


/**
 * Display the favicon
 */
if ( ! function_exists( 'zn_favicon_kallyas' ) ) {
    /**
     * Display the favicon
     * @hooked to wp_head
     * @see functions.php
     */
    function zn_favicon_kallyas(){

        if ( $favicon_image = zget_option( 'custom_favicon', 'general_options', false, false ) ) {
            $favicon = '<link rel="shortcut icon" href="' . $favicon_image . '"/>';
        }
        else {
            $favicon = '<link rel="shortcut icon" href="' . THEME_BASE_URI .'/favicon.ico"/>';
        }
        echo $favicon;
    }
}

/**
 * Add extra data to head
 */
if ( ! function_exists( 'zn_head' ) ) {
    /**
     * Add extra data to head
     * @hooked to wp_head
     * @see functions.php
     */
    function zn_head(){
        ?>
        <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo THEME_BASE_URI; ?>/css/fixes.css"/>
        <![endif]-->
        <!--[if lte IE 8]>
        <script src="<?php echo THEME_BASE_URI; ?>/js/respond.js"></script>
        <script type="text/javascript">
            var $buoop = {
                vs: { i: 8, f: 6, o: 10.6, s: 4, n: 9 }
            };

            $buoop.ol = window.onload;

            window.onload = function(){
                try {
                    if ($buoop.ol) {
                        $buoop.ol()
                    }
                }
                catch (e) {}

                var e = document.createElement("script");
                e.setAttribute("type", "text/javascript");
                e.setAttribute("src", "<?php echo get_current_scheme();?>://browser-update.org/update.js");
                document.body.appendChild(e);
            };
        </script>
        <![endif]-->

        <!-- for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <?php
    }
}

/**
 * Page pre-loading
 */
if ( ! function_exists( 'zn_page_loading' ) ) {
    /**
     * Page pre-loading
     */
    function zn_page_loading(){

        if ( zget_option( 'page_preloader' , 'general_options', false, 'no' ) == 'yes' ) {
            echo '<div id="page-loading"></div>';
        }
    }
}

/**
 * Update inline scripts
 */
if ( ! function_exists( 'zn_update_array' ) ) {
    /**
     * Update inline scripts
     * @param $script
     */
    function zn_update_array( $script ){
        $zn_array = wp_cache_get( 'zn_array' );
        if(empty($zn_array)){
            $zn_array = array();
        }
        $zn_array[ key( $script ) ] = $script[ key( $script ) ];
        wp_cache_set( 'zn_array', $zn_array );
    }
}

/**
 * Display the inline JS
 */
if ( ! function_exists( 'zn_load_inline_js' ) ) {
    /**
     * Load the inline JS
     * @param $script
     * @hooked to wp_footer
     * @see functions.php
     */
    function zn_load_inline_js( $script ){
        $zn_array = wp_cache_get( 'zn_array' );
        if ( is_array( $zn_array ) && ! empty( $zn_array ) ) {
            $script = '<script type="text/javascript">';
            $script .= '(function ($){';
            foreach ( $zn_array as $tt ) {
                $script .= $tt."\n";
            }
            $script .= '})(jQuery);';
            $script .= '</script>';
            echo $script;
        }
    }
}

/**
 * Display Google analytics to page
 */
if ( ! function_exists( 'add_googleanalytics' ) ) {
    /**
     * Display Google analytics to page
     * @hooked to wp_footer
     * @see functions.php
     */
    function add_googleanalytics(){
        if ( $google_analytics = zget_option( 'google_analytics', 'general_options' ) ) {
            echo stripslashes( $google_analytics );
        }
    }
}

/**
 * Register menus
 */
if ( ! function_exists( 'zn_register_menu' ) ) {
    /**
     * Register menus
     * @hooked to init
     * @see functions.php
     */
    function zn_register_menu(){
        if ( function_exists( 'wp_nav_menu' ) ) {
            register_nav_menus( array (
                'main_navigation' => esc_html__( 'Main Navigation', 'zn_framework' )
            ) );
            register_nav_menus( array (
                'header_navigation' => esc_html__( 'Header Navigation', 'zn_framework' ),
            ) );
            register_nav_menus( array (
                'footer_navigation' => esc_html__( 'Footer Navigation', 'zn_framework' ),
            ) );
        }
    }
}


/**
 * Add specific css class to active item
 */
if ( ! function_exists( 'zn_active_item_classes' ) ) {
    /**
     * Add specific css class to active item
     * @param array $classes
     * @param bool  $menu_item
     * @hooked to nav_menu_css_class
     * @see functions.php
     * @return array
     */
    function zn_active_item_classes( $classes = array (), $menu_item = false ){
        if ( in_array( 'current-menu-item', $menu_item->classes ) || in_array( 'current-menu-ancestor', $menu_item->classes ) ) {
            $classes[] = 'active';
        }
        return $classes;
    }
}

/**
 * Load video iframe from link
 */
if ( ! function_exists( 'get_video_from_link' ) ) {
    /**
     * Load video iframe from link
     * @param string $string
     * @param null   $css
     * @param int $width
     * @param int $height
     * @return mixed|null|string
     */
    function get_video_from_link( $string, $css = null, $width = 425, $height = 239 ){
        // Save old string in case no video is provided
        $old_string = $string;
        $video_url = parse_url( $string );

        if ( $video_url['host'] == 'www.youtube.com' || $video_url['host'] == 'youtube.com' ) {
            preg_match( '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $string, $matches );
            $string = '<iframe class="' . $css . '" width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $matches[0] . '?iv_load_policy=3&enablejsapi=0&amp;wmode=transparent&amp;modestbranding=1&amp;rel=0&amp;showinfo=0&amp;feature=player_embedded" frameborder="0" allowfullscreen></iframe>';
        }
        elseif ( $video_url['host'] == 'www.dailymotion.com' ) {
            $id = strtok( basename( $old_string ), '_' );
            $string = '<iframe frameborder="0" width="' . $width . '" height="' . $height . '" src="//www.dailymotion.com/embed/video/' . $id . '"></iframe>';
        }
        else {
            $string = preg_replace(
                array (
                    '#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i',
                    '#https://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i'
                ),
                '<iframe class="youtube-player ' . $css . '" src="//player.vimeo.com/video/$2" width="' . $width . '" height="' . $height . '" allowFullScreen></iframe>', $string );
        }

        // If no video link was provided return the full link
        return ( $string != $old_string ) ? $string: null;
    }
}

/**
 * Comments display function
 */
if ( ! function_exists( 'zn_comment' ) ) {
    /**
     * Comments display function
     * @param $comment
     * @param $args
     * @param $depth
     */
    function zn_comment( $comment, $args, $depth ){
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div id="comment-<?php comment_ID(); ?>">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, $size = '50' ); ?>
                    <?php printf( __( '<cite class="fn">%s</cite>', 'zn_framework' ), get_comment_author_link() ) ?> <?php echo __( "says :", 'zn_framework' ); ?> <?php comment_reply_link( array_merge( $args, array (
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth']
                    ) ) ) ?>
                </div>

                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em><?php _e( 'Your comment is awaiting moderation.', 'zn_framework' ) ?></em>
                    <br/>
                <?php endif; ?>

                <div class="comment-meta commentmetadata">
                    <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                        <?php printf( __( '%1$s at %2$s', 'zn_framework' ), get_comment_date(), get_comment_time() ) ?>
                    </a>
                    <?php edit_comment_link( __( '(Edit)', 'zn_framework' ), '  ', '' ) ?>
                </div>

                <?php comment_text() ?>

                <div class="zn-separator sep_normal zn-margin-d"></div>
            </div>
    <?php
    }
}

//<editor-fold desc=">>> REGISTER SIDEBARS">

if(! function_exists('wpkRegisterSidebars')){
    /**
     * Register theme sidebars
     * @hooked to widgets_init
     * @since 4.0.0
     */
    function wpkRegisterSidebars()
    {

        if ( function_exists( 'register_sidebar' ) ) {
            /**
             * Default sidebar
             */
            register_sidebar( array (
                'name'          => 'Default Sidebar',
                'id'            => 'defaultsidebar',
                'description'   => esc_html__( "This is the default sidebar. You can choose from the theme's options page where
                                        the widgets from this sidebar will be shown.", 'zn_framework' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widgettitle title">',
                'after_title'   => '</h3>'
            ));
            /**
             * Hidden Panel sidebar
             */
            register_sidebar( array (
                'name'          => 'Hidden Panel Sidebar',
                'id'            => 'hiddenpannelsidebar',
                'description'   => esc_html__( "This is the sidebar for the hidden panel in the header. You can choose from the
                                theme's options page where the widgets from this sidebar will be shown.", 'zn_framework' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widgettitle title">',
                'after_title'   => '</h3>'

            ));
            // Footer sidebar 1
            $footer_row1_widget_positions = zget_option( 'footer_row1_widget_positions', 'general_options', false, '{"3":[["4","4","4"]]}' );

            $f_row1 = key( json_decode( stripslashes( $footer_row1_widget_positions ) ) );
            if ( $f_row1 > 1 ) {
                register_sidebars( $f_row1, array (
                    'name'          => 'Footer row 1 - widget %d',
                    'id'            => "znfooter",
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="widgettitle title m_title">',
                    'after_title'   => '</h3>'
                ));
            }
            else {
                register_sidebars( 1, array (
                    'name'          => 'Footer row 1 - widget 1',
                    'id'            => "znfooter",
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="widgettitle title m_title">',
                    'after_title'   => '</h3>'
                ));
            }

            // Footer sidebar 2
            $footer_row2_widget_positions = zget_option( 'footer_row2_widget_positions', 'general_options', false, '{"3":[["4","4","4"]]}' );

            $f_row1 = key( json_decode( stripslashes( $footer_row2_widget_positions ) ) );
            if ( $f_row1 > 1 ) {
                register_sidebars( $f_row1, array (
                    'name'          => 'Footer row 2 - widget %d',
                    'id'            => "znfooter",
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="widgettitle title m_title">',
                    'after_title'   => '</h3>'
                ) );
            }
            else {
                register_sidebars( 1, array (
                    'name'          => 'Footer row 2 - widget 1',
                    'id'            => "znfooter",
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="widgettitle title m_title">',
                    'after_title'   => '</h3>'
                ) );
            }

            // global $wp_registered_sidebars;
            // Dynamic sidebars
            if ( $unlimited_sidebars = zget_option( 'unlimited_sidebars', 'unlimited_sidebars' ) ) {
                foreach ( $unlimited_sidebars as $sidebar ) {
                    if ( $sidebar['sidebar_name'] ) {

                        // $i = count($wp_registered_sidebars) + 1;

                        register_sidebar( array (
                            'name'          => $sidebar['sidebar_name'],
                            'id' => zn_sanitize_widget_id( $sidebar['sidebar_name'] ),
                            'before_widget' => '<div id="%1$s" class="widget %2$s">',
                            'after_widget'  => '</div>',
                            'before_title'  => '<h3 class="widgettitle title">',
                            'after_title'   => '</h3>'
                        ));
                    }
                }
            }
        }
    }
}
//</editor-fold desc=">>> REGISTER SIDEBARS">

/**
 * Display the Hidden panel Sidebar
 */
if ( ! function_exists( 'zn_hidden_pannel' ) ) {
    /**
     * Display the Hidden panel Sidebar
     */
    function zn_hidden_pannel(){
        if ( is_active_sidebar( 'hiddenpannelsidebar' ) ) {
            ?>
            <div class="support_panel" id="sliding_panel">
                <div class="container">
                    <?php dynamic_sidebar( 'hiddenpannelsidebar' ); ?>
                </div>
            </div><!--// end #sliding_panel.support_panel -->
        <?php
        }
    }
}

/**
 * Get current scheme
 */
if ( ! function_exists( 'get_current_scheme' ) ) {
    /**
     * Get current scheme
     * @return string
     */
    function get_current_scheme(){
        $scheme = 'http';
        if ( isset( $_SERVER["HTTPS"] ) && ( $_SERVER["HTTPS"] == "on" ) ) {
            $scheme .= "s";
        }
        return $scheme;
    }
}

/**
 * Get current page URL
 */
if ( ! function_exists( 'current_page_url' ) ) {
    /**
     * Get current page URL
     * @return string
     */
    function current_page_url(){
        $pageURL = get_current_scheme() . '://';
        if ( isset( $_SERVER["SERVER_PORT"] ) && ( (int) $_SERVER["SERVER_PORT"] != 80 ) ) {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
}

/**
 * Remove the "Read More" tag from excerpt
 */
if ( ! function_exists( 'clear_excerpt_more' ) ) {
    /**
     * Remove the "Read More" tag from excerpt
     * @param $more
     * @hooked to excerpt_more
     * @see functions.php
     * @return string
     */
    function clear_excerpt_more( $more ){
        return '';
    }
}


/**
 * Flush WP Rewrite rules
 */
if ( ! function_exists( 'zn_rewrite_flush' ) ) {
    /**
     * Flush WP Rewrite rules
     * @hooked to after_switch_theme
     * @see functions.php
     */
    function zn_rewrite_flush(){
        flush_rewrite_rules();
    }
}

/**
 * Register the Custom Post Type: Portfolio
 */
if ( ! function_exists( 'zn_portfolio_post_type' ) ) {
    /**
     * Register the Custom Post Type: Portfolio
     * @hooked to init
     * @see functions.php
     */
    function zn_portfolio_post_type(){
        $permalinks = get_option( 'zn_permalinks' );
        $slug = true;

        if (isset($permalinks['port_item']) && !empty( $permalinks['port_item'] ) ) {
            $slug = array( 'slug' => $permalinks['port_item'] );
        }

        $labels = array (
            'name'               => __( 'Portfolios', 'zn_framework' ),
            'singular_name'      => __( 'Portfolio Item', 'zn_framework' ),
            'add_new'            => __( 'Add New Portfolio Item', 'zn_framework' ),
            'all_items'          => __( 'All Portfolio Items', 'zn_framework' ),
            'add_new_item'       => __( 'Add New Portfolio', 'zn_framework' ),
            'edit_item'          => __( 'Edit Portfolio Item', 'zn_framework' ),
            'new_item'           => __( 'New Portfolio Item', 'zn_framework' ),
            'view_item'          => __( 'View Portfolio Item', 'zn_framework' ),
            'search_items'       => __( 'Search Portfolio Items', 'zn_framework' ),
            'not_found'          => __( 'No Portfolio Items found', 'zn_framework' ),
            'not_found_in_trash' => __( 'No Portfolio Items found in trash', 'zn_framework' ),
            'parent_item_colon'  => __( 'Parent Portfolio:', 'zn_framework' ),
            'menu_name'          => __( 'Portfolio Items', 'zn_framework' ),
        );

        $args = array (
            'labels'              => $labels,
            'description'         => "",
            'public'              => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 100,
            'menu_icon'           => THEME_BASE_URI.'/images/portfolio.png',
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array ( 'title', 'editor', 'excerpt' ),
            'has_archive'         => true,
            'rewrite'             => $slug,
            'query_var'           => true,
            'can_export'          => true
        );
        register_post_type( 'portfolio', $args );
    }
}

/**
 * Register the Portfolio Post Taxonomy
 */
if ( ! function_exists( 'zn_portfolio_category' ) ) {
    /**
     * Register the Portfolio Post Taxonomy
     * @hooked to init
     * @see functions.php
     */
    function zn_portfolio_category(){
        $slug = true;
        $permalinks = get_option( 'zn_permalinks' );

        if (isset($permalinks['port_tax']) && !empty( $permalinks['port_tax'] ) ) {
            $slug = array ( 'slug' => $permalinks['port_tax'] );
        }

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array (
            'name'              => __( 'Categories', 'zn_framework' ),
            'singular_name'     => __( 'Category', 'zn_framework' ),
            'search_items'      => __( 'Search Categories', 'zn_framework' ),
            'all_items'         => __( 'All Categories', 'zn_framework' ),
            'parent_item'       => __( 'Parent Category', 'zn_framework' ),
            'parent_item_colon' => __( 'Parent Category:', 'zn_framework' ),
            'edit_item'         => __( 'Edit Category', 'zn_framework' ),
            'update_item'       => __( 'Update Category', 'zn_framework' ),
            'add_new_item'      => __( 'Add New Category', 'zn_framework' ),
            'new_item_name'     => __( 'New Category Name', 'zn_framework' ),
            'menu_name'         => __( 'Portfolio categories', 'zn_framework' ),

        );

        register_taxonomy( 'project_category', 'portfolio', array (
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => $slug,
        ));
    }
}

/**
 * Register the Documentation Custom Post Type
 */
if ( ! function_exists( 'zn_documentation_post_type' ) ) {
    /**
     * Register the Documentation Custom Post Type
     * @hooked to init
     * @see functions.php
     */
    function zn_documentation_post_type(){
        $slug = true;
        $permalinks = get_option( 'zn_permalinks' );

        if ( ! empty( $permalinks['doc_item'] ) ) {
            $slug = array ( 'slug' => $permalinks['doc_item'] );
        }

        $labels = array (
            'name'               => __( 'Documentation', 'zn_framework' ),
            'singular_name'      => __( 'Documentation Item', 'zn_framework' ),
            'add_new'            => __( 'Add New Documentation Item', 'zn_framework' ),
            'all_items'          => __( 'All Documentation Items', 'zn_framework' ),
            'add_new_item'       => __( 'Add New Documentation', 'zn_framework' ),
            'edit_item'          => __( 'Edit Documentation Item', 'zn_framework' ),
            'new_item'           => __( 'New Documentation Item', 'zn_framework' ),
            'view_item'          => __( 'View Documentation Item', 'zn_framework' ),
            'search_items'       => __( 'Search Documentation Items', 'zn_framework' ),
            'not_found'          => __( 'No Documentation Items found', 'zn_framework' ),
            'not_found_in_trash' => __( 'No Documentation Items found in trash', 'zn_framework' ),
            'parent_item_colon'  => __( 'Parent Documentation:', 'zn_framework' ),
            'menu_name'          => __( 'Documentation Items', 'zn_framework' ),
        );

        $args = array (
            'labels'              => $labels,
            'description'         => "",
            'public'              => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 100,
            'menu_icon'           => THEME_BASE_URI.'/images/portfolio.png',
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array ( 'title', 'editor' ),
            'has_archive'         => true,
            'rewrite'             => $slug,
            'query_var'           => true,
            'can_export'          => true
        );
        register_post_type( 'documentation', $args );
    }
}

/**
 * Register the Documentation Post Taxonomy
 */
if ( ! function_exists( 'zn_documentation_category' ) ) {
    /**
     * Register the Documentation Post Taxonomy
     * @hooked to init
     * @see functions.php
     */
    function zn_documentation_category(){
        $slug = true;
        $permalinks = get_option( 'zn_permalinks' );

        if ( ! empty( $permalinks['doc_tax'] ) ) {
            $slug = array ( 'slug' => $permalinks['doc_tax'] );
        }

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array (
            'name'              => __( 'Categories', 'zn_framework' ),
            'singular_name'     => __( 'Category', 'zn_framework' ),
            'search_items'      => __( 'Search Categories', 'zn_framework' ),
            'all_items'         => __( 'All Categories', 'zn_framework' ),
            'parent_item'       => __( 'Parent Category', 'zn_framework' ),
            'parent_item_colon' => __( 'Parent Category:', 'zn_framework' ),
            'edit_item'         => __( 'Edit Category', 'zn_framework' ),
            'update_item'       => __( 'Update Category', 'zn_framework' ),
            'add_new_item'      => __( 'Add New Category', 'zn_framework' ),
            'new_item_name'     => __( 'New Category Name', 'zn_framework' ),
            'menu_name'         => __( 'Documentation categories', 'zn_framework' ),
        );

        register_taxonomy( 'documentation_category', 'documentation', array (
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => $slug,
        ) );
    }
}

/**
 * Display the breadcrumb menu
 */
if ( ! function_exists( 'zn_breadcrumbs' ) ) {
    /**
     * Display the breadcrumb menu
     */
    function zn_breadcrumbs(){
        global $post, $wp_query;

        $delimiter   = '&raquo;';
        $home        = __( 'Home', 'zn_framework' );
        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show

        $before = '<span class="current">'; // tag before the current crumb
        $after  = '</span>'; // tag after the current crumb

        $prepend = '';

        if ( znfw_is_woocommerce_active() ) {
            $permalinks = get_option( 'woocommerce_permalinks' );

            $shop_page_id = wc_get_page_id( 'shop' );
            $shop_page = get_post( $shop_page_id );

            if(isset($permalinks['product_base']) && isset($shop_page->post_name)) {
                if ( $shop_page_id && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) &&
                     get_option( 'page_on_front' ) !== $shop_page_id
                ) {
                    $prepend = '<li property="item" typeof="WebPage"><a property="item" typeof="WebPage" href="' .
                               get_permalink( wc_get_page_id( 'shop' ) ) . '">' .
                               get_the_title( wc_get_page_id( 'shop' ) );
                    $prepend .= '</a></li>';
                }
            }
        }

        $homeLink = home_url();

        if ( is_front_page() ) {
            echo '<ul vocab="http://schema.org/" typeof="BreadcrumbList" class="breadcrumbs fixclear"><li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' . $homeLink . '">' . $home . '</a></li></ul>';
        }
        elseif ( is_home() ) {

            $title = zget_option( 'archive_page_title', 'blog_options' );
            $title = do_shortcode( $title );

            echo '<ul vocab="http://schema.org/" typeof="BreadcrumbList" class="breadcrumbs fixclear"><li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' . $homeLink . '">' . $home . '</a></li><li>' . $title . '</li></ul>';
        }

        else
        {
            $bClass = 'breadcrumbs fixclear';
            echo '<ul vocab="http://schema.org/" typeof="BreadcrumbList"';
            if(is_search()){
                $bClass  .=' th-search-page-mtop';
            }

            echo ' class="'.$bClass.'"><li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' . $homeLink . '">' . $home . '</a></li>';
            if ( is_category() )
            {
                $thisCat = get_category( get_query_var( 'cat' ), false );

                if ( $thisCat->parent != 0 ) {
                    $cats = get_category_parents( $thisCat->parent, true, '|zn_preg|' );
                }
                else $cats = get_category_parents( $thisCat, true, '|zn_preg|' );

                if(! empty($cats) && ! is_wp_error($cats)) {
                    $cats = explode( '|zn_preg|', $cats );
                    foreach ( $cats as $s_cat ) {
                        if ( ! empty ( $s_cat ) ) {
                            $s_cat = str_replace( '<a', '<a property="item" typeof="WebPage" ', $s_cat );
                            echo '<li property="itemListElement" typeof="ListItem">' . $s_cat . '</li>';
                        }
                    }
                }
                echo '<li>' . __( "Archive from category ", 'zn_framework' ) . '"' . single_cat_title( '', false ) . '"</li>';
            }
            elseif ( is_tax( 'product_cat' ) )
            {
                echo $prepend;

                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $parents = array ();
                $parent = $term->parent;

                while ( $parent ) {
                    $parents[] = $parent;
                    $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                    $parent = $new_parent->parent;
                }

                if ( ! empty( $parents ) ) {
                    $parents = array_reverse( $parents );

                    foreach ( $parents as $parent ) {
                        $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                        echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"  href="' .
                            get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a></li>';
                    }
                }
                $queried_object = $wp_query->get_queried_object();
                echo '<li>' . $queried_object->name . '</li>';
            }
            elseif ( is_tax( 'project_category' ) || is_post_type_archive( 'portfolio' ) )
            {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                if ( ! empty( $term->parent ) ) {
                    $parents = array ();
                    $parent = $term->parent;

                    while ( $parent ) {
                        $parents[] = $parent;
                        $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                        $parent = $new_parent->parent;
                    }

                    if ( ! empty( $parents ) ) {
                        $parents = array_reverse( $parents );

                        foreach ( $parents as $parent ) {
                            $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                            echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"  href="' .
                                get_term_link( $item->slug, 'project_category' ) . '">' . $item->name . '</a></li>';
                        }
                    }
                }
                $queried_object = $wp_query->get_queried_object();
                $menuItem = $queried_object->name;
                //@wpk: #68 - Replace "portfolio" with the one set by the user in the permalinks page
                if ( strcasecmp( 'portfolio', $queried_object->name ) == 0 ) {
                    $menuItem = $queried_object->rewrite['slug'];
                }
                echo '<li>' . $menuItem . '</li>';
            }
            elseif ( is_tax( 'documentation_category' ) )
            {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $parents = array ();
                $parent = $term->parent;

                while ( $parent ) {
                    $parents[] = $parent;
                    $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                    $parent = $new_parent->parent;
                }

                if ( ! empty( $parents ) ) {
                    $parents = array_reverse( $parents );

                    foreach ( $parents as $parent ) {
                        $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                        echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"  href="' .
                            get_term_link( $item->slug, 'documentation_category' ) . '">' . $item->name . '</a></li>';
                    }
                }
                $queried_object = $wp_query->get_queried_object();
                echo '<li>' . $queried_object->name . '</li>';
            }
            elseif ( is_search() )
            {
                echo '<li>' . __( "Search results for ", 'zn_framework' ) . '"' . get_search_query() . '"</li>';
            }
            elseif ( is_day() )
            {
                echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"  href="' .
                    get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
                echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"  href="' .
                    get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';
                echo '<li>' . get_the_time( 'd' ) . '</li>';
            }
            elseif ( is_month() )
            {
                echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"  href="' .
                    get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
                echo '<li>' . get_the_time( 'F' ) . '</li>';
            }
            elseif ( is_year() )
            {
                echo '<li>' . get_the_time( 'Y' ) . '</li>';
            }
            elseif ( is_post_type_archive( 'product' ) && get_option( 'page_on_front' ) !== wc_get_page_id( 'shop' ) ) {
                $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : ucwords( get_option( 'woocommerce_shop_slug' ) );

                if ( is_search() ) {
                    echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' .
                        get_post_type_archive_link( 'product' ) . '">' . $_name . '</a></li><li>' .
                        __( 'Search results for &ldquo;', 'zn_framework' ) . get_search_query() . '</li>';
                }
                elseif ( is_paged() ) {
                    echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' .
                        get_post_type_archive_link( 'product' ) . '">' . $_name . '</a></li>';
                }
                else {
                    echo '<li>' . $_name . '</li>';
                }
            }
            elseif ( is_single() && ! is_attachment() )
            {
                if ( get_post_type() == 'portfolio' )
                {
                    // Show category name
                    $cats = get_the_term_list( $post->ID, 'project_category', ' ', '|zn_preg|', '|zn_preg|' );
                    $cats = explode( '|zn_preg|', $cats );
                    if ( ! empty ( $cats[0] ) ) {
                        $s_cat = str_replace( '<a', '<a property="item" typeof="WebPage" ', $cats[0] );
                        echo '<li property="itemListElement" typeof="ListItem">' . $s_cat . '</li>';
                    }
                    // Show post name
                    echo '<li>' . get_the_title() . '</li>';
                }
                elseif ( get_post_type() == 'product' )
                {
                    echo $prepend;

                    if ( $terms = wp_get_object_terms( $post->ID, 'product_cat' ) ) {
                        $term = current( $terms );
                        $parents = array ();
                        $parent = $term->parent;

                        while ( $parent ) {
                            $parents[] = $parent;
                            $new_parent = get_term_by( 'id', $parent, 'product_cat' );
                            $parent = $new_parent->parent;
                        }

                        if ( ! empty( $parents ) ) {
                            $parents = array_reverse( $parents );

                            foreach ( $parents as $parent ) {
                                $item = get_term_by( 'id', $parent, 'product_cat' );
                                echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' .
                                    get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a></li>';
                            }
                        }
                        echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' .
                            get_term_link( $term->slug, 'product_cat' ) . '">' . $term->name . '</a></li>';
                    }
                    echo '<li>' . get_the_title() . '</li>';
                }

                elseif ( get_post_type() != 'post' )
                {
                    $post_type = get_post_type_object( get_post_type() );
                    $slug = $post_type->rewrite;
                    echo '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' . $homeLink . '/' .
                        $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';

                    if ( $showCurrent == 1 ) {
                        echo '<li>' . get_the_title() . '</li>';
                    }
                }
                else {
                    // Show category name
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents( $cat, true, '|zn_preg|' );
                    if(! empty($cats) && ! is_wp_error($cats)) {
                        $cats = explode( '|zn_preg|', $cats );
                        foreach ( $cats as $s_cat ) {
                            if ( ! empty ( $s_cat ) ) {
                                $s_cat = str_replace( '<a', '<a property="item" typeof="WebPage" ', $s_cat );
                                echo '<li property="itemListElement" typeof="ListItem">' . $s_cat . '</li>';
                            }
                        }
                    }
                    // Show post name
                    echo '<li>' . get_the_title() . '</li>';
                }
            }
            elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() )
            {
                $post_type = get_post_type_object( get_post_type() );
                if ( ! empty ( $post_type->labels->singular_name ) ) {
                    echo '<li>' . $post_type->labels->singular_name . '</li>';
                }
            }
            elseif ( is_attachment() )
            {
                $parent = get_post( $post->post_parent );
                $cat = get_the_category( $parent->ID );
                if ( ! empty( $cat ) ) {
                    $cat = $cat[0];
                    $cats = get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
                    if(! empty($cats) && ! is_wp_error($cats)) {
                        echo $cats;
                    }
                    echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';
                    echo '<li>' . get_the_title() . '</li>';
                }
                else {
                    echo '<li>' . get_the_title() . '</li>';
                }
            }
            elseif ( is_page() && ! is_subpage() )
            {
                if ( $showCurrent == 1 ) {
                    echo '<li>' . get_the_title() . '</li>';
                }
            }
            elseif ( is_page() && is_subpage() )
            {
                $parent_id = $post->post_parent;
                $breadcrumbs = array ();
                while ( $parent_id ) {
                    $page = get_post( $parent_id );
                    $breadcrumbs[] = '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="' .
                        get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
                    $parent_id = $page->post_parent;
                }

                $breadcrumbs = array_reverse( $breadcrumbs );

                for ( $i = 0; $i < count( $breadcrumbs ); $i ++ ) {
                    echo $breadcrumbs[ $i ];
                }

                if ( $showCurrent == 1 ) {
                    echo '<li>' . get_the_title() . '</li>';
                }
            }
            elseif ( is_tag() ) {
                echo '<li>' . __( "Posts tagged ", 'zn_framework' ) . '"' . single_tag_title( '', false ) . '"</li>';
            }
            elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );
                echo '<li>' . __( "Articles posted by ", 'zn_framework' ) . ( isset( $userdata->display_name ) ? $userdata->display_name : '' ) . '</li>';
            }
            elseif ( is_404() ) {
                echo '<li>' . __( "Error 404 ", 'zn_framework' ) . '</li>';
            }
            if ( get_query_var( 'paged' ) ) {
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
                    echo ' (';
                }
                echo '<li>' . __( 'Page', 'zn_framework' ) . ' ' . get_query_var( 'paged' ) . '</li>';
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
                    echo ')';
                }
            }
            echo '</ul>';
        }
    }
}

/**
* Check if this is a subpage
*/
if ( ! function_exists( 'is_subpage' ) ) {
    /**
     * Check if this is a subpage
     * @return bool|int
     */
    function is_subpage(){
        global $post;                              // load details about this page
        if ( is_page() && $post->post_parent ) {   // test to see if the page has a parent
            return $post->post_parent;             // return the ID of the parent post
        }
        return false;
    }
}

/**
 * Display the login form
 */
if ( ! function_exists( 'zn_login_form' ) ) {
    /**
     * Display the login form
     */
    function zn_login_form(){
        global $wp;

        $current_url = home_url( $wp->request );

        // CHECK IF USER IS LOGGED IN
        if ( is_user_logged_in() || ! zget_option( 'head_show_login', 'general_options', false, 1 ) ) {
            return;
        }
        ?>

        <div class="login_register_stuff">
            <!-- Login/Register Modal forms - hidden by default to be opened through modal -->
            <div id="login_panel" class="loginbox-popup mfp-hide">
                <div class="inner-container login-panel">
                    <h3 class="m_title"><?php _e( "SIGN IN YOUR ACCOUNT TO HAVE ACCESS TO DIFFERENT FEATURES", 'zn_framework' ); ?></h3>
                    <form id="login_form" name="login_form" method="post" class="zn_form_login"
                          action="<?php echo site_url( 'wp-login.php', 'login_post' ) ?>">

                        <div class="form-group kl-fancy-form kl-fw-form">
                            <input type="text" id="kl-username" name="log" class="form-control inputbox"
                                   placeholder="<?php _e( "eg: james_smith", 'zn_framework' ); ?>"/>
                            <label><?php _e( "USERNAME", 'zn_framework' ); ?></label>
                        </div>

                        <div class="form-group kl-fancy-form kl-fw-form">
                            <input type="password" id="kl-password" name="pwd" class="form-control inputbox"
                                   placeholder="<?php _e( "type password", 'zn_framework' ); ?>"/>
                            <label><?php _e( "PASSWORD", 'zn_framework' ); ?></label>
                        </div>

                        <?php do_action( 'login_form' ); ?>

                        <label class="zn_remember" for="kl-rememberme">
                            <input type="checkbox" name="rememberme" id="kl-rememberme" value="forever"/>
                            <?php _e( " Remember Me", 'zn_framework' ); ?>
                        </label>

                        <input type="submit" id="login" name="submit_button" class="btn zn_sub_button btn-fullcolor btn-md"
                               value="<?php _e( "LOG IN", 'zn_framework' ); ?>"/>

                        <input type="hidden" value="login" class="" name="zn_form_action"/>
                        <input type="hidden" value="zn_do_login" class="" name="action"/>
                        <input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect" name="submit"/>

                        <div class="links">
                            <?php if ( (bool) get_option( 'users_can_register' ) ) { ?>
                            <a href="#register_panel" class="create_account kl-login-box"><?php _e( "CREATE AN ACCOUNT", 'zn_framework' ); ?></a> <span class="sep"></span>
                            <?php } ?>
                            <a href="#forgot_panel" class="kl-login-box"><?php _e( "FORGOT YOUR PASSWORD?", 'zn_framework' ); ?></a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- end login panel -->

            <?php if ( (bool) get_option( 'users_can_register' ) ) { ?>

                <div id="register_panel" class="loginbox-popup register-popup mfp-hide">
                    <div class="inner-container register-panel">
                        <h3 class="m_title"><?php _e( "CREATE ACCOUNT", 'zn_framework' ); ?></h3>

                        <form id="register_form" name="login_form" method="post" class="zn_form_login"
                              action="<?php echo site_url( 'wp-login.php?action=register', 'login_post' ) ?>">
                            <div class="form-group kl-fancy-form kl-fw-form">
                                <input type="text" id="reg-username" name="user_login" class="form-control inputbox"
                                       placeholder="<?php _e( "type desired username", 'zn_framework' ); ?>"/>
                                <label><?php _e( "USERNAME", 'zn_framework' ); ?></label>
                            </div>
                            <div class="form-group kl-fancy-form kl-fw-form">
                                <input type="text" id="reg-email" name="user_email" class="form-control inputbox"
                                       placeholder="<?php _e( "your-email@website.com", 'zn_framework' ); ?>"/>
                                <label><?php _e( "EMAIL", 'zn_framework' ); ?></label>
                            </div>
                                <div class="form-group kl-fancy-form kl-fw-form">
                                <input type="password" id="reg-pass" name="user_password" class="form-control inputbox"
                                       placeholder="<?php _e( "*****", 'zn_framework' ); ?>"/>
                                <label><?php _e( "PASSWORD", 'zn_framework' ); ?></label>
                            </div>
                            <div class="form-group kl-fancy-form kl-fw-form">
                                <input type="password" id="reg-pass2" name="user_password2" class="form-control inputbox"
                                       placeholder="<?php _e( "*****", 'zn_framework' ); ?>"/>
                                <label><?php _e( "CONFIRM PASSWORD", 'zn_framework' ); ?></label>
                            </div>
                            <div class="form-group kl-fw-form">
                                <input type="submit" id="signup" name="submit" class="btn btn-block btn-fullcolor btn-md"
                                       value="<?php _e( "CREATE MY ACCOUNT", 'zn_framework' ); ?>"/>
                            </div>

                            <input type="hidden" value="register" name="zn_form_action"/>
                            <input type="hidden" value="zn_do_login" name="action"/>
                            <input type="hidden" value="<?php echo $current_url; ?>"
                                   class="zn_login_redirect" name="submit"/>

                            <div class="links">
                                <a href="#login_panel" class="kl-login-box"><?php _e( "ALREADY HAVE AN ACCOUNT?", 'zn_framework' ); ?></a>
                            </div>
                        </form>
                    </div>
                </div><!-- end register panel -->
            <?php } ?>

            <div id="forgot_panel" class="loginbox-popup forgot-popup mfp-hide">
                <div class="inner-container forgot-panel">
                    <h3 class="m_title"><?php _e( "FORGOT YOUR DETAILS?", 'zn_framework' ); ?></h3>
                    <form id="forgot_form" name="login_form" method="post" class="zn_form_lost_pass"
                          action="<?php echo site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ?>">
                        <div class="form-group kl-fancy-form kl-fw-form">
                            <input type="text" id="forgot-email" name="user_login" class="form-control inputbox"
                                   placeholder="<?php _e( "...", 'zn_framework' ); ?>"/>
                            <label><?php _e( "USERNAME OR EMAIL", 'zn_framework' ); ?></label>
                        </div>
                        <div class="form-group kl-fw-form">
                            <input type="submit" id="recover" name="submit" class="btn btn-block zn_sub_button btn-fullcolor btn-md"
                                   value="<?php _e( "SEND MY DETAILS!", 'zn_framework' ); ?>"/>
                        </div>
                        <div class="links">
                            <a href="#login_panel" class="kl-login-box"><?php _e( "AAH, WAIT, I REMEMBER NOW!", 'zn_framework' ); ?></a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end register panel -->
        </div><!-- end login register stuff -->
    <?php
    }
}

/**
 * Login Form - Stop redirecting if ajax is used
 */
if ( ! function_exists( 'zn_stop_redirecting' ) ) {
    /**
     * Login Form - Stop redirecting if ajax is used
     * @param $redirect_to
     * @param $request
     * @param $user
     * @hooked to login_redirect
     * @see functions.php
     * @return mixed
     */
    function zn_stop_redirecting( $redirect_to, $request, $user ){
        if ( empty ( $_POST['ajax_login'] ) ) {
            return $redirect_to;
        }
    }
}


/**
 * Frontend: Load theme's default stylesheets
 */
if(! function_exists('wpkLoadGlobalStylesheetsFrontend')) {
    /**
     * Frontend: Load theme's default stylesheets
     * @hooked to wp_enqueue_scripts.
     * @see functions.php
     */
    function wpkLoadGlobalStylesheetsFrontend()
    {

        //@since 4.0
        wp_enqueue_style( 'th-bootstrap-styles', THEME_BASE_URI . '/css/bootstrap.min.css', false, ZN_FW_VERSION );
        wp_enqueue_style( 'kallyas-styles', get_stylesheet_uri(), false, ZN_FW_VERSION );
        wp_enqueue_style( 'th-theme-template-styles', THEME_BASE_URI . '/css/template.css', array('kallyas-styles'), ZN_FW_VERSION );
        wp_enqueue_style( 'th-theme-print-stylesheet', THEME_BASE_URI . '/css/print.css', array('kallyas-styles'), ZN_FW_VERSION );

        // Woocommerce Own Stylesheet
        if ( znfw_is_woocommerce_active() ) {
            wp_enqueue_style( 'woocommerce-overrides', THEME_BASE_URI . '/css/kl-woocommerce.css', array('kallyas-styles'), ZN_FW_VERSION );
        }

        wp_enqueue_style( 'th-bs-responsive-styles', THEME_BASE_URI . '/css/bootstrap-responsive.css', array('th-theme-template-styles'), ZN_FW_VERSION );


        // Generated css file - The options needs to be saved in order to generate new file
        $uploads = wp_upload_dir();
        wp_enqueue_style( 'th-theme-options-styles', trailingslashit($uploads['baseurl']) . 'zn_dynamic.css', array('kallyas-styles'), ZN_FW_VERSION  );

    }
}

/**
 * Frontend: Load theme's default scripts
 */
if(! function_exists('wpkLoadGlobalScriptsFrontend')) {
    /**
     * Frontend: Load theme's default scripts
     * @hooked to wp_enqueue_scripts.
     * @see functions.php
     */
    function wpkLoadGlobalScriptsFrontend()
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'th-bootstrap-plugin', THEME_BASE_URI . '/js/bootstrap.min.js', array( 'jquery' ), ZN_FW_VERSION );
        wp_enqueue_script( 'modernizr', THEME_BASE_URI . '/js/modernizr.js', false, ZN_FW_VERSION );
        wp_enqueue_script( 'jquery-plugins', THEME_BASE_URI . '/js/plugins.js', array( 'jquery' ), ZN_FW_VERSION, true );

        // Adds JavaScript to pages with the comment form to support sites with
        // threaded comments (when in use).
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        // Register scripts without loading
        wp_register_script( 'isotope', THEME_BASE_URI . '/js/jquery.isotope.min.js',array ( 'jquery' ), ZN_FW_VERSION, true );
        wp_register_script( 'caroufredsel', THEME_BASE_URI . '/sliders/caroufredsel/jquery.carouFredSel-packed.js', array ( 'jquery' ), ZN_FW_VERSION, true );

        // Smooth Scroll
        if ( zget_option( 'smooth_scroll', 'general_options' , false, 'no' ) == 'yes' ) {
            wp_enqueue_script( 'smoothscroll', THEME_BASE_URI . '/addons/smoothscroll/smoothscroll.js', array ( 'jquery' ), ZN_FW_VERSION, true );
        }
    }
}

/**
 * Frontend: Only load scripts and stylesheets when needed
 */
if(! function_exists('wpkSmartScriptLoaderFrontend')) {
    /**
     * Frontend: Only load scripts and stylesheets when needed
     * @hooked to wp_enqueue_scripts.
     * @see functions.php
     */
    function wpkSmartScriptLoaderFrontend()
    {
//<editor-fold desc=">>> SCRIPTS">

        global $pagenow;

        // Event Countdown
        if ( zget_option( 'cs_enable', 'coming_soon_options', false, 'no' ) == 'yes' && ! is_user_logged_in() && ! is_admin() && $pagenow != 'wp-login.php' )
        {
            wp_enqueue_script( 'zn_event_countdown', THEME_BASE_URI . '/js/jquery.countdown.js', array ('jquery'), ZN_FW_VERSION, true );

            $cs_date = zget_option( 'cs_date', 'coming_soon_options' );
            // Pass data to the script
            $zn_event_countdown_coming_soon = array (
                'zn_event_countdown_coming_soon' =>
                    'var wpkCCSObject = {
                        years: "' . __( 'years', 'zn_framework' ) . '",
                        months: "' . __( 'months', 'zn_framework' ) . '",
                        weeks: "' . __( 'weeks', 'zn_framework' ) . '",
                        days: "' . __( 'days', 'zn_framework' ) . '",
                        hours: "' . __( 'hours', 'zn_framework' ) . '",
                        min: "' . __( 'min', 'zn_framework' ) . '",
                        sec: "' . __( 'sec', 'zn_framework' ) . '",
                        year: "' . __( 'year', 'zn_framework' ) . '",
                        month: "' . __( 'month', 'zn_framework' ) . '",
                        week: "' . __( 'week', 'zn_framework' ) . '",
                        day: "' . __( 'day', 'zn_framework' ) . '",
                        hour: "' . __( 'hour', 'zn_framework' ) . '",
                        date: "'.$cs_date['date'].'",
                        time: "'.$cs_date['time'].'"
                    }; '. WpkZn::getFileContents(THEME_BASE.'/js/inc/zn-event-countdown-coming-soon.inc.js')
            );
            zn_update_array( $zn_event_countdown_coming_soon );

            zn_update_array( array (
                'zn_mailchimp' => WpkZn::getFileContents(THEME_BASE.'/js/inc/zn-mailchimp.inc.js')
            ));
        }

        $res_menu_trigger = zget_option( 'header_res_width', 'general_options', false, 992 );
        // Load the theme scripts
        wp_enqueue_script( 'zn-script', THEME_BASE_URI . '/js/znscript.js', array ( 'jquery' ), ZN_FW_VERSION, true );
        wp_localize_script( 'zn-script', 'zn_do_login', array (
            'ajaxurl' => admin_url( 'admin-ajax.php', 'relative' ),
            'add_to_cart_text' => __( 'Item Added to cart!', 'zn_framework' ),
        ) );
        wp_localize_script( 'zn-script', 'ZnThemeAjax', array(
            'ajaxurl'          => admin_url( 'admin-ajax.php', 'relative' ),
            'zn_back_text'     => __( 'Back', 'zn_framework' ),
            'res_menu_trigger' => ( int )$res_menu_trigger,
        ) );

//</editor-fold desc=">>> SCRIPTS">
    }
}

/**
 * Check if the coming soon option enabled
 */
add_action( 'init', 'zn_coming_soon_page', 26 );
if ( ! function_exists( 'zn_coming_soon_page' ) ) {
    /**
     * Check if the coming soon option enabled
     * @hooked to init
     * @see functions.php
     */
    function zn_coming_soon_page(){
        global $pagenow;

        if ( zget_option( 'cs_enable', 'coming_soon_options', false, 'no' ) == 'yes' && !is_user_logged_in() && !is_admin() && $pagenow != 'wp-login.php') {
            get_template_part('page', 'coming-soon');
            exit();
        }

    }
}

/**
 * Check for boxed layout or full and add specific CSS class by filter
 */
if ( ! function_exists( 'zn_body_class_names' ) ) {
    /**
     * Check for boxed layout or full and add specific CSS class by filter
     * @param $classes
     * @hooked to body_class
     * @see functions.php
     * @return array
     */
    function zn_body_class_names( $classes ){

        $zn_home_boxed_layout = zget_option( 'zn_home_boxed_layout', 'layout_options', false, 'def' );
        if ( ( zget_option( 'zn_boxed_layout', 'layout_options', false, 'no' ) == 'yes' ) ||
            ( is_front_page() && $zn_home_boxed_layout == 'yes' ) ) {
            $classes[] = 'boxed';
        }
        if ( is_front_page() && $zn_home_boxed_layout == 'no' ) {
            $classes = array_diff( $classes, array ( "boxed" ) );
        }

        if ( zget_option('zn_width','layout_options') == '1170' ) {
            $classes[] = 'res1170';
        }
        elseif ( zget_option('zn_width','layout_options') == '960' ) {
            $classes[] = 'res960';
        }

        if ( zget_option( 'menu_follow', 'general_options' , false, 'no' ) == 'yes' ) {
            $classes[] = 'kl-follow-menu';
        } else if( zget_option( 'menu_follow', 'general_options' , false, 'no' ) == 'sticky' ) {
            $classes[] = 'kl-sticky-header';
        }

        if ( zget_option( 'scrollspy_menu', 'general_options' , false, 'no' ) == 'yes' ) {
            $classes[] = 'kl-scrollspy';
        }

        /*
            Commented as per https://github.com/hogash/kallyas/issues/232
         */
        // $classes[] = zget_option( 'zn_slider_header', 'layout_options', false, 'no' ) == 'yes' ? 'slider_after_header' : 'th-header-absolute';

        return $classes;
    }
}


//<editor-fold desc=">>> AFTER_BODY ACTIONS">
/**
 * Add page loading
 */
if ( ! function_exists( 'zn_add_page_loading' ) ) {
    /**
     * Add page loading
     * @hooked to zn_after_body
     * @see functions.php
     */
    function zn_add_page_loading(){
        zn_page_loading();
    }
}

/**
 * Add the Support Panel
 */
if ( ! function_exists( 'zn_add_hidden_panel' ) ) {
    /**
     * Add the Support Panel
     * @hooked to zn_after_body
     * @see functions.php
     */
    function zn_add_hidden_panel(){
        zn_hidden_pannel();
    }
}

/**
 * Display the login form
 */
if ( ! function_exists( 'zn_add_login_form' ) ) {
    /**
     * Display the login form
     * @hooked to zn_after_body
     * @see functions.php
     */
    function zn_add_login_form(){
        zn_login_form();
    }
}

/**
 * Open Graph
 */
if ( ! function_exists( 'zn_add_open_graph' ) ) {
    /**
     * Open Graph
     * @hooked to zn_after_body
     * @see functions.php
     */
    function zn_add_open_graph(){
        ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <?php
    }
}

//</editor-fold desc=">>> AFTER_BODY ACTIONS">


//<editor-fold desc=">>> ZN_HEAD_RIGHT_AREA">

/**
 * Add navigation menu to the Top Area
 */
if ( ! function_exists( 'zn_add_navigation' ) ) {
    /**
     * Add navigation menu to the Top Area
     * @hooked to zn_head_right_area
     * @see functions.php
     */
    function zn_add_navigation(){
        if ( has_nav_menu( 'header_navigation' ) ) {
            $header_topnav_dd = zget_option( 'header_topnav_dd' , 'general_options', false, 'yes' );
            if( $header_topnav_dd == 'yes' ) {
                echo '<div class="zn_header_top_nav-wrapper ">';
                    echo '<span class="headernav-trigger js-toggle-class" data-target=".zn_header_top_nav-wrapper" data-target-class="is-opened"></span>';
                    zn_show_nav( 'header_navigation', 'zn_header_top_nav topnav' );
                echo '</div>';
            } else {
                zn_show_nav( 'header_navigation', ' topnav' );
            }
        }
    }
}

/**
 * Add Right content to action
 */
if ( ! function_exists( 'zn_hidden_pannel_link' ) ) {
    /**
     * Add Right content to action
     * @hooked to zn_head_right_area
     * @see functions.php
     */
    function zn_hidden_pannel_link(){
        if ( is_active_sidebar( 'hiddenpannelsidebar' ) ) {

            $title = zget_option( 'hidden_panel_title', 'general_options', false, __( 'SUPPORT', 'zn_framework' ) );

            ?>
            <ul class="topnav navRight topnav--sliding-panel">
                <li>
                    <a href="#" id="open_sliding_panel">
                        <i class="glyphicon glyphicon-remove-circle kl-icon-white"></i>
                        <i class="glyphicon glyphicon-info-sign kl-icon-white visible-xs xs-icon"></i>
                        <span class="hidden-xs"><?php echo $title; ?></span>
                    </a>
                </li>
            </ul>
        <?php
        }
    }
}

/**
 * Login Form - Login/logout text
 */
if ( ! function_exists( 'zn_login_text' ) ) {
    /**
     * Login Form - Login/logout text
     * @hooked to zn_head_right_area
     * @see functions.php
     */
    function zn_login_text(){

        // CHECK IF OPTION IS ENABLED
        if ( ! zget_option( 'head_show_login', 'general_options', false, 1 ) ) {
            return;
        }

        if ( is_user_logged_in() ) {
            echo '<ul class="topnav navRight topnav--log"><li><a href="' . wp_logout_url( home_url( '/' ) ) . '">';
            echo '<i class="glyphicon glyphicon-log-out visible-xs xs-icon"></i>';
            echo '<span class="hidden-xs">' . __( "LOGOUT", 'zn_framework' ) . '</span>';
            echo '</a></li></ul>';
            return;
        }
        echo '<ul class="topnav navRight topnav--log"><li><a href="#login_panel" class="kl-login-box">';
        echo '<i class="glyphicon glyphicon-log-in visible-xs xs-icon"></i>';
        echo '<span class="hidden-xs">'. __( "LOGIN", 'zn_framework' ) . '</span>';
        echo '</a></li></ul>';
    }
}

/**
 * Show header social icons
 */
if ( ! function_exists( 'zn_header_social_icons' ) ) {
    /**
     * Show header social icons
     * @hooked to zn_head_right_area
     * @see functions.php
     */
    function zn_header_social_icons(){

        if ( zget_option( 'social_icons_visibility_status', 'general_options', false, 'yes' ) == 'yes' )
        {
            if ( $header_social_icons = zget_option( 'header_social_icons', 'general_options', false, array() ) )
            {

                $icon_class = zget_option( 'header_which_icons_set', 'general_options', false, 'normal' );

                echo '<ul class="social-icons sc--' . $icon_class . ' topnav navRight">';

                foreach ( $header_social_icons as $key => $icon ) {
                    // print_r($icon);
                    $link = '';
                    $target = '';
                    if ( isset ( $icon['header_social_link'] ) && is_array( $icon['header_social_link'] ) ) {
                        $link = $icon['header_social_link']['url'];
                        $target = 'target="' . $icon['header_social_link']['target'] . '"';
                    }
                    $icon_color = '';
                    if($icon_class != 'normal' && $icon_class != 'clean'){
                        $icon_color = isset($icon['header_social_color']) && !empty($icon['header_social_color']) ? $icon['header_social_icon']['unicode'] : 'nocolor';
                    }
                    $social_icon = !empty( $icon['header_social_icon'] )  ? '<a href="' . $link . '" '.zn_generate_icon( $icon['header_social_icon'] ).' ' . $target . ' class="scheader-icon-'.$icon_color.'" title="' . $icon['header_social_title'] . '"></a>' : '';
                    echo '<li>'.$social_icon.'</li>';
                    // echo '<li><a href="' . $link . '" class="sc-icon-' . str_replace('social-', '', $icon['header_social_icon']) . '" ' . $target . ' title="' . $icon['header_social_title'] . '"></a></li>';
                }
                echo '</ul>';
            }
        }
    }
}



/**
 * WPML language switcher
 */
if ( ! function_exists( 'zn_wpml_language_switcher' ) ) {
    /**
     * WPML language switcher
     * @hooked to zn_head_right_area
     * @see functions.php
     */
    function zn_wpml_language_switcher(){
        if ( function_exists( 'icl_get_languages' ) ) {

            if ( zget_option( 'head_show_flags', 'general_options', false, 1 ) ) {
                echo '<ul class="topnav navLeft topnav--lang">';
                echo '<li class="languages drop"><a href="#"><span class="glyphicon glyphicon-globe kl-icon-white xs-icon"></span> ';
                echo '<span class="hidden-xs">'. __( "LANGUAGES", 'zn_framework' ) . '</span>';
                echo '</a>';
                echo '<div class="pPanel">';
                echo '<ul class="inner">';

                $languages = icl_get_languages( 'skip_missing=0' );

                if ( 1 < count( $languages ) ) {
                    foreach ( $languages as $l ) {
                        $active = '';
                        $icon = '</a></li>';
                        if ( $l['active'] ) {
                            $active = 'active';
                            $icon = '<span class="glyphicon glyphicon-ok"></span></a></li>';
                        }
                        echo '<li class="toplang-item ' . $active . '"><a href="' . $l['url'] . '"><img src="' . $l['country_flag_url'] . '" alt="' . $l['native_name'] . '" class="toplang-flag" /> '. $l['native_name'] . ' ' . $icon . '';
                    }
                }
                echo '</ul>';
                echo '</div>';
                echo '</li>';
                echo '</ul>';
            }
        }
    }
}
//</editor-fold desc=">>> ZN_HEAD_RIGHT_AREA">


/**
 * Retrieve the post attachment URL
 */
if ( ! function_exists( 'echo_first_image' ) ) {
    /**
     * Retrieve the post attachment URL
     * @return bool|string
     */
    function echo_first_image(){
        global $post;

        $id = $post->ID;

        // Check if the post has any images
        $post = get_post( $id );

        preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );

        if(isset($matches[1][0])){
            if ( ! empty( $matches[1][0] ) && basename( $matches[1][0] ) != 'trans.gif' ) {
                return esc_url( $matches[1][0] );
            }
            elseif (isset($matches[1][1]) && ! empty( $matches[1][1] ) ) {
                return esc_url( $matches[1][1] );
            }
        }

        return '';
    }
}

/**
 * Login system
 */
if ( ! function_exists( 'zn_do_login' ) ) {
    /**
     * Login system
     * @hooked to wp_ajax_nopriv_zn_do_login
     * @see functions.php
     */
    function zn_do_login(){
        // @wpk: pre-validate request
        $rm = strtoupper($_SERVER['REQUEST_METHOD']);
        if('POST' !== $rm){
            exit(__('Invalid request.', 'zn_framework'));
        }
        if(! isset($_POST['zn_form_action'])){
            exit(__('Invalid request.', 'zn_framework'));
        }
        if(! in_array($_POST['zn_form_action'], array('login', 'register', 'reset_pass'))){
            exit(__('Invalid request.', 'zn_framework'));
        }
        if ( $_POST['zn_form_action'] == 'login' )
        {
            $user = wp_signon();

            if ( is_wp_error( $user ) ) {
                echo '<div id="login_error">' . $user->get_error_message() . '</div>';
            }
            else {
                echo 'success';
            }
            exit;
        }
        elseif ( $_POST['zn_form_action'] == 'register' )
        {
            $zn_error         = false;
            $zn_error_message = array ();

            // Defaults
            $password =
            $username =
            $username =
            $email = '';

            if ( ! empty( $_POST['user_login'] ) ) {
                if ( username_exists( $_POST['user_login'] ) ) {
                    $zn_error           = true;
                    $zn_error_message[] = __( 'The username already exists', 'zn_framework' );
                }
                else {
                    $username = $_POST['user_login'];
                }
            }
            else {
                $zn_error           = true;
                $zn_error_message[] = __( 'Please enter an username', 'zn_framework' );
            }

            if ( ! empty( $_POST['user_password'] ) ) {
                $password = $_POST['user_password'];
            }
            else {
                $zn_error           = true;
                $zn_error_message[] = __( 'Please enter a password', 'zn_framework' );
            }

            if ( ( empty( $_POST['user_password'] ) && empty( $_POST['user_password2'] ) ) || $_POST['user_password'] != $_POST['user_password2'] ) {
                $zn_error           = true;
                $zn_error_message[] = __( 'Passwords do not match', 'zn_framework' );
            }

            if ( ! empty( $_POST['user_email'] ) ) {
                if ( ! email_exists( $_POST['user_email'] ) ) {
                    if ( ! filter_var( $_POST['user_email'], FILTER_VALIDATE_EMAIL ) ) {
                        $zn_error           = true;
                        $zn_error_message[] = __( 'Please enter a valid EMAIL address', 'zn_framework' );
                    }
                    else {
                        $email = $_POST['user_email'];
                    }
                }
                else {
                    $zn_error           = true;
                    $zn_error_message[] = __( 'This email address has already been used', 'zn_framework' );
                }
            }
            else {
                $zn_error = true;
                $zn_error_message[] = __( 'Please enter an email address', 'zn_framework' );
            }

            if ( $zn_error ) {
                echo '<div id="login_error">';

                foreach ( $zn_error_message as $error ) {
                    echo $error . '<br />';
                }
                echo '</div>';
            }
            else {
                $user_data = array (
                    'ID'           => '',
                    'user_pass'    => $password,
                    'user_login'   => $username,
                    'display_name' => $username,
                    'user_email'   => $email,
                    // Use default role or another role, e.g. 'editor'
                    'role'         => get_option( 'default_role' )
                );

                $user_id = wp_insert_user( $user_data );

                if ( ! function_exists( 'wp_new_user_notification' ) ) {
                    include_once( trailingslashit( ABSPATH ) . 'wp-includes/pluggable.php' );
                }
                wp_new_user_notification( $user_id, $password );

                echo '<div id="login_error">' . __( 'Your account has been created. You can now login.', 'zn_framework' ) . '</div>';
            }
            exit;
        }
        elseif ( $_POST['zn_form_action'] == 'reset_pass' )
        {
            echo do_action( 'login_form', 'resetpass' );
        }
    }
}

//<editor-fold desc=">>> WPK">

/**
 * Display the Info Card when you hover over the logo.
 * This function is also available as an action: zn_show_infocard
 */
if ( ! function_exists( 'kfn_showInfoCard' ) ) {
    /**
     * Display the Info Card when you hover over the logo.
     * This function is also available as an action: zn_show_infocard
     * @hooked to zn_show_infocard
     * @see functions.php
     */
    function kfn_showInfoCard(){
        global $get_stylesheet_directory_uri;

        if ( zget_option( 'infocard_display_status', 'general_options', false, 'no' ) == 'no' ) {
            return;
        }

        $logoUrl        = zget_option( 'infocard_logo_url', 'general_options' );
        $cpyDesc        = zget_option( 'infocard_company_description', 'general_options', false, '' );
        $phone          = zget_option( 'infocard_company_phone', 'general_options', false, '' );
        $email          = zget_option( 'infocard_company_email', 'general_options', false, '' );
        $cpyName          = zget_option( 'infocard_company_name', 'general_options', false, '' );
        $address          = zget_option( 'infocard_company_address', 'general_options', false, '' );
        $mapLink          = zget_option( 'infocard_gmap_link', 'general_options', false, '' );
        $socialIcons          = zget_option( 'header_social_icons', 'general_options', false, null );

        ?>

        <div id="infocard" class="logo-infocard">
            <div class="custom ">
                <div class="row">
                    <div class="col-sm-5">
                        <p>&nbsp;</p>
                        <?php if( !empty( $logoUrl ) ): ?>
                        <p style="text-align: center;"><img src="<?php echo $logoUrl;?>" alt=""></p>
                        <?php endif; ?>
                        <p style="text-align: center;"><?php echo $cpyDesc;?></p>
                    </div>

                    <div class="col-sm-7">
                        <div class="custom contact-details">
                            <p><strong><?php echo $phone;?></strong><br><?php _e( 'Email:', 'zn_framework' );?>&nbsp;<a
                                    href="mailto:<?php echo $email;?>"><?php echo $email;?></a></p>
                            <p><?php echo $cpyName . '<br/>' . $address;?></p>
                            <a href="<?php echo $mapLink;?>" target="_blank" class="map-link"><span
                                    class="glyphicon glyphicon-map-marker kl-icon-white"></span>
                                <span><?php _e( 'Open in Google Maps', 'zn_framework' );?></span></a>
                        </div>

                        <div style="height:20px;"></div>

                        <?php
                        if ( ! empty( $socialIcons ) ) {
                            echo '<ul class="social-icons sc--clean">';
                            foreach ( $socialIcons as $i => $entry ) {
                                $titleAttr  = esc_attr( $entry['header_social_title'] );
                                $url        = $entry['header_social_link']['url'];
                                $targetAttr = esc_attr( $entry['header_social_link']['target'] );
                                $icon       = $entry['header_social_icon'];
                                $social_icon = '<a href="' . $url . '" '.zn_generate_icon( $icon ).' target="' . $targetAttr . '" title="' . $titleAttr . '"></a>';
                                echo '<li>'.$social_icon.'</li>';
                                // echo '<li>';
                                // echo '<a title="' . $titleAttr . '" class="sc-icon-' . str_replace('social-', '', $icon) . '" href="' . $url . '" target="' . $targetAttr . '"></a>';
                                // echo '</li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}

/*
 * Display the dismissible admin notice regarding the usage of the Cute3D Slider
 */
if ( ! function_exists( 'kallyasShowCuteSliderNotice' ) ) {
    /**
     * Display the notification regarding the usage of the 3D Cute Slider
     */
    function kallyasShowCuteSliderNotice()
    {
        do_action( 'wpk_dismissible_notice',
            'error',
            __( 'The plugin 3D Cute Slider is no longer supported by its author and it was removed from Envato Marketplace.
            We will try to continue offering support for it as much as we can but we strongly recommend you to replace its
            usage with an other slider or continue using it at your own risk.', 'zn_framework' ),
            'kallyas-dismiss-notice' );
    }
}

/**
 * Add option to select custom header in Edit Category page
 */
if ( ! function_exists( 'wpk_zn_edit_category_form' ) ) {
    /**
     * Add option to select custom header in Edit Category page
     * @param $term
     * @hooked to sanitize_text_field( $_REQUEST['taxonomy'] ) . '_edit_form'
     * @see functions.php
     */
    function wpk_zn_edit_category_form( $term )
    { ?>
        <h2><?php _e( 'Kallyas Options', 'zn_framework' ); ?></h2>
        <table class="form-table">
            <tbody>
            <tr class="form-field form-required term-name-wrap">
                <th scope="row">
                    <label for="wpk_zn_select_custom_header"><?php _e( 'Select header', 'zn_framework' ); ?></label>
                </th>
                <td>
                    <?php
                    // GET ALL CUSTOM HEADERS
                    $allHeaders = WpkZn::getThemeHeaders(true);
                    if ( ! empty( $allHeaders ) ) {
                        echo '<select name="wpk_zn_select_custom_header" id="wpk_zn_select_custom_header">';
                        // Check option to display the previously checked option
                        $optData      = get_option( 'wpk_zn_select_custom_header_' . $term->term_id );
                        $selectedSlug = 'zn_def_header_style'; // use default by default
                        if ( ! empty( $optData ) ) {
                            $selectedSlug = $optData;
                        }
                        foreach ( $allHeaders as $slug => $name ) {
                            echo '<option value="' . $slug . '"';
                            if ( $slug == $selectedSlug ) {
                                echo ' selected="selected"';
                            }
                            echo '>' . $name . '</option>';
                        }
                        echo '</select>';
                    }
                    ?>
                    <p class="description"><?php _e( 'The custom header you want to display for this category.', 'zn_framework' ); ?></p>
                </td>
            </tr>
            </tbody>
        </table>
    <?php
    }
}

/**
 * Save the custom header set in the edit category screen
 */
if ( ! function_exists( 'wpk_zn_filterProductCatPost' ) ) {
    /**
     * Save the custom header set in the edit category screen
     */
    function wpk_zn_filterProductCatPost(){
        if ( 'POST' == strtoupper($_SERVER['REQUEST_METHOD']) ) {
            if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'editedtag' ) ) {
                if ( isset( $_POST['taxonomy'] ) ) {
                    if ( isset( $_POST['wpk_zn_select_custom_header'] ) && ! empty( $_POST['wpk_zn_select_custom_header'] ) ) {
                        if ( isset( $_POST['tag_ID'] ) && ! empty( $_POST['tag_ID'] ) ) {
                            $customHeaderSlug = sanitize_text_field( $_POST['wpk_zn_select_custom_header'] );
                            if(  $_POST['wpk_zn_select_custom_header'] == 'zn_def_header_style' ){
                                delete_option( 'wpk_zn_select_custom_header_' . absint( $_POST['tag_ID'] ) );
                            }
                            else{
                                update_option( 'wpk_zn_select_custom_header_' . absint( $_POST['tag_ID'] ), $customHeaderSlug );
                            }
                        }
                    }
                }
            }
        }
    }
}

/*--------------------------------------------------------------------------------------------------
    Logo SEO function
--------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'zn_kl_logo' ) ) {
    function zn_kl_logo( $logo = null , $use_transparent = false , $tag = null , $class = null ) {
        if( zget_option( 'head_show_logo', 'general_options', false, 'yes' ) == 'no' ){ return; }
        if ( !$tag ) {
            if ( is_front_page() ) {
                $tag = 'h1';
            }
            else{
                $tag = 'h3';
            }
        }
        if ( $logo || $logo = zget_option( 'logo_upload', 'general_options' ) ) {
            $hwstring = '';
            // Check if logo size has Custom size
            if( ( $logo_size = zget_option( 'logo_size', 'general_options' ) ) == 'no' ){
                $logo_size = zget_option( 'logo_manual_size', 'general_options' );
                $hwstring = image_hwstring( $logo_size['width'], $logo_size['height'] );
            }
            $logoimg = '';
            // Sticky logom only when available and Sticky Header is selected in MenuFollow option (General options)
            if($logoSticky = zget_option('logo_sticky', 'general_options')){
                if ( zget_option('menu_follow', 'general_options') ) {
                    $logoimg .= '<img class="logo-img-sticky" src="'.set_url_scheme( $logoSticky ).'"  alt="'.get_bloginfo('name').'" title="'.get_bloginfo('description').'" />';
                }
            }
            // Logo
            $logoimg .= '<img class="logo-img" src="'.set_url_scheme( $logo ).'" '.$hwstring.' alt="'.get_bloginfo('name').'" title="'.get_bloginfo('description').'" />';
            $logo = "<$tag class='site-logo logo $class' id='logo'><a href='".home_url('/')."'>".$logoimg."</a></$tag>";
        }
        else{
            // THIS IS JUST FOR TEXT
            $logo = '<'.$tag.' id="logo" class="site-logo logo"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></'.$tag.'>';
        }
        return $logo;
    }
}

//</editor-fold desc=">>> WPK">

/** Rev slider : hide update notices **/
if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'zn_set_revslider_as_theme' );
	function zn_set_revslider_as_theme() {
		set_revslider_as_theme();
	}
}

/** Add support for new title tag in WP 4.1 **/
if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function zn_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'zn_render_title' );
}

/** Change default pagination prev and next text with icons */
add_filter( 'zn_pagination', 'zn_change_pagination_texts' );
function zn_change_pagination_texts( $args ){
        $args['previous_text'] = '<span class="zn_icon" data-zniconfam="glyphicons_halflingsregular" data-zn_icon="&#xe257;"></span>';
        $args['older_text'] = '<span class="zn_icon" data-zniconfam="glyphicons_halflingsregular" data-zn_icon="&#xe258;"></span>';
    return $args;
}

// Chrome v45 admin menu fix
function chromefix_inline_css()
{
    if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) !== false )
    {
        wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0); }' );
    }
}
add_action('admin_enqueue_scripts', 'chromefix_inline_css');


if(! function_exists('th_wpml_get_url_for_language')) {
    /**
     * Retrieve the appropriate url for the specified $language. Requires WPML installed and active.
     *
     * @param string $original_url
     * @see:
     * @return string
     */
    function th_wpml_get_url_for_language( $original_url )
    {
        // Check if WPML plugin active and get the View Page url for the selected language
        if(! function_exists('is_plugin_active')){
            include_once(ABSPATH.'wp-admin/includes/plugin.php');
        }
        if(is_plugin_active('sitepress-multilingual-cms/sitepress.php') && defined('ICL_LANGUAGE_CODE')) {
            $post_id = url_to_postid( $original_url );
            $lang_post_id = icl_object_id( $post_id, 'page', true, ICL_LANGUAGE_CODE );
            $url = '';
            if ( $lang_post_id != 0 ) {
                $url = get_permalink( $lang_post_id );
            }
            else {
                // No page found, it's most likely the homepage
                global $sitepress;
                if(isset($sitepress) && is_object($sitepress)) {
                    $url = $sitepress->language_url( ICL_LANGUAGE_CODE );
                }
            }
            return $url;
        }
        return $original_url;
    }
}

/**
 * Resolved pagination of custom queries on homepage
 */
add_filter('redirect_canonical','pif_disable_redirect_canonical');
function pif_disable_redirect_canonical($redirect_url) {
    if ( is_front_page() && get_query_var('page') ) $redirect_url = false;
    return $redirect_url;
}