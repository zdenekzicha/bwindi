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
	<?php
		if(get_the_ID() == 4 || get_the_ID() == 48 || get_the_ID() == 94 || get_the_ID() == 119 || get_the_ID() == 586) {
			require("bwindy-api/kids.php");
		}
		else {
			echo '<div class="entry-content">';
			the_content();
			echo '</div>';
		}
	?>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'web2feel' ), 'after' => '</div>' ) ); ?>
	<?php edit_post_link( __( 'Edit', 'web2feel' ), '<span class="edit-link">', '</span>' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->