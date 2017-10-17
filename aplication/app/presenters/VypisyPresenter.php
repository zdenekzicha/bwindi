<?php

class vypisyPresenter extends BasePresenter
{

	private $vypisy;
	private $platby;
	private $deti;
	private $skola;
	private $sponzori;
	private $benefity;
	private $jsonPresenter;
	private $filter;
	private $psc;

	public $filtrSkola;
	public $filtrSelect;
	public $filtrText;
	public $filtrAdoptovane;
	public $filtrRok;

	protected function startup()
	{
	    parent::startup();
	    $this->vypisy = $this->context->vypisyModel;
	    $this->platby = $this->context->platbaModel;
	    $this->deti = $this->context->diteModel;
	    $this->jsonPresenter = $this->presenter->jsonPresenter;
			$this->sponzori = $this->context->sponzorModel;
			$this->benefity = $this->context->benefitModel;
			$this->skola = $this->context->skolaModel;
	}

  public function renderDefault()
	{
		$this->template->vypisy = $this->vypisy->vsechnyDataOdDeti();
		$this->template->sponzori = $this->sponzori->zobrazAktivniSponzory();

	}

  public function actionAktivniSponzori($filtrSkola,$filtrSelect,$filtrText,$filtrAdoptovane)
	{
		$this->filter = '';
		if(isset($filtrSelect)&&$filtrText!='') {
			$this->filter = $this->filter.' AND '.$filtrSelect.' LIKE \''.$filtrText.'%\'';
		}
		if(isset($filtrSkola)&&$filtrSkola!=0) {
			$this->filter = $this->filter.' AND dite.skolaIdSkola ='.$filtrSkola;
		}
		$this->template->sponzoriRozesilka = $this->vypisy->sponzoriRozesilka($this->filter);
    $this->template->sponzoriRozesilkaBezDeti = $this->vypisy->sponzoriRozesilkaBezDeti();
		$this->template->skoly = $this->skola->findAll();
		$this->template->filtrSkola = $filtrSkola;
		$this->template->filtrSelect = $filtrSelect;
		$this->template->filtrText = $filtrText;
		$this->template->filtrAdoptovane = $filtrAdoptovane;
	}

  public function actionPotvrzeniPlateb()
	{
		$this->template->potvrzeniPlateb = $this->vypisy->potvrzeniPlateb();

	}

	public function actionDetiAPlatby($filtrRok)
	{
		
		if(!isset($filtrRok)) {
			$filtrRok = date('Y'); 
		}

		$this->template->detiAPlatby = array();
		$vsechny_deti = $this->deti->zobrazVsechnyAktivniDeti("jmeno");
		foreach ($vsechny_deti as $dite)
			{
				$skolne_tohoto_ditete = 0;
				$letos_zaplaceno = 0;
				$zbyva_zaplatit = 0;
				$platbaLetos = $this->platby->skolneNaKonkretniRok($dite['idDite'], $filtrRok);
				$udaje_k_diteti = $this->deti->zobrazDiteApi($dite['idDite']);
				if($udaje_k_diteti) $skolne_tohoto_ditete = $udaje_k_diteti[0]['castka'];
				if($platbaLetos) {
					$zbyva_zaplatit = $skolne_tohoto_ditete - $platbaLetos[0]['rocniSoucet'];
					$letos_zaplaceno = $platbaLetos[0]['rocniSoucet'];
					}
					else {
						$zbyva_zaplatit = $skolne_tohoto_ditete;# code...
					}
				$dite['skolne'] = $skolne_tohoto_ditete + '';
				$dite['letos_zaplaceno'] =  $letos_zaplaceno + '';
				$dite['zbyva_zaplatit'] = $zbyva_zaplatit + '';
				array_push($this->template->detiAPlatby, $dite);
		  }
			$this->template->sponzori = $this->sponzori->zobrazAktivniSponzory();
			$this->template->letosni_rok = $filtrRok;
	}

	public function actionDetiABenefity()
	{
		$this->template->detiABenefity = array();
  	$vsechny_deti = $this->deti->zobrazVsechnyAktivniDeti("jmeno");
		foreach ($vsechny_deti as $dite)
			{
				$dite['benefity'] = $this->benefity->zobrazBenefityNaRok($dite['idDite'], date("Y"));
				array_push($this->template->detiABenefity, $dite);
		  }
			$this->template->letosni_rok = date("Y");
	}

  public function actionDetiSProfilovkou()
	{
		$this->template->vypisy = $this->vypisy->vsechnyDataOdDeti();
		$this->template->sponzori = $this->sponzori->zobrazAktivniSponzory();

	}

  public function actionSumPlatbyBenefity($filtrRok)
	{

		if(!isset($filtrRok) && $filtrRok != 'Rok') {
			$filtrRok = date("Y");
		}

		$this->template->roky = $this->platby->zobrazVsechnyRoky();
		$this->template->filtrRok = $filtrRok;;
		$this->template->vypisy = $this->vypisy->sumPlatbyBenefity($filtrRok);

	}

}


?>
