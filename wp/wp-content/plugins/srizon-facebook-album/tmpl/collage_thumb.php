<?php
//SrizonResourceLoader::load_mag_popup();
//SrizonResourceLoader::load_collage_plus();
//SrizonResourceLoader::load_srizon_custom_css();
$extraclass = '';
if($srz_album['showhoverzoom']) $extraclass.=' zoom';
$data .= '<div class="fbalbum'.$extraclass.'"  id="' . $scroller_id . '">';
foreach ($srz_images as $image) {
	$caption = nl2br($image['txt']);
	$data .= <<<EOL
		<div class="Image_Wrapper" data-caption="{$caption}">
			<a href="{$image['src']}" data-title="{$caption}" {$lightbox_attribute}>
				<img alt="{$caption}" src="{$image['thumb']}" data-width="{$image['width']}" data-height="{$image['height']}" width="{$image['width']}" height="{$image['height']}" />
			</a>
		</div>
EOL;
}
$data .= '</div>';
$addcaption = ($srz_album['hovercaption']) ? '.collageCaption({behaviour_c: '.$srz_album['hovercaptiontype'].'})' : '';
$data .= <<<EOL
<script>
	;
	jQuery(document).ready(function(){
		jQuery('#{$scroller_id} .Image_Wrapper').css("opacity", 0.3);
		jQuery('#{$scroller_id}').removeWhitespace().collagePlus({
			'allowPartialLastRow': {$srz_album['collagepartiallast']},
			'targetHeight': {$srz_album['targetheight']},
			'padding': {$srz_album['collagepadding']}
		}){$addcaption};
	});
	jQuery(window).resize(function(){
		jQuery('#{$scroller_id}').collagePlus({
			'allowPartialLastRow': {$srz_album['collagepartiallast']},
			'targetHeight': {$srz_album['targetheight']},
			'padding': {$srz_album['collagepadding']}
		});
	});
</script>
EOL;
