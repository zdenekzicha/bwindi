<?php

class benefitPresenter extends BasePresenter
{

	private $benefity;

	protected function startup()
	{
	    parent::startup();
	    $this->benefity = $this->context->benefitModel;
	}

		public function actionEdit($id)
	{	
    	
    	$data = $this->benefity->zobrazBenefit($id);

    	

    	$form = $this->getComponent('novyBenefitForm');

    	$form->setDefaults(array(
    			'nazev' => $data[$id]['nazev'],
                'castka' => $data[$id]['castka'],
                'aktivniZaznam' => $data[$id]['aktivniZaznam']

     	));

     	$form->addHidden('idBenefit')->setValue($id);

	    $form["create"]->caption = 'Editovat účel';
		$form->onSuccess = array(array($this, 'editBenefitFormSubmitted')); // nové nastavení

		$this->template->action = "edit";
		$this->setView('novyBenefit');


	}

	public function actionSmazat($id)
	{	
    	
    	if($this->benefity->smazatBenefit($id)){
    		$this->flashMessage('Smazali jste účel.', 'success');
    		$this->redirect('Benefit:default');
    	}else{
    		$this->flashMessage('Tento účel je nastaven u některé z plateb. Aby šel účel smazat, musíte jej napřed odebrat ze všech plateb.', 'fail');
    		$this->redirect('Benefit:default');
    	}


	}

	public function renderDefault()
	{
		$this->template->benefity = $this->benefity->zobrazBenefity();
	}


	// vytvori formular pro pridani benefitu
	protected function createComponentNovyBenefitForm()
	{
	    $form = new NAppForm;
	    $form->addText('nazev', 'Název:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat název účelu.');
	    $form->addText('castka', 'Částka:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat částku.');
	    $form->addHidden('aktivniZaznam')->setValue('1');
	    $form->addSubmit('create', 'Přidat účel');
	    $form->onSuccess[] = $this->novaNovyBenefitSubmitted;
	    return $form;
	}

	// ulozi do databaze novy bebefit
	public function novaNovyBenefitSubmitted(NAppForm $form)
	{	
    	if($this->benefity->vytvorBenefit($form->values)){
    		$this->flashMessage('Přidali jste nový účel.', 'success');
    		$this->redirect('Benefit:default');
    	}else{
    		$this->flashMessage('Nepodařilo se vytvořit nový účel.', 'fail');
    	}
	}

	public function editBenefitFormSubmitted(NAppForm $form)
	{	
		
    	if($this->benefity->editovatBenefit($form->values)){
    		$this->flashMessage('Editace účelu je hotová.', 'success');
    		$this->redirect('Benefit:default');
    	}else{
    		$this->flashMessage('Nepodařilo se editovat účel.', 'fail');
    	}
	}

}

?>