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
				'Race.accepting_flg' => 1
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
				'Race.accepting_flg' => $accepting_flg
			),
			'order' => array("Race.race_date desc"),
			'limit' => $limit
		);
		return $this->find("all",$options);

    }

}
