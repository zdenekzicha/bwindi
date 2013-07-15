<?php

require('Smarty/libs/Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = dirname(__FILE__) .'/templates/';
$smarty->config_dir = dirname(__FILE__) .'/config/';
$smarty->compile_dir = dirname(__FILE__) .'/templates_c/';
$smarty->cache_dir = dirname(__FILE__).'/cache/';

$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 120;


/*funkce pro prevod jsonu na pole*/
function jsonToArray($link,$id){
	$json_string = $link.$id;
	$jsondata = file_get_contents($json_string);
	return json_decode($jsondata, true);
}


if($_GET["s"] == "dite"){
	
	$smarty->assign("data",jsonToArray('http://localhost:8888/Bwindy/sandbox/www/api/detailDite/', $_GET['id']));

	$smarty->display('index.tpl');


}elseif ($_GET["s"] == "adoptovanedeti") {
	
	$smarty->assign("data",jsonToArray('http://localhost:8888/Bwindy/sandbox/www/api/adoptovanedeti', null));

	$smarty->display('index.tpl');

}else {
	
	$smarty->assign("data",jsonToArray('http://localhost:8888/Bwindy/sandbox/www/api/detikadpopci', null));

	$smarty->display('index.tpl');
}

?>