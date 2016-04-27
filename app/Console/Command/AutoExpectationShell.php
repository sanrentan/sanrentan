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

    //public $test_users = array(1,2,7);
    //テストユーザー (coreで管理)
    //Configure::write('test_users',array(1,2,7));

    public function main() {
    	$msg = "start shell";
    	$this->__log($msg);

        //race_idを取得
        $race_ids = array();
        if(empty($this->params['race_id'])){
            //２日以内のレースを取得
            $end_date = date('Y-m-d H:i:s', strtotime("+3 days"));

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
            //対象のレースが存在するか？
            $raceData = $this->Race->findById($race_id);
            if(empty($raceData)){
                $this->__log("レースが見つかりません。race_id = ".$race_id,true);
            }else{
                $this->__log("レースの予想を行います。race_id = ".$race_id.', '.$raceData['Race']['name']);
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
                $this->__log("出走表またはオッズが登録されていません。race_id = ".$race_id);
                continue;
            }

            $uma_count = count($cardData);

            $expectData = array();

            $test_users = Configure::read('test_users');
            shuffle($test_users);

            foreach($test_users as $user_id){

                //その人が既に予想していないか？
                $options = array(
                    'conditions' => array(
                        'race_id' => $race_id,
                        'user_id' => $user_id,
                        'cancel_flg' => 0
                    )
                );
                $count = $this->Expectation->find('count',$options);
                if($count>=1){
                    $this->__log('既に予想登録済みです。user_id:'.$user_id);
                    continue;
                }


                //予想するかランダムに判定
                
                $startSec = strtotime(date('Y-m-d H:i:s'));
                $endSec   = strtotime($raceData['Race']['race_date']);
                $seconddiff = abs($endSec - $startSec);
                $diff = $seconddiff / (60 * 60 );
                $diff = (int)$diff;
                if($diff>=24){
                    $target = 1;
                }elseif($diff>=18){
                    $target = 2;
                }elseif($diff>=12){
                    $target = 3;
                }elseif($diff>=8){
                    $target = 4;
                }elseif($diff>=6){
                    $target = 5;
                }elseif($diff>=4){
                    $target = 6;
                }elseif($diff>=3){
                    $target = 8;
                }elseif($diff>=2){
                    $target = 9;
                }else{
                    $target = 100;
                }
                $rand = rand(1,10);


                if($target<$rand){
                    //今回は予想しない
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
                $tmpData['Expectation']['race_id'] = $race_id;
                $tmpData['Expectation']['user_id'] = $user_id;
                $tmpData['Expectation']['item1'] = $expectations[0];
                $tmpData['Expectation']['item2'] = $expectations[1];
                $tmpData['Expectation']['item3'] = $expectations[2];
                $tmpData['Expectation']['item4'] = $expectations[3];
                $tmpData['Expectation']['item5'] = $expectations[4];
                $this->Expectation->create();
                $this->Expectation->save($tmpData);
            }
    
            $this->__log($raceData["Race"]["name"].'の予想登録が完了しました');

        }

    	$this->__log("finish ok!");

    }

}