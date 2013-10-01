<?php

/**
 * Vraci data jako json objekty
 */
class jsonPresenter extends BasePresenter
{

	private $deti;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	}

	/* vrati url fotky
	 * @param {string} - seralizovana url fotky
	 * @returns {string} - url fotky
	*/
	private function _getPhotoUrl($photo, $size = "Medium") {

		if($photo) {
			$photoUrl = unserialize($photo);
			$profilePhoto = $this->deti->sestavUrlProfiloveFotky($photoUrl, $size);
		}
		else {
			$profilePhoto = null;
		}

		return $profilePhoto;
	}

	/*
	 * Vypise deti k adobci	
	*/
	public function actionDetiAdopce()
	{

		$this->payload->data = array();
		$list = $this->deti->zobrazDetiKAdopci();
		$i = 0;	

		foreach ($list as $item) {

			// zobrazime pouze jmeno
			$name = explode(" ", $item['jmeno']);

			// dostaneme url na profilovou fotku
			$profilePhoto = $this->_getPhotoUrl($item['profilovaUrlSerializovana']);

			$data = array(
				"id" => $item['idDite'], 
				"jmeno" => $name[0],
				"fotka" => $profilePhoto
			);
			
            $this->payload->data[$i] = $data;
            $i++;
        }
     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}


	/*
	 * Vypise adoptovaných deti	
	*/
	public function actionAdoptovaneDeti()
	{

		$this->payload->data = array();
		$list = $this->deti->zobrazAdoptovaneDeti();
		$i = 0;		

		foreach ($list as $item) {

			// zobrazime pouze jmeno
			$name = explode(" ", $item['jmeno']);

			// dostaneme url na profilovou fotku
			$profilePhoto = $this->_getPhotoUrl($item['profilovaUrlSerializovana']);

			$data = array(
				"id" => $item['idDite'],
				"vystavene" => $item['vystavene'], 
				"jmeno" => $name[0],
				"fotka" => $profilePhoto
			);
			
            $this->payload->data[$i] = $data;
            $i++;
        }
     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

	public function actionProfil($id)
	{	
    	
		$list = $this->deti->zobrazDiteApi($id);

		foreach ($list as $item) {

			$bio = "Ahoj jmenuji se Agnes, ale všichni mi říkají Agii. Bydlím s mámou, mladší sestrou a bratrancem v malém domku, který se nám podařilo opravit díky vaší pomoci. Tatá mi umřel když mi bylo 14 a moc mi chybí. Máme pracuje na poli, takže když nejsem ve škole, snažím se jí pomáhat.";

			$profilePhoto = $this->_getPhotoUrl($item['profilovaUrlSerializovana']);

			$this->payload->data = array(
				"id" => $item['idDite'], 
				"jmeno" => $item['jmeno'],
				"bio" => $bio,
				"narozeni" => $item['datumNarozeni'],
				"pohlavi" => $item['pohlavi'],
				"skola" => $item['skolaNazev'],
				"fotka" => $profilePhoto	
			);
		
        }     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

	public function actionTimeline($id)
	{	
		$list = $this->deti->zobrazTimeline($id);

		$container = array();

		// grupujeme data v timeline podle roku
		foreach ($list as $item) {

			$photo = $this->_getPhotoUrl($item['fotoUrlSerializovana'],'large');
			
			$note = array(
				"id" => $item['id'], 
				"idDite" => $item['idDite'],
				"rok" => $item['rok'],
				"text" => $item['text'],
				"foto" => $photo
			);
			
			if($year == $item['rok']) {
				$container[] = $note;
			}
			else {
				if(!empty($container)) {
					$this->payload->data[] = $container;
				}
				$year = $item['rok'];				
				$container = array();
				$container[] = $note;
			}
		
        }   

        if(!empty($container)) {
        	$this->payload->data[] = $container;
        }

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

}

?>