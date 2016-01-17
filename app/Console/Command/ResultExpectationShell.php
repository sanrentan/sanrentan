<?php

//レースの予想結果を集計する
class ResultExpectationShell extends AppShell {

    public $uses = array('Race','RaceResult','User','Expectation','ExpectationResult');

    public function main() {
    	$msg = "start shell";
    	$this->__log($msg);

    	//race_idを取得
    	if(empty($this->args[0])){
    		$this->__log("引数にrace_idを指定してください",true);
    	}else{
	    	$race_id = $this->args[0];
    	}

    	//raceデータを取得
    	$raceData = $this->Race->findById($race_id);
    	if(empty($raceData)){
    		$this->__log("レースデータが存在しません. race_id:".$race_id,true);
    	}
    	$msg = "race_id:".$race_id." ".$raceData["Race"]["name"];
    	$this->__log($msg);

    	$year = substr($raceData["Race"]["race_date"],0,4);

    	//race結果データを取得
    	$resultData = $this->RaceResult->find("first",array("conditions"=>array("race_id"=>$race_id)));
    	if(empty($resultData)){
    		$this->__log("まだレース結果が出ていません. race_id:".$race_id,true);
    	}

    	//予想データを取得
    	$options = array(
    		"conditions" => array(
    			"race_id" => $race_id,
    			"cancel_flg" => 0,
    			"result" => 0
    		)
    	);
    	$expectationData = $this->Expectation->find("all",$options);
    	if(empty($expectationData)){
    		$this->__log("予想データがありません. race_id:".$race_id,true);
    	}

    	//当選者
    	$okCount = 0;
    	$ngCount = 0;

    	//レース結果をrace_card_idに変換
    	$horse1 = $raceData["RaceCard"][$resultData["RaceResult"]["horse1"]-1]["id"];
    	$horse2 = $raceData["RaceCard"][$resultData["RaceResult"]["horse2"]-1]["id"];
    	$horse3 = $raceData["RaceCard"][$resultData["RaceResult"]["horse3"]-1]["id"];

    	//一人一人当たったかどうか確認する
    	foreach($expectationData as $key=>$data){
    		$tmpArray = array();
    		$tmpArray[] = $data["Expectation"]["item1"];
    		$tmpArray[] = $data["Expectation"]["item2"];
    		$tmpArray[] = $data["Expectation"]["item3"];
    		$tmpArray[] = $data["Expectation"]["item4"];
    		$tmpArray[] = $data["Expectation"]["item5"];

    		$flg = false;

    		if(in_array($horse1, $tmpArray) && in_array($horse2, $tmpArray) && in_array($horse3, $tmpArray)){
    			$flg = true;
    		}


    		//ユーザー結果情報を取得
    		$options = array(
    			"conditions" => array(
    				"user_id" => $data["Expectation"]["user_id"],
    				"year"    => $year
    			)
    		); 

    		$userExpectation = $this->ExpectationResult->find("first",$options);
    		if(empty($userExpectation)){
    			$this->ExpectationResult->create();
    			$userExpectation["ExpectationResult"]["user_id"] = $data["Expectation"]["user_id"];
    			$userExpectation["ExpectationResult"]["year"] = $year;
    			$userExpectation["ExpectationResult"]["win"]  = 0;
    			$userExpectation["ExpectationResult"]["lose"] = 0;
    			$userExpectation["ExpectationResult"]["price"]= 0;
    			$userExpectation["ExpectationResult"]["max_price"]= 0;
    		}

    		$basePrice = 6000;

    		if($flg){
    			//当選処理
    			$data["Expectation"]["result"] = 1;
    			$userExpectation["ExpectationResult"]["win"]++;
    			$userExpectation["ExpectationResult"]["price"]+= ($resultData["RaceResult"]["sanrentan_price"]-$basePrice);

    			//最高当選か
    			if($resultData["RaceResult"]["sanrentan_price"]>=$userExpectation["ExpectationResult"]["max_price"]){
    				$userExpectation["ExpectationResult"]["max_price"] = $resultData["RaceResult"]["sanrentan_price"];
    				$userExpectation["ExpectationResult"]["max_race_id"] = $race_id;
    			}
    			$okCount++;
    		}else{
    			//外れ処理
    			$data["Expectation"]["result"] = 2;
    			$userExpectation["ExpectationResult"]["lose"]++;
    			$userExpectation["ExpectationResult"]["price"]-= $basePrice;
    			$ngCount++;
    		}

    		$this->Expectation->save($data);
    		$this->ExpectationResult->save($userExpectation);
    	}

    	$msg = "ok:".$okCount;
    	$this->__log($msg);
    	$msg = "ng:".$ngCount;
    	$this->__log($msg);


    	$this->__log("finish ok");

    }

}