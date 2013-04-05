<?php

class diteBenefitPresenter extends BasePresenter
{

	private $relace;
	public $diteJmeno;
	public $filtrText;
  public function actionDefault($diteJmeno, $filtrText) {
		$this->template->jmenoDitete = $diteJmeno;
		$this->filtrText = $filtrText;
	}
	protected function startup()
	{
	    parent::startup();
	    $this->relace = $this->context->diteBenefitModel;
	}

	public function renderDefault()
	{
		$this->template->relace = $this->relace->zobrazRelace($this->filtrText);
	}


}

?>
