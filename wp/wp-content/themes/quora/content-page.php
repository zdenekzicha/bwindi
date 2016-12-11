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
		if(get_the_ID() == 4 || get_the_ID() == 48 || get_the_ID() == 94 || get_the_ID() == 119 || get_the_ID() == 586 || get_the_ID() == 11 || get_the_ID() == 2882) {
			require("bwindy-api/kids.php");
		}
		else if ( get_the_ID() == 23 ) { // Homepage
			
			echo '<div class="mainPage-wrapper">';

				// uvod - obsah stranky s id 23
				echo '<div class="entry-content group">';

					// nejnovejsi zprava z blogu
					echo '<div id="new-post">';
						$args = array(
							'numberposts' => 2,
              'post_status' => 'publish'
						);
						$recent_posts = wp_get_recent_posts($args);
						$index = 0;
						foreach( $recent_posts as $recent ){
							$index ++;
							$action = "_gaq.push(['_trackEvent', 'Novinky na hp', 'Proklik na detail', 'Pozice ". $index ."'])";

							echo '<h3><a onClick="'.$action.'" href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </h3> ';
							echo '<span class="date">'. get_the_time("j.n. Y", $recent["ID"]) .'</span> ';
							$post_content = strip_tags($recent["post_content"]);
							if(strlen($post_content) > 200) {
								$post_content = substr($post_content, 0, 200) ."...";
							}
							echo '<p>' .$post_content.'</p>';
						}
					echo '</div>';

					the_content();

				echo '</div>';

			echo '</div>';
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