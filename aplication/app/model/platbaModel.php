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
    return $this->getDb()->query("SELECT *,(p.sumaZaplaceno-r.zaplacenaCastka) as bilance FROM relaceDiteBenefit as r 
        left join benefit as b on r.benefitIdBenefit=b.idBenefit  
        join (SELECT `diteIdDite`,`benefitIdBenefit`,rok as rokPlatby,sum(castka) as sumaZaplaceno FROM `platba` 
        where diteiddite=$diteIdDite group by `benefitIdBenefit`,`diteIdDite`,`rok`
        ORDER BY diteIdDite) as p on r.diteIdDite=p.diteIdDite AND r.benefitIdBenefit=p.benefitIdBenefit
        where r.diteiddite=$diteIdDite 
        order by r.datumVzniku"); 
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
