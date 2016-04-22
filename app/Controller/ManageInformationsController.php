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
class ManageInformationsController extends AdminController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'Information'
	);


    public function beforeFilter() {
		AuthComponent::$sessionKey = 'Auth.admins';
        parent::beforeFilter();

        $view_flg = array(
        	'0' => '非表示',
        	'1' => '表示',
        );
        $this->set('view_flg',$view_flg);
    }

	//お知らせ一覧
	public function admin_index(){

		$conditions = array(
			"is_deleted" => 0
		);

		$this->Paginator->settings = array(
			"conditions" => $conditions,
			"order" => "id desc",
			"limit" => 20
		);
		$infoList = $this->Paginator->paginate('Information');
		$this->set('infoList', $infoList);
	}


	//広告登録
 	public function admin_add(){

	    if ($this->request->is('post')) {
	    	$this->Information->create();
	    	if($this->Information->save($this->request->data)){
                $this->Flash->success(__('登録しました'));
	    		$this->redirect("./index");
	    	}else{
                $this->Flash->error(__('登録に失敗しました'));
	    		$this->redirect("./index");
	    	}
	    }
 	}

	//お知らせ編集
	public function admin_edit($id){

		$infoData = $this->Information->findById($id);
		$this->set("infoData",$infoData);
		if(!empty($Information)){
            $this->Flash->error(__('お知らせが存在しません'));
	    	$this->redirect("./index");
		}

        if ($this->request->is('post')||$this->request->is('put')) {

        	$this->request->data["Information"]["id"] = $id;
            if ($this->Information->save($this->request->data)) {
                $this->Flash->success(__('更新しました。id='.$id));
                return $this->redirect("./index");
            }
            $this->Flash->error(
                __('登録に失敗しました')
            );

        }else{
	        $this->request->data = $infoData;
        }
	}

	//お知らせ削除
	public function admin_delete($id){
        $this->Information->id = $id;
        if (!$this->Information->exists()) {
	    	$this->Session->setFlash("お知らせが存在しません");
            return $this->redirect("./index");
        }

		$this->Information->saveField('is_deleted', 1);  
		$this->Information->saveField('deleted', date("Y-m-d H:i:s"));  
        $this->Flash->success(__('削除しました。id='.$id));
        return $this->redirect("./index");
	}
}