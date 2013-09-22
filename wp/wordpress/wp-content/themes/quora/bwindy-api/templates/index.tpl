{foreach from=$data key=keys item=values}
	
		{foreach from=$values key=key item=value}
			<ul>
			{foreach from=$value key=key1 item=value1}
				<li>{$key1} / {$value1}</li>
			{/foreach}
			</ul>
		{/foreach}
{/foreach}