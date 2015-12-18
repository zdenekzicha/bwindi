<?php
if (!class_exists('SrizonPagination')) {
	class SrizonPagination {
		private $_perPage;
		private $_instance;
		private $_page;
		private $_totalRows = 0;

		public function __construct($perPage, $instance) {
			$this->_instance = $instance;
			$this->_perPage = $perPage;
			$this->set_instance();
		}

		private function set_instance() {
			$this->_page = (int)(!isset($_GET[$this->_instance]) ? 1 : $_GET[$this->_instance]);
			$this->_page = ($this->_page == 0 ? 1 : $this->_page);
		}

		public function set_total($_totalRows) {
			$this->_totalRows = $_totalRows;
		}

		public function page_links($path = '?', $ext = null) {
			$adjacents = 2;
			$prev = $this->_page - 1;
			$next = $this->_page + 1;
			$lastpage = ceil($this->_totalRows / $this->_perPage);
			$lpm1 = $lastpage - 1;
			$pagination = "";
			if ($lastpage > 1) {
				$pagination .= "<ul class='srizon-pagination hidden-phone visible-desktop'>";
				if ($this->_page > 1)
					$pagination .= "<li><a href='" . $path . "$this->_instance=$prev" . "$ext'>".__('Prev','srizon-facebook-album')."</a></li>";
				else
					$pagination .= "<span class='disabled'>".__('Prev','srizon-facebook-album')."</span>";
				if ($lastpage < 7 + ($adjacents * 2)) {
					for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $this->_page)
							$pagination .= "<li><span class='current'>".__($counter,'srizon-facebook-album')."</span></li>";
						else
							$pagination .= "<li><a href='" . $path . "$this->_instance=$counter" . "$ext'>".__($counter,'srizon-facebook-album')."</a></li>";
					}
				} elseif ($lastpage > 5 + ($adjacents * 2)) {
					if ($this->_page < 1 + ($adjacents * 2)) {
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
							if ($counter == $this->_page)
								$pagination .= "<li><span class='current'>".__($counter,'srizon-facebook-album')."</span></li>";
							else
								$pagination .= "<li><a href='" . $path . "$this->_instance=$counter" . "$ext'>".__($counter,'srizon-facebook-album')."</a></li>";
						}
						$pagination .= "...";
						$pagination .= "<li><a href='" . $path . "$this->_instance=$lpm1" . "$ext'>".__($lpm1,'srizon-facebook-album')."</a></li>";
						$pagination .= "<li><a href='" . $path . "$this->_instance=$lastpage" . "$ext'>".__($lastpage,'srizon-facebook-album')."</a></li>";
					} elseif ($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2)) {
						$pagination .= "<li><a href='" . $path . "$this->_instance=1" . "$ext'>".__('1','srizon-facebook-album')."</a></li>";
						$pagination .= "<li><a href='" . $path . "$this->_instance=2" . "$ext'>".__('2','srizon-facebook-album')."</a></li>";
						$pagination .= "...";
						for ($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++) {
							if ($counter == $this->_page)
								$pagination .= "<span class='current'>".__($counter,'srizon-facebook-album')."</span>";
							else
								$pagination .= "<li><a href='" . $path . "$this->_instance=$counter" . "$ext'>".__($counter,'srizon-facebook-album')."</a></li>";
						}
						$pagination .= "..";
						$pagination .= "<li><a href='" . $path . "$this->_instance=$lpm1" . "$ext'>".__($lpm1,'srizon-facebook-album')."</a></li>";
						$pagination .= "<li><a href='" . $path . "$this->_instance=$lastpage" . "$ext'>".__($lastpage,'srizon-facebook-album')."</a></li>";
					} else {
						$pagination .= "<li><a href='" . $path . "$this->_instance=1" . "$ext'>".__('1','srizon-facebook-album')."</a></li>";
						$pagination .= "<li><a href='" . $path . "$this->_instance=2" . "$ext'>".__('2','srizon-facebook-album')."</a></li>";
						$pagination .= "..";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $this->_page)
								$pagination .= "<span class='current'>".__($counter,'srizon-facebook-album')."</span>";
							else
								$pagination .= "<li><a href='" . $path . "$this->_instance=$counter" . "$ext'>".__($counter,'srizon-facebook-album')."</a></li>";
						}
					}
				}
				if ($this->_page < $counter - 1)
					$pagination .= "<li><a href='" . $path . "$this->_instance=$next" . "$ext'>".__('Next','srizon-facebook-album')."</a></li>";
				else
					$pagination .= "<li><span class='disabled'>".__('Next','srizon-facebook-album')."</span></li>";
				$pagination .= "</ul>\n";
				// for small devices
				$pagination .= "<ul class='srizon-pagination hidden-desktop visible-phone'>";
				if ($this->_page > 1)
					$pagination .= "<li><a href='" . $path . "$this->_instance=$prev" . "$ext'>".__('Prev','srizon-facebook-album')."</a></li>";
				else
					$pagination .= "<span class='disabled'>".__('Prev','srizon-facebook-album')."</span>";
				if ($this->_page < $counter - 1)
					$pagination .= "<li><a href='" . $path . "$this->_instance=$next" . "$ext'>".__('Next','srizon-facebook-album')."</a></li>";
				else
					$pagination .= "<li><span class='disabled'>".__('Next','srizon-facebook-album')."</span></li>";
				$pagination .= "</ul>";
			}
			return $pagination;
		}
	}
}