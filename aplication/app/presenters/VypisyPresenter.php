<?php

class vypisyPresenter extends BasePresenter
{

	private $vypisy;
	
	protected function startup()
	{
	    parent::startup();
	    $this->vypisy = $this->context->vypisyModel;
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
	
}

?>
