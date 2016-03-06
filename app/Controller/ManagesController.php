<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AdminController', 'Controller');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ManagesController extends AdminController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'AdminUser',
		'Expectation',
		'ExpectationResult',
		'RaceCard',
		'Race',
		'RaceResult',
		'RaceResultDetail',
		'RecentRaceResult',
		'User',
		'FavoUser'
	);


	public $kojiharu_id = 3;

    public function beforeFilter() {
		AuthComponent::$sessionKey = 'Auth.admins';
        parent::beforeFilter();

    }

	//管理画面トップ
	public function admin_index(){
	}


	//管理画面ログイン
	public function admin_login(){

	    if ($this->request->is('post')) {

	        if ($this->Auth->login()) {
	            $this->redirect($this->Auth->redirectUrl());
	        } else {
                $this->set("errorMsg","※ログインIDまたはパスワードが異なります");
	        }
	    }
	}

	///管理画面ログアウト
	public function admin_logout(){
		$this->redirect($this->Auth->logout());
	}

}