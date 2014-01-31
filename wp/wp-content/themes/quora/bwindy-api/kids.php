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

	$server = 'http://bwindi.petrsiller.cz';


	if($_GET["s"] == "profil") { // zobrazi profil ditete
		$id = checkNumber($_GET["idDite"]);
		$smarty->assign("data",jsonToArray($server.'/?presenter=json&action=profil&id='.$id, null));
		$smarty->assign("timeline",jsonToArray($server.'/?presenter=json&action=timeline&id='.$id, null));
		$smarty->display('diteProfil.tpl');

	} 
	else if ($_GET["page_id"] == "119") { // zobrazi formular o adopci ditete
		$id = checkNumber($_GET["idDite"]);
		$smarty->assign("data",jsonToArray($server.'/?presenter=json&action=profil&id='.$id, null));
		$smarty->display('formularAdopce.tpl');
	}
	else if ($_GET["page_id"] == "586") { // zpracovani odeslaneho formulare o adopci ditete

		/* ulozime si inforamce o diteti */
		$id = checkNumber($_GET["idDite"]);
		$data = jsonToArray($server.'/?presenter=json&action=profil&id='.$id, null);
		$data['data']['email'] = $_GET["email"];
		
		/* posleme email bwindi o novem sponzorovi */
		$to      = 'petr.siller@gmail.com';
		$subject = 'Bwindi Oprhans - Nový zájemce o adopci';
		$message = getMsgForBwindi($_GET['sponsor'],$_GET["email"],$_GET["phone"],$_GET["note"],$data['data']['jmeno']);	
		$headers = "From: info@bwindiorphans.org\r\n";
		$headers .= "Reply-To: info@bwindiorphans.org\r\n";
		$headers .= "CC: katerina@bwindiorphans.org\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($to, $subject, $message, $headers);

		/* posleme email spnzorovi ze vime o jeho zajmu */
		$to      = 'petr.siller@gmail.com';
		$subject = 'Děkujeme za zájem o adopci, Bwindi Oprhans';
		$message = getMsgForSponsor($data['data']['id'], $data['data']['jmeno'],$data['data']['fotka']);	
		$headers = "From: info@bwindiorphans.org\r\n";
		$headers .= "Reply-To: info@bwindiorphans.org\r\n";
		$headers .= "CC: katerina@bwindiorphans.org\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($to, $subject, $message, $headers);
		
		$smarty->assign("data",$data);
		$smarty->display('dekujeme.tpl');
	}
	else if ($_GET["page_id"] == "94") { // zobrazi vypis adoptovanych deti
		$search = checkString($_GET["search"]);
		$smarty->assign("search", $search);
		$smarty->assign("data",jsonToArray($server.'/?presenter=json&action=adoptovaneDeti&search='.$search, null));

		$smarty->display('adoptovaneDeti.tpl');
	}
	else if ($_GET["page_id"] == "11") { // zobrazi kontakty
		$smarty->display('kontakty.tpl');
	}
	else { // zobrazi vypis deti k adopci
		$smarty->assign("data",jsonToArray($server.'/?presenter=json&action=detiAdopce', null));
		$smarty->display('detiAdopce.tpl');
	}
?>