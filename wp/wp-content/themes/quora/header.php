<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'web2feel' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

<script type='text/javascript' src='http://bwindiorphans.org/wp-includes/js/lightbox/lightbox.js'></script>
<link rel='stylesheet' href='http://bwindiorphans.org/wp-includes/css/lightbox.css' type='text/css' media='all' />
<script src="<?php echo get_template_directory_uri(); ?>/js/theme.js" type="text/javascript"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-51182585-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id="mainLogo">
		<a href="/"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/logo1.png" alt="" /></a>
	</div>
	<header id="masthead" class="site-header cf" role="banner">
	
	<!--
	<div class="wrap">
		<div class="topbar">
			
		</div>
		<div class="logo">
			<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo of_get_option('w2f_logo');?>"/></a></h1>
			
		</div>
	</div>
	-->
	<?php if (is_front_page()) : ?>
	<div id="wideslider" class="flexslider">
		<ul class="slides">
		    <li>
		      <img src="http://bwindiorphans.org/wp-content/themes/quora/images/mainPhoto2.jpg" alt="" id="headerPhoto"/>
		    </li>
  		</ul>
	</div>
	<script type="text/javascript">
		/*
		var headerBlur = new headerBlur();
		headerBlur.init();
		*/
	</script>
	<?php endif; ?>

	<nav role="navigation" class="site-navigation main-navigation">
			<?php wp_nav_menu( array( 'container_id' => 'submenu', 'theme_location' => 'primary','menu_id'=>'web2feel' ,'menu_class'=>'sf-menu','fallback_cb'=> 'fallbackmenu' ) ); ?>
	</nav><!-- .site-navigation .main-navigation -->
	
	</header><!-- #masthead .site-header -->

	<div id="main" class="site-main">