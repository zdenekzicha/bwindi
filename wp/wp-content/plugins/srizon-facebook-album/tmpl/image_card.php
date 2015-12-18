<?php
//SrizonResourceLoader::load_srizon_custom_js();
//SrizonResourceLoader::load_srizon_custom_css();
$data .= <<<EOL
	<div class="full-size-card-image-container srz-clearfix" id="{$scroller_id}">
		<p class="current-caption"></p>
		<span class="srz-next"></span>
	</div>
EOL;
$json_data = json_encode($srz_images);
$data .= <<<EOL
<script>
	jQuery('#{$scroller_id}').srzSingleImageCard({
		images_json: {$json_data},
		next_class: '.srz-next, .card-first',
		max_height: {$srz_album['maxheight']},
		hover_caption: {$srz_album['hovercaption']}
	});
</script>
EOL;
