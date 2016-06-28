<?php

class sponzorPresenter extends BasePresenter
{

	private $sponzori;
	private $deti;
	private $filtr;

	public $filtrSelect;
	public $filtrText;
	public $filtrActive;

	protected function startup()
	{
	    parent::startup();
	    $this->sponzori = $this->context->sponzorModel;
	    $this->deti = $this->context->diteModel;
	}

	public function actionEdit($id)
	{	
    	
    	$data = $this->sponzori->zobrazSponzora($id);

    	

    	$form = $this->getComponent('novySponzorForm');

    	$form->setDefaults(array(
    			'jmeno' => $data[$id]['jmeno'],
                'ulice' => $data[$id]['ulice'],
                'psc' => $data[$id]['psc'],
                'ssym' => $data[$id]['ssym'],
                'mesto' => $data[$id]['mesto'],
                'mail' => $data[$id]['mail'],
                'telefon' => $data[$id]['telefon'],
                'poznamka' => $data[$id]['poznamka'],
                'posilatInfo' => $data[$id]['posilatInfo'],
                'aktivniZaznam' => $data[$id]['aktivniZaznam']
     	));

     	$form->addHidden('idSponzor')->setValue($id);

	    $form["create"]->caption = 'Editovat sponzora';
		$form->onSuccess = array(array($this, 'editSponzorFormSubmitted')); // nové nastaveni

		$this->template->maxSsym = $this->sponzori->zobrazMaximalniSsym();

		$this->template->action = "edit";
		$this->setView('novySponzor');


	}

	public function actionNovySponzor(){
		$form = $this->getComponent('novySponzorForm');
		$this->template->maxSsym = $this->sponzori->zobrazMaximalniSsym();
		$this->setView('novySponzor');
	}

	public function actionAdopce($id)
	{	
		$sponzor = $this->sponzori->zobrazSponzora($id);
    	
    	$this->template->sponzor = $sponzor[$id]['jmeno'];
    	$this->template->idSponzor = $sponzor[$id]['idSponzor'];
    	$this->template->adopce = $this->sponzori->zobrazAdopce($id);
    	$this->template->adopceNeaktivni = $this->sponzori->zobrazNeaktivniAdopce($id);

    	$form = $this->getComponent('novaAdopceForm');

    	$form->addHidden('sponzorIdSponzor')->setValue($sponzor[$id]['idSponzor']);

	}

	protected function createComponentNovaAdopceForm()
	{
 
		$deti = $this->deti->zobrazVsechnyDeti("jmeno");
		$detiSelect = array();

		foreach ($deti as $key => $value) {
			$detiSelect[$value['idDite']] = $value['vsym']." - ".$value['jmeno'];
		}
		
	    $form = new NAppForm;
	    $form->addSelect('diteIdDite', 'Dítě:', $detiSelect)->setPrompt('Zvolte dítě');
	    $form->addSubmit('create', 'Přidat dítě');
	    $form->addHidden('aktivniZaznam')->setValue('1');
	    $form->addHidden('datumVzniku')->setValue(date("Y-m-d H:i:s"));
	    $form->onSuccess[] = $this->novaAdopceFormSubmitted;
	    return $form;
	}

	public function actionSmazatAdopce($id, $idSponzor)
	{	
    	
    	if($this->sponzori->smazatAdopce($id)){
    		$this->flashMessage('Sponzorství ukončeno.', 'success');
    		$this->redirect('Sponzor:adopce', $idSponzor);
    	}else{
    		$this->flashMessage('Nepodařilo se ukončit sponzorství.', 'fail');
    		$this->redirect('Sponzor:adopce', $idSponzor);
    	}


	}

	public function actionObnovitAdopce($id, $idSponzor)
	{	
    	
    	if($this->sponzori->ObnovAdopce($id)){
    		$this->flashMessage('Sponzorství obnoveno.', 'success');
    		$this->redirect('Sponzor:adopce', $idSponzor);
    	}else{
    		$this->flashMessage('Nepodařilo se obnovit sponzorství.', 'fail');
    		$this->redirect('Sponzor:adopce', $idSponzor);
    	}


	}



