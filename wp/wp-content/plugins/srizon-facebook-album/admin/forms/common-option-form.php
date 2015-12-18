<?php
SrizonFBUI::BoxHeader( 'pro-version', "Get The Pro Version", true, 'closed' );
?>
<table class="srzfb-admin-common">
	<tr>
		<td colspan="2">
			<h4>Limitations of this version</h4>
			<ol>
				<li>Each album can display only 25 images or less</li>
				<li>Each gallery can display 25 or less album covers. Each cover will open an album with not more than 25 images
				</li>
				<li>No caption for images</li>
			</ol>
			<h4>What's in the pro version</h4>
			<ol>
				<li>Each album can display all the images from facebook. No limitation</li>
				<li>Each gallery will show all the album covers. Each cover will open the full album</li>
				<li>Description of each image from facebook will be used as image caption which is shown below the lightbox photo
				</li>
				<li>For each gallery you can Include a selected few albums or exclude a few albums and show all other albums
				</li>
			</ol>
			<h4>Get the pro version now</h4>
			<a target="_blank"
			   href="http://www.srizon.com/srizon-facebook-album">http://www.srizon.com/wordpress-plugin/srizon-facebook-album</a>

			<p>If you already have purchased the pro version you can get it from <a href="http://www.srizon.com/update" target="_blank">Srizon Website</a> or contact srizon support (support@srizon.com) with your purchase ID or email address you used for purchasing.</p>
		</td>
	</tr>
</table>
<?php
SrizonFBUI::BoxFooter();
SrizonFBUI::BoxHeader( 'box3', __( "Common Options", 'srizon-facebook-album' ), true );
$fb = new SrizonFbAlbum( 0, '' );

