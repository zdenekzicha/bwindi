<?php

class benefitPresenter extends BasePresenter
{

	private $benefity;

	protected function startup()
	{
	    parent::startup();
	    $this->benefity = $this->context->benefitModel;
	}

	public function renderDefault()
	{
		$this->template->benefity = $this->benefity->findAll();
	}

}

?>