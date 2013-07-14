<?php

class apiPresenter extends BasePresenter
{

	private $deti;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	}

	public function actionApiDetiKAdpopci()
	{	

		$this->payload->data = $this->deti->zobrazDetiKAdopci();
    	$this->sendPayload();

	}
}

?>
