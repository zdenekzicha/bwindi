<?php

class vypisyPresenter extends BasePresenter
{

	private $vypisy;
	private $platby;
	
	protected function startup()
	{
	    parent::startup();
	    $this->vypisy = $this->context->vypisyModel;
	    $this->platby = $this->context->platbaModel;
	}

  public function renderDefault()
	{
		$this->template->vypisy = $this->vypisy->vsechnyDataOdDeti();
		
	}
  
  public function actionAktivniSponzori()
	{
		$this->template->aktivniSponzori = $this->vypisy->aktivniSponzori();
		
	}
  
  public function actionPotvrzeniPlateb()
	{
		$this->template->potvrzeniPlateb = $this->vypisy->potvrzeniPlateb();
		
	}
  public function actionDetiSProfilovkou()
	{
		$this->template->vypisy = $this->vypisy->vsechnyDataOdDeti();
		
	}

  public function actionSumPlatbyBenefity($filtrRok)
	{

		if(!isset($filtrRok) && $filtrRok != 'Rok') {
			$filtrRok = date("Y");
		}

		$this->template->roky = $this->platby->zobrazVsechnyRoky();
		$this->template->filtrRok = $filtrRok;;
		$this->template->vypisy = $this->vypisy->sumPlatbyBenefity($filtrRok);
		
	}
	
}

?>
