<h1>Děti k adobci</h1>
<div id="childrens" class="group">
	<p>
		„Adoptovat“ děti, znamená financovat jejich vzdělání a podílet se na celkovém zlepšení jejich životní situace. Na podpoře jednoho dítěte se může podílet kolektivy, rodiny nebo skupiny přátel.
	</p>

		{foreach from=$data key=myId item=value}
			{foreach from=$value key=myId item=i}
  				<div class="children">
					<div class="bubble">
						<a href="?page_id=48&idDite={$i.id}&s=profil"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
					</div>
					<span>{$i.jmeno}</span></a>
				</div>
			{/foreach}
		{/foreach}

</div>
