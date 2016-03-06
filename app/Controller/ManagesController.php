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


	///管理者管理(一覧表示)
	public function admin_user(){
		$options = array(
			"conditions" => array(
				"is_deleted" => 0
			),
			"order" => "id asc"
		);
		$adminUser = $this->AdminUser->find("all",$options);
		$this->set("adminUser",$adminUser);
	}

	//管理者ユーザーの新規登録
	public function admin_user_add(){
		$select1 = array(
			"0" => "一般管理者",
			"1" => "システム管理者",
		);
		$this->set("select1",$select1);

	    if ($this->request->is('post')) {
	    	$this->AdminUser->create();
	    	if($this->AdminUser->save($this->request->data)){
                $this->Flash->success(__('登録しました'));
	    		$this->redirect("./user");
	    	}
	    }
	}
	public function admin_user_edit($id){
		if(empty($id)||!is_numeric($id)){
	    	$this->Session->setFlash("idが不正です");
	    	$this->redirect("./user");
	    }

        $this->AdminUser->id = $id;
        if (!$this->AdminUser->exists()) {
	    	$this->Session->setFlash("ユーザーが存在しません");
	    	$this->redirect("./user");
        }

        if ($this->request->is('post')||$this->request->is('put')) {

        	if(empty($this->request->data["AdminUser"]["password"])){
        		unset($this->AdminUser->validate["password"]);
        	}

            if ($this->AdminUser->save($this->request->data)) {
                $this->Flash->success(__('更新しました。id='.$id));
                return $this->redirect(array('action' => 'user'));
            }
            $this->Flash->error(
                __('登録に失敗しました')
            );
        } else {
            $this->request->data = $this->AdminUser->findById($id);
            unset($this->request->data['AdminUser']['password']);
        }

		$select1 = array(
			"0" => "一般管理者",
			"1" => "システム管理者",
		);
		$this->set("select1",$select1);
	}

	public function admin_user_delete($id){

        $this->AdminUser->id = $id;
        if (!$this->AdminUser->exists()) {
	    	$this->Session->setFlash("ユーザーが存在しません");
	    	$this->redirect("./AdminUser");
        }

		$this->AdminUser->saveField('is_deleted', 1);  
		$this->AdminUser->saveField('deleted_date', date("Y-m-d H:i:s"));  
        $this->Flash->success(__('削除しました'));
        return $this->redirect(array('action' => 'user'));
	}

}