<h1>Adoptované děti</h1>
<div id="childrens" class="group">
	<div id="searchForm" style="text-align:center; margin-bottom:20px;">
		<form action="/" method="get">
			<input type="text" name="search" placeholder="vyhledat dítě" value="{$search}"/>
			<input type="hidden" name="page_id" value="94" />
		</form>
	</div>
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
			{if !empty($search)}
				<h3 class="notice">Bohužel jsem nikoho nenašli :(</h3>
			{else}
				<h3 class="notice">Momentálně nemáme žádné adoptované děti :(</h3>
			{/if}
		{/if}

	{/foreach}
</div>
