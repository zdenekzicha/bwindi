<?php
//SrizonResourceLoader::load_mag_popup();
//SrizonResourceLoader::load_collage_plus();
//SrizonResourceLoader::load_srizon_custom_css();
$url = remove_query_arg($aid);
$url = remove_query_arg($paging_id,$url);
if($srz_common_options['jumptoarea'] == 'true'){
	$blink = $url.'#'.$scroller_id;
}
else{
	$blink = $url;
}
$extraclass = '';
if($srz_page['showhoverzoom']) $extraclass.=' zoom';
$backlink = ' <a href="' . $blink . '">' .  __('[Back To Gallery]','srizon-facebook-album') . '</a>';
$dtg=' data-gallery="gallery"';
if ($set) {
	$data .= '<h2>' . $pagetitle . $backlink . '</h2>';
	$dtg='';
}

$data .= '<div class="fbalbum'.$extraclass.'"  id="' . $scroller_id . '">';
foreach ($srz_images as $image) {
	if ($set) {
		$link = $image['src'];
		$grelval = $lightbox_attribute;
	} else {
		$u = remove_query_arg($paging_id);
		$link = add_query_arg($aid,$image['id'],$u);
		if($srz_common_options['jumptoarea'] == 'true'){
			$link = $link.'#'.$scroller_id;
		}
		$grelval = '';
		$image['txt'] = __('Album: ','srizon-facebook-album') . $image['txt'] . "\n";
		if ($srz_page['show_image_count']) {
			$image['txt'] = $image['txt'] . $image['count'] . __(' Photos','srizon-facebook-album');
		}
	}
	$caption = nl2br($image['txt']);
	$data .= <<<EOL
		<div class="Image_Wrapper" data-caption="{$caption}">
			<a href="{$link}"  data-title="{$caption}" {$grelval}{$dtg}>
				<img alt="{$caption}" src="{$image['thumb']}" data-width="{$image['width']}" data-height="{$image['height']}" width="{$image['width']}" height="{$image['height']}" />
			</a>
		</div>
EOL;
}
$data .= '</div>';
if($set) {
	$addcaption = ( $srz_page['hovercaption'] ) ? '.collageCaption({behaviour_c: ' . $srz_page['hovercaptiontype'] . '})' : '';
}
else{
	$addcaption = ( $srz_page['hovercaption'] ) ? '.collageCaption({behaviour_c: ' . $srz_page['hovercaptiontypecover'] . '})' : '';
}

$data .= <<<EOL
<script>
	;
	jQuery(document).ready(function(){
		jQuery('#{$scroller_id} .Image_Wrapper').css("opacity", 0.3);
		jQuery('#{$scroller_id}').removeWhitespace().collagePlus({
			'allowPartialLastRow': {$srz_page['collagepartiallast']},
			'targetHeight': {$srz_page['maxheight']},
			'padding': {$srz_page['collagepadding']}
		}){$addcaption};
	});
	jQuery(window).resize(function(){
		jQuery('#{$scroller_id}').collagePlus({
			'allowPartialLastRow': {$srz_page['collagepartiallast']},
			'targetHeight': {$srz_page['maxheight']},
			'padding': {$srz_page['collagepadding']}
		});
	});
</script>
EOL;

