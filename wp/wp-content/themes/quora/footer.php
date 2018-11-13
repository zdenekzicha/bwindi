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
	<!-- #main .site-main

	<?php if (is_front_page()) : ?>
		<?php require('bwindy-api/kids.php'); ?>
		<div id="actions"><a href="http://bwindiorphans.org/adopce/">Co je vzdálená adopce</a><a href="?page_id=368">Chci pomoci</a></div>
	<?php endif; ?>
	-->

</div><!-- #page .hfeed .site -->
<footer id="sponsors">
	<br/>
Přispějte na Bwindi orphans pomocí Paypalu:
	<div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="F3FBULWAMX6UY" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_CZ/i/scr/pixel.gif" width="1" height="1" />
</form><br/>
Naši partneři:<br/>
		<a href="http://www.livingstone.cz/"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/sponzori/livingstone2.jpg" /></a>
		<a href="http://www.dobryden.cz/"><img src="http://bwindiorphans.org/wp-content/themes/quora/images/sponzori/agenturaPelhrimov1.png" /></a>
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

<!-- test code for recording sessions -->
<!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
window.__insp = window.__insp || [];
__insp.push(['wid', 1818666279]);
(function() {
function ldinsp(){if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
setTimeout(ldinsp, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
})();
</script>
<!-- End Inspectlet Embed Code -->

<?php wp_footer(); ?>

</body>
</html>
