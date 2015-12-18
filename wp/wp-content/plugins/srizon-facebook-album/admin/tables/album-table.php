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
	if ( ! count( $albums ) ) {
		echo '<tr><td colspan="4"><em>'.__( 'No Albums Found', 'srizon-facebook-album' ).'</em></td></tr>';
	}
	foreach ( $albums as $album ) {
		if ( ! trim( $album->title ) ) {
			$album->title = '<em>'.__( 'Empty', 'srizon-facebook-album' ).'</em>';
		}
		?>
		<tr>
			<td>
				<a class="row-title"
				   href="admin.php?page=SrzFb-Albums&srzf=edit&id=<?php echo $album->id ?>"><?php echo $album->title; ?></a>
			</td>
			<td><input type="text" value="[srizonfbalbum id=<?php echo $album->id ?>]"/></td>
			<td width="150" class="last-table-head"><a class="button delete"
			                                           href="admin.php?page=SrzFb-Albums&srzl=delete&id=<?php echo $album->id ?>"
			                                           onclick="return confirm('Are you sure you want to delete?');"><?php _e( 'Delete', 'srizon-facebook-album' ); ?></a> &nbsp;&nbsp;
				<a class="button"
				   href="admin.php?page=SrzFb-Albums&srzl=sync&id=<?php echo $album->id ?>"><?php _e( 'ReSync', 'srizon-facebook-album' ); ?></a>
			</td>
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
