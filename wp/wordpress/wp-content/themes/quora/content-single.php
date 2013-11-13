<?php
/**
 * @package web2feel
 * @since web2feel 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="wrap">
	<!--
	<header class="entry-header">
		 <h1 class="entry-title"><?php the_title(); ?></h1> 

		<div class="entry-meta">
			<span class="user"> <i class="icon-user"></i> <?php the_author_posts_link(); ?></span>
			<span class="date"> <i class="icon-calendar"></i> <?php the_time('l, F jS, Y') ?></span>
			<span class="comment"> <i class="icon-comment"></i> <?php comments_popup_link( __( 'Leave a comment', 'web2feel' ), __( '1 Comment', 'web2feel' ), __( '% Comments', 'web2feel' ) ); ?></span>
		</div>
	</header>
	-->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'web2feel' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
