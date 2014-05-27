<?php

/**
 * Provádí operace nad tabulkou skola
 */
class SkolaModel extends Model
{
  public function zobrazBenefity()
  	{
  
  		$this->getDb()->query('DROP VIEW if exists skolaPohled');
  		$this->getDb()->query('CREATE VIEW skolaPohled as SELECT * FROM skola');
  
  		return $this->getDb()->table('skolaPohled');
  	}

  public function zobrazSkolu($id)
    {
        return $this->findAll()->where("idSkola", $id);
    }

  public function vytvorSkolu($form)
  	{
      try{
        $this->getTable()->insert($form);
        return true;

      } catch (Exception $e) {
          
          return false;

      }
  	}

  public function editovatSkolu($form)
    {     
    
      try{
          $this->getTable()->where('idSkola', $form["idSkola"])->update($form);   
       
          return true;

      } catch (Exception $e) {
          
          return false;

      }

    }

  public function smazatSkolu($id)
    {

      try{
      
          $this->getTable()->where('idSkola', $id)->delete();
       
          return true;

      } catch (Exception $e) {
          
          return false;

      }

    }
}
