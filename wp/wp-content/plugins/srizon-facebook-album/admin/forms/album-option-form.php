<form action="admin.php?page=SrzFb-Albums&srzl=save" method="post">
	<?php SrizonFBUI::BoxHeader( 'box1', __( "Album Title", 'srizon-facebook-album' ), true ); ?>
	<table class="srzfb-admin-album" width="100%">
		<tr>
			<td colspan="2">
				<input type="text" name="title" size="50" value="<?php echo $value_arr['title']; ?>"/>
			</td>
		</tr>
	</table>
	<?php

	if ( isset( $_REQUEST['id'] ) ) {

		$fb = new SrizonFbAlbum( 0, '' );

		$optvar = SrizonFBDB::GetCommonOpt();

		if ( $value_arr['album_source'] == 'profile' ) {
			if ( $value_arr['auth_type'] == 'settings' ) {
				if ( $fb->test_app_id_secret( $optvar['srzfbappid'], $optvar['srzfbappsecret'] ) ) {
					$def_token = $optvar['srzfbappid'] . '|' . $optvar['srzfbappsecret'];
					if ( $optvar['longtoken'] and $optvar['longtoken'] != $def_token ) {
						if ( $fb->test_user_token( $optvar['longtoken'] ) ) {
							echo "<div class=\"updated notice notice-success\"><h4>" . __( "FB App setup and Token Seem Valid. Renew the token every month for regular sync.", 'srizon-facebook-album' ) . "</h4></div>";
						} else {
							echo '<div class="notice notice-warning"><h4>' . __( 'App ID and Secret seems Valid but User Access Token is invalid/expired. Check the Common Options page', 'srizon-facebook-album' ) . '</h4></div>';
						}
					} else {
						echo '<div class="error"><h4>' . __( 'App ID and Secret seems Valid but User Access Token was not provided/invalid. Get a token in Common Options page.', 'srizon-facebook-album' ) . '</h4></div>';
					}
				} else {
					echo "<div class=\"error\"><h2>" . __( "Can't get valid data from facebook. Either App ID/Secret is wrong or your server has connectivity problem", 'srizon-facebook-album' ) . "</h2></div>";
				}
			} else {
				if ( $fb->test_app_id_secret( $value_arr['app_id'], $value_arr['app_secret'] ) ) {
					if ( $value_arr['longtoken'] ) {
						if ( $fb->test_user_token( $value_arr['longtoken'] ) ) {
							echo "<div class=\"updated notice notice-success\"><h4>" . __( "FB App setup and Token Seem Valid. Renew the token every month for regular sync.", 'srizon-facebook-album' ) . "</h4></div>";
						} else {
							echo '<div class="notice notice-warning"><h4>' . __( 'App ID and Secret seems Valid but User Access Token is invalid/expired. Check App settings below', 'srizon-facebook-album' ) . '</h4></div>';
						}
					} else {
						echo '<div class="error"><h4>' . __( 'App ID and Secret seems Valid but User Access Token was not provided/invalid. Get a token under App Settings Below', 'srizon-facebook-album' ) . '</h4></div>';
					}
				} else {
					echo "<div class=\"error\"><h2>" . __( "Can't get valid data from facebook. Either App ID/Secret is wrong or your server has connectivity problem", 'srizon-facebook-album' ) . "</h2></div>";
				}
			}
		} else {
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
		}


	}

	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box2', __( "Album Source", 'srizon-facebook-album' ), true );
	?>
	<div>
		<table class="srzfb-admin-album" width="100%">
			<tr>
				<td width="20%"><label><?php _e( 'Source Type', 'srizon-facebook-album' ); ?></label></td>
				<td>
					<input type="radio" name="options[album_source]" class="album_source"
					       value="page" <?php if ( $value_arr['album_source'] == 'page' )
						echo 'checked' ?>> <?php _e( 'A Facebook Page', 'srizon-facebook-album' ); ?> <span
						class="srz-admin-subtext"><?php _e( '(App ID/secret will be used from', 'srizon-facebook-album' ); ?>
						<a
							href="admin.php?page=SrzFb"><?php _e( 'Common Settings', 'srizon-facebook-album' ); ?></a>)</span>
					<br> <input type="radio" name="options[album_source]" class="album_source"
					            value="profile" <?php if ( $value_arr['album_source'] == 'profile' )
						echo 'checked' ?>> <?php _e( 'My Facebook Profile', 'srizon-facebook-album' ); ?> <span
						class="srz-admin-subtext"> <?php _e( 'My = The person who authenticates the token on settings page or below (under New App settings)', 'srizon-facebook-album' ); ?></span>
				</td>
			</tr>
			<tr class="srz-cond" data-cond-option="album_source" data-cond-value="profile">
				<td><label for=""><?php _e( 'App settings', 'srizon-facebook-album' ); ?> <br><span
							class="srz-admin-subtext"><?php _e( '(ID/Secret/Token)', 'srizon-facebook-album' ); ?></span></label>
				</td>
				<td>
					<input type="radio" name="options[auth_type]" class="auth_type"
					       value="settings" <?php if ( $value_arr['auth_type'] == 'settings' )
						echo 'checked' ?>> <?php _e( 'Use from', 'srizon-facebook-album' ); ?> <a
						href="admin.php?page=SrzFb"><?php _e( 'Common Settings', 'srizon-facebook-album' ); ?></a>. <span
						class="srz-admin-subtext"> - <?php _e( 'Make sure you generated a User Access Token', 'srizon-facebook-album' ); ?></span>
					<br> <input type="radio" name="options[auth_type]" class="auth_type"
					            value="new" <?php if ( $value_arr['auth_type'] == 'new' )
						echo 'checked' ?>> <?php _e( 'New App settings', 'srizon-facebook-album' ); ?>
				</td>
			</tr>
			<tr class="srz-cond" data-cond-option="auth_type" data-cond-value="new">
				<td>
					<span class="label"><?php _e( 'App ID', 'srizon-facebook-album' ); ?></span>
				</td>
				<td>
					<input type="text" size="40" id="srzfbappid" name="options[app_id]"
					       value='<?php echo stripslashes( $value_arr['app_id'] ); ?>'/>

					<p class="srz-admin-subtext"> <?php _e( 'Enter your App ID. FB App should be set-up properly with the domain of this website.', 'srizon-facebook-album' ); ?>
						<a href="https://www.youtube.com/watch?v=QMGSgxlux4c"
						   target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a></p>
				</td>
			</tr>

			<tr class="srz-cond" data-cond-option="auth_type" data-cond-value="new">
				<td>
					<span class="label"><?php _e( 'App Secret', 'srizon-facebook-album' ); ?></span>
				</td>
				<td>
					<input type="text" size="40" id="srzfbappsecret" name="options[app_secret]"
					       value='<?php echo stripslashes( $value_arr['app_secret'] ); ?>'/>

					<p class="srz-admin-subtext"> <?php _e( 'Enter your App Secret. FB App should be set-up properly with the domain of this website.', 'srizon-facebook-album' ); ?>
						<a
							href="https://www.youtube.com/watch?v=QMGSgxlux4c"
							target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a>

					</p>
				</td>
			</tr>

			<tr class="srz-cond" data-cond-option="auth_type" data-cond-value="new">
				<td>
					<span class="label"><?php _e( 'User Access Token', 'srizon-facebook-album' ); ?><br><span
							class="srz-admin-subtext"><?php _e( '(Renew every month)', 'srizon-facebook-album' ); ?></span></span>
				</td>
				<td>
					<a href="javascript:;" class="button-primary"
					   id="srzFBloginbutton"><?php _e( "Loading FB Scripts..." ) ?></a> <input type="text" size="40"
					                                                                           id="srzfbaccesstoken"
					                                                                           name="options[srzfbaccesstoken]"
					                                                                           value='<?php echo stripslashes( $value_arr['srzfbaccesstoken'] ); ?>'/><br>

					<p class="srz-admin-subtext"><?php _e( 'In order to get user access token your FB App should be set-up properly with the domain of this website. Default App ID and Secret will not work as they are not set-up for your domain. Create your own app for your domain.', 'srizon-facebook-album' ); ?>
						<a href="https://www.youtube.com/watch?v=QMGSgxlux4c"
						   target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a></p>
				</td>
			</tr>
			<tr>
				<td><label for=""><?php _e( 'Album ID(s)', 'srizon-facebook-album' ); ?></label></td>
				<td>
					<textarea name="albumid" id="albumid" rows="5"
					          cols="50"><?php echo $value_arr['albumid']; ?></textarea>

					<p class="srz-admin-subtext"><?php _e( 'If the album link(URL) is', 'srizon-facebook-album' ); ?>
						<span
							style="color:blue;">http://www.facebook.com/media/set/?set=a.<strong
								style="color:red">number1</strong>.number2.number3...</span>
						<?php _e( 'then the ID is', 'srizon-facebook-album' ); ?> <strong
							style="color:red">number1</strong> <?php _e( 'which should be put in this field', 'srizon-facebook-album' ); ?>
					</p>

					<p class="srz-admin-subtext"><?php _e( 'Separate multiple IDs with newline or whitespace (They will be merged into a single album)', 'srizon-facebook-album' ); ?></p>

					<p class="srz-admin-subtext"><?php _e( 'For showing multiple album with different cover photo, add a', 'srizon-facebook-album' ); ?>
						<a
							href="admin.php?page=SrzFb-Galleries"><?php _e( 'Gallery', 'srizon-facebook-album' ); ?>
						</a> <?php _e( 'instead', 'srizon-facebook-album' ); ?></p>
				</td>
			</tr>
		</table>


		<div></div>
	</div>
	<?php
	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box3', __( "Layout Related", 'srizon-facebook-album' ), true );
	?>

	<table class="srzfb-admin-album">
		<tr>
			<td>
				<label class="label"
				       for="layout"><strong><?php _e( 'Layout', 'srizon-facebook-album' ); ?></strong></label>
			</td>
			<td>
				<select name="options[layout]" id="layout" class="layout-options">
					<option value="collage_thumb" <?php if ( $value_arr['layout'] == 'collage_thumb' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '1. Collage - Thumb', 'srizon-facebook-album' ); ?>
					</option>
					<option value="collage_full" <?php if ( $value_arr['layout'] == 'collage_full' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '2. Collage - Full', 'srizon-facebook-album' ); ?>
					</option>
					<option value="slider_lightbox" <?php if ( $value_arr['layout'] == 'slider_lightbox' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '3. Slider - Lightbox', 'srizon-facebook-album' ); ?>
					</option>
					<option value="slider_image_above" <?php if ( $value_arr['layout'] == 'slider_image_above' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '4. Slider - Image Above', 'srizon-facebook-album' ); ?>
					</option>
					<option value="slider_image_below" <?php if ( $value_arr['layout'] == 'slider_image_below' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '5. Slider - Image Below', 'srizon-facebook-album' ); ?>
					</option>
					<option value="single_image" <?php if ( $value_arr['layout'] == 'single_image' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '6. Single Image', 'srizon-facebook-album' ); ?>
					</option>
					<option value="image_card" <?php if ( $value_arr['layout'] == 'image_card' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '7. Image Card', 'srizon-facebook-album' ); ?>
					</option>
				</select>
			</td>
		</tr>

		<tr class="srz-cond" data-cond-option="layout-options"
		    data-cond-value="collage_thumb,slider_lightbox,slider_image_above,slider_image_below">
			<td><label for="targetheight"
			           class="label"><?php _e( 'Target Thumb Height', 'srizon-facebook-album' ); ?></label></td>
			<td>
				<input id="targetheight" name="options[targetheight]"
				       type="text"
				       value="<?php echo $value_arr['targetheight']; ?>"
					/>

				<p class="srz-admin-subtext"><?php _e( 'This may not be the exact height but closer to this', 'srizon-facebook-album' ); ?></p>
			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options" data-cond-value="collage_thumb,collage_full">
			<td><label for="collagepadding"
			           class="label"><?php _e( 'Collage - Padding', 'srizon-facebook-album' ); ?></label></td>
			<td>
				<input id="collagepadding" name="options[collagepadding]"
				       type="text"
				       value="<?php echo $value_arr['collagepadding']; ?>"
					/>

				<p class="srz-admin-subtext"><?php _e( 'Padding size around each image', 'srizon-facebook-album' ); ?></p>

			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options" data-cond-value="collage_thumb,collage_full">
			<td><label for="collagepartiallast"
			           class="label"><?php _e( 'Collage - Fill Last Row', 'srizon-facebook-album' ); ?>
				</label></td>
			<td>
				<select id="collagepartiallast" name="options[collagepartiallast]"

				        class="btn-group btn-group-yesno"
					>
					<option value="true" <?php if ( $value_arr['collagepartiallast'] == 'true' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
					</option>
					<option value="false" <?php if ( $value_arr['collagepartiallast'] == 'false' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
					</option>
				</select>

				<p class="srz-admin-subtext"><?php _e( 'Stretch the image of the last row to fill the space', 'srizon-facebook-album' ); ?></p>

			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options"
		    data-cond-value="collage_thumb,collage_full,slider_image_above,slider_image_below,single_image,image_card">
			<td><label for="hovercaption"
			           class="label"><?php _e( 'Mouse-over Caption', 'srizon-facebook-album' ); ?></label></td>
			<td>
				<em>Available on <a href="http://www.srizon.com/srizon-facebook-album"
				                    target="_blank">Pro Version</a> Only</em></td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options" data-cond-value="collage_thumb">
			<td><label for="showhoverzoom"
			           class="label"><?php _e( 'Animate Thumb on Hover', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<select id="showhoverzoom" name="options[showhoverzoom]"

				        class="btn-group btn-group-yesno"
					>
					<option value="1" <?php if ( $value_arr['showhoverzoom'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
					</option>
					<option value="0" <?php if ( $value_arr['showhoverzoom'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
					</option>
				</select>


			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options"
		    data-cond-value="slider_lightbox,slider_image_above,slider_image_below,single_image">
			<td><label for="animationspeed"
			           class="label"><?php _e( 'Animation Time in MilliSecs', 'srizon-facebook-album' ); ?></label></td>
			<td>
				<input id="animationspeed" name="options[animationspeed]"
				       type="text"
				       value="<?php echo $value_arr['animationspeed']; ?>"
					/>


			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options"
		    data-cond-value="slider_lightbox,slider_image_above,slider_image_below">
			<td><label for="autoslideinterval"
			           class="label"><?php _e( 'AutoSlide Interval in Seconds.', 'srizon-facebook-album' ); ?>
				</label></td>
			<td>
				<input id="autoslideinterval" name="options[autoslideinterval]"
				       type="text"
				       value="<?php echo $value_arr['autoslideinterval']; ?>"
					/>

				<p class="srz-admin-subtext"><?php _e( 'Put 0 for disabling autoSlide', 'srizon-facebook-album' ); ?></p>
			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="layout-options"
		    data-cond-value="collage_full,slider_image_above,slider_image_below,single_image,image_card">
			<td><label for="maxheight"
			           class="label"><?php _e( 'Maximum height of the full image', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<input id="maxheight" name="options[maxheight]"
				       type="text"
				       value="<?php echo $value_arr['maxheight']; ?>"
					/></td>
		</tr>

	</table>
	<?php
	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box4', __( "Options", 'srizon-facebook-album' ), true );
	?>
	<table class="srzfb-admin-album">
		<tr>
			<td>
				<label for="updatefeed"
				       class="label"><?php _e( 'Sync After Every # minutes', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<input type="text" size="5" name="options[updatefeed]" id="updatefeed"
				       value="<?php echo $value_arr['updatefeed']; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label"
				       for="image_sorting"><?php _e( 'Images Sorting', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<select name="options[image_sorting]" id="image_sorting">
					<option value="default" <?php if ( $value_arr['image_sorting'] == 'default' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Default (As given by FB API)', 'srizon-facebook-album' ); ?>
					</option>
					<option value="defaultr" <?php if ( $value_arr['image_sorting'] == 'defaultr' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Default Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="modified" <?php if ( $value_arr['image_sorting'] == 'modified' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Modification Time', 'srizon-facebook-album' ); ?>
					</option>
					<option value="modifiedr" <?php if ( $value_arr['image_sorting'] == 'modifiedr' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Modification Time Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="created" <?php if ( $value_arr['image_sorting'] == 'created' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Creation Time', 'srizon-facebook-album' ); ?>
					</option>
					<option value="createdr" <?php if ( $value_arr['image_sorting'] == 'createdr' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Creation Time Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="shuffle" <?php if ( $value_arr['image_sorting'] == 'shuffle' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Shuffle on each load', 'srizon-facebook-album' ); ?>
					</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>
				<label class="label"
				       for="totalimg"><?php _e( 'Total Number of Images', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<input type="text" size="5" name="options[totalimg]" id="totalimg"
				       value="<?php echo $value_arr['totalimg']; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label"
				       for="paginatenum"><?php _e( 'Paginate After # Thumbs', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<input type="text" size="5" id="paginatenum" name="options[paginatenum]"
				       value="<?php echo $value_arr['paginatenum']; ?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<label class="label"><?php wp_nonce_field( 'srz_fb_albums', 'srjfb_submit' ); ?></label>
				<?php
				if ( isset( $value_arr['id'] ) ) {
					echo '<input type="hidden" name="id" value="' . $value_arr['id'] . '" />';
				}
				?>
				<input type="submit" class="button-primary" name="submit"
				       value="<?php _e( 'Save Album', 'srizon-facebook-album' ); ?>"/>
			</td>
		</tr>
	</table>
	<?php SrizonFBUI::BoxFooter(); ?>
</form>