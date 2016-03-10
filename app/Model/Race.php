<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Race extends AppModel {

	public $hasMany = array(
        'RaceCard' => array(
            'className' => 'RaceCard',
            'conditions' => array('RaceCard.is_deleted' => 0),
            'order' => 'RaceCard.uma asc'            
        )
    );

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'レース名を入力してください'
            ),
            'length' => array(
                'rule' => array( 'maxLength', 20),
                'message' => 'レース名は20文字まで',
            ),
        ),
        'full_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'レース正式名称を入力してください'
            ),
            'length' => array(
                'rule' => array( 'maxLength', 50),
                'message' => 'レース正式名称は50文字までです',
            ),
        ),
        'grade' => array(
            'numeric' => array(
                'rule' => array( 'numeric'),
                'message' => 'グレードは数字を入力してください',
            ),
        ),
        'distance' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '距離を入力してください'
            ),
            'numeric' => array(
                'rule' => array( 'numeric'),
                'message' => '距離は数字を入力してください',
            ),
        ),
        'type' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '芝・ダートを入力してください'
            ),
            'numeric' => array(
                'rule' => array( 'numeric'),
                'message' => '芝・ダートは数字を入力してください',
            ),
        ),
        'turn' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '右または左を入力してください'
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '右または左は数字を入力してください',
            ),
        ),
        'note' => array(
            'length' => array(
                'rule' => array( 'maxLength', 100),
                'message' => '備考欄は100文字まで',
            ),
        ),
        'race_date' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'レース名を入力してください'
            ),
            'datetime' => array(
                'rule' => array("datetime"),
                'message' => '有効な日時を入力してください。',
            ),
        ),
        'view_flg' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '表示フラグを入力してください'
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '表示フラグは数字を入力してください',
            ),
        ),
        'accepting_flg' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '受付フラグを入力してください'
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '受付フラグは数字を入力してください',
            ),
        ),
        'kojiharu_flg' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'こじはるフラグを入力してください'
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'こじはるフラグは数字を入力してください',
            ),
        ),

        'html_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'html_idを入力してください'
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'html_idは数字を入力してください',
            ),
        ),

    );	


    public function afterFind($results,$primary = false){
    	if(!empty($results)&&count($results)==1){
    		$wkArray = array();
    		foreach($results[0]["RaceCard"] as $key=>&$data){
    			if(!empty($wkArray[$data["wk"]])){
	    			$wkArray[$data["wk"]]++;
	    			$data["wk_flg"] = false;
    			}else{
	    			$wkArray[$data["wk"]]=1;
	    			$data["wk_flg"] = true;
    			}
    		}
    		$results[0]["wkData"] = $wkArray;
    	}
    	return $results;
    }

	//受付中のレースを取得
    public function getAcceptingRace(){
		$options = array(
			'conditions' => array(
				'Race.is_deleted' => 0,
				'Race.view_flg' => 1,
				//'Race.accepting_flg' => 1,
                'Race.race_date >=' => date("Y-m-d H:i:s")
			),
			'order' => array("Race.race_date asc")
		);

		return $this->find("all",$options);
    }

    //直近のレースを取得
    public function getRecentRace($accepting_flg = 0,$limit = 5){
		$options = array(
			'conditions' => array(
				'Race.is_deleted' => 0,
				'Race.view_flg' => 1,
				'Race.accepting_flg' => $accepting_flg,
                'Race.race_date <=' => date("Y-m-d H:i:s")
			),
			'order' => array("Race.race_date desc"),
			'limit' => $limit
		);
		return $this->find("all",$options);
    }

    //対象の年のレース結果を取得
    public function getRaceListYear($year,$kojiharu_flg=0){
    	$start = $year."-01-01 00:00:00";
		$end   = $year."-12-31 00:00:00";

		$options = array(
			"conditions" => array(
				"race_date between ? and ?" => array($start,$end),
				"is_deleted" => 0,
				"view_flg" => 1,
			),
			"order" => "id desc"
		);

		if($kojiharu_flg==1){
			$options["conditions"]["kojiharu_flg"] = 1;
		}

		$raceData = $this->find("all",$options);
		return $raceData;
    }

}
