<?php

/**
 * Provádí operace nad tabulkou deti
 */
class BenefitModel extends Model
{

	public function zobrazBenefity()
	{

		$this->getDb()->query('DROP VIEW if exists benefityPohled');
		$this->getDb()->query('CREATE VIEW benefityPohled as SELECT * FROM benefit');

		return $this->getDb()->table('benefityPohled');
	}
}