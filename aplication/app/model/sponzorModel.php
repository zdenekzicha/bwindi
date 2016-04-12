<?php

/**
 * Provádí operace nad tabulkou deti
 */
class sponzorModel extends Model
{

	public function zobrazSponzory($filtr)
	{

		$this->getDb()->query('DROP VIEW if exists sponzoriPohled');
		$this->getDb()->query('CREATE VIEW sponzoriPohled as SELECT s.*, d.jmeno AS diteJmeno FROM sponzor AS s LEFT JOIN (dite AS d, relaceditesponzor AS r) ON (s.idSponzor = r.sponzorIdSponzor AND r.diteIdDite = d.idDite AND r.aktivniZaznam = 1 ) GROUP BY s.idSponzor ORDER BY s.jmeno');

		return $this->getDb()->table('sponzoriPohled')->where($filtr);

	}
	//metoda, ktera zobrazuje sponzory, kteri maji adoptovane dite
	public function zobrazAktivniSponzory()
	{
    	return $this->db->fetchAll('SELECT * FROM relaceditesponzor AS r , sponzor AS s WHERE s.aktivniZaznam = 1 AND r.aktivniZaznam = 1 AND r.sponzoridsponzor = s.idsponzor');
	}

	public function zobrazVsechnySponzory()
	{
    	return $this->db->fetchAll('SELECT * FROM sponzor WHERE aktivniZaznam = 1 ORDER BY ssym, jmeno ');
	}


	public function vytvorSponzora($form)
  	{

  		try{
        	$form["psc"]=preg_replace('/\s+/', '', $form["psc"]);
          $this->getTable()->insert($form);
	        return true;

	      } catch (Exception $e) {

	          return false;

	      }

  	}

  	public function vytvorAdopci($form)
  	{
  		try{
        	$this->db->table('relaceditesponzor')->insert($form);
	        return true;

	      } catch (Exception $e) {

	          return false;

	      }

  	}

  	  public function zobrazSponzora($id)
    {
        return $this->findAll()->where("idSponzor", $id);
    }

    public function zobrazMaximalniSsym()
    {
        return $this->getTable()->max('ssym');
    }

     public function zobrazAdopce($id)
    {
        return $this->db->fetchAll('SELECT d.jmeno, d.idDite, r.idRelaceDiteSponzor, DATE_FORMAT(r.datumVzniku,"%d.%m.%Y") AS datumVzniku FROM relaceditesponzor AS r, dite AS d WHERE r.aktivniZaznam = 1  AND r.diteIdDite = d.idDite AND r.sponzoridsponzor = '. $id .'');
    }

    public function zobrazNeaktivniAdopce($id)
    {
        return $this->db->fetchAll('SELECT d.jmeno, d.idDite, r.idRelaceDiteSponzor, DATE_FORMAT(r.datumVzniku,"%d.%m.%Y") AS datumVzniku, DATE_FORMAT(r.datumZaniku,"%d.%m.%Y") AS datumZaniku FROM relaceditesponzor AS r, dite AS d WHERE r.aktivniZaznam = 0  AND r.diteIdDite = d.idDite AND r.sponzoridsponzor = '. $id .'');
    }

  	  public function editovatSponzora($form)
    {

      try{
          $form["psc"]=preg_replace('/\s+/', '', $form["psc"]);
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

      public function smazatAdopce($id)
    {

      try{

          $this->getDb()->query('UPDATE relaceditesponzor SET aktivniZaznam = 0, datumZaniku = NOW() WHERE idRelaceDiteSponzor = '.$id.'');

          return true;

      } catch (Exception $e) {

          return false;

      }


    }

    public function obnovAdopce($id)
    {

      try{

          $this->getDb()->query('UPDATE relaceditesponzor SET aktivniZaznam = 1, datumZaniku = null, datumVzniku = NOW() WHERE idRelaceDiteSponzor = '.$id.'');

          return true;

      } catch (Exception $e) {

          return false;

      }


    }

    public function vyraditSponzora($idSponzor)
  	{
        		try{

			$this->getDb()->query('UPDATE sponzor SET aktivniZaznam=0,datumZaniku=NOW() WHERE idSponzor='.$idSponzor);
      $this->getDb()->query('UPDATE relaceDiteSponzor SET aktivniZaznam=0,datumZaniku=NOW() WHERE sponzoraIdSponzor='.$idDite);

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

     public function zaraditSponzora($idSponzor)
  	{
        		try{

			$this->getDb()->query('UPDATE sponzor SET aktivniZaznam=1,datumZaniku=NULL WHERE idSponzor='.$idSponzor);

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}


}
