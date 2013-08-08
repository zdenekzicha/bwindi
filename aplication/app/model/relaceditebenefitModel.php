<?php

/**
 * 
 */
class RelaceDiteBenefitModel extends Model
{

	public function zobrazRelace($diteIdDite)
	{
		return $this->getDb()->query("SELECT *,(ifnull(p.sumaZaplaceno, 0)-ifnull(r.zaplacenaCastka, 0)) as bilance FROM relaceditebenefit as r 
        left join benefit as b on r.benefitIdBenefit=b.idBenefit  
        left join (SELECT `diteIdDite`,`benefitIdBenefit`,rok as rokPlatby,sum(castka) as sumaZaplaceno FROM `platba` 
        where diteiddite=$diteIdDite group by `benefitIdBenefit`,`diteIdDite`,`rok`
        ORDER BY diteIdDite) as p on r.diteIdDite=p.diteIdDite AND r.benefitIdBenefit=p.benefitIdBenefit AND r.rok=p.rokPlatby
        where r.diteiddite=$diteIdDite 
        order by r.datumVzniku DESC"); 
        
                
	}
	
	public function vytvorDiteBenefit($form)
  	{			
  	
  		try{
			
			$this->db->table('relaceditebenefit')->insert($form);
			 
	        return true;

	    } catch (Exception $e) {
	        
	        return false;

	    }
	  }
	
  public function zobrazDiteBenefit($id)
  	{
      	return $this->findAll()->where("idRelaceDiteBenefit", $id);
  	}
  	
	public function editovatDiteBenefit($form)
  	{			
  	
  		try{
			$this->getTable()->where('idRelaceDiteBenefit', $form["idRelaceDiteBenefit"])->update($form);		
			 
	        return true;

	    } catch (Exception $e) {
	        
	        return false;

	    }

  	}
	
}

