<?php

/**
 * Provádí operace nad tabulkou deti
 */
class DiteModel extends Model
{

	public function zobrazDeti($filter)
	{
		/*
		$query = 'CREATE VIEW detiPohled AS SELECT view1.*, sponzor.jmeno AS sponzor
			FROM (SELECT view.*, skola.nazev AS skolaNazev
			FROM (SELECT dite.* , relaceditesponzor.idRelaceDiteSponzor, relaceditesponzor.sponzorIdSponzor AS relaceIdSponzor FROM dite LEFT JOIN relaceditesponzor ON dite.idDite = relaceditesponzor.diteIdDite) AS view
			LEFT JOIN skola ON view.skolaIdSkola = skola.idSkola) AS view1
			LEFT JOIN sponzor ON view1.relaceIdSponzor=sponzor.idSponzor';


		$this->getDb()->query('DROP VIEW if exists view, view1, detiPohled');
		$this->getDb()->query('CREATE VIEW view AS SELECT dite.* , relaceditesponzor.idRelaceDiteSponzor, relaceditesponzor.sponzorIdSponzor AS relaceIdSponzor FROM dite LEFT JOIN relaceditesponzor ON dite.idDite = relaceditesponzor.diteIdDite');
		$this->getDb()->query('CREATE VIEW view1 AS SELECT view.*, skola.nazev as skolaNazev from view LEFT JOIN skola ON view.skolaIdSkola = skola.idSkola');
		$this->getDb()->query('CREATE VIEW detiPohled as SELECT view1.*, sponzor.jmeno as jmenoSponzor from view1 LEFT JOIN sponzor ON view1.relaceIdSponzor=sponzor.idSponzor');

		*/
		$this->getDb()->query('DROP VIEW if exists detiPohled');
    	$this->getDb()->query('CREATE VIEW detiPohled as SELECT d.*, s.jmeno AS jmenoSponzor, sk.nazev AS skolaNazev, sk.idSkola AS skolaId FROM dite AS d LEFT JOIN (sponzor AS s, relaceditesponzor AS r) ON (r.aktivniZaznam = 1 AND d.idDite = r.diteIdDite AND r.sponzorIdSponzor = s.idSponzor) LEFT JOIN (skola as sk) ON (d.skolaIdSkola = idSkola) GROUP BY d.idDite ORDER BY d.jmeno');
		//return $this->getDb()->table('detiPohled');
		return $this->getDb()->table('detiPohled')->where($filter);
	}

	//metoda, ktera zobrazuje adoptovane deti
	public function zobrazAdoptovaneDeti($search)
	{
    	return $this->db->fetchAll('SELECT * FROM relaceditesponzor AS r , dite AS d WHERE d.aktivniZaznam = 1 AND r.aktivniZaznam = 1 AND d.vystavene = 1 AND r.diteIdDite = d.idDite  AND d.jmeno LIKE ("%'.$search.'%") GROUP BY d.idDite ORDER BY d.jmeno');

	}

	//metoda, ktera zobrazuje adoptovane deti na webu
	public function zobrazAdoptovaneDetiNaWebu($search)
	{
    	return $this->db->fetchAll('SELECT * FROM relaceditesponzor AS r , dite AS d WHERE d.aktivniZaznam = 1 AND r.aktivniZaznam = 1 AND d.vystavene = 1 AND r.diteIdDite = d.idDite AND d.skolaIdSkola != 94 AND d.jmeno LIKE ("%'.$search.'%") GROUP BY d.idDite ORDER BY d.jmeno');

	}

	//metoda, ktera zobrazuje deti mimo program
	public function zobrazDetiMimoProgram()
	{
    	return $this->db->fetchAll('SELECT * FROM dite AS d WHERE d.skolaIdSkola = 94');

	}

	public function zobrazVsechnyDeti($order)
	{
    	return $this->getTable()->order($order);
	}

	public function zobrazVsechnyAktivniDeti($order)
	{
    	return $this->db->fetchAll('SELECT * FROM  dite WHERE aktivniZaznam = 1 ORDER BY '.$order);
	}

	public function zobrazDite($id)
	{
		return $this->findAll()->where("idDite", $id);
	}

	public function existujeSponzor($id)
	{
		return $this->db->fetchAll('SELECT idRelaceDiteSponzor, sponzorIdSponzor FROM  relaceditesponzor WHERE diteIdDite ='.$id.' and aktivniZaznam = 1');
	}

	public function jeSkolaPouzita($id)
	{
		return $this->db->fetchAll('SELECT COUNT(*) FROM dite WHERE skolaIdSkola ='.$id.'');
	}

