<?php
function srz_fb_gallery_shortcode( $atts ) {
	if ( ! isset( $atts['id'] ) ) {
		return __('Invalid shortcode... ID missing','srizon-facebook-album');
	}
	$srz_pageid = $atts['id'];
	$srz_page   = SrizonFBDB::GetGallery( $srz_pageid );
	if ( ! $srz_page ) {
		return __('Page Not Found','srizon-facebook-album');
	}
	if($srz_page['album_source'] == 'profile') $srz_page['pageid']='me';
	srz_fb_set_debug_msg( 'Album Details:', $srz_page );
	if ( ! isset( $GLOBALS['imggroup'] ) ) {
		$GLOBALS['imggroup'] = 1;
	} else {
		$GLOBALS['imggroup'] ++;
	}
	$paging_id   = 'jfb' . $GLOBALS['imggroup'];
	$scroller_id = 'fbalbum' . $GLOBALS['imggroup'];
	$aid         = 'aid' . $GLOBALS['imggroup'];
	$set         = isset( $_REQUEST[ $aid ] ) ? $_REQUEST[ $aid ] : '';

	$srzfbgallery = new SrizonFBAlbum( $srz_page['updatefeed'] * 60, srz_fb_get_access_token( $srz_page ) );
	if ( $set ) {
		$srz_images_all = $srzfbgallery->get_facebook_albums_images( $_REQUEST[ $aid ], $srz_page['image_sorting'] );
		$pagetitle      = $srzfbgallery->get_pagetitle( $srz_page['pageid'], $set ,$srz_page['id']);
	} else {
		$srz_images_all = $srzfbgallery->get_facebook_gallery_covers( $srz_page['pageid'], $srz_page['album_sorting'], $srz_page['include_exclude'], $srz_page['excludeids'], $srz_page['id'] );
	}
	srz_fb_set_debug_msg( 'Images', $srz_images_all );

	$srz_common_options = SrizonFBDB::GetCommonOpt();
	if ( $srz_common_options['loadlightbox'] == 'mp' ) {
		$lightbox_attribute = 'class="aimg"';
	} else {
		$lightbox_attribute = stripslashes( $srz_common_options['lightboxattrib'] );
	}

	$srz_totalimgall = count( $srz_images_all );
	$srz_cur_page    = isset( $_REQUEST[ $paging_id ] ) ? ( $_REQUEST[ $paging_id ] - 1 ) : 0;
	$srz_images      = array_slice( $srz_images_all, $srz_cur_page * $srz_page['paginatenum'], $srz_page['paginatenum'] );
	$data            = '';
	include( dirname( __FILE__ ) . '/../tmpl/gallery.php' );
	$data .= srizon_show_pagination( $srz_page['paginatenum'], $srz_totalimgall, $scroller_id, $paging_id, $srz_common_options['jumptoarea'] );

	return $data;
}

add_shortcode( 'srizonfbgallery', 'srz_fb_gallery_shortcode' );

