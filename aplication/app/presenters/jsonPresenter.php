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

			$data = array(
				"id" => $item['idDite'], 
				"jmeno" => $name[0]
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

			$data = array(
				"id" => $item['idDite'], 
				"jmeno" => $name[0]
			);
			
            $this->payload->data[$i] = $data;
            $i++;
        }
     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

	public function actionProfil($id)
	{	
    	
		$list = $this->deti->zobrazDite($id);

		foreach ($list as $item) {

			$bio = "Ahoj jmenuji se Agnes, ale všichni mi říkají Agii. Bydlím s mámou, mladší sestrou a bratrancem v malém domku, který se nám podařilo opravit díky vaší pomoci. Tatá mi umřel když mi bylo 14 a moc mi chybí. Máme pracuje na poli, takže když nejsem ve škole, snažím se jí pomáhat.";

			$this->payload->data = array(
				"id" => $item['idDite'], 
				"jmeno" => $item['jmeno'],
				"bio" => $bio,
				"narozeni" => $item['datumNarozeni'],
				"pohlavi" => $item['pohlavi'],
				"skola" => $item['skolaNazev']	
			);
		
        }     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

	public function actionTimeline($id)
	{	
		$list = $this->deti->zobrazTimeline($id);

		$data = array();

		foreach ($list as $item) {

			$this->payload->data[] = array(
				"id" => $item['id'], 
				"idDite" => $item['idDite'],
				"rok" => $item['rok'],
				"text" => $item['text'],
				"foto" => $item['foto']
			);
		
        }     

        $this->sendPayload();
        $this->terminate(); // ukončí presenter

	}

}

?>