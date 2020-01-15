<?php if(! defined('ABSPATH')){ return; }
/**
 * Template layout for ARCHIVES
 * @package  Kallyas
 * @author   Team Hogash
 */
get_header();
/*** USE THE NEW HEADER FUNCTION **/
	//** Put the header with title and breadcrumb
	$title = zn_archive_title();
	WpkPageHelper::zn_get_subheader( array( 'title' => $title ) );

	// Check to see if the page has a sidebar or not
	$main_class = zn_get_sidebar_class('archive_sidebar');
	if( strpos( $main_class , 'right_sidebar' ) !== false || strpos( $main_class , 'left_sidebar' ) !== false ) { $zn_config['sidebar'] = true; } else { $zn_config['sidebar'] = false; }
	$zn_config['size'] = $zn_config['sidebar'] ? 'col-sm-9' : 'col-sm-12';

?>
<section id="content" class="site-content" >
	<div class="container">
		<div class="row">

			<div id="th-content-archive" class="<?php echo $main_class;?>">

				<?php
				$columns = zget_option( 'blog_style_layout', 'blog_options', false, '1' );
				if ( $columns > 1 ) {
					get_template_part( 'blog', 'columns' );
				}
				else {
					get_template_part( 'blog', 'default' );
				}
				?>
			</div><!--// #th-content-archive -->

			<?php get_sidebar(); ?>
		</div>
	</div>
</section><!--// #content -->
<?php get_footer();
