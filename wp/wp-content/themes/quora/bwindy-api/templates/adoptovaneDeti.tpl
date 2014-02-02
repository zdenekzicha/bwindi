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
				<div class="children noShow">
				<div class="bubble">
					<a href="?page_id=48&idDite={$i.id}&s=profil">
						{if $i.fotka}
							<img src="" alt="" data-src="{$i.fotka}" />
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
			{if !empty($search)}
				<h3 class="notice">Bohužel jsem nikoho nenašli :(</h3>
			{else}
				<h3 class="notice">Momentálně nemáme žádné adoptované děti :(</h3>
			{/if}
		{/if}

	{/foreach}
</div>
