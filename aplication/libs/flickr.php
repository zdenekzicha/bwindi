<?php
    //echo "Knihovna flickr je pripojena";
    require_once("../libs/phpflickr.php");
    $flickr = new phpFlickr('dcd9fe3a305890c4a9fe2bda3167be87','649d3653904e3bd4', true);
    $flickr->setToken("72157639234385904-f768dc0738d878a7");
    if(empty($_GET['frob'])) {
  	$flickr->auth('write'); // redirects if none; write access to upload a photo
  }
  else {
  	// Get the FROB token, refresh the page;  without a refresh, there will be "Invalid FROB" error
  	$flickr->auth_getToken($_GET['frob']);
  	header('Location: index.php');
  	exit();
  }
?>
