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

App::uses('AppController', 'Controller');

App::import('Vendor', 'simple_html_dom');



/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class HomesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'Expectation',
		'RaceCard',
		'Race'
	);

	//レースを表示
	public function index(){
		$this->set("message","こんにちわ。レース一覧を表示します。");

		//受付中のレース
		$acceptingRace = $this->Race->getAcceptingRace();

		//過去５レース
		$recentRace = $this->Race->getRecentRace();

		//最新のこじはる予想
		$recentKojiharu = $this->Expectation->getRecentKojiharu();

		$this->set(compact("acceptingRace", "recentRace","recentKojiharu"));

	}


	//レース詳細
	public function detail($raceId){
		$this->set("message","出走表");

		$raceData = $this->Race->findById($raceId);

		if(empty($raceData)){
			echo "race not found ! race_id = ".$raceId;exit;
		}
		$this->set("raceData",$raceData);

		//予想
		if($this->request->is('post')){
			if(!empty($this->request->data['Expectation']['item'])&&count($this->request->data['Expectation']['item'])==Configure::read('Base.box_count')){
				//ここでセッションにpost値を入れる
	            $this->Session->write('expectation', $this->request->data);
				$this->redirect('/confirm');
			}else{
				$this->Session->setFlash(__('※'.Configure::read('Base.box_count').'つ選択してください。'));
			}
		}

		//すでに予想しているか	
		$myData = array();
		if(!empty($this->user["id"])){
			$myData = $this->Expectation->getExpectationData($raceId,$this->user["id"]);
		}

		//こじはるの予想
		$kojiharuData = $this->Expectation->getExpectationData($raceId);

		$this->set(compact("myData","kojiharuData"));


	}

	//確認画面
	public function confirm(){
		$this->set("message","確認画面");
		$postData = $this->Session->read("expectation");
		$raceData = $this->Race->findById($postData["Expectation"]["race_id"]);

		//こじはるの情報を取得
		$kojiharuData = $this->Expectation->getExpectationData($postData["Expectation"]["race_id"]);

		//自分用
		$selectArray = array();
		foreach($raceData["RaceCard"] as $key=>$data){
			if(in_array($data["id"],$postData["Expectation"]["item"])){
				$selectArray[] = $data;
			}
		}

		$this->set(compact("postData", "raceData","selectArray","kojiharuData"));
	}

	//登録機能
	public function complete(){

		if(!empty($this->user["id"])&&count($this->request->data['Expectation']['item'])==Configure::read('Base.box_count')){
			//既に予想していないか？
			$exceptionData = $this->Expectation->getExpectationData($this->request->data['Expectation']['race_id'],$this->user["id"]);
			if(empty($exceptionData)){
				$expectationData = array(
					'race_id' => $this->request->data['Expectation']['race_id'],
					'user_id' => $this->user["id"],
				);
				for($i=0;$i<Configure::read('Base.box_count');$i++){
					$expectationData['item'.($i+1)] = $this->request->data['Expectation']['item'][$i];
				}
				$this->Expectation->create();
				$this->Expectation->save($expectationData);
			    $this->Session->write('expectation', "");

			    //
				$raceData = $this->Race->findById($this->request->data['Expectation']['race_id']);
				$this->set("raceData",$raceData);
			}else{
				$this->Session->setFlash(__('※不正な遷移です。'));
				$this->redirect('/');
			}

		}else{
			$this->Session->setFlash(__('※不正な遷移です。'));
			$this->redirect('/');
		}
	}

	//マイページ
	public function mypage(){
		//自分の予想一覧を取得

	}

	//後ほどシェルにする
	//URLからデータを取得する場合
	//参考URL http://www.junk-port.com/php/php-simple-html-dom-parser/
	public function index2($raceId=null){

		if(empty($raceId)||!is_numeric($raceId)){
			$raceId = 1;
		}

		//対象のレースが存在するか？
		$raceData = $this->Race->findById($raceId);
		if(empty($raceData)){
			echo "race not found ! race_id = ".$raceId;exit;
		}

		//すでに出走表にデータが登録されていないか？
		$options = array(
			'conditions' => array(
				'is_deleted' => 0,
				'race_id' => $raceData["Race"]["id"]
			)
		);
		$cardData = $this->RaceCard->find("all",$options);
		if(!empty($cardData)){
			echo "raceCard already exists! race_id = ".$raceId;exit;
		}

		//htmlを取得
		$html = file_get_html('http://keiba.yahoo.co.jp/race/denma/'.$raceData["Race"]["html_id"].'/');
		
		//trのループ
		$i=0;
		$horseList = array();
		foreach($html->find('.denmaLs tr') as $key=>$element){
			//ヘッダー行は飛ばす
			if($i>0){
				//tdのループ
				$tdCounter = 0;
				foreach($element->find('td') as $key2=>$data){
					switch ($tdCounter) {
						
						case 0://枠
							$horseList[$i]["wk"] = $data->plaintext;
							break;
						case 1://馬番
							$horseList[$i]["uma"] = $data->plaintext;
							break;
						case 2://馬名,性齢
							$horseList[$i]["name"] = $data->find("strong")[0]->plaintext;
							$tmp = $data->find("span")[0]->plaintext;
							$horseList[$i]["sexage"] = explode('/',$tmp)[0]; 
							break;
						case 3://馬体重、増減
							$horseList[$i]["weight"] = substr($data->plaintext, 1,3); 
							$horseList[$i]["plus"] = substr($data->plaintext, 4); 
							break;
						case 4://騎手名、斤量
							$horseList[$i]["j_name"]   = $data->find("a")[0]->plaintext;
							$horseList[$i]["j_weight"]   = substr($data->plaintext, -5); 
							break;
						case 5://父馬、母馬、母父馬
							//$tmp = explode(" ",$data->plaintext);
							//$horseList[$i]["father"]   = ""; 
							//$horseList[$i]["mother"]   = "";
							//$horseList[$i]["m_father"] = "";

					} 
					$tdCounter++;
				}
			}
			$i++;
		}

		//DBに登録
		foreach($horseList as $key=>&$horse){
			$horse["race_id"] = $raceId;
			$this->RaceCard->create();
			$this->RaceCard->save($horse);
		}
		$this->set("horseList",$horseList);
		$this->response->charset('Shift_JIS');
	}


}