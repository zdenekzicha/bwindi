<?php
/* Last updated with phpFlickr 1.3.2
 *
 * This example file shows you how to call the 100 most recent public
 * photos.  It parses through them and prints out a link to each of them
 * along with the owner's name.
 *
 * Most of the processing time in this file comes from the 100 calls to
 * flickr.people.getInfo.  Enabling caching will help a whole lot with
 * this as there are many people who post multiple photos at once.
 *
 * Obviously, you'll want to replace the "<api key>" with one provided 
 * by Flickr: http://www.flickr.com/services/api/key.gne
 */
// Start the session since phpFlickr uses it but does not start it itself
session_start();
require_once("phpFlickr.php");
/*
$f = new phpFlickr("ea5b2639a376614c747ccbe62faa4738");

$recent = $f->photos_getRecent();

foreach ($recent['photo'] as $photo) {
    $owner = $f->people_getInfo($photo['owner']);
    echo "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
    echo $photo['title'];
    echo "</a> Owner: ";
    echo "<a href='http://www.flickr.com/people/" . $photo['owner'] . "/'>";
    echo $owner['username'];
    echo "</a><br>";
}*/

// Create new phpFlickr object: new phpFlickr('[API Key]','[API Secret]')
$flickr = new phpFlickr('ea5b2639a376614c747ccbe62faa4738','0f68a240ec5f6830', true);

// Authenticate;  need the "IF" statement or an infinite redirect will occur
if(empty($_GET['frob'])) {
	$flickr->auth('write'); // redirects if none; write access to upload a photo
}
else {
	// Get the FROB token, refresh the page;  without a refresh, there will be "Invalid FROB" error
	$flickr->auth_getToken($_GET['frob']);
	header('Location: konec.php');
	exit();
}

// Send an image sync_upload(photo, title, desc, tags)
// The returned value is an ID which represents the photo
$result = $flickr->sync_upload('pic_BenjaminFriday.jpg', $_POST['Nazev fotky'], $_POST['Popis, popis, popis, popis.'], 'id1075, Abel Byamugisha');
echo $result;
?>
