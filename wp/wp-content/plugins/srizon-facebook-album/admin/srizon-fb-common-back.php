<?php
add_action( 'admin_menu', 'srz_fb_menu' );

function srz_fb_menu() {
	$srzfbpagehook  = add_menu_page( __( 'FB Album', 'srizon-facebook-album' ), __( 'FB Album', 'srizon-facebook-album' ), 'manage_options', 'SrzFb', 'srz_fb_options_page', srz_fb_get_resource_url( 'resources/images/srzfb-icon.png' ) );
	$srzfbpagehook2 = add_submenu_page( 'SrzFb', "FB Album", __( 'Albums', 'srizon-facebook-album' ), 'manage_options', 'SrzFb-Albums', 'srz_fb_albums' );
	$srzfbpagehook3 = add_submenu_page( 'SrzFb', "FB Album", __( 'Galleries', 'srizon-facebook-album' ), 'manage_options', 'SrzFb-Galleries', 'srz_fb_galleries' );
	add_action( "admin_print_scripts-{$srzfbpagehook}", 'srzfb_load_admin_resources' );
	add_action( "admin_print_scripts-{$srzfbpagehook2}", 'srzfb_load_admin_resources' );
	add_action( "admin_print_scripts-{$srzfbpagehook3}", 'srzfb_load_admin_resources' );
	global $submenu;
	$submenu['SrzFb'][0][0] =  __( 'Common Options', 'srizon-facebook-album' );
}

function srzfb_load_admin_resources() {
	wp_enqueue_style( 'srzfbadmin', WP_PLUGIN_URL . '/srizon-facebook-album/admin/resources/admin.css', null, '1.0' );
	wp_enqueue_script( 'srzfbadmin', WP_PLUGIN_URL . '/srizon-facebook-album/admin/resources/admin.js', array( 'jquery' ), '1.0' );
}

function srz_fb_options_page() {
	SrizonFBUI::PageWrapStart();
	if ( $_POST['submit'] ) {
		if ( wp_verify_nonce( $_POST['srjfb_submit'], 'SrjFb' ) == false ) {
			die( 'Form token mismatch!' );
		}
		$optvar = SrizonFBDB::SaveCommonOpt();
	} else {
		$optvar = SrizonFBDB::GetCommonOpt();
	}
	echo '<div class="icon32" id="icon-tools"><br /></div><h2>' . __( 'Srizon FB Album Option Page', 'srizon-facebook-album' ) . '</h2>';
	SrizonFBUI::OptionWrapperStart();
	SrizonFBUI::RightColStart();
	SrizonFBUI::BoxHeader( 'box1', __( "About This Plugin", 'srizon-facebook-album' ) );
	echo '<p>' . __( 'This Plugin will show your Facebook album(s) into your WordPress site.', 'srizon-facebook-album' ) . '
<br> ' . __( 'Select', 'srizon-facebook-album' ) . ' <em>' . __( 'Albums', 'srizon-facebook-album' ) . '</em> ' . __( 'or', 'srizon-facebook-album' ) . ' <em>' . __( 'Galleries', 'srizon-facebook-album' ) . '</em> ' . __( 'from sub-menu and add a new album or gallery', 'srizon-facebook-album' ) . '.
<br>' . __( 'Use the generated shortcode on your post/page to display the album/gallery', 'srizon-facebook-album' ) . '</p>';
	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box-what-to-do', __( "What to do:", 'srizon-facebook-album' ) );
	echo '<p><ol>
<li>' . __( 'Setup the options on this page', 'srizon-facebook-album' ) . '</li>
<li>' . __( 'Click on the Albums or Galleries sub-menu', 'srizon-facebook-album' ) . '</li>
<li>' . __( 'Click "Add New" button to add a new album or gallery. (or click on an existing album title to edit that)', 'srizon-facebook-album' ) . '</li>
<li>' . __( 'Fill-up or modify the form and save that', 'srizon-facebook-album' ) . '</li>
<li>' . __( 'Your albums or galleries will be listed along with the shortcodes. Use the shortcodes into your page/post to show the photo album or gallery', 'srizon-facebook-album' ) . '</li>
<li>' . __( 'Try out different options/layouts', 'srizon-facebook-album' ) . '</li>
</ol></p>';
	SrizonFBUI::BoxFooter();
	SrizonFBUI::RightColEnd();
	SrizonFBUI::LeftColStart();
	include 'forms/common-option-form.php';
	SrizonFBUI::LeftColEnd();
	SrizonFBUI::OptionWrapperEnd();
	SrizonFBUI::PageWrapEnd();
}