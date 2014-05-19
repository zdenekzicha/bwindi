
{foreach from=$data key=myId item=item}
	<div id="thanksForAdoption">
		<h1>Děkujeme</h1>
		<div class="photo bubble">
			{if $item.fotka}
				<img src="{$item.fotka}" alt="" />
			{else}
				<img src="http://bwindiorphans.org/wp-content/themes/quora/images/portrait.jpg" alt="" />
			{/if}
		</div>
		<p>Moc vám děkujeme za snahu pomoci dětěm z Bwindi orphans. Během následujících dnů vás kontaktujeme přes email <span>{$item.email}</span> a zdělíme vám všechny informace potřebné k adopci.</p>
		<i>Tým bwindi orphans a {$item.jmeno}</i>
	</div>
{/foreach}
