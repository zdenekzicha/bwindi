<?php

/**
 * Kids presenter.
 */
class KidsPresenter extends BasePresenter
{

	private $kids;

	protected function startup()
	{
	    parent::startup();
	    $this->kids = $this->context->kids;
	}

	public function selectAllKids()
	{
	    return $this->kids->findAll();
	}

	public function renderDefault()
	{
		$this->template->kids = $this->selectAllKids();
	}

}

?>