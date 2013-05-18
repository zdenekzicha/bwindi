<?php

/**
 * Provádí operace nad tabulkou deti
 */
class sponzorModel extends Model
{

	public function zobrazSponzory($filtr)
	{

		$this->getDb()->query('DROP VIEW if exists sponzoriPohled');
		$this->getDb()->query('CREATE VIEW sponzoriPohled as SELECT s.*, d.jmeno AS diteJmeno FROM sponzor AS s LEFT JOIN (dite AS d, relaceditesponzor AS r) ON (s.idSponzor = r.sponzorIdSponzor AND r.diteIdDite = d.idDite AND r.aktivniZaznam = 1) GROUP BY s.idSponzor');

		return $this->getDb()->table('sponzoriPohled')->where($filtr);
	}
	//metoda, ktera zobrazuje sponzory, kteri maji adoptovane dite
	public function zobrazAktivniSponzory()
	{
    	return $this->db->fetchAll('SELECT * FROM relaceditesponzor AS r , sponzor AS s WHERE r.sponzoridsponzor = s.idsponzor');
	}

	public function zobrazVsechnySponzory()
	{
    	return $this->db->fetchAll('SELECT * FROM sponzor');
	}


	public function vytvorSponzora($form)
  	{			
  	
  		try{
        	$this->getTable()->insert($form);
	        return true;

	      } catch (Exception $e) {
	          
	          return false;

	      }

  	}

  	  public function zobrazSponzora($id)
    {
        return $this->findAll()->where("idSponzor", $id);
    }


  	  public function editovatSponzora($form)
    {     
    
      try{
          $this->getTable()->where('idSponzor', $form["idSponzor"])->update($form);   
       
          return true;

      } catch (Exception $e) {
          
          return false;

      }

    }

  public function smazatSponzora($id)
    {

      try{
      
          $this->getTable()->where('idSponzor', $id)->delete();
       
          return true;

      } catch (Exception $e) {
          
          return false;

      }

    }


}