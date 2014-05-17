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

	</div>
	<!-- #main .site-main -->
	<?php if (is_front_page()) : ?>
		<div id="childrensWrapper">
			<h2>Děti k adopci</h2>
			<div class="children">
				<div class="bubble male">
					<a href="?page_id=48&amp;idDite=56&amp;s=profil">
						<img src="http://farm6.static.flickr.com/5486/12654449173_c36b36dd41.jpg" alt="" data-src="http://farm6.static.flickr.com/5486/12654449173_c36b36dd41.jpg">
					</a>
				</div>
				<span>Onesmas Agaba</span>
			</div>
			<div class="children">
				<div class="bubble male">
					<a href="?page_id=48&amp;idDite=110&amp;s=profil">
						<img src="http://farm8.static.flickr.com/7362/12452788534_4c39a9e7ff.jpg" alt="" data-src="http://farm8.static.flickr.com/7362/12452788534_4c39a9e7ff.jpg">
					</a>
				</div>
				<span>Emmanuel Egitu</span>
			</div>
			<div class="children">
				<div class="bubble male">
					<a href="?page_id=48&amp;idDite=199&amp;s=profil">
						<img src="http://farm6.static.flickr.com/5516/12652873814_a81661e69e.jpg" alt="" data-src="http://farm6.static.flickr.com/5516/12652873814_a81661e69e.jpg">
					</a>
				</div>
				<span>K - Lovis Muhwezi</span>
			</div>
		</div>
		<div id="actions"><a href="http://bwindiweb.petrsiller.cz/adopce/">Co je vzdálená adopce</a><a href="?page_id=368">Chci pomoci</a></div>
	<?php endif; ?>
	
</div><!-- #page .hfeed .site -->
<footer id="sponsors">
	<div>
		<a href="http://www.livingstone.cz/"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/livingstone1.png" /></a>
		<a href="http://www.divokehusy.cz/"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/nadaceDivokeHusy1.png" /></a>
		<a href="http://www.dobryden.cz/"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/agenturaPelhrimov1.png" /></a>
		<a href="?page_id=845"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/sponzori/bwindiCoffeBlack.jpg" /></a>
	</div>
</footer>


<?php wp_footer(); ?>

</body>
</html>