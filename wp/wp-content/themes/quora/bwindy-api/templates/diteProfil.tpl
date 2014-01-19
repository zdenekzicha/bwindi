
{foreach from=$data key=myId item=dite}
	<div id="profile" class="twoColumnsLayout group">
		<div id="left">
	<div class="photo bubble">
		{if $dite.fotka}
			<img src="{$dite.fotka}" alt="" />
		{else}
			<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
		{/if}
	</div>
	{if $dite.sponzor}
		<div id="helpMe" class="disable">Už mám sponzora</div>
	{else}
		<a href="/?page_id=119&idDite={$dite.id}" id="helpMe">Pomůžeš mi?</a>
	{/if}
	{if $dite.skolne}
		<p>Školné pro mě na celý rok stojí <strong>{$dite.skolne} Kč</strong></p>
	{/if}
	<!--
		<h4>Co potřebuji</h4>
		<table>
		<tr><th>Školné</th><td>8 500 Kč</td></tr>
		<tr><th>Boty</th><td>300 Kč</td></tr>
		<tr><th>Koza</th><td>1 200 Kč</td></tr>
		<tr><th>Lucerna</th><td>200 Kč</td></tr>
		</table>

		<h4>Co už mám</h4>
		<table>
		<tr><th>Matrace</th><td></td></tr>
		</table>
	-->
	</div>
		<div id="right">
			<h1>{$dite.jmeno}</h1>
			<p class="perex">Chodí do {$dite.skola}, {if $dite.rocnik != ''}{$dite.rocnik} ročník{/if} {if $dite.vek != 0} je mi {$dite.vek} let{/if}</p>
			<p>{$dite.bio}</p>

			<div id="timeline">
				{foreach from=$timeline key=key item=item name=item}
					{foreach from=$item key=key1 item=item1 name=item1}
		   				<div {if $smarty.foreach.item1.index != 0}class="noShow"{/if}>
			   				{foreach from=$item1 key=key2 item=item2 name=item2}		   				
				   				{if $smarty.foreach.item2.index == 0}
									<div class="start">{$item2.rok}</div>
				   				{/if}
								<div class="note">
									{if $item2.foto != ''}<img src="{$item2.foto}">{/if} 
									{if $item2.text != ''}<p>{$item2.text}</p>{/if}
								</div>
							{/foreach}
						</div>
					{/foreach}

					<a href="#" class="showMore">Předchozí rok</a>
					<script>					
						jQuery( document ).ready(function() {
							jQuery("#timeline .showMore").click(function(e) {
								e.preventDefault();
								
							    var part = jQuery("#timeline .noShow");

								for(var i = 0; i < part.length; i++) {
									part.eq(i).removeClass('noShow');
									window.scrollBy(0,50);
									break;
								}

								if(jQuery("#timeline .noShow").length == 0) {
									jQuery(this).remove();
								}
							});
						});				
					</script>

				{/foreach}		
			</div>
		</div>
	</div>
{/foreach}
