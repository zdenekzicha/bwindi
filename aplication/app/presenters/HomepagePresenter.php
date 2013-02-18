<?php
use Nette\Application\UI\Form;
/**
 * Dite presenter.
 */
class homepagePresenter extends BasePresenter
{

	private $deti;
	private $filter;
	private $test;

	private $filterPohlavi;
	private $filtrSelect;
	private $filtrText;
	private $filtrWeb;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	}

	public function actionDefault($id,$pohlavi,$filtrSelect,$filtrText,$filtrWeb)
	{	
    	$this->filter = array();
		if(isset($pohlavi)) {
			array_push($this->filter, array('pohlavi' => $pohlavi));
		}

		if(isset($filtrText)) {
			array_push($this->filter, array($filtrSelect => $filtrText));
		}

		if(isset($filtrWeb)) {
			array_push($this->filter, array('vystavene' => 1));
		}

		$this->filterPohlavi = $pohlavi;
		$this->filtrSelect = $filtrSelect;
		$this->filtrText = $filtrText;
		$this->filtrWeb = $filtrWeb;
	}

	public function renderDefault()
	{

		$this->template->filterPohlavi = $this->filterPohlavi;
		$this->template->filterSelect = $this->filtrSelect;
		$this->template->filtrText = $this->filtrText;
		$this->template->filtrWeb = $this->filtrWeb;
		$this->template->deti = $this->deti->zobrazDeti($this->filter);
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