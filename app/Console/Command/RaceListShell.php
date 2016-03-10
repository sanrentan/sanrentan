<?php

App::import('Vendor', 'simple_html_dom');

//出走表を取得する
class RaceListShell extends AppShell {

    public $uses = array('Race','RaceCard','RaceDetail','RecentRaceResult');

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
            $raceId = $this->params["race_id"];
        }

        //updateFlg
        if($this->params["update"]==1){
            $updateFlg = true;
        }else{
            $updateFlg = false;
        }


        if(empty($raceId)||!is_numeric($raceId)){
            $raceId = 1;
        }
        //対象のレースが存在するか？
        $raceData = $this->Race->findById($raceId);
        if(empty($raceData)){
            $this->__log("レースが見つかりません。race_id = ".$raceId,true);
        }

        //すでに出走表にデータが登録されていないか？
        $options = array(
            'conditions' => array(
                'is_deleted' => 0,
                'race_id' => $raceData["Race"]["id"]
            )
        );
        $cardData = $this->RaceCard->find("all",$options);
        if(!empty($cardData)){
            if($updateFlg==false){
                $this->__log("既に出走表が登録されています。race_id = ".$raceId,true);
            }else{
                $this->__log("既に出走表が存在しますが処理を続けます");
            }
        }

        //htmlを取得
        $html = file_get_html('http://keiba.yahoo.co.jp/race/denma/'.$raceData["Race"]["html_id"].'/');
        
        //trのループ
        $i=0;
        $horseList = array();

        $recent_5race_results = array();

        foreach($html->find('.denmaLs tr') as $key=>$element){
            //ヘッダー行は飛ばす
            if($i>0){
                //tdのループ
                $tdCounter = 0;
                foreach($element->find('td') as $key2=>$data){
                    switch ($tdCounter) {
                        
                        case 0://枠
                            $horseList[$i]["wk"] = $data->plaintext;
                            break;
                        case 1://馬番
                            $horseList[$i]["uma"] = $data->plaintext;
                            break;
                        case 2://馬名,性齢
                            $horseList[$i]["name"] = $data->find("strong")[0]->plaintext;
                            $tmp = $data->find("span")[0]->plaintext;
                            $horseList[$i]["sexage"] = explode('/',$tmp)[0];

                            //ここから直近レースの結果を取得する
                            $horseUrl = $data->find("a")[0]->href;
                            $horseHtml = file_get_html("http://keiba.yahoo.co.jp/".$horseUrl);
                            $j = 0;
                            foreach($horseHtml->find('#resultLs tr') as $key3 => $rowElements){
                                if($j > 0 && $j < 6){
                                    $tdCounter2 = 0;
                                    foreach($rowElements->find('td') as $key4 => $tdData){
                                        switch($tdCounter2){

                                            case 0 :
                                                $recent_5race_results[$i][$j]["race_date"] =  $tdData->plaintext;
                                                break;
                                            case 1:
                                                $recent_5race_results[$i][$j]["race_name"] =  $tdData->plaintext;
                                                break;
                                            case 2:
                                                $recent_5race_results[$i][$j]["place"] = $tdData->find("span")[0]->plaintext;
                                                break;
                                            case 3:
                                                $recent_5race_results[$i][$j]["cource"] =  $tdData->find("span")[0]->plaintext;
                                                break;
                                            case 4:
                                                $recent_5race_results[$i][$j]["baba"] =  $tdData->find("span")[0]->plaintext;
                                                break;
                                            case 5:
                                                $recent_5race_results[$i][$j]["number_of_heads"] = $tdData->plaintext;
                                                break;
                                            case 6:
                                                $recent_5race_results[$i][$j]["wk"] = $tdData->plaintext;
                                                break;
                                            case 7:
                                                $recent_5race_results[$i][$j]["uma"] = $tdData->plaintext;
                                                break;
                                            case 8:
                                                $recent_5race_results[$i][$j]["popularity"] = $tdData->plaintext;
                                                break;
                                            case 9:
                                                $recent_5race_results[$i][$j]["odds"] = $tdData->plaintext;
                                                break;
                                            case 10:
                                                $recent_5race_results[$i][$j]["order_of_arrival"] = $tdData->plaintext; 
                                                break;
                                            case 11:
                                                $recent_5race_results[$i][$j]["jockey"] = $tdData->plaintext;
                                                break;
                                        }
                                        $tdCounter2++;
                                    }
                                    
                                }
                                $j++;
                            }


                            break;
                        case 3://馬体重、増減
                            $horseList[$i]["weight"] = substr($data->plaintext, 1,3); 
                            $horseList[$i]["plus"] = substr($data->plaintext, 4); 
                            break;
                        case 4://騎手名、斤量
                            $horseList[$i]["j_name"]   = $data->find("a")[0]->plaintext;
                            $horseList[$i]["j_weight"]   = substr($data->plaintext, -5); 
                            break;
                        case 5://父馬、母馬、母父馬
                            //$tmp = explode(" ",$data->plaintext);
                            //$horseList[$i]["father"]   = ""; 
                            //$horseList[$i]["mother"]   = "";
                            //$horseList[$i]["m_father"] = "";

                    } 
                    $tdCounter++;
                }
            }
            $i++;
        }
        //DBに登録
        $row = 1;
        foreach($horseList as $key=>&$horse){
            $horse["race_id"] = $raceId;

            if($updateFlg==false){
                $this->RaceCard->create();
                $this->RaceCard->save($horse);
                $last_id = $this->RaceCard->getLastInsertID();
                foreach($recent_5race_results[$row] as $eachResult){
                    $eachResult["race_card_id"] = $last_id;
                    //$eachResult["race_card_id"] = 1;
                    $this->RecentRaceResult->create();
                    $this->RecentRaceResult->save($eachResult);
                }
                $row++;
            }else{
                //RaceCardのみ更新
                $options = array(
                    "conditions" => array(
                        "race_id" => $horse["race_id"],
                        "name" => $horse["name"]
                    )
                );
                $tmpData = $this->RaceCard->find("first",$options);
                $tmpData["RaceCard"]["wk"] = $horse["wk"];
                $tmpData["RaceCard"]["uma"] = $horse["uma"];
                $this->RaceCard->save($tmpData);
            }
        }


    	$this->__log("finish ok!.".$raceData["Race"]["name"]);

    }

}