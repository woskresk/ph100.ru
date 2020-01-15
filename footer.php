<?php
if ( zget_option( 'footer_show', 'general_options', false, 'yes' ) == 'yes' ) { ?>
	<footer id="footer" class="site-footer">
		<div class="container">
			<?php

				if ( zget_option( 'footer_row1_show', 'general_options', false, 'yes' ) == 'yes' ) {

					echo '<div class="row">';

					$footer_row1_widget_positions = zget_option( 'footer_row1_widget_positions', 'general_options', false, '{"3":[["4","4","4"]]}' );
					$columns_array = json_decode( stripslashes( $footer_row1_widget_positions ), true );
					$number_of_columns = is_array( $columns_array ) ? key( $columns_array ) : 1;

					for ( $i = 1; $i <= $number_of_columns; $i ++ ) {
						echo '<div class="col-sm-' . $columns_array[ $number_of_columns ][0][ $i - 1 ] . '">';
						if ( ! dynamic_sidebar( 'Footer row 1 - widget ' . $i . '' ) ) : endif;
						echo '</div>';
					}

					echo '</div><!-- end row -->';
				}


				if ( zget_option( 'footer_row2_show', 'general_options', false, 'yes' ) == 'yes' ) {

					echo '<div class="row">';

					$footer_row2_widget_positions = zget_option( 'footer_row2_widget_positions', 'general_options', false, '{"3":[["4","4","4"]]}' );
					$columns_array = json_decode( stripslashes( $footer_row2_widget_positions ), true );
					$number_of_columns = is_array( $columns_array ) ? key( $columns_array ) : 1;

					for ( $i = 1; $i <= $number_of_columns; $i ++ ) {
						echo '<div class="col-sm-' . $columns_array[ $number_of_columns ][0][ $i - 1 ] . '">';
						if ( ! dynamic_sidebar( 'Footer row 2 - widget ' . $i . '' ) ) : endif;
						echo '</div>';
					}

					echo '</div><!-- end row -->';
				}

			?>

			<div class="row">
				<div class="col-sm-12">
					<div class="bottom clearfix">

						<?php
						// Footer menu
						if ( has_nav_menu( 'footer_navigation' ) ) {
							echo '<div class="zn_footer_nav-wrapper">';
								zn_show_nav( 'footer_navigation', 'topnav footer_nav', array( 'depth' => '1' ) );
							echo '</div>';
						}
						?>

						<?php

						if ( zget_option( 'footer_social_icons_enable', 'general_options', false, 'yes' ) == 'yes' )
        				{
							$footer_social_icons = zget_option( 'footer_social_icons', 'general_options', false, array() );
							if ( ! empty ( $footer_social_icons ) ) {

								$icon_class = zget_option( 'footer_which_icons_set', 'general_options', false, 'normal' );

								echo '<ul class="social-icons sc--' . $icon_class . ' clearfix">';
									echo '<li class="title">' . __( 'GET SOCIAL', 'zn_framework' ) . '</li>'; // Translate

									foreach ( $footer_social_icons as $key => $icon ) {

										$link   = '';
										$target = '';

										if ( isset ( $icon['footer_social_link'] ) && is_array( $icon['footer_social_link'] ) ) {
											$link   = $icon['footer_social_link']['url'];
											$target = 'target="' . $icon['footer_social_link']['target'] . '"';
										}
										$icon_color = '';
										if($icon_class != 'normal' && $icon_class != 'clean'){
											$icon_color = isset($icon['footer_social_color']) && !empty($icon['footer_social_color']) ? $icon['footer_social_icon']['unicode'] : 'nocolor';
										}
					                    $social_icon = !empty( $icon['footer_social_icon'] )  ? '<a '.zn_generate_icon( $icon['footer_social_icon'] ).' href="' . $link . '" ' . $target . ' title="' . $icon['footer_social_title'] . '" class="scfooter-icon-'.$icon_color.'"></a>' : '';
					                    echo '<li>'.$social_icon.'</li>';
										//echo '<li><a class="sc-icon-' . str_replace('social-', '', $icon['footer_social_icon']) . '" href="' . $link . '" ' . $target . ' title="' . $icon['footer_social_title'] . '"></a></li>';
									}

								echo '</ul>';
							}
						}
						?>

						<?php
						$copyright_text = zget_option( 'copyright_text', 'general_options' );
						$footer_logo = zget_option( 'footer_logo', 'general_options' );
						if ( !empty( $copyright_text ) || !empty( $footer_logo ) ) { ?>

							<div class="copyright">
								<?php
									if ( !empty( $footer_logo ) ) {
										echo '<a href="' . home_url() . '"><img src="' . $footer_logo . '" alt="' . get_bloginfo( 'name' ) . '" /></a>';
									}

									if ( !empty( $copyright_text ) ) {
										echo '<p>' . do_shortcode(stripslashes( $copyright_text )) . '</p>';
									}
								?>
							</div><!-- end copyright -->
						<?php } ?>
					</div>
					<!-- end bottom -->
				</div>
			</div>
			<!-- end row -->
		</div>
	</footer>
<?php } ?>
</div><!-- end page_wrapper -->

<a href="#" id="totop" class="js-scroll-event" data-forch="300" data-visibleclass="on--totop" ><?php echo __( 'TOP', 'zn_framework' ); ?></a>
<?php zn_footer(); ?>
<?php wp_footer(); ?>

<!-- <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
<script>
// Initialize and add the map
function initMap() {
  // The location of Uluru Культурно-
  var uluru = {lat: 59.893858, lng: 30.451600};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 15, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0g4vwhSZkYtgzRZi6xIBYOFA-eA5luEM&callback=initMap">
</script>

</body>
</html>


