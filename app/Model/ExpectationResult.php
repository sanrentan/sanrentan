<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class ExpectationResult extends AppModel {

	public $kojiharu_id = 3;


	public function getResultData($user_id,$year){
		$options = array(
			"conditions" => array(
				"user_id" => $user_id,
				"year" => $year
			)
		);
		return $this->find("first",$options);
	}
}
