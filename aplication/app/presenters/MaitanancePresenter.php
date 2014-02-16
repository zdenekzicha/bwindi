<?php

/**
 * maitanance funkce 
 */
class maitanancePresenter extends BasePresenter
{

	private $deti;

	protected function startup()
	{
	    parent::startup();
	    $this->deti = $this->context->diteModel;
	}

	public function actionUpdateProfilePhotoURL(){
		$deti = $this->deti->zobrazVsechnyDeti();

		foreach ($deti as $item) {
			$form['idDite'] = $item['idDite'];
			$form['profilovaFotka'] = $this->deti->sestavUrlProfiloveFotky(unserialize($item['profilovaUrlSerializovana']));
			if($this->deti->editovatDite($form)){
				$logMessage = "OK";
			}else{
				$logMessage = "FAIL";
			}
			file_put_contents(dirname(__FILE__) . '/../../log/profil-foto-'.date("Y-m-d").'.log', $log[] = $item['idDite'].":".$logMessage.":".$form['profilovaFotka']."\n", FILE_APPEND);
		}
		$this->terminate();
	}

	public function actionUpdateTimelinePhotoURL(){
		$deti = $this->deti->zobrazVsechnyDeti();

		foreach ($deti as $item) {
			$timelineList = $this->deti->zobrazTimeline($item['idDite']);
			$form['diteIdDite'] = $item['idDite'];
			foreach ($timelineList as $timelineItem) {
				$form['id'] = $timelineItem['id'];
				$form['foto'] = $this->deti->sestavUrlProfiloveFotky(unserialize($timelineItem['fotoUrlSerializovana']));
				if($this->deti->editujTimeline($form)){
					$logMessage = "OK";
				}else{
					$logMessage = "FAIL";
				}
				file_put_contents(dirname(__FILE__) . '/../../log/timeline-foto-'.date("Y-m-d").'.log', $log[] = $item['idDite'].":".$timelineItem["id"].":".$logMessage.":".$form['foto']."\n", FILE_APPEND);
			}
		}
		$this->terminate();
	}
}