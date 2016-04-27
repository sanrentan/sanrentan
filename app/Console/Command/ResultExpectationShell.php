<?php

App::import('Vendor', 'simple_html_dom');

//レースの予想結果を集計する
class ResultExpectationShell extends AppShell {

    public $uses = array('Race','RaceResult','RaceResultDetail','User','Expectation','ExpectationResult','Information');

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

        $parser->addOption(
            'mode', array(
                'help' => '1:resultExpect 2:raceData',
                'default' => 1,
            )
        );

        return $parser;
    }

    public function main() {

    	$msg = "start shell";
    	$this->__log($msg);

        $mode_array = array(1,2);
        $mode = $this->params['mode'];
        if(!in_array($mode, $mode_array)){
            $this->__log('modeの値が不正です:'.$mode,true);
        }

        //race_idを取得
        $race_ids = array();
        if(empty($this->params['race_id'])){
            //取得する
            if($mode==1){
                //本日のレースを取得
                $start_date = date('Y-m-d').' 00:00:00';
                $end_date   = date('Y-m-d').' 23:59:59';
            }elseif($mode==2){
                //３日以内のレースを取得
                $start_date = date('Y-m-d H:i:s', strtotime("-3 days"));
                $end_date   = date('Y-m-d').' 23:59:59';
            }

            $options = array(
                'fields' => array('id'),
                'conditions' => array(
                    'race_date >=' => $start_date,
                    'race_date <=' => $end_date,
                    'is_deleted' => 0
                ),
                'order' => 'id asc',
                'recursive' => -1
            );

            $race_list = $this->Race->find('list',$options);
            if(!empty($race_list)){
                foreach($race_list as $key=>$data){
                    $race_ids[] = $data;
                }

            }else{
                $this->__log('対象のレースが存在しません:mode:'.$mode,true);
            }

        }else{
            if(is_numeric($this->params['race_id'])){
                $race_ids[] = $this->params['race_id'];
            }else{
                $this->__log('race_idの値が不正です:'.$this->params['race_id'],true);
            }
        }

        foreach($race_ids as $key=>$race_id){
            if($mode==1){
                //レース結果を取得し、予想結果を生成
                $this->get_race_result($race_id,$mode);
            }elseif($mode==2){
                //レース結果の追加情報を取得
                $this->get_race_result_add($race_id,$mode);
            }
        }

        $this->__log("finish ok!");

    }

    public function get_race_result($race_id,$mode){

    	//raceデータを取得
    	$raceData = $this->Race->findById($race_id);
    	if(empty($raceData)){
    		$this->__log("レースデータが存在しません. race_id:".$race_id,true);
    	}else{
            $this->__log("レース結果を登録します。race_id = ".$race_id.', '.$raceData['Race']['name']);            
        }

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
            $this->__log("既にレース結果が存在します。race_id = ".$race_id.', '.$raceData['Race']['name']);            
            return;
        }

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
         if(!empty($resultData['sanrentan'])){
             $sanrentan = explode("－",$resultData["sanrentan"]);
             $resultData["horse1"] = $sanrentan[0];
             $resultData["horse2"] = $sanrentan[1];
             $resultData["horse3"] = $sanrentan[2];
             $resultData["race_id"] = $race_id;

             $this->RaceResult->create();
             $this->RaceResult->save($resultData);

             $this->__log("race_results ok");            
         }else{
            $this->__log("レース結果がまだ出ていない可能性があります。race_id = ".$race_id.', '.$raceData['Race']['name']);            
            return;
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
            $this->__log("resultDetail already exists!",true);
        }

        $resultData = $this->__get_html_data($raceData);

        foreach ($resultData as $key => $data) {
            //新規登録
            $data["race_id"] = $race_id;
            $this->RaceResultDetail->create();
            $this->RaceResultDetail->save($data);
        }
        $this->__log("RaceResultDetail OK");


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
                $userExpectation["ExpectationResult"]["modified"] = date('Y-m-d H:i:s');


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
                $userExpectation["ExpectationResult"]["modified"] = date('Y-m-d H:i:s');
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


        //お知らせに追加する
        if($okCount>0){
            $this->Information->addRaceResultInfo($race_id);
        }


        $this->__log("レース結果を登録が完了しました。race_id = ".$race_id.', '.$raceData['Race']['name']);            

    }

    public function get_race_result_add($race_id,$mode){

        //raceデータを取得
        $raceData = $this->Race->findById($race_id);
        if(empty($raceData)){
            $this->__log("レースデータが存在しません. race_id:".$race_id,true);
        }else{
            $this->__log("レース結果を更新します。race_id = ".$race_id.', '.$raceData['Race']['name']);            
        }

        //次にレース結果詳細テーブル
        //すでに結果詳細データが登録されていないか？
        $options = array(
            'conditions' => array(
                'race_id' => $race_id
            )
        );
        $resultDetail = $this->RaceResultDetail->find("all",$options);
        if(empty($resultDetail)){
            $this->__log("レースデータが存在しません. race_id:".$race_id,true);
        }

        $resultData = $this->__get_html_data($raceData);

        foreach($resultData as $key=>$data){
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

        $this->__log("レース結果の更新が完了しました。race_id = ".$race_id.', '.$raceData['Race']['name']);            
    }


    private function __get_html_data($raceData){
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

        return $resultData;

    }



}