if ( $fb->test_app_id_secret( $optvar['srzfbappid'], $optvar['srzfbappsecret'] ) ) {
	$def_token = $optvar['srzfbappid'] . '|' . $optvar['srzfbappsecret'];
	if ( $optvar['longtoken'] and $optvar['longtoken'] != $def_token ) {
		if ( $fb->test_user_token( $optvar['longtoken'] ) ) {
			echo "<div class=\"updated notice notice-success\"><h4>" . __( "FB App setup and Token Seem Valid. Renew the token every month for regular sync.", 'srizon-facebook-album' ) . "</h4></div>";
		} else {
			echo '<div class="notice notice-warning"><h4>' . __( 'App ID and Secret seems Valid but User Access Token is invalid/expired. The app will only be able to work with public/unrestricted &quot;FB Pages&quot;. Get a token and give the app more power.', 'srizon-facebook-album' ) . '</h4></div>';
		}
	} else {
		echo '<div class="notice notice-warning"><h4>' . __( 'App ID and Secret seems Valid but User Access Token was not provided/invalid. The app will only be able to work with public/unrestricted &quot;FB Pages&quot;. Get a token and give the app more power.', 'srizon-facebook-album' ) . '</h4></div>';
	}
} else {
	echo "<div class=\"error\"><h2>" . __( "Can't get valid data from facebook. Either App ID/Secret is wrong or your server has connectivity problem", 'srizon-facebook-album' ) . "</h2></div>";
}
?>
<form action="admin.php?page=SrzFb" method="post">
	<table class="srzfb-admin-common">
		<tr>
			<td width="20%">
				<span class="label"><?php _e( 'Lightbox Selection:', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<input type="radio" name="loadlightbox"
				       value="mp"<?php if ( $optvar['loadlightbox'] == 'mp' ) {
					echo ' checked="checked"';
				} ?> /><?php _e( 'Built in Responsive Lightbox', 'srizon-facebook-album' ); ?>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <input type="radio" name="loadlightbox"
				                                                   value="no"<?php if ( $optvar['loadlightbox'] == 'no' ) {
					echo ' checked="checked"';
				} ?> /><?php _e( 'Other Lightbox', 'srizon-facebook-album' ); ?>
			</td>
		</tr>
		<tr>
			<td>
				<span class="label"><?php _e( 'Lightbox Link Attribute', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<input type="text" size="30" name="lightboxattrib"
				       value='<?php echo stripslashes( $optvar['lightboxattrib'] ); ?>'/>

				<p class="srz-admin-subtext"><?php _e( '(Might be required for Other Lightbox)', 'srizon-facebook-album' ); ?></p>
			</td>
		</tr>
		<tr>
			<td><span class="label"><?php _e( 'Scroll to target', 'srizon-facebook-album' ); ?></span></td>
			<td>
				<input type="radio" name="jumptoarea"
				       value="false"<?php if ( $optvar['jumptoarea'] == 'false' ) {
					echo ' checked="checked"';
				} ?> /> <?php _e( 'No', 'srizon-facebook-album' ); ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <input
					type="radio" name="jumptoarea"
					value="true"<?php if ( $optvar['jumptoarea'] == 'true' ) {
					echo ' checked="checked"';
				} ?> /> <?php _e( 'Yes', 'srizon-facebook-album' ); ?>
				<p class="srz-admin-subtext"><?php _e( 'Scroll to album area when an album/pagination link is clicked?', 'srizon-facebook-album' ); ?></p>
			</td>

		</tr>
		<tr>
			<td colspan="2">
				<strong><?php _e( 'Default App ID - App Secret - User Token', 'srizon-facebook-album' ); ?></strong><br>
				<br>
				<?php _e( 'You can also fetch a User Token which is needed for fetching personal albums/gallery', 'srizon-facebook-album' ); ?>
			</td>
		</tr>

		<tr>
			<td>
				<span class="label"><?php _e( 'App ID', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<input type="text" size="40" id="srzfbappid" name="srzfbappid"
				       value='<?php echo stripslashes( $optvar['srzfbappid'] ); ?>'/>

				<p class="srz-admin-subtext"><?php _e( 'Put the default App ID.', 'srizon-facebook-album' ); ?>
					<a
						href="https://www.youtube.com/watch?v=QMGSgxlux4c"
						target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a></p>
			</td>
		</tr>

		<tr>
			<td>
				<span class="label"><?php _e( 'App Secret', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<input type="text" size="40" id="srzfbappsecret" name="srzfbappsecret"
				       value='<?php echo stripslashes( $optvar['srzfbappsecret'] ); ?>'/>

				<p class="srz-admin-subtext"><?php _e( 'Put the default App Secret.', 'srizon-facebook-album' ); ?>
					<a
						href="https://www.youtube.com/watch?v=QMGSgxlux4c"
						target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a></p>
			</td>
		</tr>

		<tr>
			<td>
				<span class="label"><?php _e( 'User Access Token', 'srizon-facebook-album' ); ?> <br><span
						class="srz-admin-subtext"><?php _e( '(Renew every month)', 'srizon-facebook-album' ); ?></span></span>
			</td>
			<td>
				<a href="javascript:;" class="button-primary"
				   id="srzFBloginbutton"><?php _e( "Loading FB Scripts..." ) ?></a> <input type="text" size="40"
				                                                                           id="srzfbaccesstoken"
				                                                                           name="srzfbaccesstoken"
				                                                                           value='<?php echo stripslashes( $optvar['srzfbaccesstoken'] ); ?>'/><br>

				<p class="srz-admin-subtext"><?php _e( 'In order to get user access token your FB App should be set-up properly with the domain of this website. Default App ID and Secret will not work as they are not set-up for your domain. Create your own app for your domain.', 'srizon-facebook-album' ); ?>
					<a href="https://www.youtube.com/watch?v=QMGSgxlux4c"
					   target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a></p>
			</td>
		</tr>

		<tr>
			<td>
				<span class="label"><?php wp_nonce_field( 'SrjFb', 'srjfb_submit' ); ?></span>
			</td>
			<td>
				<input type="submit" class="button-primary" name="submit"
				       value="<?php _e( 'Save Options', 'srizon-facebook-album' ); ?>"/>
			</td>
		</tr>

	</table>
</form>
<?php
SrizonFBUI::BoxFooter();
SrizonFBUI::BoxHeader( 'box4', __( "How to setup other lightbox: (An example showing setup instructions for FancyBox)", 'srizon-facebook-album' ), true, 'closed' );
?>
<table>
	<tr>
		<td>
			<ol>
				<li><?php _e( 'Select "Other Lightbox" above', 'srizon-facebook-album' ); ?></li>
				<li><?php _e( 'Put rel="something" on the next field (should be already there by default) and save', 'srizon-facebook-album' ); ?></li>
				<li><?php _e( 'Install', 'srizon-facebook-album' ); ?> <a target="_blank"
				                                                          href="http://wordpress.org/extend/plugins/fancybox-for-wordpress/">FancyBox
						<?php _e( 'for Wordpress', 'srizon-facebook-album' ); ?></a></li>
				<li><?php _e( 'After installation and activation of FancyBox plugin go to it\'s settings panel', 'srizon-facebook-album' ); ?></li>
				<li><?php _e( 'Select "Extra Calls" Tab', 'srizon-facebook-album' ); ?></li>
				<li><?php _e( 'Check (activate) "Additional FancyBox Calls"', 'srizon-facebook-album' ); ?></li>
				<li><?php _e( 'A textbox will expand. Put the following code there', 'srizon-facebook-album' ); ?> <br/>
					<textarea rows="9" cols="50">jQuery(".fbalbum > div.imgboxouter >
						a").fancybox({
						'transitionIn': 'elastic',
						'transitionOut': 'elastic',
						'speedIn': 600,
						'speedOut': 200,
						'type': 'image'
						}); </textarea>
				</li>
				<li><?php _e( 'Save Changes and reload the album on frontend', 'srizon-facebook-album' ); ?></li>
				<li><?php _e( 'Now you should see the images of this plugin loading in fancybox', 'srizon-facebook-album' ); ?></li>
			</ol>
		</td>
	</tr>
</table>