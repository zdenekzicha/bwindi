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
			$profilePhoto = $item['profilovaFotka'];//$this->_getPhotoUrl($item['profilovaUrlSerializovana']);

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
			$profilePhoto = $profilePhoto = $item['profilovaFotka'];

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
    			
		// zjistime zda mame sponzora
		$sponsor = false;
		$sponsorData = $this->deti->existujeSponzor($id);
		if($sponsorData) {
			$sponsor = true;
		}

		$list = $this->deti->zobrazDiteApi($id);
		foreach ($list as $item) {

			$profilePhoto = $item['profilovaFotka'];

			$this->payload->data = array(
				"id" => $item['idDite'], 
				"jmeno" => $item['jmeno'],
				"bio" => $item['bio'],
				"rocnik" => $item['rocnik'],
				"vek" => $this->deti->vratVek($item['datumNarozeni']),
				"narozeni" => $item['datumNarozeni'],
				"pohlavi" => $item['pohlavi'],
				"skola" => $item['skolaNazev'],
				"fotka" => $profilePhoto,
				"sponzor" => $sponsor	
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

			$photo = $item['foto'];
			
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