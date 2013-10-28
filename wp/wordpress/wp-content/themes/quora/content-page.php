<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="wrap">
	<!---
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?> xxx</h1>
	</header>
	-->
	<!-- .entry-header -->

	<div class="entry-content">
		<!-- <?php the_content(); ?> -->
		<!-- <?echo get_the_ID(); ?> -->
		<!-- ID 119 - formular pro adopci -->
		<?php 

			if(get_the_ID() == 4 || get_the_ID() == 48 || get_the_ID() == 94 || get_the_ID() == 119 || get_the_ID() == 122) {
				require("bwindy-api/kids.php");
			}
			else {
				the_content();
			}
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'web2feel' ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'web2feel' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->