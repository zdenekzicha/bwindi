<?php

class skolaPresenter extends BasePresenter
{

	private $skoly;

	protected function startup()
	{
	    parent::startup();
	    $this->skoly = $this->context->skolaModel;
	}

	public function actionEdit($id)
	{	
    	
    	$data = $this->skoly->zobrazSkolu($id);

    	

    	$form = $this->getComponent('novaSkolaForm');

    	$form->setDefaults(array(
    			'nazev' => $data[$id]['nazev'],
                'castka' => $data[$id]['castka'],
                'maxRok' => $data[$id]['maxRok'],
                'predpona' => $data[$id]['predpona']

     	));

     	$form->addHidden('idSkola')->setValue($id);

	    $form["create"]->caption = 'Editovat školu';
		$form->onSuccess = array(array($this, 'editSkolaFormSubmitted')); // nové nastaveni

		$this->template->action = "edit";
		$this->setView('novaSkola');


	}

	public function actionSmazat($id)
	{	
    	
    	if($this->skoly->smazatSkolu($id)){
    		$this->flashMessage('Smazali jste školu.', 'success');
    		$this->redirect('Skola:default');
    	}else{
    		$this->flashMessage('Tato škola je přiřazená k některému dítěti. Aby šla škola smazat nesmí být přiřazena k žádnému dítěti.', 'fail');
    		$this->redirect('Skola:default');
    	}


	}

	public function renderDefault()
	{
		$this->template->skoly = $this->skoly->findAll();
	}

	// vytvori formular pro pridani skoly
	protected function createComponentNovaSkolaForm()
	{
	    $form = new NAppForm;
	    $form->addText('nazev', 'Název:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat název školy.');
	    $form->addText('castka', 'Školné:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat školné.');
	    $form->addText('maxRok', 'Počet ročníku:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat počet ročníků.');
	    $form->addText('predpona', 'Typ školy:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat typ školy (např. základní, střední).');
	    $form->addSubmit('create', 'Přidat školu');
	    $form->onSuccess[] = array($this, 'novaSkolaFormSubmitted');
	    return $form;
	}

	// ulozi do databaze novou skolu
	public function novaSkolaFormSubmitted(NAppForm $form)
	{	
    	if($this->skoly->vytvorSkolu($form->values)){
    		$this->flashMessage('Nová škola přidána.', 'success');
    		$this->redirect('Skola:default');	
    	}else{
    		$this->flashMessage('Nepodařilo se přidat novou školu.', 'fail');
    	}
    	
	}

	// edituje skolu v databazi
	public function editSkolaFormSubmitted(NAppForm $form)
	{	
		
    	if($this->skoly->editovatSkolu($form->values)){
    		$this->flashMessage('Editace školy je hotová.', 'success');
    		$this->redirect('Skola:default');
    	}else{
    		$this->flashMessage('Nepodařilo se editovat školu.', 'fail');
    	}
	}
}

?>
