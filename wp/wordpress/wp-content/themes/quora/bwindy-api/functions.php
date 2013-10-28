<?php
	/*funkce pro prevod jsonu na pole*/
	function jsonToArray($link,$id){
		$json_string = $link.$id;
		$jsondata = file_get_contents($json_string);
		return json_decode($jsondata, true);
	}

	/*vrati obsah zpravy pro email ktery se posle bwindi */
	function getMsgForBwindi($sponsor,$email,$phone,$note,$childName) {
		$url = "http://bwindiweb.petrsiller.cz";

		$message = "<html><body  style='font-family: Arial, sans-serif;'>";
		$message .= "<p style='padding: 10px 0; margin: 0 50px; border-bottom: 1px solid #ccc; text-align: center;'>
						<img src='".$url."/wp-content/themes/quora/images/logo1.png' alt='Bwindi Orphans' width='150'>
					</p>";
		$message .= "<div style='text-align: center; color: #997653'>
						<h1 style='padding-top: 20px; font-size: 40px; font-weight: normal; color: #504342;'>Máme nového zájemce o adopci</h1>
						<p style='font-size: 14px; color: #997653;'>".$sponsor." by chtěl(a) adoptovat</p>
						<p><a href='".$url."/?page_id=48&idDite=".$childId."&s=profil' style='color: #4CB63D; font-size: 14px;'>".$childName."</a></p>
						<p style='padding-top: 20px; margin: 0; font-size: 14px; color: #997653;'>".$sponsor." píše:</p>";
		
		if($note != "") {
			$message .= "<p style='color: #504342; font-size: 14px;'>".$note."</p>";	
		}
						
		$message .= "<p style='padding-top: 20px; margin: 0; font-size: 14px; color: #997653;'>Kontaktujte ho prosím:</p>
					<h3 style='padding: 10px; margin: 0; font-size: 20px; font-weight: normal; color: #504342;'>
						<a href='mailto:.".$email."' style='font-size: 20px; color: #504342;'>".$email."</a>
					</h3>";

		if($phone != "") {
			$message .= "<h3 style='padding: 0 0 10px; margin: 0; font-size: 20px; font-weight: normal; color: #504342;'>".$phone."</h3>";
		}

		$message .= "</div>";

		$message .= "<div style='padding: 20px 0 10px; margin: 60px 50px 0; text-align: center; color: #997653; border-top: 1px solid #ccc;'>
						<a href='http://www.bwindiorphans.org' style='color: #4CB63D'>www.bwindiOrphans.org</a> -
						<a href='mailto:http://www.bwindiorphans.org' style='color: #4CB63D'>bwindiorphans@Bwindiorphans.org</a> - 
						+420 607 659 125
					</div>";
		$message .= "</html></body>";
		return $message;
	}

	/*vrati obsah zpravy pro email ktery se posle zajmci o adopci */
	function getMsgForSponsor($childId, $childName, $childPhoto) {
		$url = "http://bwindiweb.petrsiller.cz";

		if($childPhoto == '') {
			$childPhoto = $url.'/wp-content/themes/quora/images/portrait.jpg';
		}

		$message = "<html><body  style='font-family: Arial, sans-serif;'>";
		$message .= "<p style='padding: 10px 0; margin: 0 50px; border-bottom: 1px solid #ccc; text-align: center;'>
						<img src='".$url."/wp-content/themes/quora/images/logo1.png' alt='Bwindi Orphans' width='150'>
					</p>";
		$message .= "<div style='text-align: center; color: #997653'>
						<h1 style='padding-top: 20px; font-size: 40px; font-weight: normal; color: #504342;'>Děkujeme za váš zájem o adopci</h1>
						<p style='font-size: 14px; color: #997653;'>V nejbližší době vám pošleme číslo účtu a potřebné informace k provedení platby pro adoptování:</p>
						<p>
							<div style='position: relative; margin: 0 auto; height: 150px; width: 150px; overflow: hidden; border-radius: 50%; border: 3px solid #e9e2cb;'>	
								<img src='".$childPhoto."' alt='' style='width: 100%;' />
							</div>
							<a href='".$url."/?page_id=48&idDite=".$childId."&s=profil' style='color: #4CB63D; font-size: 14px;'>".$childName."</a>
						</p>
						<p style='font-size: 14px; color: #997653;'>Na tento email prosím neodpovídejte.</p>
						<p style='color: #504342; font-size: 14px;'><i>S pozdravem tým Bwindi Orphans a Benjamin Friday</i></p>
					</div>";
		$message .= "<div style='padding: 20px 0 10px; margin: 60px 50px 0; text-align: center; color: #997653; border-top: 1px solid #ccc;'>
						<a href='http://www.bwindiorphans.org' style='color: #4CB63D'>www.bwindiOrphans.org</a> -
						<a href='mailto:http://www.bwindiorphans.org' style='color: #4CB63D'>bwindiorphans@Bwindiorphans.org</a> - 
						+420 607 659 125
					</div>";
		$message .= "</html></body>";
		return $message;
	}
?>