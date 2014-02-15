<h1>Děti k adopci</h1>
<div id="childrens" class="group">
		{foreach from=$data key=myId item=value}
			{foreach from=$value key=myId item=i name="kids"} 
  				<div class="children noShow">
					<div class="bubble {$i.pohlavi}">
						<a href="?page_id=48&idDite={$i.id}&s=profil">
							{if $i.fotka}
							<img src="" alt="" data-src="{$i.fotka}" />
							{else}
								<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
							{/if}
						</a>
					</div>
					<span>{$i.jmeno}</span>
				</div>


			{/foreach}

			{if $value|@count > 10}
				<a href="#" class="showMoreChildren">Další děti</a>
				<script>
					jQuery( document ).ready(function() {
						function showPhoto(e) {
							if(e) {
								e.preventDefault();
							}
							
						    var childrens = jQuery("#childrens .noShow");

							for(var i = 0; i < childrens.length; i++) {
								childrens.eq(i).removeClass('noShow');
								var photo = childrens.eq(i).find( "img");
								var src = photo.attr('data-src');
								photo.attr('src',src);
								if(i == 11) {
									break;
								}
							}

							if(jQuery("#childrens .noShow").length == 0) {
								jQuery(this).remove();
							}
						}

						jQuery("#childrens .showMoreChildren").click(showPhoto);

						showPhoto(null);
					});							
				</script>
			{/if} 

			{if empty($value)}
				<h3>Momentálně mají všechny děti svého sponzora</h3>
			{/if}
		{/foreach}
		

		{if count($data) > 10 }
			
		{/if}



</div>
