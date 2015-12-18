<?php
//SrizonResourceLoader::load_elastislide();
//SrizonResourceLoader::load_srizon_custom_css();
$data .= <<<EOL
	<div class="full-size-image">
		<div class="full-size-image-container srz-clearfix">
			<div class="full-size-single-image" id="full-{$scroller_id}"></div>
			<span class="srz-prev"></span>
			<span class="srz-next"></span>
		</div>
		<div class="loading-wrap">
			<ul class="elastislide-list"  id="{$scroller_id}">
EOL;
$i = 0;
foreach ( $srz_images as $image ) {
	$caption = nl2br( $image['txt'] );
	$data .= <<<EOL
				<li>
					<a href="javascript:;" data-index="{$i}">
						<img src="{$image['thumb']}" alt="{$caption}" width="{$image['width']}" height="{$image['height']}" />
					</a>
				</li>

EOL;
	$i ++;
}
$data .= <<<EOL
			</ul>
		</div>
	</div>
EOL;
$json_data = json_encode( $srz_images );
$data .= <<<EOL
<script type="text/javascript">
	jQuery('#{$scroller_id}').matchImgHeight({
		'height':{$srz_album['targetheight']}
	});

	jQuery(window).load(function(){
		jQuery( '#{$scroller_id}').unwrap().elastislide({
			speed: {$srz_album['animationspeed']}
		});

		jQuery('#{$scroller_id}').autoscrollElastislide({
			interval: {$srz_album['autoslideinterval']}
		});

		jQuery('#full-{$scroller_id}').srzSingleImageSlider({
				images_json: {$json_data},
				prev_class: '.srz-prev',
				next_class: '.srz-next, .full-size-single-image',
				max_height: {$srz_album['maxheight']},
				fadeout_time: {$srz_album['animationspeed']},
				fadein_time: {$srz_album['animationspeed']},
				thumb_container: '#{$scroller_id}',
				hover_caption: {$srz_album['hovercaption']}
			});
	});
</script>
EOL;
