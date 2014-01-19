<?php
/**
 * @package web2feel
 * @since web2feel 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
<div class="wrap">

		<div class="post-img">
				<?php
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
					$image = aq_resize( $img_url, 300, 300, true ); //resize & crop the image
				?>
				
				<?php if($image) : ?>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>"/></a>
				<?php endif; ?>
		</div>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'web2feel' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<span class="user"> <i class="icon-user"></i> <?php the_author_posts_link(); ?></span>
			<span class="date"> <i class="icon-calendar"></i> <?php the_time('l, F jS, Y') ?></span>
			<span class="comment"> <i class="icon-comment"></i> <?php comments_popup_link( __( 'Leave a comment', 'web2feel' ), __( '1 Comment', 'web2feel' ), __( '% Comments', 'web2feel' ) ); ?></span>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	
	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<div class="readmore"> <a href="<?php the_permalink(); ?>"> <?php _e( 'Read More', 'web2feel' ); ?></a> </div> 
	</div><!-- .entry-summary -->
	

	</div>
</article><!-- #post-<?php the_ID(); ?> -->

