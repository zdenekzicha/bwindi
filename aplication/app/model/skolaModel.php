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
}
