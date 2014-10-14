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
	
}

?>
