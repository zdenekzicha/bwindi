<?php

/**
 * Provádí operace nad tabulkou deti
 */
class sponzorModel extends Model
{

	public function zobrazSponzory($filtr)
	{

		$this->getDb()->query('DROP VIEW if exists sponzoriPohled');
		$this->getDb()->query('CREATE VIEW sponzoriPohled as SELECT s.*, d.jmeno AS diteJmeno FROM sponzor AS s LEFT JOIN (dite AS d, relaceditesponzor AS r) ON (s.idSponzor = r.sponzorIdSponzor AND r.diteIdDite = d.idDite) GROUP BY s.idSponzor');

		return $this->getDb()->table('sponzoriPohled')->where($filtr);
	}
	//metoda, ktera zobrazuje sponzory, kteri maji adoptovane dite
	public function zobrazAktivniSponzory()
	{
    	return $this->db->fetchAll('SELECT * FROM relaceditesponzor AS r , sponzor AS s WHERE r.sponzoridsponzor = s.idsponzor');
	}
}