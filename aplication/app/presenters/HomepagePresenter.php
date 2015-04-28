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
	public $filtrActive;
	public $filtrSkola;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	    $this->sponzori = $this->context->sponzorModel;
	    $this->skola = $this->context->skolaModel;
	}

	public function actionDefault($id,$filtrPohlavi,$filtrSelect,$filtrText,$filtrWeb,$filtrActive,$filtrSkola)
	{	
    	$this->filter = array();
		if(isset($filtrPohlavi)) {
			array_push($this->filter, array('pohlavi' => $filtrPohlavi));
		}

		if(isset($filtrSkola) && $filtrSkola != 0) {
			array_push($this->filter, array('skolaId' => $filtrSkola));
		}

		if(isset($filtrText)) {
			array_push($this->filter, array($filtrSelect." LIKE ?" => "%".$filtrText."%"));
		}

		if(isset($filtrWeb)) {
			array_push($this->filter, array('vystavene' => 0));
		}else{
			array_push($this->filter, array('vystavene' => 1));
		}

		if(isset($filtrActive)) {
			array_push($this->filter, array('aktivniZaznam' => 0));
		}else{
			array_push($this->filter, array('aktivniZaznam' => 1));
		}

		$this->filtrPohlavi = $filtrPohlavi;
		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
		$this->filtrWeb = $filtrWeb;
		$this->filtrActive = $filtrActive;
		$this->filtrSkola = $filtrSkola;
	}

	public function actionEdit($id)
	{	
    	
    	$data = $this->deti->zobrazDite($id);
      
      	$this->template->profilovaFotka = $data[$id]['profilovaFotka'];
      	$this->template->idDite = $data[$id]['idDite'];
        $this->template->aktivniVProjektu = $data[$id]['aktivniZaznam']; 

    	$form = $this->getComponent('noveDiteForm');

    	$form->setDefaults(array(
    			'jmeno' => $data[$id]['jmeno'],
    			'bio' => $data[$id]['bio'],
                'pohlavi' => $data[$id]['pohlavi'],
                'datumNarozeni' => $data[$id]['datumNarozeni'],
                'rezervovane' => $data[$id]['rezervovane'],
                'vsym' => $data[$id]['vsym'],
                'rocnik' => $data[$id]['rocnik'],
                'vystavene' => $data[$id]['vystavene'],
                'skolaIdSkola' => $data[$id]['skolaIdSkola'],
                'aktivniZaznam' => $data[$id]['aktivniZaznam']

     	));
      $form->addHidden('idDite')->setValue($id);

     	$this->template->maxVsym = $this->deti->zobrazMaximalniVsym();

	    $form["create"]->caption = 'Editovat dítě';
		$form->onSuccess = array(array($this, 'editDiteFormSubmitted')); // nové nastavení

		$this->template->action = "edit";
		$this->setView('noveDite');


	}

	public function actionNoveDite(){
		$form = $this->getComponent('noveDiteForm');
		$this->template->maxVsym = $this->deti->zobrazMaximalniVsym();
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
 
		$deti = $this->deti->zobrazVsechnyDeti("jmeno");
		$detiSelect = array();

		foreach ($deti as $key => $value) {
			$detiSelect[$value['idDite']] = $value['vsym']." - ".$value['jmeno'];
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

	public function actionTimeline($id){
		$dite = $this->deti->zobrazDite($id);
    	
    	$this->template->diteS = $dite[$id]['jmeno'];
    	$this->template->idDite = $dite[$id]['idDite'];
    	
    	$this->template->timeline = $this->deti->zobrazTimeline($id);
	}

	public function actionSmazatTimeline($id, $idDite)
	{	
    	
    	if($this->deti->smazatTimeline($id)){
    		$this->flashMessage('Smazali jste záznam.', 'success');
    		$this->redirect('Homepage:timeline', $idDite);
    	}else{
    		$this->flashMessage('Záznam se nepodařilo smazat.', 'fail');
    		$this->redirect('Homepage:timeline', $idDite);
    	}


	}

	public function actionNoveTimeline($id){
		$dite = $this->deti->zobrazDite($id);
		$max = $this->deti->maxTimelineItemOrder($id);
    	
    	$this->template->diteS = $dite[$id]['jmeno'];
    	$this->template->idDite = $dite[$id]['idDite'];

    	$form = $this->getComponent('novyTimelineForm');

    	$form->addHidden('diteIdDite')->setValue($dite[$id]['idDite']);
    	$form->addHidden('jmeno')->setValue($dite[$id]['jmeno']);

    	$form->setDefaults(
    		array('rok' => date("Y"),
    		'poradi' => ($max[0]['max'] + 1)
    		));

	}

	public function actionEditTimeline($id, $idDite){
		$dite = $this->deti->zobrazDite($idDite);
    	
    	$this->template->diteS = $dite[$idDite]['jmeno'];
    	$this->template->idDite = $dite[$idDite]['idDite'];

    	$data = $this->deti->zobrazTimelineItem($id);

    	$this->template->foto = $data[$id]['foto'];

    	$form = $this->getComponent('novyTimelineForm');

    	$form->addHidden('diteIdDite')->setValue($dite[$idDite]['idDite']);
    	$form->addHidden('jmeno')->setValue($dite[$idDite]['jmeno']);

    	//$form->addHidden('foto')->setValue($data[$id]['foto']);
    	$form->addHidden('fotoUrlSerializovana')->setValue($data[$id]['fotoUrlSerializovana']);
    	$form->addHidden('flickrId')->setValue($data[$id]['flickrId']);
    	$form->setDefaults(array(
    			'text' => $data[$id]['text'],
    			'rok' => $data[$id]['rok'],
                'poradi' => $data[$id]['poradi'],
                'fotoFile' => $data[$id]['foto']
     	));

     	$form->addHidden('id')->setValue($id);

	    $form["create"]->caption = 'Editovat záznam';
		$form->onSuccess = array(array($this, 'editTimelineFormSubmitted')); // nové nastavení

		$this->template->action = "edit";
		$this->setView('noveTimeline');




	}


	protected function createComponentNovyTimelineForm()
	{
		
	    $form = new NAppForm;
	    $form->addTextArea('text', 'Text', 80, 7);
	    $form->addText('rok', 'Rok:', 40, 255);
	    $form->addText('poradi', 'Pořadí:', 40, 255);
	    $form->addUpload('fotoFile', 'Fotka:');
	    $form->addSubmit('create', 'Přidat záznam');
	    $form->onSuccess[] = $this->novyTimelineFormSubmitted;
	    return $form;
	}

	public function novyTimelineFormSubmitted(NAppForm $form)
	{	
		$values = $form->getValues();

    	if($this->deti->vytvorTimeline($form->values)){
    		$this->flashMessage('Přidali jste záznam do timeline.', 'success');
    		$this->redirect('Homepage:timeline', $values["diteIdDite"]);
    	}else{
    		$this->flashMessage('Nepodařilo se přidat záznam.', 'fail');
    	}
	}

	public function editTimelineFormSubmitted(NAppForm $form)
	{	
		$values = $form->getValues();
    
    	if($this->deti->editujTimeline($form->values)){
    		$this->flashMessage('Editace proběhla úspěšně.', 'success');
    		$this->redirect('Homepage:timeline', $values["diteIdDite"]);
    	}else{
    		$this->flashMessage('Nepodařilo se záznam editovat.', 'fail');
    	}
	}


	public function renderDefault()
	{

		$this->template->filtrPohlavi = $this->filtrPohlavi;
		$this->template->filtrSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
		$this->template->filtrWeb = $this->filtrWeb;
		$this->template->filtrActive = $this->filtrActive;
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
	    $form->addTextArea('bio', 'Bio', 80, 7);
	    $form->addText('vsym', 'Variabilní symbol:', 10, 10)->addRule(NAppForm::INTEGER, 'Variabilní symbol musí být číslo.');	    
	    $form->addText('rocnik', 'Ročník:', 10, 10);
	    $form->addUpload('profilovasoubor', 'Nahraj novou fotku');
	    $form->addCheckbox('vystavene','Vystavené na webu');
	    $form->addCheckbox('rezervovane','Má zájemce o adopci');
	    $form->addCheckbox('aktivniZaznam','Aktivní v projektu')->setValue(1)->setDisabled();
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
		$values = $form->getValues();
	
    	if($this->deti->editovatDite($form->values)){
    		$this->flashMessage('Editace dítěte je hotová.', 'success');
    		$this->redirect('Homepage:edit', $values["idDite"]);

    	}else{
    		$this->flashMessage('Nepodařilo se editovat dítě.', 'fail');
    	}

	}
  public function actionVyraditDite($idDite)
	{	
    	
    	if($this->deti->vyraditDite($idDite)){
    		$this->flashMessage('Vyřadili jste dítě.', 'success');
    		$this->redirect('Homepage:default', $idDite);
    	}else{
    		$this->flashMessage('Dítě se nepodařilo vyřadit.', 'fail');
    		$this->redirect('Homepage:edit', $idDite);
    	}
	}
  public function actionZaraditDite($idDite)
	{	
    	
    	if($this->deti->zaraditDite($idDite)){
    		$this->flashMessage('Zařadili jste dítě zpět do projektu. Staré vazby na případné původní sponzory se ale znova neobnoví', 'success');
    		$this->redirect('Homepage:edit', $idDite);
    	}else{
    		$this->flashMessage('Dítě se zařadit zpět.', 'fail');
    		$this->redirect('Homepage:edit', $idDite);
    	}
	}
  

}

?>
