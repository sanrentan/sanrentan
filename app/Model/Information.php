<?php

class Information extends AppModel {

	public $name = 'Information';
	public $useTable = 'informations'; 

	//お知らせを取得
	public function getInfoList($limit=5){

		$options = array(
			'conditions' => array(
				'is_deleted' => 0,
				'view_flg' => 1
			),
			'order' => 'start_date desc,id desc',
			'limit' => $limit,
		);

		return $this->find('all',$options);

	}


	//レース当選者がいた時にデータを追加する
	public function addRaceResultInfo($race_id){
		$this->Race = ClassRegistry::init('Race');
		$raceData = $this->Race->findById($race_id);

		$raceName = $raceData['Race']['name'];
		if(!empty($raceData['Race']['grade'])){
			$raceName.= '(G'.$raceData['Race']['grade'].')';
		}

		$title = '<a href="/result/'.$raceData['Race']['id'].'">'.$raceName.'</a>で当サイトから予想的中者がでました。おめでとうござます！';

		$infoData = array(
			'title' => $title,
			'start_date' => date('Y-m-d'),
			'view_flg' => 1
		);
		$this->create();
		$this->save($infoData);

	}
}
