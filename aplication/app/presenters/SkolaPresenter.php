<?php

class skolaPresenter extends BasePresenter
{

	private $skoly;

	protected function startup()
	{
	    parent::startup();
	    $this->skoly = $this->context->skolaModel;
	}

	public function renderDefault()
	{
		$this->template->skoly = $this->skoly->findAll();
	}

}

?>
