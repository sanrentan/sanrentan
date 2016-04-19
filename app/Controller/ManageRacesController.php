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
class ManageRacesController extends AdminController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'RaceCard',
		'Race',
		'RaceResult',
		'RaceResultDetail',
		'RecentRaceResult',
	);

	public $components = array(
		'Paginator','Auth'
	);


	public $kojiharu_id = 3;

    public function beforeFilter() {
		AuthComponent::$sessionKey = 'Auth.admins';
        parent::beforeFilter();

    }

	//レース一覧
	public function admin_index(){
		//TODO 年月による検索をつけたい

		$this->Paginator->settings = array(
			"conditions" => array(
				"is_deleted" => 0
			),
			"order" => "id desc",
			"recursive" => "-1",
			"limit" => 20
		);
		$raceList = $this->Paginator->paginate('Race');
		$this->set('raceList', $raceList);


	}

	//レース詳細
	public function admin_race_view($id){
		if(empty($id)){
			$this->Flash->error(__('idを指定してください'));
		} 

		//レース

		//出走表

		//過去5レース

		//配当金

		//レース結果

	}

	//レース登録
 	public function admin_race_add(){
		$this->__raceSetting();


	    if ($this->request->is('post')) {
        	$this->request->data["Race"]["place"] = $this->request->data["Race"]["placeArray"].$this->request->data["Race"]["raceArray"]."R";
	    	$this->Race->create();
	    	if($this->Race->save($this->request->data)){
                $this->Flash->success(__('登録しました'));
	    		$this->redirect("./index");
	    	}
	    }

 	}

	//レース編集
	public function admin_race_edit($id){
		//とりあえずRaceテーブルのみでOK
		$raceData = $this->Race->findById($id);
		$this->set("raceData",$raceData);

		$this->__raceSetting();

        if ($this->request->is('post')||$this->request->is('put')) {

        	$this->request->data["Race"]["id"] = $id;
        	$this->request->data["Race"]["place"] = $this->request->data["Race"]["placeArray"].$this->request->data["Race"]["raceArray"]."R";

            if ($this->Race->save($this->request->data)) {
                $this->Flash->success(__('更新しました。id='.$id));
                return $this->redirect("./index");
            }
            $this->Flash->error(
                __('登録に失敗しました')
            );

        }else{
			$tmp = $raceData["Race"]["place"];
			$raceData["Race"]["placeArray"] = mb_substr($tmp,0,2);
			$raceData["Race"]["raceArray"] = substr(mb_substr($tmp,2), 0, -1);
	        $this->request->data = $raceData;
        }


	}

	//レース削除
	public function admin_race_delete($id){
        $this->Race->id = $id;
        if (!$this->Race->exists()) {
	    	$this->Session->setFlash("レースが存在しません");
            return $this->redirect("./index");
        }

		$this->Race->saveField('is_deleted', 1);  
		$this->Race->saveField('deleted_date', date("Y-m-d H:i:s"));  
        $this->Flash->success(__('削除しました'));
        return $this->redirect("./index");
	}


	private function __raceSetting(){
		$placeArray = array(
			"東京" => "東京",
			"中山" => "中山",
			"阪神" => "阪神",
			"京都" => "京都",
			"中京" => "中京",
			"札幌" => "札幌",
			"函館" => "函館",
			"福島" => "福島",
			"新潟" => "新潟",
			"小倉" => "小倉"
		);
		$this->set("placeArrays",$placeArray);

		for($i=1;$i<=13;$i++){
			$raceArray[$i] = $i."R";
		}
		$this->set("raceArrays",$raceArray);

		$typeArray = array("芝","ダート");
		$this->set("typeArrays",$typeArray);

		$turnArray = array("右回り","左回り");
		$this->set("turnArrays",$turnArray);

		$viewArray = array("非表示","表示");
		$this->set("viewArrays",$viewArray);

		$acceptArray = array("受付停止","受付中");
		$this->set("acceptArrays",$acceptArray);

		$kojiharuArray = array("対象外","対象レース");
		$this->set("kojiharuArrays",$kojiharuArray);

	}




}