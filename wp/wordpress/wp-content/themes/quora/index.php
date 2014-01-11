<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package web2feel
 * @since web2feel 1.0
 */

get_header(); ?>


<!--
	<div id="wideslider" class="flexslider">
		<ul class="slides">
		    <?php 	$count = of_get_option('w2f_slide_number');
					$slidecat =of_get_option('w2f_slide_categories');
					
					$query = new WP_Query( array( 'cat' =>$slidecat,'posts_per_page' =>$count ) );
		           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
		 	
			 		<li>
			 			
					<?php
						$thumb = get_post_thumbnail_id();
						$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
						$image = aq_resize( $img_url, 960, 400, true ); //resize & crop the image
					?>
					
					<?php if($image) : ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>"/></a>
					<?php endif; ?>
	
					<div class="flex-caption">
						<h2><?php the_title(); ?></h2>
					</div>
			<?php endwhile; endif; ?>
					    		
		  </li>
		</ul>
	</div>
	-->
<div id="mainPage" class="group">
	<h1>Snažíme se zlepšit život dětem v Ugandě xx</h1>
	<p>
		Prostřednictvím adopce na dálku se staráme o sirotky ve dvou ugandských oblastech. 
		Adoptivní rodiče z ČR platí dětem školní docházku, uniformy, stravu a základní lékařskou péči.
	</p>
	<p>
		Podporujeme snahu rodin našich dětí o vylepšení jejich životní úrovně - kupujeme tradiční 
		výrobky a poskytujeme malé půjčky do začátku drobného podnikání. Snažíme se dětem poskytnout dobrý základ a věříme, že jim 
		pomůže postavit se na vlastní nohy.
	</p>
	<div id="actions">
		<a href="#">Více o adopci</a>
		<a href="#">Děti k adopci</a>
	</div>
</div>		

<?php get_footer(); ?>