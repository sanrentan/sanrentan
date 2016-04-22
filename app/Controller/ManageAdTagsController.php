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
class ManageAdTagsController extends AdminController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'AdTag'
	);


	public $banner_size = array(
		1 => "728*90(横長）",
		2 => "300*250(正方形など）",
		3 => "350*80(ミニバナー)",
		4 => "120*600(縦長)",
		5 => "amazon",
	);

    public function beforeFilter() {
		AuthComponent::$sessionKey = 'Auth.admins';
        parent::beforeFilter();

        $this->set("banner_size",$this->banner_size);
    }

	//広告一覧一覧
	public function admin_index(){

		$conditions = array(
			"is_deleted" => 0
		);
		$type = 9999;
		if(!empty($this->request->data['type'])){
			if($this->request->data['type']!=9999){
				$conditions['type'] = $this->request->data['type'];
				$type = $this->request->data['type'];
				$_SESSION['adTagType'] = $type;
				$this->request->params['named']['page'] = 1;
			}else{
				unset($_SESSION['adTagType']);
				$this->request->params['named']['page'] = 1;
			}
		}elseif(!empty($_SESSION['adTagType'])){
			$type = $_SESSION['adTagType'];
			$conditions['type'] = $type;
		}

		$this->set('type',$type);

		$this->Paginator->settings = array(
			"conditions" => $conditions,
			"order" => "id desc",
			"limit" => 20
		);
		$adTagList = $this->Paginator->paginate('AdTag');
		$this->set('adTagList', $adTagList);
	}


	//広告登録
 	public function admin_add(){

	    if ($this->request->is('post')) {
	    	$this->AdTag->create();
	    	if($this->AdTag->save($this->request->data)){
                $this->Flash->success(__('登録しました'));
	    		$this->redirect("./index");
	    	}else{
                $this->Flash->error(__('登録に失敗しました'));
	    		$this->redirect("./index");
	    	}
	    }
 	}

	//広告編集
	public function admin_edit($id){

		$adData = $this->AdTag->findById($id);
		$this->set("adData",$adData);
		if(!empty($AdTag)){
            $this->Flash->error(__('広告が存在しません'));
	    	$this->redirect("./index");
		}

        if ($this->request->is('post')||$this->request->is('put')) {

        	$this->request->data["AdTag"]["id"] = $id;
            if ($this->AdTag->save($this->request->data)) {
                $this->Flash->success(__('更新しました。id='.$id));
                return $this->redirect("./index");
            }
            $this->Flash->error(
                __('登録に失敗しました')
            );

        }else{
	        $this->request->data = $adData;
        }
	}

	//広告削除
	public function admin_delete($id){
        $this->AdTag->id = $id;
        if (!$this->AdTag->exists()) {
	    	$this->Session->setFlash("広告が存在しません");
            return $this->redirect("./index");
        }

		$this->AdTag->saveField('is_deleted', 1);  
		$this->AdTag->saveField('deleted', date("Y-m-d H:i:s"));  
        $this->Flash->success(__('削除しました'));
        return $this->redirect("./index");
	}
}