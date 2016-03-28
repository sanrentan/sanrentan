<?php

App::import('Vendor', 'simple_html_dom');

//オッズを取得する
class RaceOddsShell extends AppShell {

    public $uses = array('Race','RaceCard');

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addOption(
            'race_id', array(
                'help' => 'race_id',
                'default' => null,
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


        //対象のレースが存在するか？
        $raceData = $this->Race->findById($raceId);
        if(empty($raceData)){
            $this->__log("レースが見つかりません。race_id = ".$raceId,true);
        }else{
            $this->__log('レース名：'.$raceData['Race']['name']);
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
            $this->__log("まだ出走表が登録されていません。race_id = ".$raceId,true);
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
        foreach($horseList as $key=>&$data){
            $data['ninki'] = $key+1;
            $tmpArray[$data['uma']] = $data;
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

    	$this->__log("finish ok!.".$raceData["Race"]["name"]);

    }

}