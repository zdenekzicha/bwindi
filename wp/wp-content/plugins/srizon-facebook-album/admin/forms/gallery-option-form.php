<form action="admin.php?page=SrzFb-Galleries&srzl=save" method="post">
	<?php SrizonFBUI::BoxHeader( 'box1', __( "Gallery Title", 'srizon-facebook-album' ), true ); ?>
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
	SrizonFBUI::BoxHeader( 'box2', __( "Gallery Source", 'srizon-facebook-album' ), true );
	?>
	<div>
		<table class="srzfb-admin-album" width="100%">
			<tr>
				<td width="25%"><label><?php _e( 'Source Type', 'srizon-facebook-album' ); ?></label></td>
				<td>
					<input type="radio" name="options[album_source]" class="album_source"
					       value="page" <?php if ( $value_arr['album_source'] == 'page' )
						echo 'checked' ?>> <?php _e( 'A Facebook Page', 'srizon-facebook-album' ); ?> <span
						class="srz-admin-subtext">(<?php _e( 'App ID/secret will be used from', 'srizon-facebook-album' ); ?>
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
						echo 'checked' ?>> Use from <a
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
							target="_blank"><?php _e( 'How-to video', 'srizon-facebook-album' ); ?></a></p>
				</td>
			</tr>

			<tr class="srz-cond" data-cond-option="auth_type" data-cond-value="new">
				<td>
					<span class="label"><?php _e( 'User Access Token', 'srizon-facebook-album' ); ?> <br><span
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
			<tr class="srz-cond" data-cond-option="album_source" data-cond-value="page">
				<td><label for=""><?php _e( 'Page ID', 'srizon-facebook-album' ); ?></label></td>
				<td>
					<input type="text" name="pageid" size="25" value="<?php echo $value_arr['pageid']; ?>"/>

					<p class="srz-admin-subtext">
						<?php _e( 'If the Page link(URL) is', 'srizon-facebook-album' ); ?> <span
							style="color:blue;">http://www.facebook.com/<strong
								style="color: red">pagename</strong></span>
						<?php _e( 'then the ID is', 'srizon-facebook-album' ); ?> <strong
							style="color: red">pagename</strong> <?php _e( 'which should be put in this field.', 'srizon-facebook-album' ); ?>
					</p>

					<p class="srz-admin-subtext">
						<?php _e( 'If the Page link(URL) is', 'srizon-facebook-album' ); ?> <span
							style="color:blue;">http://www.facebook.com/pages/name/<strong
								style="color: red;">number</strong></span>
						<?php _e( 'then the ID is the', 'srizon-facebook-album' ); ?> <strong
							style="color: red;">number</strong> <?php _e( 'which should be put in this field.', 'srizon-facebook-album' ); ?>
					</p>

				</td>
			</tr>
		</table>
	</div>
	<?php
	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box3', __( "Include or Exclude Albums", 'srizon-facebook-album' ), true );
	?>
	<div>
		<table class="srzfb-admin-gallery">
			<tr>
				<td colspan="2"><em>Available on <a href="http://www.srizon.com/srizon-facebook-album"
				                                    target="_blank">Pro Version</a> Only</em></td>
			</tr>
		</table>
	</div>
	<?php
	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box33', __( "Layout Related", 'srizon-facebook-album' ), true );
	?>

	<table class="srzfb-admin-gallery">
		<tr>
			<td width="30%"><label for="maxheight"
			                       class="label"><?php _e( 'Target Thumb Height', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<input id="maxheight" name="options[maxheight]"
				       type="text"
				       value="<?php echo $value_arr['maxheight']; ?>"
					/>

				<p class="srz-admin-subtext"><?php _e( 'This may not be the exact height but closer to this.', 'srizon-facebook-album' ); ?></p>
			</td>
		</tr>
		<tr>
			<td><label for="collagepadding"
			           class="label"><?php _e( 'Collage - Padding', 'srizon-facebook-album' ); ?></label></td>
			<td>
				<input id="collagepadding" name="options[collagepadding]"
				       type="text"
				       value="<?php echo $value_arr['collagepadding']; ?>"
					/>


			</td>
		</tr>
		<tr>
			<td><label for="collagepartiallast"
			           class="label"><?php _e( 'Collage - Fill Last Row', 'srizon-facebook-album' ); ?></label>
			</td>
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


			</td>
		</tr>
		<tr>
			<td><label for="hovercaptiontypecover"
			           class="label"><?php _e( 'Caption Behavior (Cover Photos)', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<select id="hovercaptiontypecover" name="options[hovercaptiontypecover]"
					>
					<option value="0" <?php if ( $value_arr['hovercaptiontypecover'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Show On Hover - Hide On Leave', 'srizon-facebook-album' ); ?>
					</option>
					<option value="1" <?php if ( $value_arr['hovercaptiontypecover'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Hide On Hover - Show On Leave', 'srizon-facebook-album' ); ?>
					</option>
					<option value="2" <?php if ( $value_arr['hovercaptiontypecover'] == '2' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Always Show', 'srizon-facebook-album' ); ?>
					</option>
				</select>


			</td>
		</tr>
		<tr>
			<td><label for="hovercaption"
			           class="label"><?php _e( 'Mouse Over Caption (Album Photos)', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<select id="hovercaption" name="options[hovercaption]"

				        class="hovercaption"
					>
					<option value="1" <?php if ( $value_arr['hovercaption'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
					</option>
					<option value="0" <?php if ( $value_arr['hovercaption'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
					</option>
				</select>
			</td>
		</tr>
		<tr class="srz-cond" data-cond-option="hovercaption" data-cond-value="1">
			<td><label for="hovercaptiontype"
			           class="label"><?php _e( 'Caption Behavior (Album Photos)', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<select id="hovercaptiontype" name="options[hovercaptiontype]"
					>
					<option value="0" <?php if ( $value_arr['hovercaptiontype'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Show On Hover - Hide On Leave', 'srizon-facebook-album' ); ?>
					</option>
					<option value="1" <?php if ( $value_arr['hovercaptiontype'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Hide On Hover - Show On Leave', 'srizon-facebook-album' ); ?>
					</option>
					<option value="2" <?php if ( $value_arr['hovercaptiontype'] == '2' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Always Show', 'srizon-facebook-album' ); ?>
					</option>
				</select>


			</td>
		</tr>
		<tr>
			<td><label for="show_image_count"
			           class="label"><?php _e( 'Show Image Count On Album Cover', 'srizon-facebook-album' ); ?></label>
			</td>
			<td>
				<select id="show_image_count" name="options[show_image_count]"

				        class="btn-group btn-group-yesno"
					>
					<option value="1" <?php if ( $value_arr['show_image_count'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
					</option>
					<option value="0" <?php if ( $value_arr['show_image_count'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
					</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="showhoverzoom"
			           class="label"><?php _e( 'Animate Thumb on Hover', 'srizon-facebook-album' ); ?></label></td>
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

	</table>
	<?php
	SrizonFBUI::BoxFooter();
	SrizonFBUI::BoxHeader( 'box4', __( "Options", 'srizon-facebook-album' ), true );
	?>
	<table class="srzfb-admin-gallery">
		<tr>
			<td width="30%">
				<span
					class="label"><?php _e( 'Sync After Every # minutes', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<input type="text" size="5" name="options[updatefeed]"
				       value="<?php echo $value_arr['updatefeed']; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<span class="label"><?php _e( 'Album (Cover) Sorting', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<select name="options[album_sorting]">
					<option value="default" <?php if ( $value_arr['album_sorting'] == 'default' )
						echo 'selected="selected"' ?>><?php _e( 'Default (As given by FB API)', 'srizon-facebook-album' ); ?>
					</option>
					<option value="defaultr" <?php if ( $value_arr['album_sorting'] == 'defaultr' )
						echo 'selected="selected"' ?>><?php _e( 'Default Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="modified" <?php if ( $value_arr['album_sorting'] == 'modified' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time', 'srizon-facebook-album' ); ?>
					</option>
					<option value="modifiedr" <?php if ( $value_arr['album_sorting'] == 'modifiedr' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="created" <?php if ( $value_arr['album_sorting'] == 'created' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time', 'srizon-facebook-album' ); ?>
					</option>
					<option value="createdr" <?php if ( $value_arr['album_sorting'] == 'createdr' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="shuffle" <?php if ( $value_arr['album_sorting'] == 'shuffle' )
						echo 'selected="selected"' ?>><?php _e( 'Shuffle on each load', 'srizon-facebook-album' ); ?>
					</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<span class="label"><?php _e( 'Images Sorting (Inside each Album)', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<select name="options[image_sorting]">
					<option value="default" <?php if ( $value_arr['image_sorting'] == 'default' )
						echo 'selected="selected"' ?>><?php _e( 'Default (As given by FB API)', 'srizon-facebook-album' ); ?>
					</option>
					<option value="defaultr" <?php if ( $value_arr['image_sorting'] == 'defaultr' )
						echo 'selected="selected"' ?>><?php _e( 'Default Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="modified" <?php if ( $value_arr['image_sorting'] == 'modified' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time', 'srizon-facebook-album' ); ?>
					</option>
					<option value="modifiedr" <?php if ( $value_arr['image_sorting'] == 'modifiedr' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="created" <?php if ( $value_arr['image_sorting'] == 'created' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time', 'srizon-facebook-album' ); ?>
					</option>
					<option value="createdr" <?php if ( $value_arr['image_sorting'] == 'createdr' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time Reversed', 'srizon-facebook-album' ); ?>
					</option>
					<option value="shuffle" <?php if ( $value_arr['image_sorting'] == 'shuffle' )
						echo 'selected="selected"' ?>><?php _e( 'Shuffle on each load', 'srizon-facebook-album' ); ?>
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
				<span class="label"><?php _e( 'Paginate After # Images', 'srizon-facebook-album' ); ?></span>
			</td>
			<td>
				<input type="text" size="5" name="options[paginatenum]"
				       value="<?php echo $value_arr['paginatenum']; ?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div>
					<span class="label"><?php wp_nonce_field( 'SrzFbGalleries', 'srjfb_submit' ); ?></span>
					<?php
					if ( isset( $value_arr['id'] ) ) {
						echo '<input type="hidden" name="id" value="' . $value_arr['id'] . '" />';
					}
					?>
					<input type="submit" class="button-primary" name="submit"
					       value="<?php _e( 'Save Gallery', 'srizon-facebook-album' ); ?>"/>
				</div>
			</td>
		</tr>
	</table>
	<?php
	SrizonFBUI::BoxFooter();
	?>

</form>