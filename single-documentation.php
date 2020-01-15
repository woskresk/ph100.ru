<?php if(! defined('ABSPATH')){ return; }
/**
 * Template layout for single documentation entries
 * @package  Kallyas
 * @author   Team Hogash
 */
get_header();

/*** USE THE NEW HEADER FUNCTION **/
WpkPageHelper::zn_get_documentation_header();

/*
 * Import global variables
 */
global $post;

if(!isset($post) || !isset($post->ID)){
    return;
}

/*--------------------------------------------------------------------------------------------------
	CONTENT AREA
--------------------------------------------------------------------------------------------------*/
?>
<section id="content" class="site-content" >
    <div class="container">
        <div id="mainbody">
            <div class="row">
                <?php while ( have_posts() ) : the_post();
                    ?>
                    <div class="col-sm-12 post-<?php the_ID(); ?>">
                        <div class="zn_doc_breadcrumb fixclear">
                            <?php _e( "YOU ARE HERE:", 'zn_framework' ); ?>
                            <?php
                            echo '<span><a href="' . get_site_url() . '">' . __( "HOME", 'zn_framework' ) . '</a></span>';
                            if ( is_tax( 'documentation_category' ) ) {

                                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                                $parents = array ();
                                $parent  = $term->parent;
                                while ( $parent ) {
                                    $parents[]  = $parent;
                                    $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                                    $parent     = $new_parent->parent;
                                }

                                if ( ! empty( $parents ) ) {
                                    $parents = array_reverse( $parents );
                                    foreach ( $parents as $parent ) {
                                        $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                                        echo '<span><a href="' . get_term_link( $item->slug, 'documentation_category' ) . '">' . $item->name . '</a></span>';
                                    }
                                }

                                $queried_object = $wp_query->get_queried_object();
                                echo '<span>' . $queried_object->name . '</span>';
                            }
                            elseif ( is_search() ) {
                                echo '<span>' . __( "Search results for ", 'zn_framework' ) . '"' . get_search_query() . '"</span>';
                            }
                            elseif ( is_single() ) {
                                // Show category name
                                $cats = get_the_term_list( $post->ID, 'documentation_category', '', '|zn_preg|', '|zn_preg|' );
                                $cats = explode( '|zn_preg|', $cats );

                                if ( ! empty ( $cats[0] ) ) {

                                    echo '<span>' . $cats[0] . '</span>';
                                }

                                // Show post name
                                echo '<span>' . get_the_title() . '</span>';
                            }
                            ?>
                        </div>
                        <div class="clear"></div>

                        <h1 class="page-title"><?php the_title(); ?></h1>

                        <div class="itemView clearfix eBlog">

                            <div class="itemBody">
                                <!-- Blog Content -->
                                <?php the_content(); ?>
                            </div>
                            <!-- end item body -->

                            <div class="clear"></div>
                        </div>
                        <!-- End Item Layout -->
                    </div>
                <?php endwhile;
                wp_reset_query(); ?>
            </div>
        </div><!--// End #mainbody -->
    </div><!--// End .col-sm-12 -->
</section>

<?php get_footer(); ?>
