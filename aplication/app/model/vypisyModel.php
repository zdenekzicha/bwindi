<?php

/**
 * Provádí operace nad tabulkou skola
 */
class VypisyModel extends Model
{
  	public function vsechnyDataOdDeti()
	{
		$dotaz = 'SELECT dite.jmeno as diteJmeno, skola.nazev as diteSkola, dite.vsym as diteVsym, dite.poznamka as ditePoznamka, sponzor.jmeno as sponzorJmeno  
    FROM skola,dite, relaceditesponzor, sponzor WHERE relaceditesponzor.diteIdDite = dite.idDite AND 
    relaceditesponzor.sponzorIdSponzor = sponzor.idSponzor AND skola.idSkola = dite.skolaIdSkola 
    ORDER BY dite.jmeno';
    return $this->getDb()->query($dotaz);
	}
}
