<?php

/**
 * Provádí operace nad tabulkou skola
 */
class VypisyModel extends Model
{
  public function vsechnyDataOdDeti()
	{
		$dotaz = 'SELECT dite.jmeno as diteJmeno, skola.nazev as diteSkola, dite.vsym as diteVsym, dite.poznamka as ditePoznamka, sponzor.jmeno as sponzorJmeno  
    FROM skola,dite, relaceditesponzor, sponzor 
    WHERE relaceditesponzor.diteIdDite = dite.idDite AND 
    relaceditesponzor.sponzorIdSponzor = sponzor.idSponzor AND 
    skola.idSkola = dite.skolaIdSkola 
    ORDER BY dite.jmeno';
    return $this->getDb()->query($dotaz);
	}
  
  public function aktivniSponzori()
	{
		$dotaz = 'SELECT sponzor.mail FROM `sponzor`, dite, relaceditesponzor WHERE 
              sponzor.idSponzor = relaceditesponzor.sponzorIdSponzor AND
              dite.idDite = relaceditesponzor.diteIdDite AND 
              dite.aktivniZaznam = 1 AND
              relaceditesponzor.aktivniZaznam = 1
              GROUP BY sponzor.mail
              ORDER BY sponzor.jmeno ';
    return $this->getDb()->query($dotaz);
	}
}
