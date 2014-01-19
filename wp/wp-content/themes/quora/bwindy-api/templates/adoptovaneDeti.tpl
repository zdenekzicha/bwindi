<h1>Adoptované děti</h1>
<div id="childrens" class="group">
		{foreach from=$data key=myId item=value}
			{foreach from=$value key=myId item=i name=kids}
  				<div class="children {if $smarty.foreach.kids.index > 11}noShow{/if}">
					<div class="bubble">
						<a href="?page_id=48&idDite={$i.id}&s=profil">
							{if $i.fotka}
								<img src="{$i.fotka}" alt="" />
							{else}
								<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
							{/if}
						</a>
					</div>
					<span>{$i.jmeno}</span></a>
				</div>
			{/foreach}

			{if $value|@count > 11}
				<a href="#" class="showMoreChildren">Další děti</a>
				<script>					
					jQuery( document ).ready(function() {
						jQuery("#childrens .showMoreChildren").click(function(e) {
							e.preventDefault();
							
						    var childrens = jQuery("#childrens .noShow");
							console.log(childrens);

							for(var i = 0; i < childrens.length; i++) {
								childrens.eq(i).removeClass('noShow');
								if(i == 11) {
									break;
								}
							}

							if(jQuery("#childrens .noShow").length == 0) {
								jQuery(this).remove();
							}
						});
					});
				</script>
			{/if} 

			{if empty($value)}
				<h3>Momentálně mají všechny děti svého sponzora</h3>
			{/if}

		{/foreach}
</div>
