<?php if(! defined('ABSPATH')){ return; }
/**
 * Template layout for single entries
 * @package  Kallyas
 * @author   Team Hogash
 */
get_header();

/*** USE THE NEW HEADER FUNCTION **/
WpkPageHelper::zn_get_subheader();


// Check to see if the page has a sidebar or not
$main_class = zn_get_sidebar_class('single_sidebar');
if( strpos( $main_class , 'right_sidebar' ) !== false || strpos( $main_class , 'left_sidebar' ) !== false ) { $zn_config['sidebar'] = true; } else { $zn_config['sidebar'] = false; }
$zn_config['size'] = $zn_config['sidebar'] ? 'col-sm-9' : 'col-sm-12';

?>

	<section id="content" class="site-content" >
		<div class="container">
			<div class="row">

				<!--// Main Content: page content from WP_EDITOR along with the appropriate sidebar if one specified. -->
				<div class="<?php echo $main_class;?>">
					<div id="th-content-post">
						<?php
						while ( have_posts() ) : the_post();
							get_template_part( 'inc/page', 'content-view-post.inc' );
						endwhile;

						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>
					</div><!--// #th-content-post -->
				</div>

				<?php get_sidebar(); ?>
			</div>
		</div>
	</section><!--// #content -->
<?php
get_footer();
