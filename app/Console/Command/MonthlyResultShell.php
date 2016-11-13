<?php

//月間ランキング
class MonthlyResultShell extends AppShell {

    public $uses = array('Race', 'RaceCard', 'RaceResult', 'Expectation', 'User');

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addOption(
            'month', array(
                'help' => 'month [yyyy-mm]',
                'default' => date('Y-m'),
            )
        );

        return $parser;
    }

    public function main() {
    	$msg = "start shell";
    	$this->__log($msg);

        //race_idを取得
        if(empty($this->params["month"])){
            $this->__log("引数にmonthを指定してください",true);
        }else{
            $target_month = $this->params["month"];
        }
        $this->__log('target:'.$target_month);

        $start = date('Y-m-d', strtotime('first day of ' . $target_month))." 00:00:00";
        $end   = date('Y-m-d', strtotime('last day of ' . $target_month))." 23:59:59";

        //対象月のレースを取得
        $options = array(
            'fields' => array('id'),
            'conditions' => array(
                'race_date between ? and ?' => array($start,$end),
                'is_deleted' => 0,
            ),
            'order' => 'id asc',
            'recursive' => -1,
        );
        $race_list = $this->Race->find('list',$options);

        if(empty($race_list)){
            $this->__log('レースが存在しません',true);
        }

        //最低このレース数の予想が必要（半分）
        $target_race_count = floor(count($race_list)/2);
        $target_race_count = 6;
        //$target_race_count = 2;

        //レース結果を取得
        $options = array(
            'fields' => array('id','sanrentan_price'),
            'conditions' => array(
                'race_id' => $race_list,
            ),
            'recursive' => -1
          );
        $race_result = $this->RaceResult->find('list',$options);

        if(empty($race_result)){
            $this->__log('レース結果が存在しません',true);
        }

        foreach($race_result as $key=>$data){            
            $race = $this->Race->findById($key);
            echo $race['Race']['name'].'(G'.$race['Race']['grade'].') ：　'.$data.'円'.PHP_EOL;
        }



        //予想データを取得
        $options = array(
            'conditions' => array(
                'race_id' => $race_list,
                'result' => array(1,2),
                'cancel_flg' => 0,
            ),
            'order' => 'race_id asc,id asc',
            'recursive' => -1
          );
        $ex_result = $this->Expectation->find('all',$options);

        foreach($ex_result as $key => $data){


            if($data['Expectation']['result']==1){
                //的中
                $price = $race_result[$data['Expectation']['race_id']] - 6000;
                $win = 1;
                $lose = 0;
            }else{
                $price = -6000;
                $win = 0;
                $lose = 1;
            }

            if(empty($result_data[$data['Expectation']['user_id']]['price'])){
                $result_data[$data['Expectation']['user_id']]['user_id'] = $data['Expectation']['user_id'];
                $result_data[$data['Expectation']['user_id']]['price'] = $price;
                $result_data[$data['Expectation']['user_id']]['win'] = $win;
                $result_data[$data['Expectation']['user_id']]['lose'] = $lose;
                $result_data[$data['Expectation']['user_id']]['count'] = 1;

            }else{
                $result_data[$data['Expectation']['user_id']]['price'] += $price;                   
                $result_data[$data['Expectation']['user_id']]['win'] += $win;
                $result_data[$data['Expectation']['user_id']]['lose'] += $lose;
                $result_data[$data['Expectation']['user_id']]['count'] += 1;
            }

        }

        $sort = array();
        foreach($result_data as $key => $data){
            $sort[$key] = $data['price'];
        }
        array_multisort($sort, SORT_DESC, $result_data);

        $user_array = array();
        foreach($result_data as $key => $data){
            if(count($user_array)>=5){
                break;
            }

            if($data['count'] < $target_race_count){
                continue;
            }

            //ユーザーの取得
            $user = $this->User->findById($data['user_id']);
            $tmp_data = array(
                'user_id' => $user['User']['id'],
                'nickname' => $user['User']['nickname'],
                'img' => $user['User']['profile_img'],
                'count' => $data['count'],
                'price' => $data['price'],
                'win' => $data['win'],
                'lose' => $data['lose'],
            );

            $user_array[] = $tmp_data;
        }

        print_R($user_array);

    	$this->__log("finish ok!");

    }

}