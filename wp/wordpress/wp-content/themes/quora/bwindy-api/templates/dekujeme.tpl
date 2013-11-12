
{foreach from=$data key=myId item=item}
	<div id="thanksForAdoption">
		<div class="photo bubble">
			{if $item.fotka}
				<img src="{$item.fotka}" alt="" />
			{else}
				<img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" />
			{/if}
		</div>
		<h1>Děkujeme</h1>
		<p>Moc vám děkujeme za snahu pomoci dětěm z Bwindi orphans. Během následujících dnů vás kontaktujeme přes email <span>{$item.email}</span> a zdělíme vám všechny informace potřebné k adopci.</p>
		<i>Tým bwindi orphans a {$item.jmeno}</i>
	</div>
{/foreach}
