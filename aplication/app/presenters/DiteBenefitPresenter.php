<?php

class diteBenefitPresenter extends BasePresenter
{

	private $relace;
  private $platby;
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
	    $this->platby = $this->context->platbaModel;
	}

	public function renderDefault()
	{
		$this->template->relace = $this->relace->zobrazRelace($this->filtrText);
		$this->template->zbyvajiciPenize = $this->platby->zbyvajiciPenize($this->filtrText);
	}


}

?>
