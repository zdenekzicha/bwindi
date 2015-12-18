<?php
if ( ! function_exists( 'sort_created_time' ) ) {
	function sort_created_time( $a, $b ) {
		$atime = strtotime( $a['created_time'] );
		$btime = strtotime( $b['created_time'] );
		if ( $atime < $btime ) {
			return - 1;
		} else {
			return 1;
		}
	}
}
if ( ! function_exists( 'sort_updated_time' ) ) {
	function sort_updated_time( $a, $b ) {
		$atime = strtotime( $a['updated_time'] );
		$btime = strtotime( $b['updated_time'] );
		if ( $atime < $btime ) {
			return - 1;
		} else {
			return 1;
		}
	}
}

if ( ! function_exists( 'srz_fb_get_access_token' ) ) {
	function srz_fb_get_access_token( $arr ) {
		if ( $arr['album_source'] == 'profile' ) {
			if ( $arr['auth_type'] == 'new' ) {
				return '&access_token=' . $arr['longtoken'];
			} else {
				$common_opts = SrizonFBDB::GetCommonOpt();

				return '&access_token=' . $common_opts['longtoken'];
			}

		} else {
			$common_opts = SrizonFBDB::GetCommonOpt();

			return '&access_token=' . $common_opts['longtoken'];
		}
	}
}

if ( ! function_exists( 'srz_fb_set_debug_msg' ) ) {
	function srz_fb_set_debug_msg( $title, $message ) {
		if ( isset( $_REQUEST['debugjfb'] ) ) {
			echo '<h2>' . $title . '</h2>';
			echo '<pre>';
			print_r( $message );
			echo '</pre>';
		}
	}
}
//todo

if ( ! function_exists( 'srizon_show_pagination' ) ) {
	function srizon_show_pagination( $per_page, $total, $scroller_id, $paging_id, $jumptoarea = 'false' ) {
		if ( ! $total > $per_page ) {
			return;
		}
		require_once( dirname( __FILE__ ) . '/srizon_pagination.php' );
		$paginator = new SrizonPagination( $per_page, $paging_id );
		$paginator->set_total( $total );
		$url = remove_query_arg( $paging_id );
		if ( $jumptoarea == 'true' ) {
			if ( strpos( $url, '?' ) ) {
				return $paginator->page_links( $url . '&', '#' . $scroller_id );
			} else {
				return $paginator->page_links( $url . '?', '#' . $scroller_id );
			}
		} else {
			if ( strpos( $url, '?' ) ) {
				return $paginator->page_links( $url . '&' );
			} else {
				return $paginator->page_links( $url . '?' );
			}
		}
	}
}
