<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?>

	</div><!-- #main .site-main -->
	<?php if (is_front_page()) : ?>
		<div id="bottom">		
			<div class="container_12 cf">
				<?php if ( !function_exists('dynamic_sidebar')
				        || !dynamic_sidebar("Footer") ) : ?>  
				<?php endif; ?>
				<!--  <div class="grid_4">  <?php get_template_part( 'sponsors' ); ?> </div> -->
			</div>
		</div>
	<?php endif; ?>
</div><!-- #page .hfeed .site -->
<footer id="sponsors">
	<div>
		<a href="#"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/livingstone1.png" /></a>
		<a href="#"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/nadaceDivokeHusy1.png" /></a>
		<a href="#"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/agenturaPelhrimov1.png" /></a>
	</div>
</footer>


<?php wp_footer(); ?>

</body>
</html>