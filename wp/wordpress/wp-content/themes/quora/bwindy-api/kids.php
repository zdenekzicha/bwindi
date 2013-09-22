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


if($_GET["s"] == "profil"){

	$smarty->assign("data",jsonToArray('http://bwindi.petrsiller.cz/?presenter=json&action=profil&id='.$_GET["idDite"], null));
	$smarty->assign("timeline",jsonToArray('http://bwindi.petrsiller.cz/?presenter=json&action=timeline&id='.$_GET["idDite"], null));
	$smarty->display('diteProfil.tpl');


}else if ($_GET["page_id"] == "94") {
	
	$smarty->assign("data",jsonToArray('http://bwindi.petrsiller.cz/?presenter=json&action=adoptovaneDeti', null));

	$smarty->display('adoptovaneDeti.tpl');

}else {

	$smarty->assign("data",jsonToArray('http://bwindi.petrsiller.cz/?presenter=json&action=detiAdopce', null));

	$smarty->display('detiAdopce.tpl');
}



?>