<?php

class sponzorPresenter extends BasePresenter
{

	private $sponzori;
	private $deti;
	private $filtr;

	public $filtrSelect;
	public $filtrText;

	protected function startup()
	{
	    parent::startup();
	    $this->sponzori = $this->context->sponzorModel;
	    $this->deti = $this->context->diteModel;
	}

	public function actionDefault($filtrSelect,$filtrText) {

		$this->filtr = array();
		if(isset($filtrText)) {
			array_push($this->filtr, array($filtrSelect => $filtrText));
		}

		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
	}

	public function renderDefault()
	{
		$this->template->sponzori = $this->sponzori->zobrazSponzory($this->filtr);
		$this->template->deti = $this->deti->zobrazAdoptovaneDeti();

		$this->template->filtrSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
	}

}

?>
