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
		<?php require('bwindy-api/kids.php'); ?>
		<div id="actions"><a href="http://bwindiorphans.org/adopce/">Co je vzdálená adopce</a><a href="?page_id=368">Chci pomoci</a></div>
	<?php endif; ?>

</div><!-- #page .hfeed .site -->
<footer id="sponsors">
	<div>
		<a href="http://www.livingstone.cz/"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/sponzori/livingstone1.png" width="140" class="sponsor1"/></a>
		<a href="http://www.divokehusy.cz/"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/sponzori/nadaceDivokeHusy1.png" width="140" /></a>
		<a href="http://www.dobryden.cz/"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/sponzori/agenturaPelhrimov1.png" height="80" /></a>
		<a href="?page_id=845"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/sponzori/bwindiCoffeBlack.jpg" width="140" class="sponsor4" /></a>
	</div>
</footer>

<script>
/*
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51182585-1', 'bwindiorphans.org');
  ga('send', 'pageview');
*/
</script>

<?php wp_footer(); ?>

</body>
</html>