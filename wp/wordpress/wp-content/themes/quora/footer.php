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
	<div id="bottom">
		<?php if (is_front_page()) : ?>
			<div class="container_12 cf">
				<?php if ( !function_exists('dynamic_sidebar')
				        || !dynamic_sidebar("Footer") ) : ?>  
				<?php endif; ?>
				<!--  <div class="grid_4">  <?php get_template_part( 'sponsors' ); ?> </div> -->
			</div>
		<?php endif; ?>
	</div>
	<div id="sponsors">
		<a href="#"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/livingstone.png" /></a>
		<a href="#"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/nadaceDivokeHusy.png" /></a>
		<a href="#"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/agenturaPelhrimov.png" /></a>
	</div>
	<footer id="colophon" class="site-footer" role="contentinfo"></footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>