	public function actionSmazat($id)
	{	
    	
    	if($this->skoly->smazatSponzora($id)){
    		$this->flashMessage('Smazali jste sponzora.', 'success');
    		$this->redirect('Sponzor:default');
    	}else{
    		$this->flashMessage('Sponzora se nepodařilo smazat.', 'fail');
    		$this->redirect('Sponzor:default');
    	}


	}

	public function actionDefault($filtrSelect, $filtrText, $filtrActive) {

		$this->filtr = array();
		if(isset($filtrText)) {
			array_push($this->filtr, array($filtrSelect." LIKE ?" => "%".$filtrText."%"));
		}

		if(isset($filtrActive)) {
			array_push($this->filtr, array('aktivniZaznam' => 0));
		}else{
			array_push($this->filtr, array('aktivniZaznam' => 1));
		}

		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
		$this->filtrActive = $filtrActive;
	}

	public function renderDefault()
	{

		$this->template->sponzori = $this->sponzori->zobrazSponzory($this->filtr);
		$this->template->deti = $this->deti->zobrazAdoptovaneDeti('');


		$this->template->filtrActive = $this->filtrActive;
		$this->template->filtrSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
	}

	protected function createComponentNovySponzorForm()
	{
		
	    $form = new NAppForm;
	    $form->addText('jmeno', 'Jméno:', 40, 255)->addRule(NAppForm::FILLED, 'Je nutné zadat jméno sponzora.');
	    $form->addText('ulice', 'Adresa:', 40, 255);
	    $form->addText('psc', 'PSČ:', 6, 5);
	    $form->addText('ssym', 'Specifický symbol:', 10, 10)->addRule(NAppForm::INTEGER, 'Specifický symbol musí být číslo.');
	    $form->addText('mesto', 'Město:', 40, 255);
	    $form->addText('mail', 'E-mail:', 40, 255);
	    $form->addText('telefon', 'Telefon:', 40, 255);
	    $form->addTextArea('poznamka', 'Poznamka:');
	    $form->addCheckbox('aktivniZaznam','Aktivní v projektu')->setValue(1);
	    $form->addCheckbox('posilatInfo','Chce posílat infomaily')->setValue(1);
	    $form->addHidden('datumVzniku')->setValue(date("Y-m-d H:i:s"));
	    //$form->addSelect('idDite', 'Dítě:', $detiSelect)->setPrompt('Zvolte dítě');
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

	public function novaAdopceFormSubmitted(NAppForm $form)
	{	
		$values = $form->getValues();
    
    	if($this->sponzori->vytvorAdopci($form->values)){
    		$this->flashMessage('Přidali jste dítě k tomuto sponzorovi.', 'success');
    		$this->redirect('Sponzor:adopce', $values["sponzorIdSponzor"]);
    	}else{
    		$this->flashMessage('Dítě se nepodařilo přidat.', 'fail');
    	}
	}

	public function editSponzorFormSubmitted(NAppForm $form)
	{	
		
    	if($this->sponzori->editovatSponzora($form->values)){
    		$this->flashMessage('Editace sponzora je hotová.', 'success');
    		$this->redirect('Sponzor:default');
    	}else{
    		$this->flashMessage('Nepodařilo se editovat sponzora.', 'fail');
    	}
	}
  
  public function actionVyraditSponzora($idSponzor)
	{	
    	
    	if($this->deti->vyraditSponzora($idSponzor)){
    		$this->flashMessage('Vyřadili jste sponzora.', 'success');
    		$this->redirect('Sponzor:default', $idSponzor);
    	}else{
    		$this->flashMessage('Sponzora se nepodařilo vyřadit.', 'fail');
    		$this->redirect('Sponzor:edit', $idSponzor);
    	}
	}
  public function actionZaraditSponzora($idSponzor)
	{	
    	
    	if($this->deti->zaraditSponzora($idSponzor)){
    		$this->flashMessage('Zařadili jste sponzora zpět do projektu. Staré vazby na případné původní děti se ale znova neobnoví', 'success');
    		$this->redirect('Sponzor:edit', $idSponzor);
    	}else{
    		$this->flashMessage('Sponzora se nepodařilo zařadit zpět.', 'fail');
    		$this->redirect('Sponzor:edit', $idSponzor);
    	}
	}

}

?>
