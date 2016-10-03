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

        $parser->addOption(
            'mode', array(
                'help' => '1:list 2:uma 3:weight 4:odds',
                'default' => 1,
            )
        );


        return $parser;
    }

    public function main() {
    	$msg = 'start shell';
    	$this->__log($msg);

        $mode_array = array(1,2,3,4);
        $mode = $this->params['mode'];
        if(!in_array($mode, $mode_array)){
            $this->__log('modeの値が不正です:'.$mode,true);
        }

        //race_idを取得
        $race_ids = array();
        if(empty($this->params['race_id'])){
            //取得する
            if($mode==1){
                //5日以内のレースを取得
                $end_date = date('Y-m-d H:i:s', strtotime("+5 days"));
            }elseif($mode==2){
                //4日以内のレースを取得
                $end_date = date('Y-m-d H:i:s', strtotime("+4 days"));
            }elseif($mode==3){
                //本日のレースを取得
                $end_date = date('Y-m-d').' 17:00:00';
            }elseif($mode==4){
                //３日以内のレースを取得
                $end_date = date('Y-m-d H:i:s', strtotime("+3 days"));
            }

            $options = array(
                'fields' => array('id'),
                'conditions' => array(
                    'race_date >' => date('Y-m-d H:i:s'),
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

            //海外レースは何もしない
            if(in_array($race_id, Configure::read('sp_race'))){
                continue;
            }

            if($mode==1){
                //出走表を取得
                $this->get_race_data($race_id,$mode);
            }elseif($mode==2){
                //枠番馬番を取得
                $this->get_number_data($race_id,$mode);
            }elseif($mode==3){
                //馬体重を取得
                $this->get_weight_data($race_id,$mode);
            }elseif($mode==4){
                //オッズを取得
                $this->get_odds_data($race_id,$mode);
            }
        }

    	$this->__log("finish ok!");

    }

    //出走表を取得
    public function get_race_data($race_id,$mode){

        //対象のレースが存在するか？
        $raceData = $this->Race->findById($race_id);
        if(empty($raceData)){
            $this->__log("レースが見つかりません。race_id = ".$race_id,true);
        }else{
            $this->__log("出走表を登録します。race_id = ".$race_id.', '.$raceData['Race']['name']);
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
            $this->__log("既に出走表が登録されています。race_id = ".$race_id,true);
        }

        list($horseList,$recent_5race_results) = $this->__get_html_data($raceData);
        $this->__save_race_data($mode,$horseList,$recent_5race_results,$race_id);

        //レースを公開する
        $raceData['Race']['view_flg'] = 1;
        $raceData['Race']['modified'] = date('Y-m-d H:i:s');
        $this->Race->save($raceData);
        $this->__log("出走表を登録し公開しました。race_id = ".$race_id.', '.$raceData['Race']['name']);

    }

    //枠番、馬番等を取得
    public function get_number_data($race_id,$mode){
        //対象のレースが存在するか？
        $raceData = $this->Race->findById($race_id);
        if(empty($raceData)){
            $this->__log("レースが見つかりません。race_id = ".$race_id,true);
        }else{
            $this->__log("枠番馬番を登録します。race_id = ".$race_id.', '.$raceData['Race']['name']);
        }

        //すでに出走表にデータが登録されていないか？
        $options = array(
            'conditions' => array(
                'is_deleted' => 0,
                'race_id' => $raceData["Race"]["id"]
            )
        );
        $cardData = $this->RaceCard->find("all",$options);
        if(empty($cardData)){
            $this->__log("まだ出走表が登録されていません。race_id = ".$race_id,true);
        }

        list($horseList,$recent_5race_results) = $this->__get_html_data($raceData);
        
        //この地点で出走馬数に変更がある場合は、エラーとする
        if(count($horseList)!=count($raceData['RaceCard'])){
            $this->__log("[エラー]:取り消しの馬がいるため、枠番馬番を登録を行いませんでした。確認後再度実行してください。race_id = ".$race_id.', '.$raceData['Race']['name']);
            return;
        }

        $this->__save_race_data($mode,$horseList,$recent_5race_results,$race_id);

        //レースを受付開始する
        $raceData['Race']['view_flg'] = 1;
        $raceData['Race']['accepting_flg'] = 1;
        $raceData['Race']['modified'] = date('Y-m-d H:i:s');
        $this->Race->save($raceData);

        $this->__log("枠番馬番を登録し受付を開始しました。race_id = ".$race_id.', '.$raceData['Race']['name']);
    }


    //馬体重を取得
    public function get_weight_data($race_id,$mode){

        //対象のレースが存在するか？
        $raceData = $this->Race->findById($race_id);
        if(empty($raceData)){
            $this->__log("レースが見つかりません。race_id = ".$race_id,true);
        }else{
            $this->__log("馬体重を登録します。race_id = ".$race_id.', '.$raceData['Race']['name']);
        }

        //すでに出走表にデータが登録されていないか？
        $options = array(
            'conditions' => array(
                'is_deleted' => 0,
                'race_id' => $raceData["Race"]["id"]
            )
        );
        $cardData = $this->RaceCard->find("all",$options);
        if(empty($cardData)){
            $this->__log("まだ出走表が登録されていません。race_id = ".$race_id,true);
        }

        list($horseList,$recent_5race_results) = $this->__get_html_data($raceData);
        $this->__save_race_data($mode,$horseList,$recent_5race_results,$race_id);

        $this->__log("馬体重を登録しました。race_id = ".$race_id.', '.$raceData['Race']['name']);

    }

    //htmlからデータを取得する
    private function __get_html_data($raceData){
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
        return array($horseList,$recent_5race_results);
    }


    //DBに登録する処理
    private function __save_race_data($mode,$horseList,$recent_5race_results,$race_id){

        //DBに登録
        $row = 1;
        foreach($horseList as $key=>&$horse){
            $horse["race_id"] = $race_id;

            if($mode==1){
                $this->RaceCard->create();
                $this->RaceCard->save($horse);
                $last_id = $this->RaceCard->getLastInsertID();

                if(empty($recent_5race_results)){
                    $this->__log("過去5レースが登録されていません。race_card_id:".$last_id);
                    continue;
                }

                foreach($recent_5race_results[$row] as $eachResult){
                    $eachResult["race_card_id"] = $last_id;
                    $this->RecentRaceResult->create();
                    $this->RecentRaceResult->save($eachResult);
                }
                $row++;

            }elseif($mode==2){
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
                $tmpData["RaceCard"]["modified"] = date("Y-m-d H:i:s");
                $this->RaceCard->save($tmpData);

            }elseif($mode==3){
                //RaceCardのみ更新
                $options = array(
                    "conditions" => array(
                        "race_id" => $horse["race_id"],
                        "name" => $horse["name"]
                    )
                );
                $tmpData = $this->RaceCard->find("first",$options);
                $tmpData["RaceCard"]["weight"] = $horse["weight"];
                $tmpData["RaceCard"]["plus"] = $horse["plus"];
                $tmpData["RaceCard"]["modified"] = date("Y-m-d H:i:s");
                $this->RaceCard->save($tmpData);

            }
        }

    }

    //オッズを登録する処理
    public function get_odds_data($race_id,$mode){

        //対象のレースが存在するか？
        $raceData = $this->Race->findById($race_id);
        if(empty($raceData)){
            $this->__log("レースが見つかりません。race_id = ".$race_id,true);
        }else{
            $this->__log("オッズを登録します。race_id = ".$race_id.', '.$raceData['Race']['name']);
        }

        //すでに出走表にデータが登録されていないか？
        $options = array(
            'conditions' => array(
                'is_deleted' => 0,
                'race_id' => $raceData["Race"]["id"]
            )
        );
        $cardData = $this->RaceCard->find("all",$options);
        if(empty($cardData)){
            $this->__log("まだ出走表が登録されていません。race_id = ".$race_id,true);
        }

        //htmlを取得
        $html = file_get_html('http://keiba.yahoo.co.jp/odds/tfw/'.$raceData["Race"]["html_id"].'/');
        
        //trのループ
        $i=0;
        $horseList = array();

        foreach($html->find('.layoutCol2L tr') as $key=>$element){
            //ヘッダー行は飛ばす
            if($i>0){
                //tdのループ
                $tdCounter = 0;
                foreach($element->find('td') as $key2=>$data){
                    switch ($tdCounter) {
 
                        case 1://馬番
                            $uma = $data->plaintext;
                            $horseList[$uma]["uma"] = $data->plaintext;
                            break;
                        case 2://馬名
                            $horseList[$uma]["name"] = $data->plaintext;
                            break;
                        case 3://オッズ
                            $horseList[$uma]["odds"] = $data->plaintext;
                            break;

                    } 
                    $tdCounter++;
                }
            }
            $i++;
        }
        $i = 0;
        foreach($html->find('.layoutCol2R tr') as $key=>$element){
            //ヘッダー行は飛ばす
            if($i>0){
                //tdのループ
                $tdCounter = 0;
                foreach($element->find('td') as $key2=>$data){
                    switch ($tdCounter) {                        
                        case 1://馬番
                            $uma = $data->plaintext;
                            $horseList[$uma]['uma'] = $data->plaintext;
                            break;
                        case 2://馬名
                            $horseList[$uma]['name'] = $data->plaintext;
                            break;
                        case 3://オッズ
                            $horseList[$uma]['odds'] = $data->plaintext;
                            break;
                    } 
                    $tdCounter++;
                }
            }
            $i++;
        }

        foreach ($horseList as $key => $value){
            $key_id[$key] = $value['odds'];
        }
        $sortArray = array_multisort ( $key_id , SORT_ASC , $horseList);

        $tmpArray = array();
        $ninki = 1;
        foreach($horseList as $key=>&$data){
            if(is_numeric($data['odds'])){
                $data['ninki'] = $ninki;
                $ninki++;
                $tmpArray[$data['uma']] = $data;
            }else{
                $this->__log("オッズが存在しない:". print_r($data,true));
            }
        }

        //DBに登録
        foreach($cardData as $key => &$data){
            //一応馬名のチェック
            if($data['RaceCard']['name'] == $tmpArray[$data['RaceCard']['uma']]['name']){
                $data['RaceCard']['odds'] = $tmpArray[$data['RaceCard']['uma']]['odds'];
                $data['RaceCard']['ninki'] = $tmpArray[$data['RaceCard']['uma']]['ninki'];
            }else{
                $this->__log("ng:".$data["RaceCard"]["name"]);
            }
        }
        if(!$this->RaceCard->saveAll($cardData)){
            $this->__log("save fail.".$raceData["Race"]["name"]);
        }

        $this->__log("オッズを登録しました。race_id = ".$race_id.', '.$raceData['Race']['name']);

    }

}
