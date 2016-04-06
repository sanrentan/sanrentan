<?php

App::import('Vendor', 'simple_html_dom');

//レースの予想結果を集計する
class ResultExpectationShell extends AppShell {

    public $uses = array('Race','RaceResult','RaceResultDetail','User','Expectation','ExpectationResult');

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addOption(
            'race_id', array(
                'help' => 'race_id',
                'default' => null,
            )
        );
        $parser->addOption(
            'update', array(
                'help' => '1:update',
                'default' => 0,
            )
        );

        return $parser;
    }

    public function main() {

    	$msg = "start shell";
    	$this->__log($msg);

    	//race_idを取得
    	if(empty($this->params["race_id"])){
    		$this->__log("引数にrace_idを指定してください",true);
    	}else{
	    	$race_id = $this->params["race_id"];
    	}

        //updateFlg
        if($this->params["update"]==1){
            $updateFlg = true;
        }else{
            $updateFlg = false;
        }

    	//raceデータを取得
    	$raceData = $this->Race->findById($race_id);
    	if(empty($raceData)){
    		$this->__log("レースデータが存在しません. race_id:".$race_id,true);
    	}
    	$msg = "race_id:".$race_id." ".$raceData["Race"]["name"];
    	$this->__log($msg);

    	$year = substr($raceData["Race"]["race_date"],0,4);


        //配当金を取得
        //すでに結果データが登録されていないか？
        $options = array(
            'conditions' => array(
                'race_id' => $raceData["Race"]["id"]
            )
        );

        $resultData = $this->RaceResult->find("all",$options);
        if(!empty($resultData)){
            if($updateFlg==false){
                $this->__log("すでにrace_resultsが存在します",true);
            }else{
                $this->__log("race_resultsは既に存在しますが処理を続けます");
            }
        }else{

            //htmlを取得
            $html = file_get_html('http://keiba.yahoo.co.jp/race/result/'.$raceData["Race"]["html_id"].'/');
            
            $nameArray = array("単勝","複勝","馬連","枠連","ワイド","馬単","3連複","3連単");
            $colsArray = array("tan","fuku","uma","wk","wide","umatan","sanrenpuku","sanrentan");

            //trのループ
            $resultData = array();
            foreach($html->find('.resultYen tr') as $key=>$element){
                //$targetCol = null;
                foreach($element->find('th') as $key2=>$data){
                    if(in_array($data->plaintext, $nameArray)){
                        $colKey = array_search($data->plaintext,$nameArray);
                        $col = $colsArray[$colKey];
                        $duplCounter = 1;
                    }else{
                        $this->__log("data is problem",true);
                    }
                }

                if($colKey==1||$colKey==4){
                    $col = $colsArray[$colKey].$duplCounter;
                    $duplCounter++;
                }


                $tdCounter = 0;
                foreach($element->find('td') as $key2=>$data){
                    switch ($tdCounter) {
                        case 0://馬番
                            $resultData[$col] = $data->plaintext;
                            break;
                        case 1://金額
                            $price = mb_substr($data->plaintext, 0, -1);
                            $price = str_replace(",", "", $price);
                            $resultData[$col."_price"] = $price;
                            break;
                        case 2://人気
                            $popularity = mb_substr($data->plaintext,0,mb_strlen($data->plaintext)-4);
                            $resultData[$col."_popularity"] = $popularity;
                            break;
                    }
                    $tdCounter++;
                }
            }
            $sanrentan = explode("－",$resultData["sanrentan"]);
            $resultData["horse1"] = $sanrentan[0];
            $resultData["horse2"] = $sanrentan[1];
            $resultData["horse3"] = $sanrentan[2];
            $resultData["race_id"] = $race_id;

            $this->RaceResult->create();
            $this->RaceResult->save($resultData);

            $this->__log("race_results ok");

        }



        //次にレース結果詳細テーブル
        //すでに結果詳細データが登録されていないか？
        $options = array(
            'conditions' => array(
                'race_id' => $raceData["Race"]["id"]
            )
        );
        $resultDetail = $this->RaceResultDetail->find("all",$options);
        if(!empty($resultDetail)){
            if($updateFlg==false){
                $this->__log("resultDetail already exists!",true);
            }
        }

        //htmlを取得
        $html = file_get_html('http://keiba.yahoo.co.jp/race/result/'.$raceData["Race"]["html_id"].'/');
        

        //trのループ
        $resultData = array();
        $i = 0;

        foreach($html->find('#resultLs tr') as $key=>$element){
            $tdCounter = 0;
            foreach($element->find('td') as $key2=>$data){
                switch ($tdCounter) {
                    case 0://着順
                        if(!empty($data->plaintext)&&is_numeric($data->plaintext)){
                            $resultData[$i]["result"] = $data->plaintext;
                        }else{
                            //競争中止や出走除外など
                            $resultData[$i]["result"] = 99;
                        }
                        break;
                    case 1://枠
                        $resultData[$i]["wk"] = $data->plaintext;
                        break;
                    case 2://馬
                        $resultData[$i]["uma"] = $data->plaintext;
                        break;
                    case 3://馬名
                        $resultData[$i]["name"] = $data->plaintext;
                        break;
                    case 4://性齢
                        $resultData[$i]["sexage"] = $data->plaintext;
                        break;
                    case 5://騎手名
                        $resultData[$i]["j_name"] = $data->plaintext;
                        break;
                    case 6://time
                        $resultData[$i]["time"] = $data->plaintext;
                        break;
                    case 7://着差
                        $resultData[$i]["difference"] = $data->plaintext;
                        break;
                    case 9://ラスト３ハロン
                        $resultData[$i]["last_time"] = $data->plaintext;
                        break;
                    case 10://斤量
                        $resultData[$i]["j_weight"] = $data->plaintext;
                        break;
                    case 11://体重
                        $resultData[$i]["weight"] = $data->plaintext;
                        break;
                    case 12://人気
                        $resultData[$i]["popularity"] = $data->plaintext;
                        break;
                    case 15://調教師
                        $resultData[$i]["trainer"] = $data->plaintext;
                        break;
                }
                $tdCounter++;
            }
            $i++;
        }

        foreach ($resultData as $key => $data) {

            if($updateFlg==false){
                //新規登録
                $data["race_id"] = $race_id;
                $this->RaceResultDetail->create();
                $this->RaceResultDetail->save($data);
            }else{
                //更新
                $options = array(
                    "conditions" => array(
                        "race_id" => $race_id,
                        "uma" => $data["uma"]
                    )
                );
                $tmpData = $this->RaceResultDetail->find("first",$options);
                //人気は月曜にならないととれないので
                $tmpData["RaceResultDetail"]["popularity"] = $data["popularity"];
                $tmpData["RaceResultDetail"]["result"]  = $data["result"];
                $tmpData["RaceResultDetail"]["trainer"] = $data["trainer"];
                $tmpData["RaceResultDetail"]["last_time"] = $data["last_time"];
                $tmpData["RaceResultDetail"]["modified"] = date("Y-m-d H:i:s");
                $this->RaceResultDetail->save($tmpData);
            }

        }
        $this->__log("RaceResultDetail OK");

        if($updateFlg){
            $this->__log("update OK.",true);
        } 


        //以下予想結果を判定
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
            $raceData["Race"]["accepting_flg"] = 0;
            $this->Race->save($raceData);
    		$this->__log("予想データがありませんが終了フラグをたてました. race_id:".$race_id,true);
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

        //レースを受付終了にする
        $raceData["Race"]["accepting_flg"] = 0;
        $this->Race->save($raceData);


    	$msg = "ok:".$okCount;
    	$this->__log($msg);
    	$msg = "ng:".$ngCount;
    	$this->__log($msg);


    	$this->__log("finish ok");

    }

}