<?php

/**
 * Provádí operace nad tabulkou deti
 */
class PlatbaModel extends Model
{

	public function zobrazPlatby($filtr)
	{

		$this->getDb()->query('DROP VIEW if exists platbaPohled');
		$this->getDb()->query('CREATE VIEW platbaPohled as SELECT p.*, DATE_FORMAT(p.datum,"%d.%m.%Y") AS date, d.jmeno AS diteJmeno, d.vsym AS diteVsym, s.jmeno AS sponzorJmeno, s.ssym AS sponzorVsym, b.nazev AS benefitNazev FROM platba AS p, dite AS d, sponzor AS s, benefit AS b WHERE p.diteIdDite = d.idDite AND p.sponzorIdSponzor = s.idSponzor AND p.benefitIdBenefit = b.idBenefit ORDER BY p.datum DESC');

		return $this->getDb()->table('platbaPohled')->where($filtr);
	}

	//metoda, ktera zobrazuje vsechny roky v platbach
	public function zobrazVsechnyRoky()
	{
    	return $this->db->fetchAll('SELECT rok FROM platba GROUP BY rok');
	}

	public function zobrazPlatbu($id)
	{
    	return $this->findAll()->where("idPlatba", $id);
	}

	public function vytvorPlatbu($form)
  	{			
  	
  		try{
			
			$this->getTable()->insert($form);
			 
	        return true;

	    } catch (Exception $e) {
	        
	        return false;

	    }

  	}
  	
  	public function zbyvajiciPenize($diteIdDite)
  	{
    return $this->getDb()->query("SELECT nazev as benefit, bilance, rokPlatby as rok FROM
	(SELECT nazev,rokPlatby,(p.sumaObdrzeno - ifnull(r.sumaZaplaceno, 0)) as bilance FROM (
        	SELECT `diteIdDite`,`benefitIdBenefit`,`rok` as rokPlatby,sum(castka) as sumaObdrzeno FROM `platba` where diteiddite=$diteIdDite and benefitIdBenefit != 1 group by `benefitIdBenefit`,`diteIdDite`,`rok` ORDER BY diteIdDite) as p 
	left join (SELECT benefitIdBenefit as rbenefitIdBenefit, diteIdDite, rok, sum(zaplacenaCastka) as sumaZaplaceno from relaceDiteBenefit group by `benefitIdBenefit`,`diteIdDite`,`rok`) as r on 	r.diteIdDite=p.diteIdDite and r.rok = p.rokPlatby and r.rbenefitIdBenefit = p.benefitIdBenefit 
left join benefit as b on p.benefitIdBenefit=b.idBenefit)as vysledek
WHERE bilance>0
ORDER by rok DESC
"); 
    }
    
    public function penizeSkolne($diteIdDite)
  	{
    return $this->getDb()->query("SELECT *, sum(castka) as rocniSoucet, count(castka) as pocetPlateb FROM platba
WHERE benefitIdBenefit = 0 AND diteIdDite = $diteIdDite
GROUP BY rok
ORDER by rok DESC
"); 
    }

  	  	public function editovatPlatbu($form)
  	{			
  	
  		try{
			$this->getTable()->where('idPlatba', $form["idPlatba"])->update($form);		
			 
	        return true;

	    } catch (Exception $e) {
	        
	        return false;

	    }

  	}

  	public function smazatPlatbu($id)
  	{

  		try{
			
			$this->getTable()->where('idPlatba', $id)->delete();
			 
	        return true;

	    } catch (Exception $e) {
	        
	        return false;

	    }

  	}
  	
  	


}
