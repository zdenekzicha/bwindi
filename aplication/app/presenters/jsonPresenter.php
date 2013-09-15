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
	 * Vypise adoptovane deti	
	*/
	public function renderDefault()
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
}

?>