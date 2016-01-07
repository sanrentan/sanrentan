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

}
