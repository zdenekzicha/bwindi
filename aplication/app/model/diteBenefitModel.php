<?php

/**
 * Provádí operace nad tabulkou deti
 */
class DiteBenefitModel extends Model
{

	public function zobrazRelace($diteIdDite)
	{
		return $this->getDb()->query("SELECT *,(r.zaplacenaCastka-p.sumaZaplaceno) as bilance FROM relaceDiteBenefit as r 
        left join benefit as b on r.benefitIdBenefit=b.idBenefit  
        left join (SELECT `diteIdDite`,`benefitIdBenefit`,rok as rokPlatby,sum(castka) as sumaZaplaceno FROM `platba` 
        where diteiddite=$diteIdDite group by `benefitIdBenefit`,`diteIdDite`,`rok`
        ORDER BY diteIdDite) as p on r.diteIdDite=p.diteIdDite AND r.benefitIdBenefit=p.benefitIdBenefit
        where r.diteiddite=$diteIdDite 
        order by r.datumVzniku"); 
                
	}

	
}
