<?php
	require('Smarty/libs/Smarty.class.php');
	require('functions.php');

	$smarty = new Smarty;

	$smarty->template_dir = dirname(__FILE__) .'/templates/';
	$smarty->config_dir = dirname(__FILE__) .'/config/';
	$smarty->compile_dir = dirname(__FILE__) .'/templates_c/';
	$smarty->cache_dir = dirname(__FILE__).'/cache/';

	$smarty->debugging = false;
	$smarty->caching = false;
	$smarty->cache_lifetime = 120;

	$server = 'http://admin.bwindiorphans.org';
	$emailReceiver = "katerina@bwindiorphans.org";


	if($_GET["s"] == "profil") { // zobrazi profil ditete
		$id = checkNumber($_GET["idDite"]);
		$smarty->assign("data",jsonToArray($server.'/?presenter=Json&action=profil&id='.$id, null));
		$smarty->assign("timeline",jsonToArray($server.'/?presenter=Json&action=timeline&id='.$id, null));
		$smarty->display('diteProfil.tpl');

	} 
	else if ($_GET["page_id"] == "119") { // zobrazi formular o adopci ditete
		$id = checkNumber($_GET["idDite"]);
		$smarty->assign("data",jsonToArray($server.'/?presenter=Json&action=profil&id='.$id, null));
		$smarty->display('formularAdopce.tpl');
	}
	else if ($_GET["page_id"] == "586") { // zpracovani odeslaneho formulare o adopci ditete

		/* ulozime si inforamce o diteti */
		$id = checkNumber($_GET["idDite"]);
		$data = jsonToArray($server.'/?presenter=Json&action=profil&id='.$id, null);
		$data['data']['email'] = $_GET["email"];
		
		/* posleme email bwindi o novem sponzorovi */
		$to      = $emailReceiver;
		$subject = 'Bwindi Oprhans - Nový zájemce o adopci';
		$message = getMsgForBwindi($id,$_GET['sponsor'],$_GET["email"],$_GET["phone"],$_GET["city"],$_GET["street"],$_GET["zipcode"],$_GET["note"],$data['data']['jmeno'],$data['data']['fotka']);	
		$headers = "From:". $_GET["email"]."\r\n";
		$headers .= "Reply-To:". $_GET["email"]."\r\n";
		$headers .= "Cc: petr.siller@gmail.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($to, $subject, $message, $headers);

		/* posleme email spnzorovi ze vime o jeho zajmu */
		$to      = $_GET["email"];
		$subject = 'Děkujeme za zájem o adopci, Bwindi Oprhans';
		$message = getMsgForSponsor($id, $data['data']['jmeno'],$data['data']['fotka']);
		$headers = "From: ".$emailReceiver."\r\n";
		$headers .= "Reply-To: ".$emailReceiver."\r\n";
		$headers .= "Cc: petr.siller@gmail.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($to, $subject, $message, $headers);
		
		$smarty->assign("data",$data);
		$smarty->display('dekujeme.tpl');
	}
	else if ($_GET["page_id"] == "94") { // zobrazi vypis adoptovanych deti
		$search = checkString($_GET["search"]);
		$smarty->assign("search", $search);
		$smarty->assign("data",jsonToArray($server.'/?presenter=Json&action=adoptovaneDeti&search='.$search, null));

		$smarty->display('adoptovaneDeti.tpl');
	}
	else if ($_GET["page_id"] == "11") { // zobrazi kontakty
		$smarty->display('kontakty.tpl');
	}

	else if (is_front_page()) { // na hp zobrazi prvnich x deti k adopci
		$smarty->assign("data",jsonToArray($server.'/?presenter=Json&action=detiAdopce', null));
		$smarty->display('detiAdopceNaHp.tpl');
	}
	else { // zobrazi vypis deti k adopci
		$smarty->assign("data",jsonToArray($server.'/?presenter=Json&action=detiAdopce', null));
		$smarty->display('detiAdopce.tpl');
	}
?>