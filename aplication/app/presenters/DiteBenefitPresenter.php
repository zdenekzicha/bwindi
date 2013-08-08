<?php

class diteBenefitPresenter extends BasePresenter
{

	private $relace;
  private $platby;
  private $dite;
  private $sponzori;
  private $benefity;
	public $diteJmeno;
	public $filtrText;
  public function actionDefault($diteJmeno, $filtrText) {
		$this->template->jmenoDitete = $diteJmeno;
		$this->filtrText = $filtrText;
		$this->template->idDite = $filtrText;
	}
	protected function startup()
	{
	    parent::startup();
	    $this->relace = $this->context->relaceDiteBenefitModel;
	    $this->platby = $this->context->platbaModel;
	    $this->dite = $this->context->diteModel;
	    $this->sponzori = $this->context->sponzorModel;
	    $this->benefity = $this->context->benefitModel;
	    
	}

	public function renderDefault()
	{
		$this->template->relace = $this->relace->zobrazRelace($this->filtrText);
		$this->template->zbyvajiciPenize = $this->platby->zbyvajiciPenize($this->filtrText);
		
	}
	
	public function actionEdit($id)
	{	
    	
    	$data = $this->relace->zobrazDiteBenefit($id);

    	$form = $this->getComponent('novyDiteBenefitForm');
            
    	$form->setDefaults(array(
                'diteIdDite' => $data[$id]['diteIdDite'],
                'benefitIdBenefit' => $data[$id]['benefitIdBenefit'],
                'zaplacenaCastka' => $data[$id]['zaplacenaCastka'],
                'rok' => $data[$id]['rok'],
                'poznamka' => $data[$id]['poznamka']
     	));

     	$form->addHidden('idRelaceDiteBenefit')->setValue($id);

	    $form["create"]->caption = 'Editovat benefit';
		$form->onSuccess = array(array($this, 'editDiteBenefitFormSubmitted')); // nové nastavení

		$this->template->action = "edit";
		$this->setView('novyDiteBenefit');
    

	}
	
	// vytvori formular pro pridani benefitu
	protected function createComponentNovyDiteBenefitForm()
	{
 
		$deti = $this->dite->zobrazVsechnyDeti();
		$detiSelect = array();

		foreach ($deti as $key => $value) {
			$detiSelect[$value['idDite']] = $value['jmeno'];
		}

		$sponzori = $this->sponzori->zobrazVsechnySponzory();
		$sponzoriSelect = array();

		foreach ($sponzori as $key => $value) {
			$sponzoriSelect[$value['idSponzor']] = $value['jmeno'];
		}

		$benefity = $this->benefity->zobrazBenefity();
		$benefitySelect = array();

		foreach ($benefity as $key => $value) {
			$benefitySelect[$value['idBenefit']] = $value['nazev'];
		}
		
	    $form = new NAppForm;
	    $form->addText('zaplacenaCastka', 'Zaplacená částka:');
	    $form->addText('rok', 'Rok:', 5, 4);
	    $form->addText('poznamka', 'Poznamka:', 10, 255);
	    $form->addSelect('diteIdDite', 'Dítě:', $detiSelect)->setPrompt('Zvolte dítě')->addRule(NAppForm::FILLED, 'Je nutné zadat dítě.');
		  $form->addSelect('benefitIdBenefit', 'Benefit:', $benefitySelect)->setPrompt('Zvolte benefit')->addRule(NAppForm::FILLED, 'Je nutné zadat benefit.');
	    $form->addHidden('datumVzniku')->setValue(date("Y-m-d H:i:s"));
	    $form->addSubmit('create', 'Přidat benefit');
	    $form->onSuccess[] = $this->novaNovyDiteBenefitSubmitted;
	    return $form;
	}

	// ulozi do databaze novy bebefit
	public function novaNovyDiteBenefitSubmitted(NAppForm $form)
	{	
    	if($this->relace->vytvorDiteBenefit($form->values)){
    		$this->flashMessage('Přidali jste nový benefit.', 'success');
    		$this->redirect('homepage:default');
    	}else{
    		$this->flashMessage('Nepřidali jste nový benefit.', 'fail');
    	}
	}

	public function editDiteBenefitFormSubmitted(NAppForm $form)
	{	
		
    	if($this->relace->editovatDiteBenefit($form->values)){
    		$this->flashMessage('Editace benefitu je hotová.', 'success');
    		$this->redirect('this',array('id' => $form->values->idRelaceDiteBenefit));
        //$this->redirect("diteBenefit:edit");
    	}else{
    		$this->flashMessage('Nepodařilo se editovat benefit.', 'fail');
    	}
	}
	
	

}

?>
