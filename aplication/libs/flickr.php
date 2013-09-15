<?php
    echo "Knihovna flickr je pripojena";
    require_once("../libs/phpflickr.php");
    $flickr = new phpFlickr('ea5b2639a376614c747ccbe62faa4738','0f68a240ec5f6830', true);
    $flickr->setToken("72157635508355551-44072074b100f1be");
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
