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
	    $form->addText('vsym', 'Variabilní symbol:', 10, 10)->addRule(NAppForm::PATTERN, 'Variabilní symbol musí být číslo.', '([0-9]\s*)');	    
	    $form->addText('rocnik', 'Ročník:', 10, 10)->addRule(NAppForm::PATTERN, 'Ročník musí být číslo.', '([0-9]\s*)');
	    $form->addCheckbox('vystavene','Vystavené na webu');
	    $form->addHidden('aktivniZaznam')->setValue('1');
	    $form->addHidden('datumVzniku')->setValue(date("Y-m-d H:i:s"));
	    $form->addSelect('skolaIdSkola', 'Škola:', $skolySelect)->setPrompt('Zvolte školu');
	    $form->addSubmit('create', 'Přidat dítě');
	    $form->onSuccess[] = $this->noveDiteFormSubmitted;
	    return $form;
	}

	// ulozi do databaze nove dite
	public function noveDiteFormSubmitted(NAppForm $form)
	{	
		
    	if($this->deti->vytvorDite($form->values)){
    		$this->flashMessage('Přidali jste nové dítě.', 'success');
    		$this->redirect('Homepage:default');
    	}else{
    		$this->flashMessage('Neřidali jste nové dítě.', 'fail');
    	}
	}

}

?>
