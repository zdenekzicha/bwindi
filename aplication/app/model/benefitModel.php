<?php

/**
 * Provádí operace nad tabulkou deti
 */
class BenefitModel extends Model
{

	public function zobrazBenefity()
	{

		$this->getDb()->query('DROP VIEW if exists benefityPohled');
		$this->getDb()->query('CREATE VIEW benefityPohled as SELECT * FROM benefit order by vsym');

		return $this->getDb()->table('benefityPohled');
	}

  public function zobrazBenefit($id)
  {
      return $this->findAll()->where("idBenefit", $id);
  }

	public function vytvorBenefit($form)
  	{
  		try {
  			$this->getTable()->insert($form);
  			return true;		
  		} catch (Exception $e) {
  			return false;
  		}
      
  	}

  public function editovatBenefit($form)
    {     
    
      try{
          $this->getTable()->where('idBenefit', $form["idBenefit"])->update($form);   
       
          return true;

      } catch (Exception $e) {
          
          return false;

      }

    }

  public function smazatBenefit($id)
    {

      try{
      
          $this->getTable()->where('idBenefit', $id)->delete();
       
          return true;

      } catch (Exception $e) {
          
          return false;

      }

    }
}
