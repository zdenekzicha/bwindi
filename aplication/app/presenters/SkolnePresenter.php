<?php

class skolnePresenter extends BasePresenter
{

	private $relace;
  private $platby;
  private $dite;
  private $sponzori;
  private $benefity;
	public $diteJmeno;
	public $idDite;
  public function actionDefault($idDite, $jmenoDite) {
		$this->template->jmenoDitete = $jmenoDite;
		$this->idDite = $idDite;
		$this->template->idDite = $idDite;
	}
	protected function startup()
	{
	    parent::startup();
	    $this->relace = $this->context->diteBenefitModel;
	    $this->platby = $this->context->platbaModel;
	    $this->dite = $this->context->diteModel;
	    $this->sponzori = $this->context->sponzorModel;
	    $this->benefity = $this->context->benefitModel;
	    
	}

	public function renderDefault()
	{
		$this->template->penizeSkolne = $this->platby->penizeSkolne($this->idDite);
		
	}
	


}

?>
