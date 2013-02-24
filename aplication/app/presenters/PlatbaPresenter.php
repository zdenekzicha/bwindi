<?php

class platbaPresenter extends BasePresenter
{

	private $platby;
	private $filtr;

	public $filtrSelect;
	public $filtrText;
	public $filtrRok;

	protected function startup()
	{
	    parent::startup();
	    $this->platby = $this->context->platbaModel;
	}

	public function actionDefault($filtrSelect,$filtrText,$filtrRok) {

		$this->filtr = array();
		if(isset($filtrText)) {
			array_push($this->filtr, array($filtrSelect => $filtrText));
		}

		// jako defaultni hodnota filteru se bere aktualni rok
		
		if(isset($filtrRok) && $filtrRok != 'Rok') {
			array_push($this->filtr, array('rok' => $filtrRok));
		}

		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
		$this->filtrRok = $filtrRok;
	}

	public function renderDefault()
	{
		$this->template->platby = $this->platby->zobrazPlatby($this->filtr);
		$this->template->roky = $this->platby->zobrazVsechnyRoky();

		$this->template->filtrSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
		$this->template->filtrRok = $this->filtrRok;
	
	}

}

?>