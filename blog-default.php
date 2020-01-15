<?php
    global $hasSidebar;
?>
<div class="itemListView clearfix eBlog">
    <div class="itemList">
        <?php
            if ( have_posts() ) :
                $postCount = 0;
                while ( have_posts() ) {
                    the_post();

                    $featPostClass = is_sticky( get_the_id() ) ? 'featured-post' : '';
                    $image = '';
                    $sb_archive_use_full_image = zget_option( 'sb_archive_use_full_image', 'blog_options', false, 'no' );
                    $usePostFirstImage = (zget_option( 'zn_use_first_image', 'blog_options' , false, 'yes' ) == 'yes');

                    // Create the featured image html
                    if ( has_post_thumbnail() && !post_password_required() ) {

                        $thumb   = get_post_thumbnail_id( get_the_id() );
                        $f_image = wp_get_attachment_url( $thumb );
                        if ( ! empty ( $f_image ) ) {

                            if(!empty($featPostClass)){
                                $image = vt_resize( '', $f_image, 1140, 480, true );
                                $image = '<div class="zn_full_image"><img class="zn_post_thumbnail" src="' . $image['url'] . '" alt=""/></div>';
                            }
                            elseif ($sb_archive_use_full_image == 'yes' ) {
                                $image = '<div class="zn_full_image"><a data-lightbox="image" href="' . $f_image .'">' .
                                         get_the_post_thumbnail( get_the_id(), 'full-width-image' ) . '</a></div>';
                            }
                            else {
                                $image = '<div class="zn_post_image"><a href="' . get_permalink() . '" class="pull-left">' . get_the_post_thumbnail(
                                        get_the_ID(),
                                        array(460, 320)
                                    ) . '</a></div>';
                            }
                        }
                    }
                    elseif ($usePostFirstImage  && ! post_password_required() )
                    {
                        $f_image = echo_first_image();

                        // if sticky post
                        if(! empty($featPostClass)){
                            if ( ! empty ( $f_image ) ) {
                                $_image = vt_resize( '', $f_image, 1140, 480, true );
                                $image = '<div class="zn_full_image">';
                                if(isset($_image['url']) && !empty($_image['url'])){
                                    $image .= '<img class="zn_post_thumbnail" src="' . $_image['url'] . '" alt=""/>';
                                }
                                $image .= '</div>';
                            }
                            else { echo '<div class="zn_sticky_no_image"></div>'; }
                        }
                        else {
                            if ( ! empty ( $f_image ) ) {
                                if ( $sb_archive_use_full_image == 'yes' ) {
                                    $size = zn_get_size( 'sixteen', $hasSidebar, 30 );
                                    $image = vt_resize( '', $f_image, $size['width'], '', true );
                                    $image = '<div class="zn_full_image"><a data-lightbox="image" href="' . $f_image . '"><img class="zn_post_thumbnail" src="' . $image['url'] . '" alt=""/></a></div>';
                                }
                                else {
                                    $resized_image = vt_resize( '', $f_image, 460, 320, true );
                                    $image = '<div class="zn_post_image">';
                                    $image .= '<a href="' . get_permalink() . '" class="pull-left">';
                                    // Fixes: PHP Warning: Illegal string offset 'url' when 'url' is not present in
                                    // the list
                                    if(isset($resized_image['url']) && !empty($resized_image['url'])){
                                        $image .= '<img class="zn_post_thumbnail" src="' . $resized_image['url'] . '" alt=""/>';
                                    }
                                    $image .= '</a>';
                                    $image .= '</div>';
                                }
                            }
                        }
                    }
                    ?>
                    <?php if(!empty($featPostClass)) {?>
                    <div class="itemContainer post-<?php echo get_the_ID() .' '. $featPostClass;?>">
                        <?php
                            if(empty($image)){
                                echo '<div class="zn_sticky_no_image"></div>';
                            }
                            else { echo $image; }
                        ?>
                        <div class="itemFeatContent">
                            <div class="itemFeatContent-inner">
                                <div class="itemHeader">
                                    <h3 class="itemTitle">
                                        <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
                                    </h3>
                                    <div class="post_details">
                                    <span class="catItemDateCreated">
                                            <?php the_time( 'l, d F Y' );?>
                                    </span>
                                        <span class="catItemAuthor"><?php echo __( 'by', 'zn_framework' );?> <?php the_author_posts_link(); ?></span>
                                    </div>
                                    <!-- end post details -->
                                </div>
                                <ul class="itemLinks clearfix">
                                    <li class="itemCategory">
                                        <span  data-zniconfam='glyphicons_halflingsregular' data-zn_icon="&#xe117;"></span>
                                        <span><?php echo __( 'Published in', 'zn_framework' );?></span>
                                        <?php the_category( ", " ); ?>
                                    </li>
                                </ul>
                                <div class="itemComments">
                                    <a href="<?php the_permalink(); ?>"><?php comments_number( __( 'No Comments', 'zn_framework'), __( '1 Comment', 'zn_framework' ), __( '% Comments', 'zn_framework' ) ); ?></a>
                                </div>
                                <!-- item links -->
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>

                    <div class="itemContainer post-<?php echo get_the_ID()?>">
                        <div class="itemHeader">
                            <h3 class="itemTitle">
                                <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
                            </h3>

                            <div class="post_details">
                                <span class="catItemDateCreated">
                                        <?php the_time( 'l, d F Y' );?>
                                </span>
                                <span class="catItemAuthor"><?php echo __( 'by', 'zn_framework' );?> <?php the_author_posts_link(); ?></span>
                            </div>
                            <!-- end post details -->
                        </div>
                        <!-- end itemHeader -->

                        <div class="itemBody">
                            <div class="itemIntroText">
                                <?php
                                echo $image;
                                if( zget_option( 'sb_archive_content_type', 'blog_options', false, 'full' ) == 'excerpt' ){
                                    the_excerpt();
                                }
                                else{
                                    the_content();
                                }

                                ?>
                            </div>
                            <!-- end Item Intro Text -->
                            <div class="clear"></div>
                            <div class="itemBottom clearfix">
                                <?php if ( has_tag() ) { ?>
                                    <div class="itemTagsBlock">
                                        <?php echo WpkZn::getPostTags(get_the_ID()); ?>
                                        <div class="clear"></div>
                                    </div><!-- end tags blocks -->
                                <?php } ?>
                                <div class="itemReadMore">
                                    <a class="btn btn-fullcolor text-uppercase"
                                       href="<?php the_permalink(); ?>"><?php echo __( 'Read more', 'zn_framework' );?></a>
                                </div>
                                <!-- end read more -->
                            </div>
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
                        <div class="itemComments">
                            <a href="<?php the_permalink(); ?>"><?php comments_number( __( 'No Comments', 'zn_framework'), __( '1 Comment', 'zn_framework' ), __( '% Comments', 'zn_framework' ) ); ?></a>
                        </div>
                        <!-- item links -->
                        <div class="clear"></div>

                    </div><!-- end Blog Item -->
                    <?php } ?>
                    <div class="clear"></div>
                <?php
                    $postCount++;
                }
            else: ?>
                <div class="itemContainer noPosts">
                    <p><?php echo __( 'Sorry, no posts matched your criteria.', 'zn_framework' ); ?></p>
                </div><!-- end Blog Item -->
                <div class="clear"></div>
            <?php endif; ?>
    </div>
    <!-- end .itemList -->

    <!-- Pagination -->
    <?php zn_pagination(); ?>
</div>
<!-- end blog items list (.itemListView) -->
