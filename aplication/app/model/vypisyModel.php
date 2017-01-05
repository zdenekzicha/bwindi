<?php

/**
 * Provádí operace nad tabulkou skola
 */
class VypisyModel extends Model
{
  public function vsechnyDataOdDeti()
	{
		$dotaz = 'SELECT dite.idDite as idDite, dite.jmeno as diteJmeno, skola.nazev as diteSkola, dite.rocnik as diteRocnik, dite.vsym as diteVsym, dite.poznamka as ditePoznamka, sponzor.jmeno as sponzorJmeno, dite.profilovaFotka as diteProfilovaFotka
    FROM skola,dite, relaceditesponzor, sponzor
    WHERE relaceditesponzor.diteIdDite = dite.idDite AND
    relaceditesponzor.sponzorIdSponzor = sponzor.idSponzor AND
    relaceditesponzor.aktivniZaznam = 1 AND
    sponzor.aktivniZaznam = 1 AND
    skola.idSkola = dite.skolaIdSkola AND
    dite.aktivniZaznam = 1
    GROUP BY dite.idDite
    ORDER BY dite.jmeno';
    return $this->getDb()->query($dotaz);
	}

  public function sponzoriRozesilka($filter)
	{

		$dotaz = 'SELECT sponzor.mail FROM `sponzor`, dite, relaceditesponzor WHERE
              sponzor.idSponzor = relaceditesponzor.sponzorIdSponzor AND
              dite.idDite = relaceditesponzor.diteIdDite AND
              dite.aktivniZaznam = 1 AND
              relaceditesponzor.aktivniZaznam = 1 AND
              sponzor.aktivniZaznam = 1 AND
              sponzor.posilatInfo = 1 '.$filter.'
              GROUP BY sponzor.mail
              ORDER BY sponzor.jmeno ';
    return $this->getDb()->query($dotaz, $filter);
	}

  public function sponzoriRozesilkaBezDeti()
  {
    $dotaz = 'SELECT sponzor.mail FROM `sponzor` WHERE
              sponzor.posilatInfo = 1 AND
              sponzor.idSponzor NOT IN
              (
                SELECT sponzor.idSponzor FROM `sponzor`, dite, relaceditesponzor WHERE
              sponzor.idSponzor = relaceditesponzor.sponzorIdSponzor AND
              dite.idDite = relaceditesponzor.diteIdDite AND
              dite.aktivniZaznam = 1 AND
              relaceditesponzor.aktivniZaznam = 1'.$filter.'
              )
              GROUP BY sponzor.mail
              ORDER BY sponzor.jmeno';
    return $this->getDb()->query($dotaz);
  }

  public function potvrzeniPlateb()
  {
    $dotaz = 'SELECT platba.sponzorIdSponzor as idSponzor, sponzor.jmeno as sponzorJmeno, sponzor.ulice as ulice, sponzor.psc as psc, sponzor.mesto as mesto, year(platba.datum) as rok,date(MAX(platba.datum)) as posledniDatum, SUM(platba.castka) as soucet, COUNT(platba.sponzorIdSponzor) as pocetPlateb FROM `platba`,`sponzor` WHERE platba.sponzorIdSponzor=sponzor.idSponzor
group by platba.sponzorIdSponzor, year(platba.datum) ORDER by year(platba.datum) DESC, sponzor.jmeno ASC';
    return $this->getDb()->query($dotaz);
  }

  public function sumPlatbyBenefity($rok)
  {
    $dotaz = 'SELECT SUM(p.castka) AS castka, b.nazev AS nazev, b.vsym AS vsym

    FROM platba AS p, benefit AS b

    WHERE p.benefitIdBenefit = b.idBenefit AND rok = "'. $rok .'"

    GROUP BY benefitIdBenefit

    ';
    return $this->getDb()->query($dotaz);
  }
}
