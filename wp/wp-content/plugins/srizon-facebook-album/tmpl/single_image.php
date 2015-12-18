<?php
//SrizonResourceLoader::load_srizon_custom_js();
//SrizonResourceLoader::load_srizon_custom_css();
$data .= <<<EOL
	<div class="full-size-image-container srz-clearfix">
		<div class="full-size-single-image" id="{$scroller_id}"></div>
		<span class="srz-prev"></span>
		<span class="srz-next"></span>
	</div>
EOL;
$json_data = json_encode( $srz_images );
$data .= <<<EOL
<script>
	jQuery('#{$scroller_id}').srzSingleImageSlider({
		images_json: {$json_data},
		prev_class: '.srz-prev',
		next_class: '.srz-next, .full-size-single-image',
		max_height: {$srz_album['maxheight']},
		fadeout_time: {$srz_album['animationspeed']},
		fadein_time: {$srz_album['animationspeed']},
		hover_caption: {$srz_album['hovercaption']}
	});
</script>
EOL;