	public function zobrazDiteApi($id)
	{
		return $this->db->fetchAll('SELECT d.*, s.jmeno AS jmenoSponzor, sk.nazev AS skolaNazev, sk.predpona AS skolaTyp, sk.nazevWeb AS skolaText, sk.idSkola AS skolaId, sk.castka AS castka, sk.castkaPristiRok AS castkaPristiRok FROM dite AS d LEFT JOIN (sponzor AS s, relaceditesponzor AS r) ON (d.idDite = r.diteIdDite AND r.sponzorIdSponzor = s.idSponzor) LEFT JOIN (skola as sk) ON (d.skolaIdSkola = idSkola) WHERE d.idDite = '.$id.' GROUP BY d.idDite ORDER BY d.jmeno ');
		//return $this->getDb()->table('detiPohled')->where("idDite", $id);
	}

	 public function zobrazSourozence($id)
    {
        return $this->db->fetchAll('SELECT d.jmeno, d.idDite, r.idSourozenzi FROM sourozenzi AS r, dite AS d WHERE r.diteIdDite2 = d.idDite AND r.diteIdDite1 = '. $id .'');
    }

    public function zobrazTimeline($id){
    	return $this->db->table('timeline')->where("diteIdDite", $id)->order('rok DESC, poradi DESC, id DESC') ;
    }

    public function maxTimelineItemOrder($id){
    	//return $this->db->table('timeline')->max('poradi')->where("id", $id);
    	return $this->db->fetchAll('SELECT MAX(poradi) AS max FROM timeline WHERE id='.$id);
    }

    public function zobrazTimelineItem($id){
    	return $this->db->table('timeline')->where("id", $id);
    }

    public function vytvorTimeline($form)
  	{



	try{

	  		/*  Flickr magic*/
	  	if($form['fotoFile']->getError()!=4){ //Provede se jen kdyz je nahrana fotka.
	      if ($form['fotoFile']->getError() > 0){
	          echo "Chyba při nahrávání fotky fotky: ".$this->codeToMessage($form['foto']->getError())."<br>";
	          return false;
	          }
	        else{
	          require_once("../libs/flickr.php");
	          $flickrId = $flickr->sync_upload($form['fotoFile']->getTemporaryFile(), $form['jmeno'], '', 'Timeline, '.$form['jmeno'].', Bwindi Orphans'.$form["diteIdDite"], 0);
	          $form['flickrId']=$flickrId;
	          $fotoInfo = $flickr->photos_getInfo($flickrId);
	          $form['fotoUrlSerializovana'] = serialize($fotoInfo['photo']);
	          $form['foto'] = $this->sestavUrlProfiloveFotky($fotoInfo['photo']);
	          }
	      }
      		/*  Flickr magic - konec*/
  			unset($form['jmeno']);
  			unset($form['fotoFile']);
			$this->db->table('timeline')->insert($form);
	        return true;

	    } catch (Exception $e) {

	        return false;
	    }
  	}

