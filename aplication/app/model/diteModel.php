<?php

/**
 * Provádí operace nad tabulkou deti
 */
class DiteModel extends Model
{

	public function zobrazDeti()
	{
		/*
		$query = 'CREATE VIEW detiPohled AS SELECT view1.*, sponzor.jmeno AS sponzor
			FROM (SELECT view.*, skola.nazev AS skolaNazev 
			FROM (SELECT dite.* , relaceditesponzor.idRelaceDiteSponzor, relaceditesponzor.sponzorIdSponzor AS relaceIdSponzor FROM dite LEFT JOIN relaceditesponzor ON dite.idDite = relaceditesponzor.diteIdDite) AS view
			LEFT JOIN skola ON view.skolaIdSkola = skola.idSkola) AS view1 
			LEFT JOIN sponzor ON view1.relaceIdSponzor=sponzor.idSponzor';
		*/

		$this->getDb()->query('DROP VIEW if exists view, view1, detiPohled');
		$this->getDb()->query('CREATE VIEW view AS SELECT dite.* , relaceditesponzor.idRelaceDiteSponzor, relaceditesponzor.sponzorIdSponzor AS relaceIdSponzor FROM dite LEFT JOIN relaceditesponzor ON dite.idDite = relaceditesponzor.diteIdDite');
		$this->getDb()->query('CREATE VIEW view1 AS SELECT view.*, skola.nazev as skolaNazev from view LEFT JOIN skola ON view.skolaIdSkola = skola.idSkola'); 
		$this->getDb()->query('CREATE VIEW detiPohled as SELECT view1.*, sponzor.jmeno as jmenoSponzor from view1 LEFT JOIN sponzor ON view1.relaceIdSponzor=sponzor.idSponzor');

		return $this->getDb()->table('detiPohled');
		//return $this->getDb()->table('detiPohled')->where(array('vsym' => '1061'));
	}
}