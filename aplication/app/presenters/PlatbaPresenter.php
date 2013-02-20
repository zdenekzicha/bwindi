<?php

class platbaPresenter extends BasePresenter
{

	private $platby;

	protected function startup()
	{
	    parent::startup();
	    $this->platby = $this->context->platbaModel;
	}

	public function renderDefault()
	{
		$this->template->platby = $this->platby->zobrazPlatby();
	}

}

?>