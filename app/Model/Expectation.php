<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Expectation extends AppModel {

	public $kojiharu_id = 3;

	//public $belongsTo = array(
    //   'Race' => array(
     //       'className' => 'Race',
    //        'foreignKey' => 'race_id'
    //    )
    //);

    //レースの予想を取得 ※第２引数がなければこじはるの予想を返す
    public function getExpectationData($race_id,$user_id = 3){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.race_id' => $race_id,
				'Expectation.user_id' => $user_id,
			),
			'limit' => 1
		);
		$resultData = $this->find("first",$options);

		$returnData = array();

		if(!empty($resultData)){
			$tmpArray = array();
			for($i=1;$i<=Configure::read('Base.box_count');$i++){
				$tmpArray[] = $resultData["Expectation"]["item".$i];
			}
			$raceCard = ClassRegistry::init('RaceCard');
			$options = array(
				"conditions" => array("RaceCard.id"=>$tmpArray)
			);
			$horseData["selectData"] = $raceCard->find("all",$options);
			$returnData = array_merge($resultData,$horseData);
		}
		return $returnData;
    }

   //みんなのレースの予想を取得
    public function getExpectationOther($race_id,$limit = 5){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.race_id' => $race_id,
			),
			'limit' => $limit
		);
		$resultData = $this->find("all",$options);

		if(!empty($resultData)){

			//ユーザー情報も取得
			$userIds = array();
			foreach($resultData as $key=>$data){
				$userIds[] = $data["Expectation"]["user_id"];
			}
			$User = ClassRegistry::init('User');
			$tmpData = $User->find("all",array("conditions"=>array("User.id"=>$userIds)));
			$userData = array();
			foreach($tmpData as $key=>$data){
				$userData[$data["User"]["id"]] = $data["User"];
			}

			//出走表データを取得
			$raceCard = ClassRegistry::init('RaceCard');
			$tmpData = $raceCard->find("all",array("conditions"=>array("race_id"=>$race_id)));
			$cardData = array();
			foreach($tmpData as $key=>$data){
				$cardData[$data["RaceCard"]["id"]] = $data;
			}

			foreach($resultData as $key=>&$data){
				$tmpArray = array();
				for($i=1;$i<=Configure::read('Base.box_count');$i++){
					$data["selectData"][] = $cardData[$data["Expectation"]["item".$i]];
					$data["User"] = $userData[$data["Expectation"]["user_id"]];
				}
			}
		}
		return $resultData;
    }


	//最新のこじはるの予想を取得
    public function getRecentKojiharu(){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.user_id' => $this->kojiharu_id,
			),
			'order' => array("Expectation.id desc"),
			'limit' => 1
		);

		$result = $this->find("first",$options);

		$tmpArray = array();
		for($i=1;$i<=Configure::read('Base.box_count');$i++){
			$tmpArray[] = $result["Expectation"]["item".$i];
		}

		$race = ClassRegistry::init('Race');
		$raceData = $race->findById($result["Expectation"]["race_id"]);

		//表示用
		foreach($raceData["RaceCard"] as $key=>$data){
			if(in_array($data["id"], $tmpArray)){
				$result["Expectation"]["view"][] = $data;
			}
		}

		$resultData = array_merge($result,$raceData);
		return $resultData;
    }

    //指定したレースの自分の予想一覧を返す（複数レース）race_idは配列指定
    public function getExpectaionList($user_id,$race_id){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.race_id' => $race_id,
				'Expectation.user_id' => $user_id,
			),
			'order' => "race_id desc"
		);
		$raceData = $this->find("all",$options);

		//Expectationの馬idから馬番を得る
		$RaceCard = ClassRegistry::init('RaceCard');
		$umaData = $RaceCard->find("list",array("conditions"=>array("race_id"=>$race_id),"fields"=>array("uma")));
		$wkData  = $RaceCard->find("list",array("conditions"=>array("race_id"=>$race_id),"fields"=>array("wk")));

		$returnData = array();
		if(!empty($raceData)){
			foreach($raceData as $key=>$data){
				for($i=1;$i<=5;$i++){
					$data["Expectation"]["item".$i."_uma"] = $umaData[$data["Expectation"]["item".$i]];
					$data["Expectation"]["item".$i."_wk"] = $wkData[$data["Expectation"]["item".$i]];
				}
				$returnData[$data["Expectation"]["race_id"]] =$data;
			}
		}
		return $returnData;
    }

    //当選した人を取得
    public function getWinUsers($race_id){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.race_id' => $race_id,
				'Expectation.result' => 1,
			),
			'order' => "id asc"
		);
		$winData = $this->find("all",$options);

		//あとで消す
		$winData = array_merge($winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData,$winData);

		$userIds = array();
		if(!empty($winData)){
			foreach($winData as $key=>$data){
				$userIds[] = $data["Expectation"]["user_id"];
			}

			$User = ClassRegistry::init('User');
			$tmpData = $User->find("all",array("conditions"=>array("User.id"=>$userIds)));
			$userData = array();
			foreach($tmpData as $key=>$data){
				$userData[$data["User"]["id"]] = $data["User"];
			}

			foreach($winData as $key=>&$data){
				$data["User"] = $userData[$data["Expectation"]["user_id"]];
			}
		}

		return $winData;




		//Expectationの馬idから馬番を得る
		$RaceCard = ClassRegistry::init('RaceCard');
		$umaData = $RaceCard->find("list",array("conditions"=>array("race_id"=>$race_id),"fields"=>array("uma")));
		$wkData  = $RaceCard->find("list",array("conditions"=>array("race_id"=>$race_id),"fields"=>array("wk")));

		$returnData = array();
		if(!empty($winData)){
			foreach($winData as $key=>$data){
				for($i=1;$i<=5;$i++){
					$data["Expectation"]["item".$i."_uma"] = $umaData[$data["Expectation"]["item".$i]];
					$data["Expectation"]["item".$i."_wk"] = $wkData[$data["Expectation"]["item".$i]];
				}
				$returnData[$data["Expectation"]["race_id"]] =$data;
			}
		}

		print_R($returnData);exit;
		return $returnData;

    }


}
