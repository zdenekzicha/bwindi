
{foreach from=$data key=myId item=dite}
	<div id="profile" class="twoColumnsLayout group">
		<div id="left">
	<div class="photo bubble {if $dite.pohlavi == 'F'}female{else}male{/if}">
		{if $dite.fotka}
			<img src="{$dite.fotka}" alt="" />
		{else}
			<img src="http://bwindiorphans.org/wp-content/themes/quora/images/portrait.jpg" alt="" />
		{/if}
	</div>
	{if $dite.skolaTyp == 'q'}
		<div id="helpMe" class="disable">{$dite.skolaText}.</div>
	{else}
		{if $dite.rezervovane}
			<div id="helpMe" class="disable">Má zájemce</div>
		{else if $dite.sponzor}
			<div id="helpMe" class="disable">Už mám adoptivní rodiče</div>
		{else}
			<a href="/?page_id=119&idDite={$dite.id}" id="helpMe">Pomůžeš mi?</a>
		{/if}
		{if $dite.skolne}
			<p>Abych {if $dite.pohlavi == "F"}mohla{else}mohl{/if} letos chodit do školy potřebuji <strong>{$dite.skolne} Kč</strong></p>
		{/if}
	{/if}

	{if $dite.vs != ''}
		<p style="font-size: 0.667em">
			Číslo účtu: 210764965/0300<br/>
			Vs:{$dite.vs}
			
			{if $dite.ss != 0}
				<br/>Ss:{$dite.ss}
			{/if}

		</p>
	{/if}
	</div>
		<div id="right">
			<h1>{$dite.jmeno}</h1>
			<p class="perex">
				Jsem {if $dite.pohlavi == "F"}holka{else}kluk{/if} a je mi {$dite.vek} let. <br/>
				{if $dite.skola != '' && $dite.skolaTyp != 'q'}
					{if $dite.skolaTyp == 'z'}
						Chodím do {if $dite.rocnik != ''}{$dite.rocnik}. třídy{/if} základní školy {$dite.skola}.
					{elseif $dite.skolaTyp == 's'}
						Studuji {if $dite.rocnik != ''}{$dite.rocnik}. ročník{/if} střední školy {$dite.skola}.
					{elseif $dite.skolaTyp == 'u'}
						Chodím do {if $dite.rocnik != ''}{$dite.rocnik}. ročníku{/if} na učilišti {$dite.skola}.
          {elseif $dite.skolaTyp == 'o'}
						Studuji {if $dite.rocnik != ''}{$dite.rocnik}. ročník{/if} odborné školy {$dite.skola}.
					{elseif $dite.skolaTyp == 'v'}
						Chodím do {if $dite.rocnik != ''}{$dite.rocnik}. ročníku{/if} na {$dite.skola}.
					{else}
						{if $dite.skolaText}{$dite.skolaText}.{/if}
					{/if}
				{/if}
			</p>
			<p>{$dite.bio|nl2br}</p>

			<div id="timeline">
				{foreach from=$timeline key=key item=item name=item}
					{foreach from=$item key=key1 item=item1 name=item1}
		   				<div class="noShow">
			   				{foreach from=$item1 key=key2 item=item2 name=item2}
				   				{if $smarty.foreach.item2.index == 0}
									<div class="start">{$item2.rok}</div>
				   				{/if}
								<div class="note">
									{if $item2.foto != ''}
										<a href="{$item2.fotoBig}" data-lightbox="gallery" {if $item2.text != ''}title="{$item2.text|nl2br|escape:'htmlall'}"{/if} >
											<img src="" data-src="{$item2.foto}" />
										</a>
									{/if} 
									{if $item2.text != ''}<p>{$item2.text|nl2br}</p>{/if}
								</div>
							{/foreach}
						</div>
					{/foreach}

					<a href="#" class="showMore">Předchozí rok</a>
					<script>					
						jQuery( document ).ready(function() {
							function nextYear(e) {
								if(e) {
									e.preventDefault();
								}

							    var part = jQuery("#timeline .noShow");

								for(var i = 0; i < part.length; i++) {
									part.eq(i).removeClass('noShow');
									var photos = part.eq(i).find('img');
									for(var a = 0; a < photos.length; a++) {
										var src = photos[a].getAttribute('data-src');
										photos[a].setAttribute('src',src);
									}
									window.scrollBy(0,50);
									break;
								}

								if(jQuery("#timeline .noShow").length == 0) {
									jQuery(this).remove();
								}
							};

							jQuery("#timeline .showMore").click(nextYear);
							nextYear(null);
						});				
					</script>

				{/foreach}		
			</div>
		</div>
	</div>
{/foreach}
