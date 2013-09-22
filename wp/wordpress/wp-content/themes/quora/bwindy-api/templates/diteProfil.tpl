
{foreach from=$data key=myId item=dite}
	<div id="profile">
		<div id="left">
	<div class="photo bubble"><img src="http://bwindiweb.petrsiller.cz/wp-content/themes/quora/images/portrait.jpg" alt="" /></div><a href="#" id="helpMe">Pomůžeš mi</a>
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
	</div>
		<div id="right">
			<h1>{$dite.jmeno}</h1>
			<h3>Chodím do Buhoma {$dite.skola}, 3 ročník <br /> je mi 19 let</h3>
			<p>{$dite.bio}</p>
	<div id="timeline">
		{foreach from=$timeline key=key item=item}
			{foreach from=$item key=key1 item=item1}
				<div class="start">{$item1.rok}</div>
				<div class="note">
					{if $item1.foto != ''}<img src="{$item1.foto}">{/if} 
					<p>{$item1.text}</p>
				</div>
			{/foreach}
		{/foreach}
		
	</div>
		</div>
	</div>
{/foreach}
