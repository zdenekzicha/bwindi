<?php

class skolaPresenter extends BasePresenter
{

	private $skoly;

	protected function startup()
	{
	    parent::startup();
	    $this->skoly = $this->context->skolaModel;
	}

	public function renderDefault()
	{
		$this->template->skoly = $this->skoly->findAll();
	}

	// vytvori formular pro pridani skoly
	protected function createComponentNovaSkolaForm()
	{
	    //$userPairs = $this->userRepository->findAll()->fetchPairs('id', 'name');

	    $form = new NAppForm;
	    $form->addText('nazev', 'Název:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat název školy.');
	    $form->addText('castka', 'Školné:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat školné.');
	    $form->addText('maxRok', 'Počet ročníku:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat počet ročníků.');
	    $form->addText('predpona', 'Typ školy:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat typ školy (např. základní, střední).');
	    $form->addSubmit('create', 'Přidat školu');
	    $form->onSuccess[] = $this->novaSkolaFormSubmitted;
	    return $form;
	}

	// ulozi do databaze novou skolu
	public function novaSkolaFormSubmitted(NAppForm $form)
	{	
    	$this->skoly->vytvorSkolu($form->values->nazev, $form->values->castka, $form->values->maxRok, $form->values->predpona);
    	$this->flashMessage('Nová škola přidána.', 'success');
    	$this->redirect('Skola:default');
	}
}

?>
