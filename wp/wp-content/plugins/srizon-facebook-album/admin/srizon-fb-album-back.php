<?php
function srz_fb_albums() {
	SrizonFBUI::PageWrapStart();
	if ( isset( $_REQUEST['srzf'] ) ) {
		switch ( $_REQUEST['srzf'] ) {
			case 'edit':
				srz_fb_albums_edit();
				break;
			default:
				break;
		}
	} else {
		if ( isset( $_REQUEST['srzl'] ) ) {
			switch ( $_REQUEST['srzl'] ) {
				case 'save';
					srz_fb_albums_save();
					break;
				case 'delete':
					srz_fb_albums_delete();
					break;
				case 'sync':
					srz_fb_albums_sync();
					break;
				default:
					break;
			}
		}
		echo '<h2>Albums<a href="admin.php?page=SrzFb-Albums&srzf=edit" class="add-new-h2">' . __( 'Add New', 'srizon-facebook-album' ) . '</a></h2>';
		$albums = SrizonFBDB::GetAllAlbums();
		include( 'tables/album-table.php' );
	}
	SrizonFBUI::PageWrapEnd();
}


function srz_fb_albums_edit() {
	$optvar = SrizonFBDB::GetCommonOpt();
	if ( isset( $_GET['id'] ) ) {
		echo '<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>' . __( 'Edit Album', 'srizon-facebook-album' ) . '</h2>';
		$value_arr = SrizonFBDB::GetAlbum( $_GET['id'] );
	} else {
		echo '<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>' . __( 'Add New Album', 'srizon-facebook-album' ) . '</h2>';
		$value_arr = array(
			'title'              => '',
			'albumid'            => '',
			'updatefeed'         => '600',
			'image_sorting'      => 'default',
			'totalimg'           => '1000',
			'layout'             => 'collage_thumb',
			'tpltheme'           => 'white',
			'paginatenum'        => '18',
			'targetheight'       => '200',
			'collagepadding'     => '2',
			'collagepartiallast' => 'true',
			'hovercaption'       => '1',
			'hovercaptiontype'   => '0',
			'showhoverzoom'      => '1',
			'animationspeed'     => '500',
			'autoslideinterval'  => '0',
			'maxheight'          => '500',
			'album_source'       => 'page',
			'auth_type'          => 'settings',
			'app_id'             => $optvar['srzfbappid'],
			'app_secret'         => $optvar['srzfbappsecret'],
		);
	}

	SrizonFBUI::OptionWrapperStart();
	SrizonFBUI::RightColStart();
	SrizonFBUI::BoxHeader( 'box1', __( "About Single Album", 'srizon-facebook-album' ) );
	echo '<div><p>' . __( 'It creates a single album using one or more Facebook album IDs.', 'srizon-facebook-album' ) . '</p>
<p>' . __( 'If multiple IDs are used, they will be merged into a single album.', 'srizon-facebook-album' ) . '</p>
<p>' . __( 'For showing multiple album with different cover photo, add a', 'srizon-facebook-album' ) . ' <a href="admin.php?page=SrzFb-Galleries">' . __( 'Gallery', 'srizon-facebook-album' ) . '</a> ' . __( 'instead', 'srizon-facebook-album' ) . '</p></div>';
	SrizonFBUI::BoxFooter();
	SrizonFBUI::RightColEnd();
	SrizonFBUI::LeftColStart();
	include 'forms/album-option-form.php';
	SrizonFBUI::LeftColEnd();
	SrizonFBUI::OptionWrapperEnd();
}

function srz_fb_albums_save() {
	if ( wp_verify_nonce( $_POST['srjfb_submit'], 'srz_fb_albums' ) == false ) {
		die( 'Nice Try!' );
	}
	if ( ! isset( $_POST['id'] ) ) {
		SrizonFBDB::SaveAlbum( true );
		echo "<div class=\"updated notice notice-success is-dismissible\"><h4>" . __( "New Album Created! Now copy the shortcode and use it in your post/page", 'srizon-facebook-album' ) . "</h4></div>";
	} else {
		SrizonFBDB::SaveAlbum( false );
		echo "<div class=\"updated notice notice-success is-dismissible\"><h4>" . __( "Album Saved!", 'srizon-facebook-album' ) . "</h4></div>";
	}
}

function srz_fb_albums_delete() {
	if ( isset( $_GET['id'] ) ) {
		SrizonFBDB::DeleteAlbum( $_GET['id'] );
	}
	echo "<div class=\"notice notice-warning is-dismissible\"><h4>" . __( "Album Deleted!", 'srizon-facebook-album' ) . "</h4></div>";
}

function srz_fb_albums_sync() {
	if ( isset( $_GET['id'] ) ) {
		SrizonFBDB::SyncAlbum( $_GET['id'] );
	}
	echo "<div class=\"updated notice notice-success is-dismissible\"><h4>" . __( "Cached data deleted for this album! It will be synced on the next load!", 'srizon-facebook-album' ) . "</h4></div>";
}