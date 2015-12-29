<?php

/**
 * Vraci data jako json objekty
 */
class jsonPresenter extends BasePresenter
{

	private $deti;
	private $sponzor;
	private $platby;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	    $this->sponzor = $this->context->sponzorModel;
	    $this->platby = $this->context->platbaModel;
	}

	/*
	 * Vypise deti k adobci	
	*/
	public function actionDetiAdopce()
	{

		$this->payload->data = array();
		$list = $this->deti->zobrazDetiKAdopci('');
		$i = 0;	

		foreach ($list as $item) {

			// dostaneme url na profilovou fotku
			$profilePhoto = $item['profilovaFotka'];

			
			if($item['pohlavi'] == 'M') {
				$pohlavi = 'male';
			}
			else {
				$pohlavi = 'female';
			}

			$data = array(
				"id" => $item['idDite'], 
				"jmeno" => $item['jmeno'],
				"pohlavi" => $pohlavi,
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
	public function actionAdoptovaneDeti($search)
	{

		$this->payload->data = array();
		$list = $this->deti->zobrazAdoptovaneDeti($search);
		$i = 0;		

		foreach ($list as $item) {

			// dostaneme url na profilovou fotku
			$profilePhoto = $profilePhoto = $item['profilovaFotka'];

			if($item['pohlavi'] == 'M') {
				$pohlavi = 'male';
			}
			else {
				$pohlavi = 'female';
			}

			$data = array(
				"id" => $item['idDite'],
				"vystavene" => $item['vystavene'], 
				"jmeno" => $item['jmeno'],
				"pohlavi" => $pohlavi,
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
		$isSponzor = $this->deti->existujeSponzor($id);
		if($isSponzor) {
			$sponsor = true;
			$sponsorData = $this->sponzor->zobrazSponzora($isSponzor[0]['sponzorIdSponzor']);
			$ssym = $sponsorData[$isSponzor[0]['sponzorIdSponzor']]['ssym'];
		}else{
			$ssym = 0;
		}
		
		$list = $this->deti->zobrazDiteApi($id);
		foreach ($list as $item) {

			$profilePhoto = $item['profilovaFotka'];
			$platba = $this->platby->skolneNaKonkretniRok($item['idDite'], date("Y"));

			if($item['castka'] <= $platba[0]['rocniSoucet'] ){
				$skolneZaplaceno = 'ano';
			}else{
				$skolneZaplaceno = 'ne';
			}

			$this->payload->data = array(
				"id" => $item['idDite'], 
				"jmeno" => $item['jmeno'],
				"bio" => $item['bio'],
				"rocnik" => $item['rocnik'],
				"vek" => $this->deti->vratVek($item['datumNarozeni']),
				"narozeni" => $item['datumNarozeni'],
				"pohlavi" => $item['pohlavi'],
				"skola" => $item['skolaNazev'],
				"skolaText" => $item['skolaText'],
				"skolaTyp" => $item['skolaTyp'],
				"skolne" => $item['castka'],
				"zaplaceneSkolne" => $platba[0]['rocniSoucet'],
				"skolneRozdil" => $item['castka'] - $platba[0]['rocniSoucet'],
				"skolneZaplaceno" => $skolneZaplaceno,
				"fotka" => $profilePhoto,
				"sponzor" => $sponsor,
				"rezervovane" => $item['rezervovane'],
				"vs" => $item['vsym'],
				"ss" => $ssym
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

			$photoBig = $this->deti->sestavUrlProfiloveFotky(unserialize($item['fotoUrlSerializovana']), 'large');
			
			$note = array(
				"id" => $item['id'], 
				"idDite" => $item['idDite'],
				"rok" => $item['rok'],
				"text" => $item['text'],
				"foto" => $item['foto'],
				"fotoBig" => $photoBig
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