  	public function smazatTimeline($id)
  	{
        		try{

			$this->db->table('timeline')->where('id', $id)->delete();

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

  	public function editujTimeline($form)
    {
      require_once("../libs/flickr.php");
      try{
      		if(isset($form['fotoFile']) && $form['fotoFile']->getError()!=4){ //Provede se jen kdyz je nahrana fotka.
		      if ($form['fotoFile']->getError() > 0){
		          echo "Chyba při nahrávání fotky fotky: ".$this->codeToMessage($form['foto']->getError())."<br>";
		          return false;
		          }
		        else{

		          $flickrId = $flickr->sync_upload($form['fotoFile']->getTemporaryFile(), $form['jmeno'], '', 'Timeline, '.$form['jmeno'].', Bwindi Orphans'.$form["diteIdDite"], 0);
		          $form['flickrId']=$flickrId;
		          $fotoInfo = $flickr->photos_getInfo($flickrId);
		          $form['fotoUrlSerializovana'] = serialize($fotoInfo['photo']);
		          $form['foto'] = $this->sestavUrlProfiloveFotky($fotoInfo['photo']);
		          }
		      }

      		unset($form['jmeno']);
      		unset($form['fotoFile']);

      		$this->db->exec('UPDATE timeline SET ? WHERE id=?', $form, $form["id"]);

          return true;

     } catch (Exception $e) {

          return false;

    	}

    }

    public function zobrazMaximalniVsym()
    {
        return $this->getTable()->max('vsym');
    }

	public function vytvorDite($form)
  	{

  		try{

  			if($form['profilovasoubor']->getError()!=4){ //Provede se jen kdyz je nahrana fotka.
		        if ($form['profilovasoubor']->getError() > 0){
		          echo "Chyba při nahrávání fotky fotky: ".$this->codeToMessage($form['profilovasoubor']->getError())."<br>";
		          return false;
		          }
		        else{

		          require_once('../libs/flickr.php');
		          $flickrId = $flickr->sync_upload($form['profilovasoubor']->getTemporaryFile(), $form['jmeno'], '', 'Profilova fotka, '.$form['jmeno'].', Bwindi Orphans', 0);
		          $form['flickrId']=$flickrId;
		          $fotoInfo = $flickr->photos_getInfo($flickrId);
		          $form['profilovaUrlSerializovana'] = serialize($fotoInfo['photo']);
		          $form['profilovaFotka'] = $this->sestavUrlProfiloveFotky($fotoInfo['photo']);
		          }
		      }
		      /*  Flickr magic - konec*/
		  		unset($form['profilovasoubor']); // Mazu docasnej soubor, aby proslo ulozeni do DB
			$form['aktivniZaznam'] = 1;
			$this->getTable()->insert($form);

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

  	public function vytvorSourozence($form)
  	{
  		try{
        	$this->db->table('sourozenzi')->insert($form);
	        return true;

	      } catch (Exception $e) {

	          return false;

	      }

  	}

  	public function editovatDite($form)
  	{



  		try{
  		/*  Flickr magic*/
      if(isset($form['profilovasoubor']) && $form['profilovasoubor']->getError()!=4){ //Provede se jen kdyz je nahrana fotka.
        if ($form['profilovasoubor']->getError() > 0){
          echo "Chyba při nahrávání fotky fotky: ".$this->codeToMessage($form['profilovasoubor']->getError())."<br>";
          return false;
          }
        else{

          require_once('../libs/flickr.php');
          $flickrId = $flickr->sync_upload($form['profilovasoubor']->getTemporaryFile(), $form['jmeno'], '', 'Profilova fotka, '.$form['jmeno'].', Bwindi Orphans'.$form["idDite"], 0);
          $form['flickrId']=$flickrId;
          $fotoInfo = $flickr->photos_getInfo($flickrId);
          $form['profilovaUrlSerializovana'] = serialize($fotoInfo['photo']);
          $form['profilovaFotka'] = $this->sestavUrlProfiloveFotky($fotoInfo['photo']);
          }
      }
      /*  Flickr magic - konec*/
  		unset($form['profilovasoubor']); // Mazu docasnej soubor, aby proslo ulozeni do DB
			$this->getTable()->where('idDite', $form["idDite"])->update($form);
	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

  	public function sestavUrlProfiloveFotky ($photo, $size = "Medium") {
			//receives an array (can use the individual photo data returned
			//from an API call) and returns a URL (doesn't mean that the
			//file size exists)
			$sizes = array(
				"square" => "_s",
				"thumbnail" => "_t",
				"small" => "_m",
				"medium" => "",
				"medium_640" => "_z",
				"large" => "_b",
				"original" => "_o"
			);

			$size = strtolower($size);
			if (!array_key_exists($size, $sizes)) {
				$size = "medium";
			}

			if ($size == "original") {
				$url = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['originalsecret'] . "_o" . "." . $photo['originalformat'];
			} else {
				$url = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . $sizes[$size] . ".jpg";
			}
			return $url;
		}

  	public function smazatDite($id)
  	{
        		try{

			$this->getTable()->where('idDite', $id)->delete();

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

  	public function zvysitRocnik($listDiteId)
  	{
		try{
			$this->getDb()->query("UPDATE dite SET rocnik = rocnik + 1 where idDite in (". $listDiteId . ")");
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

    public function vyraditDite($idDite)
  	{
        		try{

			$this->getDb()->query('UPDATE dite SET aktivniZaznam=0,datumZaniku=NOW() WHERE idDite='.$idDite);
      $this->getDb()->query('UPDATE relaceDiteSponzor SET aktivniZaznam=0,datumZaniku=NOW() WHERE diteIdDite='.$idDite);

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

    public function zaraditDite($idDite)
  	{
        		try{

			$this->getDb()->query('UPDATE dite SET aktivniZaznam=1,datumZaniku=NULL WHERE idDite='.$idDite);

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }

  	}

  	public function smazatSourozence($idDite1, $idDite2)
  	{

  		try{

			//$this->getDb()->query('DELETE FROM sourozenzi WHERE diteIdDite1 = '.$idDite.' OR diteIdDite2 = '.$idDite);
			echo 'DELETE FROM sourozenzi WHERE (diteIdDite1 = '.$idDite1.' AND diteIdDite2 = '.$idDite2.') OR (diteIdDite1 = '.$idDite2.' AND diteIdDite2 = '.$idDite1.')';

			$this->getDb()->query('DELETE FROM sourozenzi WHERE (diteIdDite1 = '.$idDite1.' AND diteIdDite2 = '.$idDite2.') OR (diteIdDite1 = '.$idDite2.' AND diteIdDite2 = '.$idDite1.')');

	        return true;

	    } catch (Exception $e) {

	        return false;

	    }
	}

	public function vratVek($narozeni){
		$vek = intval(date('Y') - $narozeni);

		if($vek < 100){
			return $vek;
		}else{
			return 0;
		}
	}

  	public function zobrazDetiKAdopci($search)
  	{
  		return $this->db->fetchAll('SELECT * FROM dite as d LEFT JOIN relaceditesponzor as r ON r.diteIdDite = d.idDite WHERE d.idDite NOT IN (SELECT diteIdDite FROM relaceditesponzor WHERE aktivniZaznam = 1) AND d.aktivniZaznam = 1 AND d.vystavene = 1 GROUP BY d.idDite '); }

	public function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }


}
