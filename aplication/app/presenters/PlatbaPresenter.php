<?php

class platbaPresenter extends BasePresenter
{

	private $platby;
	private $filtr;
	private $dite;
	private $sponzori;
	private $benefity;

	public $filtrSelect;
	public $filtrText;
	public $filtrRok;

	protected function startup()
	{
	    parent::startup();
	    $this->platby = $this->context->platbaModel;
	    $this->dite = $this->context->diteModel;
	    $this->sponzori = $this->context->sponzorModel;
	    $this->benefity = $this->context->benefitModel;
	}

	public function actionDefault($filtrSelect,$filtrText,$filtrRok) {

		$this->filtr = array();
		if(isset($filtrText)) {
			array_push($this->filtr, array($filtrSelect." LIKE ?" => "%".$filtrText."%"));
		}

		// jako defaultni hodnota filteru se bere aktualni rok
		
		if(isset($filtrRok) && $filtrRok != 'Rok') {
			array_push($this->filtr, array('rok' => $filtrRok));
		}

		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
		$this->filtrRok = $filtrRok;
	}

		public function actionEdit($id)
	{	
    	
    	$data = $this->platby->zobrazPlatbu($id);

    	$form = $this->getComponent('novaPlatbaForm');

    	$date = new DateTime($data[$id]['datum']);

    	$form->setDefaults(array(
    			'datum' => $date->format('d.m.Y'),
                'castka' => $data[$id]['castka'],
                'ucet' => $data[$id]['ucet'],
                'poznamka' => $data[$id]['poznamka'],
                'rok' => $data[$id]['rok'],
                'diteIdDite' => $data[$id]['diteIdDite'],
                'sponzorIdSponzor' => $data[$id]['sponzorIdSponzor'],
                'benefitIdBenefit' => $data[$id]['benefitIdBenefit']

     	));

     	$form->addHidden('idPlatba')->setValue($id);

	    $form["create"]->caption = 'Editovat platbu';
		$form->onSuccess = array(array($this, 'editPlatbaFormSubmitted')); // nové nastavení

		$this->template->action = "edit";
		$this->setView('novaPlatba');


	}

	public function actionSmazat($id)
	{	
    	
    	if($this->platby->smazatPlatbu($id)){
    		$this->flashMessage('Smazali jste platbu', 'success');
    		$this->redirect('Platba:default');
    	}else{
    		$this->flashMessage('Platbu se nepodařilo smazat.', 'fail');
    		$this->redirect('Platba:default');
    	}


	}

	public function renderDefault()
	{
		$this->template->platby = $this->platby->zobrazPlatby($this->filtr);
		$this->template->roky = $this->platby->zobrazVsechnyRoky();

		$this->template->filtrSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
		$this->template->filtrRok = $this->filtrRok;
	
	}

	// vytvori formular pro pridani platby
	protected function createComponentNovaPlatbaForm()
	{
 
		$deti = $this->dite->zobrazVsechnyDeti();
		$detiSelect = array();

		foreach ($deti as $key => $value) {
			$detiSelect[$value['idDite']] = $value['vsym']." - ".$value['jmeno'];
		}

		$sponzori = $this->sponzori->zobrazVsechnySponzory();
		$sponzoriSelect = array();

		foreach ($sponzori as $key => $value) {
			$sponzoriSelect[$value['idSponzor']] = $value['ssym']." - ".$value['jmeno'];
		}

		$benefity = $this->benefity->zobrazBenefity();
		$benefitySelect = array();

		foreach ($benefity as $key => $value) {
			$benefitySelect[$value['idBenefit']] = $value['nazev'];
		}
		
	    $form = new NAppForm;
	    $form->addText('datum', 'Datum:', 40, 255);
	    $form->addText('castka', 'Částka:');
	    $form->addText('ucet', 'Účet:', 10, 255);
	    $form->addText('poznamka', 'Poznamka:', 10, 255);
	    $form->addText('rok', 'Rok:', 5, 4);
	    $form->addSelect('diteIdDite', 'Dítě:', $detiSelect)->setPrompt('Zvolte dítě');
	    $form->addSelect('sponzorIdSponzor', 'Sponzor:', $sponzoriSelect)->setPrompt('Zvolte sponzora')->addRule(NAppForm::FILLED, 'Je nutné zadat sponzora.');
		$form->addSelect('benefitIdBenefit', 'Benefit:', $benefitySelect)->setPrompt('Zvolte benefit')->addRule(NAppForm::FILLED, 'Je nutné zadat benefit.');
	    $form->addSubmit('create', 'Přidat platbu');
	    $form->onSuccess[] = $this->NovaPlatbaFormSubmitted;


	    $form['datum']->setValue(date("j.n.Y"));
	    $form['rok']->setValue(date("Y"));

	    return $form;
	}

	// ulozi do databaze nove platby
	public function NovaPlatbaFormSubmitted(NAppForm $form)
	{	
		$values = $form->getValues();
		$date = new DateTime($values['datum']);
	    $form['datum']->setValue($date->format('Y-m-d'));
		
    	if($this->platby->vytvorPlatbu($form->values)){
    		$this->flashMessage('Přidali jste novou platbu.', 'success');
    		$this->redirect('Platba:default');
    	}else{
    		$this->flashMessage('Nepřidali jste novou platbu.', 'fail');
    	}
	}

	public function editPlatbaFormSubmitted(NAppForm $form)
	{	
		$values = $form->getValues();
		$date = new DateTime($values['datum']);
	    $form['datum']->setValue($date->format('Y-m-d'));

    	if($this->platby->editovatPlatbu($form->values)){
    		$this->flashMessage('Editace platby je hotová.', 'success');
    		$this->redirect('Platba:default');
    	}else{
    		$this->flashMessage('Nepodařilo se editovat platbu.', 'fail');
    	}
	}

}

?>