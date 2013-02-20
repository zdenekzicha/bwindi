<?php

/**
 * Provádí operace nad tabulkou deti
 */
class sponzorModel extends Model
{

	public function zobrazSponzory()
	{

		$this->getDb()->query('DROP VIEW if exists sponzoriPohled');
		$this->getDb()->query('CREATE VIEW sponzoriPohled as SELECT s.*, d.jmeno AS diteJmeno FROM sponzor AS s, dite AS d, relaceditesponzor AS r WHERE s.idSponzor = r.sponzorIdSponzor AND r.diteIdDite = d.idDite');

		return $this->getDb()->table('sponzoriPohled');
	}
}