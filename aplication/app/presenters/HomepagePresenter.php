<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->kids = $this->kids->selectAllKids();
	}

}
