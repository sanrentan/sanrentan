<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class RaceResult extends AppModel {

	public $hasMany = array(
        'RaceResultDetail' => array(
            'className' => 'RaceResultDetail',
            //'conditions' => array('RaceCard.is_deleted' => 0),
            'order' => 'RaceResultDetail.result asc',
            'foreignKey' => 'race_id'
        )
    );

}
