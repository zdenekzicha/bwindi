<?php

/**
 * Vraci data jako json objekty
 */
class jsonPresenter extends BasePresenter
{

	private $deti;
	private $sponzor;
	private $platby;
	private $skola;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	    $this->sponzor = $this->context->sponzorModel;
	    $this->platby = $this->context->platbaModel;
	    $this->skola = $this->context->skolaModel;
	}

	/*
	 * Vypise deti k adopci	
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
		$list = $this->deti->zobrazAdoptovaneDetiNaWebu($search);
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

	/*
	 * Vypise deti mimo program - vystudovane
	*/
	public function actionDetiMimoProgram()
	{

		$this->payload->data = array();
		$list = $this->deti->zobrazDetiMimoProgram();
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


	/*
	 * Detail ditete
	*/
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

		// najdi dalsi a predchozi dite
		if($sponsor){
			$listDeti = $this->deti->zobrazAdoptovaneDetiNaWebu('');
		}else{
			$listDeti = $this->deti->zobrazDetiKAdopci('');
		}
		
		foreach ($listDeti as $key => $value) {
			if($value['idDite'] == $id){
				$next = $listDeti[$key + 1]['idDite'];
				$prev = $listDeti[$key - 1]['idDite'];
			}
		}
		
		// vyber dite
		$list = $this->deti->zobrazDiteApi($id);
		foreach ($list as $item) {

			// vypis profilovku
			$profilePhoto = $item['profilovaFotka'];

			// platby letos
			$platbaLetos = $this->platby->skolneNaKonkretniRok($item['idDite'], date("Y"));

			$platbaLetosRozdil = $item['castka'] - $platbaLetos[0]['rocniSoucet'];

			if($item['castka'] <= $platbaLetos[0]['rocniSoucet'] ){
				$skolneLetosZaplaceno = true;
			}else{
				$skolneLetosZaplaceno = false;
			}
			// --

			// platby nextYear
			$platbaPristiRok = $this->platby->skolneNaKonkretniRok($item['idDite'], date("Y") + 1);

			if($item['castkaPristiRok'] <= $platbaPristiRok[0]['rocniSoucet'] ){
				$skolnePristiRokZaplaceno = true;
			}else{
				$skolnePristiRokZaplaceno = false;
			}
			// --

			// skola
			$skola = $this->skola->zobrazSkolu($item['skolaId']);

			if($item['rocnik'] == $skola[$item['skolaId']]['maxRok']){
				$posledniRocnik = true;
				$skolnePristiRok = null;
				$platbaPristiRokRozdil = null;

				// ma nastaveno budouci skolu
				if(!is_null($item['skolaIdSkolaNext'])){
					$skolaNext = $this->skola->zobrazSkolu($item['skolaIdSkola']);
					$posledniRocnik = false;
					$skolnePristiRok = $skolaNext[0]["castkaPristiRok"];
					$platbaPristiRokRozdil = $skolnePristiRok - $platbaPristiRok[0]['rocniSoucet'];
				}

			}else{
				$posledniRocnik = false;
				$skolnePristiRok = $item['castkaPristiRok'];
				$platbaPristiRokRozdil = $skolnePristiRok - $platbaPristiRok[0]['rocniSoucet'];
			}
			// --

			$name = explode(" ",$item['jmeno']);
			
			// data do sablony
			$this->payload->data = array(
				//dite
				"id" => $item['idDite'], 
				"jmeno" => $name[0],
				"prijmeni" =>  $name[1],
				"prekladJmena" => $item['prekladJmena'],
				"bio" => $item['bio'],
				"vek" => $this->deti->vratVek($item['datumNarozeni']),
				"narozeni" => $item['datumNarozeni'],
				"pohlavi" => $item['pohlavi'],
				"fotka" => $profilePhoto,
				"sponzor" => $sponsor,
				"rezervovane" => $item['rezervovane'],
				"vs" => $item['vsym'],
				"ss" => $ssym,
				"dalsiDite" => $next,
				"predchoziDite" => $prev,
				//skola
				"rocnik" => $item['rocnik'],
				"skola" => $item['skolaNazev'],
				"skolaId" => $item['skolaIdSkola'],
				"skolaText" => $item['skolaText'],
				"skolaTyp" => $item['skolaTyp'],
				"jePosledniRocnik" => $posledniRocnik,
				//platby letos
				"skolneLetos" => $item['castka'],
				"skolneLetosZaplaceno" => $platbaLetos[0]['rocniSoucet'],
				"skolneLetosRozdil" => $platbaLetosRozdil,
				"jeSkolneLetosZaplaceno" => $skolneLetosZaplaceno,
				//patby pristi rok
				"skolnePristiRok" => $skolnePristiRok,
				"skolePristiRokZaplaceno" => $platbaPristiRok[0]['rocniSoucet'],
				"skolnePristiRokRozdil" => $platbaPristiRokRozdil,
				"jeSkolneNaPristiRokZaplaceno" => $skolnePristiRokZaplaceno,
			);
		
        }     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}
	
	/*
	 * Vypis timeline v detailu ditete
	*/
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

	/*
	 * Zobrazi seznam sourozencu
	*/
	public function actionSourozenec($id)
	{	

		$list = $this->deti->zobrazSourozence($id);

		$container = array();
		for ($i = 0; $i < count($list); $i++) {
			$note = array(
				"idDite" => $list[$i]['idDite'], 
				"jmeno" => $list[$i]['jmeno'],
				"profilovaFotka" => $list[$i]['profilovaFotka'],
				"pohlavi" => $list[$i]['pohlavi']
			);
			array_push($container, $note);
				
        } 
  

        if(!empty($container)) {
        	$this->payload->data[] = $container;
        }

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

}

?>