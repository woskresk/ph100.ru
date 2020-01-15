<?php get_header();

	$headerClass = zget_option( '404_header_style', 'zn_404_options', false, 'zn_def_header_style' );
	if( $headerClass != 'zn_def_header_style' ) {
		$headerClass = 'uh_'.$headerClass;
	}


	WpkPageHelper::zn_get_subheader( array( 'headerClass' => $headerClass, 'def_header_bread' => false, 'def_header_date' => false, 'def_header_title' => false ) );
?>
	<div class="error404-page">

		<section id="content" class="site-content" >
			<div class="container">

				<div id="mainbody">

					<div class="row">
						<div class="col-sm-12">

							<div class="error404-content">
								<h2><span>404</span></h2>
								<h3><?php echo __("The page cannot be found.",'zn_framework');?></h3>
							</div>

						</div>

	                    <div class="col-sm-12">
	                        <?php get_search_form(); ?>
	                    </div>
					</div><!-- end row -->

				</div><!-- end mainbody -->

			</div><!-- end container -->
		</section><!-- end #content -->
	</div>

<?php get_footer(); ?>
</div>
