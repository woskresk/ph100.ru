<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' );?>"/>
<meta name="twitter:widgets:csp" content="on">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
<link rel="stylesheet" href="/wp-content/themes/kallyas/kallyas/coolcarousel/css/s.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="/wp-content/themes/kallyas/kallyas/images/tables/select.css" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript"></script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
<script type="text/javascript" src="/wp-content/themes/kallyas/kallyas/js/eskju.jquery.scrollflow.min.js"></script>
<script type="text/javascript">
	$(function() {
		$('#wsx-ofk').click(function() {
					$('#pixar-lbi').removeClass('selected-8cl');
					$('#pixar-lbi').addClass('empty-flv');
					$('#bugs-duv').removeClass('empty-flv');
					$('#bugs-duv').addClass('selected-8cl');
				});
		$('#wsx-vuj').click(function() {
					$('#pixar-lbi').removeClass('empty-flv');
					$('#pixar-lbi').addClass('selected-8cl');
					$('#bugs-duv').removeClass('selected-8cl');
					$('#bugs-duv').addClass('empty-flv');
				});
		});
		</script>










<script type="text/javascript">

			       $(document).on('mouseover', '.list-win tr', function(){
            var id = $(this).data().linkId;
            $('.photoWin img[data-img-id=' + id +']').addClass('active');       
        });
       
        $(document).on('mouseover', '.photoWin img', function(){
            var id = $(this).data().imgId;
            $('.list-win tr[data-link-id=' + id +']').addClass('active');       
        });
 
        $(document).on('mouseout', '.list-win tr, .photoWin img', function(){
            $('.photoWin img').removeClass('active');
            $('.list-win tr').removeClass('active');
        }); 
	
		</script>














		
<?php
	global $post;
	wp_head();

?>
</head>
<body  <?php body_class(); ?>>

<?php //<!-- AFTER BODY ACTION -->
/*
 * @hooked zn_add_page_loading()
 * @hooked zn_add_hidden_panel()
 * @hooked zn_add_login_form()
 * @hooked zn_add_open_graph()
 */
do_action( 'zn_after_body' ); ?>


<div id="page_wrapper">

<?php
/*
 * Display SITE HEADER
 */
do_action('th_display_site_header');