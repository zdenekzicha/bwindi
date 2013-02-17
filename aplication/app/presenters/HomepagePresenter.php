<?php

/**
 * Dite presenter.
 */
class homepagePresenter extends BasePresenter
{

	private $deti;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	}

	public function renderDefault()
	{
		$this->template->deti = $this->deti->zobrazDeti();
	}

}

?>