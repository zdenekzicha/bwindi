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
		$this->template->sponzori = $this->sponzori->vratVsechnySponzory();
	}

	/*
	protected function createComponentFilterForm()
	{
		$form = new NAppForm;
	    $form->addText('text', 'Úkol:', 40, 100)->addRule(NAppForm::FILLED, 'Je nutné zadat text úkolu.');
	    $form->addSubmit('create', 'Vytvořit');
	    $form->onSuccess[] = $this->filterFormSubmitted;
	    return $form;
	}

	public function filterFormSubmitted(NAppForm $form)
	{
    	//$this->taskRepository->createTask($this->list->id, $form->values->text, $form->values->userId);
    	//$this->flashMessage('Úkol přidán.', 'success');
    	$this->redirect('this');
	}
	*/

}

?>
