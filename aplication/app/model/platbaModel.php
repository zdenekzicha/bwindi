<?php

/**
 * Provádí operace nad tabulkou deti
 */
class PlatbaModel extends Model
{

	public function zobrazPlatby()
	{

		$this->getDb()->query('DROP VIEW if exists platbaPohled');
		$this->getDb()->query('CREATE VIEW platbaPohled as SELECT p.*, DATE_FORMAT(p.datum,"%d.%m.%Y") AS date, d.jmeno AS diteJmeno, d.vsym AS diteVsym, s.jmeno AS sponzorJmeno, s.ssym AS sponzorVsym, b.nazev AS benefitNazev FROM platba AS p, dite AS d, sponzor AS s, benefit AS b WHERE p.diteIdDite = d.idDite AND p.sponzorIdSponzor = s.idSponzor AND p.benefitIdBenefit = b.idBenefit');

		return $this->getDb()->table('platbaPohled');
	}
}