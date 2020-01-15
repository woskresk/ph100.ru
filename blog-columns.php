<?php
	global $columns, $zn_config;

/*
 * Load resources in footer
 */
wp_enqueue_script('isotope', THEME_BASE_URI.'/js/jquery.isotope.min.js',array ( 'jquery' ), ZN_FW_VERSION, true);

$columns = !empty( $zn_config['blog_columns'] ) ? $zn_config['blog_columns'] : zget_option( 'blog_style_layout', 'blog_options', false, '1' );
$columns_size = 12 / $columns;

?>
	<div class="itemListView clearfix eBlog">
		
			<?php
				if ( have_posts() ) :

                    echo '<div class="itemList zn_blog_columns">';

					while ( have_posts() ) {
						the_post();

						$image = '';

						$image_size = zn_get_size( 'span' . $columns_size );

						// Create the featured image html
						if ( has_post_thumbnail( get_the_id() ) ) {
							$thumb = get_post_thumbnail_id( get_the_id() );
							if ( ! empty ( $thumb ) ) {
								$feature_image = wp_get_attachment_url( $thumb );
                                $image = get_the_post_thumbnail(get_the_ID(), 'full', array('class'=>'shadow'));
								$image         = '<a href="' . get_permalink() . '">'.$image.'</a>';
							}
						}
						elseif ( zget_option( 'zn_use_first_image', 'blog_options' , false, 'yes' ) == 'yes' ) {
							$f_image = echo_first_image();

							if ( ! empty ( $f_image ) ) {
                                $image = '<img class="shadow" src="' . $f_image . '" alt=""/>';
                                $image = '<a href="' . get_permalink() . '">'.$image.'</a>';
							}
						}
						?>
                        <div class="col-sm-6 col-lg-<?php echo $columns_size;?> blog-isotope-item">
                            <div class="itemContainer zn_columns zn_columns<?php echo $columns;?> post-<?php the_ID(); ?>">
                                <?php if( ! empty( $image ) ) : ?>
                                <div class="itemThumbnail">
                                    <?php echo $image; ?>
                                    <div class="overlay">
                                        <div class="overlay__inner">
                                            <a href="<?php the_permalink(); ?>" class="readMore" title="" data-readmore="<?php echo __('Read More', 'zn_framework') ?>"></a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="itemHeader">
                                    <h3 class="itemTitle">
                                        <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
                                    </h3>

                                    <div class="post_details">
									<span class="catItemDateCreated"><span
                                            data-zniconfam='glyphicons_halflingsregular' data-zn_icon="&#xe109;"></span> <?php the_time( 'l, d F Y' );?></span>
									<span class="catItemAuthor"><?php echo __( 'by', 'zn_framework' );?> <?php the_author_posts_link(); ?></span>
                                    </div>
                                    <!-- end post details -->
                                </div>
                                <!-- end itemHeader -->

                                <div class="itemBody">
                                    <div class="itemIntroText">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <!-- end Item Intro Text -->
                                    <div class="clear"></div>
                                </div>
                                <!-- end Item BODY -->

                                <ul class="itemLinks clearfix">
                                    <li class="itemCategory">
                                        <span data-zniconfam='glyphicons_halflingsregular' data-zn_icon="&#xe117;"></span>
                                        <span><?php echo __( 'Published in', 'zn_framework' );?></span>
                                        <?php the_category( ", " ); ?>
                                    </li>
                                </ul>
                                <!-- item links -->
                                <div class="clear"></div>
                                <?php if ( has_tag() ) { ?>
                                    <div class="itemTagsBlock">
                                        <span data-zniconfam='glyphicons_halflingsregular' data-zn_icon="&#xe042;"></span>
                                        <span><?php echo __( 'Tagged under:', 'zn_framework' ); ?></span>
                                        <?php the_tags( '' ); ?>
                                        <div class="clear"></div>
                                    </div><!-- end tags blocks -->
                                <?php } ?>
                            </div><!-- end Blog Item -->
                        </div>
						<?php
					}

                    echo '</div>';
                    
				else: ?>
					<div class="itemContainer noPosts">
						<p><?php echo __( 'Sorry, no posts matched your criteria.', 'zn_framework' ); ?></p>
					</div><!-- end Blog Item -->
					<div class="clear"></div>
				<?php endif; ?>
		
		<!-- end .itemList -->

		<!-- Pagination -->
		<?php zn_pagination(); ?>
    </div>

