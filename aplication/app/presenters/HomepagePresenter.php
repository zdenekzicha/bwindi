<?php
use Nette\Application\UI\Form;
/**
 * Dite presenter.
 */
class homepagePresenter extends BasePresenter
{

	private $deti;
	private $skola;
	private $sponzori;
	private $filter;
	private $test;

	public $filtrPohlavi;
	public $filtrSelect;
	public $filtrText;
	public $filtrWeb;
	public $filtrSkola;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	    $this->sponzori = $this->context->sponzorModel;
	    $this->skola = $this->context->skolaModel;
	}

	public function actionDefault($id,$filtrPohlavi,$filtrSelect,$filtrText,$filtrWeb,$filtrSkola)
	{	
    	$this->filter = array();
		if(isset($filtrPohlavi)) {
			array_push($this->filter, array('pohlavi' => $filtrPohlavi));
		}

		if(isset($filtrSkola) && $filtrSkola != 0) {
			array_push($this->filter, array('skolaId' => $filtrSkola));
		}

		if(isset($filtrText)) {
			array_push($this->filter, array($filtrSelect => $filtrText));
		}

		if(isset($filtrWeb)) {
			array_push($this->filter, array('vystavene' => 1));
		}

		$this->filtrPohlavi = $filtrPohlavi;
		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
		$this->filtrWeb = $filtrWeb;
		$this->filtrSkola = $filtrSkola;
	}

	public function actionEdit($id)
	{	
    	
    	$data = $this->deti->zobrazDite($id);

    	

    	$form = $this->getComponent('noveDiteForm');

    	$form->setDefaults(array(
    			'jmeno' => $data[$id]['jmeno'],
                'pohlavi' => $data[$id]['pohlavi'],
                'datumNarozeni' => $data[$id]['datumNarozeni'],
                'vsym' => $data[$id]['vsym'],
                'rocnik' => $data[$id]['rocnik'],
                'vystavene' => $data[$id]['vystavene'],
                'skolaIdSkola' => $data[$id]['skolaIdSkola'],
                'aktivniZaznam' => $data[$id]['aktivniZaznam']

     	));

     	$form->addHidden('idDite')->setValue($id);

	    $form["create"]->caption = 'Editovat dítě';
		$form->onSuccess = array(array($this, 'editDiteFormSubmitted')); // nové nastavení

		$this->template->action = "edit";
		$this->setView('noveDite');


	}

	public function actionSmazat($id)
	{	
    	
    	if($this->deti->smazatDite($id)){
    		$this->flashMessage('Smazali jste dítě.', 'success');
    		$this->redirect('Homepage:default');
    	}else{
    		$this->flashMessage('Toto dítě má v systému další záznamy. Jedná se buď o platby, benefity a nebo je spojeno s nějakým sponzorem. Pokud chcete toto dítě smazat, musíte napřed odstranit tyto záznamy.', 'fail');
    		$this->redirect('Homepage:default');
    	}


	}

	public function actionSourozenci($id)
	{	
		$dite = $this->deti->zobrazDite($id);
    	
    	$this->template->diteS = $dite[$id]['jmeno'];
    	$this->template->idDite = $dite[$id]['idDite'];
    	$this->template->sourozenci = $this->deti->zobrazSourozence($id);

    	$form = $this->getComponent('novySourozenecForm');

    	$form->addHidden('diteIdDite1')->setValue($dite[$id]['idDite']);

	}

	protected function createComponentNovySourozenecForm()
	{
 
		$deti = $this->deti->zobrazVsechnyDeti();
		$detiSelect = array();

		foreach ($deti as $key => $value) {
			$detiSelect[$value['idDite']] = $value['jmeno'];
		}
		
	    $form = new NAppForm;
	    $form->addSelect('diteIdDite2', 'Dítě:', $detiSelect)->setPrompt('Zvolte dítě');
	    $form->addSubmit('create', 'Přidat sourozence');
	    $form->onSuccess[] = $this->novySourozenecFormSubmitted;
	    return $form;
	}

		public function actionSmazatSourozence($id, $idDite)
	{	
    	
    	if($this->deti->smazatSourozence($id)){
    		$this->flashMessage('Smazali jste dítě.', 'success');
    		$this->redirect('Homepage:sourozenci', $idDite);
    	}else{
    		$this->flashMessage('Dítě se nepodařilo smazat.', 'fail');
    		$this->redirect('Homepage:sourozenci', $idDite);
    	}


	}




	public function renderDefault()
	{

		$this->template->filtrPohlavi = $this->filtrPohlavi;
		$this->template->filtrSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
		$this->template->filtrWeb = $this->filtrWeb;
		$this->template->filtrSkola = $this->filtrSkola;

		$this->template->deti = $this->deti->zobrazDeti($this->filter);
		$this->template->skoly = $this->skola->findAll();
		$this->template->sponzori = $this->sponzori->zobrazAktivniSponzory();
	}

	// vytvori formular pro pridani ditete
	protected function createComponentNoveDiteForm()
	{
 
		$skoly = $this->skola->findAll();
		$skolySelect = array();

		foreach ($skoly as $key => $value) {
			$skolySelect[$value['idSkola']] = $value['nazev'];
		}
		
	    $form = new NAppForm;
	    $form->addText('jmeno', 'Jméno:', 40, 255)->addRule(NAppForm::FILLED, 'Je nutné zadat jméno dítěte.');
	    $form->addSelect('pohlavi', 'Pohlaví:', array('M' => 'muž', 'F' => 'žena'))->setPrompt('Zvolte pohlaví')->addRule(NAppForm::FILLED, 'Je nutné zadat pohlaví dítěte.');
	    $form->addText('datumNarozeni', 'Datum narození:', 5, 4);
	    $form->addText('vsym', 'Variabilní symbol:', 10, 10)->addRule(NAppForm::INTEGER, 'Variabilní symbol musí být číslo.');	    
	    $form->addText('rocnik', 'Ročník:', 10, 10)->addRule(NAppForm::INTEGER, 'Ročník musí být číslo.');
	    $form->addCheckbox('vystavene','Vystavené na webu');
	    $form->addHidden('aktivniZaznam')->setValue('1');
	    $form->addHidden('datumVzniku')->setValue(date("Y-m-d H:i:s"));
	    $form->addSelect('skolaIdSkola', 'Škola:', $skolySelect)->setPrompt('Zvolte školu');
	    $form->addSubmit('create', 'Přidat dítě');
	    $form->onSuccess[] = array($this, 'noveDiteFormSubmitted');
	    return $form;
	}

	// ulozi do databaze nove dite
	public function noveDiteFormSubmitted(NAppForm $form)
	{	
		
    	if($this->deti->vytvorDite($form->values)){
    		$this->flashMessage('Přidali jste nové dítě.', 'success');
    		$this->redirect('Homepage:default');
    	}else{
    		$this->flashMessage('Nepřidali jste nové dítě.', 'fail');
    	}
	}

	public function novySourozenecFormSubmitted(NAppForm $form)
	{	
		$values = $form->getValues();
    
    	if($this->deti->vytvorSourozence($form->values)){
    		$this->flashMessage('Přidali jste sourozence k tomuto dítěti.', 'success');
    		$this->redirect('Homepage:sourozenci', $values["diteIdDite1"]);
    	}else{
    		$this->flashMessage('Dítě se nepodařilo přidat.', 'fail');
    	}
	}

	// edituje v databazi dite
	public function editDiteFormSubmitted(NAppForm $form)
	{	
		
    	if($this->deti->editovatDite($form->values)){
    		$this->flashMessage('Editace dítěte je hotová.', 'success');
    		$this->redirect('Homepage:default');
    	}else{
    		$this->flashMessage('Nepodařilo se editovat dítě.', 'fail');
    	}
	}

}

?>
