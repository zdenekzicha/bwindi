<?php

class benefitPresenter extends BasePresenter
{

	private $benefity;

	protected function startup()
	{
	    parent::startup();
	    $this->benefity = $this->context->benefitModel;
	}

	public function renderDefault()
	{
		$this->template->benefity = $this->benefity->zobrazBenefity();
	}


	// vytvori formular pro pridani benefitu
	protected function createComponentNovyBenefitForm()
	{
	    $form = new NAppForm;
	    $form->addText('nazev', 'Název:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat název benefitu.');
	    $form->addText('castka', 'Částka:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat částku.');
	    $form->addHidden('aktivniZaznam')->setValue('1');
	    $form->addSubmit('create', 'Přidat bebefit');
	    $form->onSuccess[] = $this->novaNovyBenefitSubmitted;
	    return $form;
	}

	// ulozi do databaze novy bebefit
	public function novaNovyBenefitSubmitted(NAppForm $form)
	{	
    	if($this->benefity->vytvorBenefit($form->values)){
    		$this->flashMessage('Přidali jste nový benefit.', 'success');
    		$this->redirect('Benefit:default');
    	}else{
    		$this->flashMessage('Nepřidali jste nový benefit.', 'fail');
    	}
	}

}

?>