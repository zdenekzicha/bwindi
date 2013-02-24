<?php

/**
 * Provádí operace nad tabulkou deti
 */
class DiteModel extends Model
{

	public function zobrazDeti($filter)
	{
		/*
		$query = 'CREATE VIEW detiPohled AS SELECT view1.*, sponzor.jmeno AS sponzor
			FROM (SELECT view.*, skola.nazev AS skolaNazev 
			FROM (SELECT dite.* , relaceditesponzor.idRelaceDiteSponzor, relaceditesponzor.sponzorIdSponzor AS relaceIdSponzor FROM dite LEFT JOIN relaceditesponzor ON dite.idDite = relaceditesponzor.diteIdDite) AS view
			LEFT JOIN skola ON view.skolaIdSkola = skola.idSkola) AS view1 
			LEFT JOIN sponzor ON view1.relaceIdSponzor=sponzor.idSponzor';
		

		$this->getDb()->query('DROP VIEW if exists view, view1, detiPohled');
		$this->getDb()->query('CREATE VIEW view AS SELECT dite.* , relaceditesponzor.idRelaceDiteSponzor, relaceditesponzor.sponzorIdSponzor AS relaceIdSponzor FROM dite LEFT JOIN relaceditesponzor ON dite.idDite = relaceditesponzor.diteIdDite');
		$this->getDb()->query('CREATE VIEW view1 AS SELECT view.*, skola.nazev as skolaNazev from view LEFT JOIN skola ON view.skolaIdSkola = skola.idSkola'); 
		$this->getDb()->query('CREATE VIEW detiPohled as SELECT view1.*, sponzor.jmeno as jmenoSponzor from view1 LEFT JOIN sponzor ON view1.relaceIdSponzor=sponzor.idSponzor');

		*/
		$this->getDb()->query('DROP VIEW if exists detiPohled');
    	$this->getDb()->query('CREATE VIEW detiPohled as SELECT d.*, s.jmeno AS jmenoSponzor, sk.nazev AS skolaNazev, sk.idSkola AS skolaId FROM dite AS d LEFT JOIN (sponzor AS s, skola as sk, relaceditesponzor AS r) ON ((d.idDite = r.diteIdDite AND r.sponzorIdSponzor = s.idSponzor) AND d.skolaIdSkola = idSkola) GROUP BY d.idDite');
		//return $this->getDb()->table('detiPohled');
		return $this->getDb()->table('detiPohled')->where($filter);
	}

	//metoda, ktera zobrazuje adoptovane deti
	public function zobrazAdoptovaneDeti()
	{
    	return $this->db->fetchAll('SELECT * FROM relaceditesponzor AS r , dite AS d WHERE r.diteiddite = d.iddite');
	}

}
