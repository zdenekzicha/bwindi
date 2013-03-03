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

	// vytvori formular pro pridani sponzora
	protected function createComponentNovySponzorForm()
	{
 
		$deti = $this->deti->zobrazVsechnyDeti();
		$detiSelect = array();

		foreach ($deti as $key => $value) {
			$detiSelect[$value['idDite']] = $value['jmeno'];
		}
		
	    $form = new NAppForm;
	    $form->addText('jmeno', 'Jméno:', 40, 255)->addRule(NAppForm::FILLED, 'Je nutné zadat jméno sponzora.');
	    $form->addText('ulice', 'Adresa:', 40, 255);
	    $form->addText('psc', 'PSČ:', 6, 5)->addRule(NAppForm::PATTERN, 'PSČ musí mít 5 číslic.', '([0-9]\s*){5}');
	    $form->addText('ssym', 'Specifický symbol:', 10, 10)->addRule(NAppForm::PATTERN, 'Specifický symbol musí být číslo.', '([0-9]\s*)');
	    $form->addText('mesto', 'Město:', 40, 255);
	    $form->addText('mail', 'E-mail:', 40, 255);
	    $form->addText('telefon', 'Telefon:', 40, 255);
	    $form->addHidden('aktivniZaznam')->setValue('1');
	    $form->addHidden('datumVzniku')->setValue(date("Y-m-d H:i:s"));
	    $form->addSelect('idDite', 'Dítě:', $detiSelect)->setPrompt('Zvolte dítě');
	    $form->addSubmit('create', 'Přidat sponzora');
	    $form->onSuccess[] = $this->novySponzorFormSubmitted;
	    return $form;
	}

	// ulozi do databaze noveho sponzora
	public function novySponzorFormSubmitted(NAppForm $form)
	{	
		
    	if($this->sponzori->vytvorSponzora($form->values)){
    		$this->flashMessage('Přidali jste nového sponzora.', 'success');
    		$this->redirect('Sponzor:default');
    	}else{
    		$this->flashMessage('Nepřidali jste nového sponzora.', 'fail');
    	}
	}

}

?>
