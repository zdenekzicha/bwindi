<?php

class sponzorPresenter extends BasePresenter
{

	private $sponzori;

	protected function startup()
	{
	    parent::startup();
	    $this->sponzori = $this->context->sponzorModel;
	}

	public function renderDefault()
	{
		$this->template->sponzori = $this->sponzori->findAll();
	}

}

?>