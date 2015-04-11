{foreach from=$data key=myId item=value}
	{if !empty($value)}
		<div id="forAdoption">
			{foreach from=$value key=myId item=i name=kids}
				{if $i@index eq 3}
					{break}
				{/if} 
				<div class="children">
					<div class="bubble {$i.pohlavi}">
						<a href="?page_id=48&idDite={$i.id}&s=profil">
							{if $i.fotka}
								<img src="{$i.fotka}" alt="" />
							{else}
								<img src="http://bwindiorphans.org/wp-content/themes/quora/images/portrait.jpg" alt="" />
							{/if}
						</a>
					</div>
					<span class="bubbleName">{$i.jmeno}</span>
				</div>
			{/foreach}
		</div>
	{/if}
{/foreach}
