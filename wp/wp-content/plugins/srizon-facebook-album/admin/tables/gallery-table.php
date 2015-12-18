<table class="wp-list-table widefat srzfbalbumtable">
	<thead>
	<tr>
		<th><?php _e( 'Title', 'srizon-facebook-album' ); ?></th>
		<th><?php _e( 'Shortcode', 'srizon-facebook-album' ); ?></th>
		<th class="last-table-head"><?php _e( 'Action', 'srizon-facebook-album' ); ?></th>
	</tr>
	</thead>

	<tbody>
	<?php
	if ( ! count( $galleries ) ) {
		echo '<tr><td colspan="4"><em>'.__( 'No Galleries Found', 'srizon-facebook-album' ).'</em></td></tr>';
	}
	foreach ( $galleries as $gallery ) {
		if ( ! trim( $gallery->title ) ) {
			$gallery->title = '<em>'.__( 'Empty', 'srizon-facebook-album' ).'</em>';
		}
		?>
		<tr>
			<td>
				<a class="row-title"
				   href="admin.php?page=SrzFb-Galleries&srzf=edit&id=<?php echo $gallery->id ?>"><?php echo $gallery->title; ?></a>
			</td>
			<td><input type="text" value="[srizonfbgallery id=<?php echo $gallery->id ?>]"/></td>
			<td class="last-table-head" width="150"><a class="button delete"
			                                           href="admin.php?page=SrzFb-Galleries&srzl=delete&id=<?php echo $gallery->id ?>"
			                                           onclick="return confirm('Are you sure you want to delete?');"><?php _e( 'Delete', 'srizon-facebook-album' ); ?></a> &nbsp;&nbsp;
				<a class="button button-cancel"
				   href="admin.php?page=SrzFb-Galleries&srzl=sync&id=<?php echo $gallery->id ?>"><?php _e( 'ReSync', 'srizon-facebook-album' ); ?></a></td>
		</tr>
	<?php } ?>
	</tbody>

	<thead>
	<tr>
		<th><?php _e( 'Title', 'srizon-facebook-album' ); ?></th>
		<th><?php _e( 'Shortcode', 'srizon-facebook-album' ); ?></th>
		<th class="last-table-head"><?php _e( 'Action', 'srizon-facebook-album' ); ?></th>
	</tr>
	</thead>
</table>
