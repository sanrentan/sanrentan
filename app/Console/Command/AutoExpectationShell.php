<?php

App::import('Vendor', 'simple_html_dom');

//自動で予想するシェル
class AutoExpectationShell extends AppShell {

    public $uses = array('Race','RaceCard','Expectation');

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

    public $test_users = array(1,2,7,8,9,10,11,12,13,14,15,16,17);

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
                'race_id' => $raceData["Race"]["id"],
                'ninki >= ' => 1
             ),
            'order' => 'ninki asc'
        );
        $cardData = $this->RaceCard->find("all",$options);
        if(empty($cardData)){
            $this->__log("出走表またはオッズが登録されていません。race_id = ".$raceId,true);
        }

        $uma_count = count($cardData);

        $expectData = array();

        foreach($this->test_users as $user_id){
            //その人が既に予想していないか？
            $options = array(
                'conditions' => array(
                    'race_id' => $raceId,
                    'user_id' => $user_id,
                    'cancel_flg' => 0
                )
            );
            $count = $this->Expectation->find('count',$options);
            if($count>=1){
                $this->__log('既に予想登録済みです。user_id:'.$user_id);
                continue;
            }

            $expectations = array();

            //予想する
            for($i=0;$i<$uma_count;$i++){
                $card_id = $cardData[$i]['RaceCard']['id'];
                $odds = $cardData[$i]['RaceCard']['odds'];

                //2倍以下だったら
                if($odds<2){
                    $rand = rand(0,100);
                    $ok = 90;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                //4倍以下だったら
                }elseif($odds<4){
                    $rand = rand(0,100);
                    $ok = 75;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                //6倍以下だったら
                }elseif($odds<4){
                    $rand = rand(0,100);
                    $ok = 70;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                //10倍以下だったら
                }elseif($odds<10){
                    $rand = rand(0,100);
                    $ok = 60;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                //20倍以下だったら
                }elseif($odds<10){
                    $rand = rand(0,100);
                    $ok = 50;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                //30倍以下だったら
                }elseif($odds<30){
                    $rand = rand(0,100);
                    $ok = 40;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                //50倍以下だったら
                }elseif($odds<50){
                    $rand = rand(0,100);
                    $ok = 30;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }

                }else{
                    $rand = rand(0,100);
                    $ok = 10;
                    if($rand<=$ok){
                        if(!in_array($card_id, $expectations)){
                            $expectations[] = $card_id;
                        }
                    }
                }
                if(count($expectations)==5){
                    sort($expectations);
                    break;
                }

                //予想が終わらなかったらやり直し
                if(($i+1)==$uma_count&&count($expectations)<5){
                    $i=-1;
                }

            }

            //登録
            $tmpData = array();
            $tmpData['Expectation']['race_id'] = $raceId;
            $tmpData['Expectation']['user_id'] = $user_id;
            $tmpData['Expectation']['item1'] = $expectations[0];
            $tmpData['Expectation']['item2'] = $expectations[1];
            $tmpData['Expectation']['item3'] = $expectations[2];
            $tmpData['Expectation']['item4'] = $expectations[3];
            $tmpData['Expectation']['item5'] = $expectations[4];
            $expectData[] = $tmpData;
        }

        $this->Expectation->saveAll($expectData);
    	$this->__log("finish ok!.".$raceData["Race"]["name"]);

    }

}