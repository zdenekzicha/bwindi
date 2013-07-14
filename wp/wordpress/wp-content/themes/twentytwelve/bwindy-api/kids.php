<?php

$json_string = 'http://localhost:8888/Bwindy/sandbox/www/api/apidetikadpopci';
$jsondata = file_get_contents($json_string);
$obj = json_decode($jsondata, true);

//print_r($obj);

require('Smarty/libs/Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = dirname(__FILE__) .'/templates/';
$smarty->config_dir = dirname(__FILE__) .'/config/';
$smarty->compile_dir = dirname(__FILE__) .'/templates_c/';
$smarty->cache_dir = dirname(__FILE__).'/cache/';

$smarty->debugging = true;
$smarty->caching = true;
$smarty->cache_lifetime = 120;

$smarty->assign("data",$obj);

$smarty->display('index.tpl');

echo "a";

?>