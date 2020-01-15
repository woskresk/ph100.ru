<?php if(! defined('ABSPATH')){ return; }
/**
 * This is the template layout for pages.
 * Template Name: ui
 * @package  Kallyas
 * @author   Team Hogash
 */

get_header();

WpkPageHelper::zn_get_subheader();


?>
<div class="container" style="width: 500px; height: 200px; background-color: red;"></div>
<!--// Main Content: page content from WP_EDITOR along with the appropriate sidebar if one specified. -->
    <section id="content" class="site-content" >
        <div class="container">
            <div class="row">
                <div class="<?php echo $main_class;?>">
                    <div id="th-content-page">
                        <?php
                        while ( have_posts() ) : the_post();
                            get_template_part( 'inc/page', 'content-view-page.inc' );
                        endwhile;

                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>
                    </div><!--// #th-content-page -->
                </div><!--// #th-content-page wrapper -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </section><!--// #content -->

<?php get_footer(); ?>
