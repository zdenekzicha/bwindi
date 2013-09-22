<?php

class apiPresenter extends BasePresenter
{

	private $deti;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	}

	public function actionDetiKAdpopci()
	{	

		$this->payload->data = $this->deti->zobrazDetiKAdopci();
    	$this->sendPayload();

	}

	public function actionAdoptovaneDeti()
	{	

		$this->payload->data = $this->deti->zobrazAdoptovaneDeti();
    	$this->sendPayload();

	}

	public function actionDetailDite($id)
	{	
		
		$this->payload->data = $this->deti->zobrazDiteApi($id);
    	$this->sendPayload();

	}

	public function actionTimeline($id)
	{
		//print_r($this->deti->zobrazTimeline($id));
		$this->payload->data = $this->deti->zobrazTimeline($id);
    	$this->sendPayload();

	}
}

?>
