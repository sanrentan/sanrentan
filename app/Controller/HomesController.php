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
		'ExpectationResult',
		'RaceCard',
		'Race',
		'RaceResult',
		'RaceResultDetail',
		'RecentRaceResult'
	);

	public $kojiharu_id = 3;

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

		//RSS
		$tmpRss = simplexml_load_file('http://keiba.jp/rss/news.xml');
		$newsRss = array();
		$counter = 0;
		foreach($tmpRss->channel->item as $item){
			if($counter<5){
				$newsRss[] = $item;
				$counter++;
			}else{
				break;
			}
		}
		$tmpRss = simplexml_load_file('http://keiba.jp/rss/prediction.xml');
		$expectRss = array();
		$counter = 0;
		foreach($tmpRss->channel->item as $item){
			if($counter<5){
				$expectRss[] = $item;
				$counter++;
			}else{
				break;
			}
		}
		$tmpRss = simplexml_load_file('http://godskeiba.ldblog.jp/index.rdf');
		$matomeRss = array();
		$counter = 0;
		foreach($tmpRss->item as $item){
			if($counter<10){
				$matomeRss[] = $item;
				$counter++;
			}else{
				break;
			}
		}
		$this->set(compact("newsRss", "expectRss","matomeRss"));

	}


	//レース詳細
	public function detail($raceId){
		$this->set("message","出走表");
		$RecentRaceResult = array();

		$raceData = $this->Race->findById($raceId);

		$raceCardData = $raceData['RaceCard'];
		$raceCardId = array();
		foreach($raceCardData as $data ){
			array_push($raceCardId, $data['id']);
		}
		$RecentRaceResult = $this->RecentRaceResult->find('all',
			[
			'conditions' => ['race_card_id' => $raceCardId]
			]
			);
		//viewに渡すようの配列を生成
		$eachRaceCardIdResult = array();
		foreach($RecentRaceResult as $eachRace){
			if(!isset($eachRaceCardIdResult[$eachRace['RecentRaceResult']['race_card_id']])){
				//レースカードIDをキーに配列を持っていなければ配列を渡す
				$eachRaceCardIdResult[$eachRace['RecentRaceResult']['race_card_id']] = array();
				
			}
			//レースカードIDをキーに最近のレース結果をプッシュしていく
			array_push($eachRaceCardIdResult[$eachRace['RecentRaceResult']['race_card_id']], $eachRace['RecentRaceResult']);
		}
		$this->set('recentRaceResult', $eachRaceCardIdResult);
		

		if(empty($raceData)){
			echo "race not found ! race_id = ".$raceId;exit;
		}
		$this->set("raceData",$raceData);
		//直近レースの結果
		//$recentRaceResult= $this->Racee->

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

	//結果ページ
	public function result($raceId){
		$this->set("message","結果ページ");

		$raceData = $this->Race->findById($raceId);

		if(empty($raceData)){
			echo "race not found ! race_id = ".$raceId;exit;
		}

		//レース結果を取得
		$raceResultData = $this->RaceResult->findById($raceId);

		//レース結果がない場合はdetailへリダイレクト
		if(empty($raceResultData)){
			$this->redirect("/detail/".$raceId);
		}

		//自分の予想を取得	
		$myData = array();
		if(!empty($this->user["id"])){
			$myData = $this->Expectation->getExpectationData($raceId,$this->user["id"]);
		}

		//こじはるの予想
		$kojiharuData = $this->Expectation->getExpectationData($raceId);

		$this->set(compact("raceData","raceResultData","myData","kojiharuData"));
	}


	//マイページ
	public function mypage(){
		$this->set("naviType","mypage");
		
		if(empty($this->user["id"])){
			//ログインページへリダイレクト
			$this->redirect('/login');
		}else{
			$user = $this->user;
		}

		$year = date("Y");//TODO 引数で受け取りたい


		//対象の年のレースを取得
		$raceData = $this->Race->getRaceListYear($year);

		$raceIdArr = array();
		foreach($raceData as $key=>$data){
			$raceIdArr[] = $data["Race"]["id"];
		}

		//レース結果を取得
		$options = array("conditions"=>array("race_id"=>$raceIdArr));
		$tmpData = $this->RaceResult->find("all",$options);
		$raceResultData = array();
		foreach($tmpData as $key=>$data){
			$raceResultData[$data["RaceResult"]["race_id"]] = $data;
		}

		//自分の予想一覧を取得
		$myData = $this->Expectation->getExpectaionList($user["id"],$raceIdArr);
		//自分の結果を取得
		$myResultData = $this->ExpectationResult->getResultData($user["id"],$year);

		//こじはるの予想一覧を取得
		$kojiharuData = $this->Expectation->getExpectaionList($this->kojiharu_id,$raceIdArr);
		//こじはるの結果を取得
		$kojiharuResultData = $this->ExpectationResult->getResultData($this->kojiharu_id,$year);

		$this->set(compact("raceData", "raceResultData","myData","myResultData","kojiharuData","kojiharuResultData"));

	}


	//こじはるの予想一覧
	public function kojiharu_list(){
		$this->set("naviType","kojiharu");
		
		$year = date("Y");//TODO 引数で受け取りたい

		//対象の年のレースを取得
		$raceData = $this->Race->getRaceListYear($year,1);

		$raceIdArr = array();
		foreach($raceData as $key=>$data){
			$raceIdArr[] = $data["Race"]["id"];
		}

		//レース結果を取得
		$options = array("conditions"=>array("race_id"=>$raceIdArr));
		$tmpData = $this->RaceResult->find("all",$options);
		$raceResultData = array();
		foreach($tmpData as $key=>$data){
			$raceResultData[$data["RaceResult"]["race_id"]] = $data;
		}


		//こじはるの予想一覧を取得
		$myData = $this->Expectation->getExpectaionList($this->kojiharu_id,$raceIdArr);
		//こじはるの結果を取得
		$myResultData = $this->ExpectationResult->getResultData($this->kojiharu_id,$year);

		$this->set(compact("raceData", "raceResultData","myData","myResultData"));

	}

	//当サイトについて
	public function about(){
		$this->set("naviType","about");
	}

	//お問い合わせ
	public function contact(){
		$this->set("naviType","contact");

		if($this->request->is('post')){
			
			if(empty($this->request->data["Home"]["name"])){
				$errMessage["name"] = "※名前を入力してください";
			}
			if(empty($this->request->data["Home"]["email"])){
				$errMessage["email"] = "※メールアドレスを入力してください";
			}
			if(empty($this->request->data["Home"]["message"])){
				$errMessage["message"] = "※お問い合わせ内容を入力してください";
			}
			if(empty($errMessage)){
				//セッションに保存
                $this->Session->write('contact', $this->request->data["Home"]);
                $this->redirect('/contact_confirm');
			}
			$this->set("errMessage",$errMessage);
		}
	}

	//お問い合わせ確認画面
	public function contact_confirm(){
    	$this->set("naviType","contact");

    	$data = $this->Session->read('contact');
    	$this->set("data",$data);

		if($this->request->is('post')){
	    	//メール送信

	    	//sessionから削除
	        $this->Session->write('contact', "");

	        //リダイレクト
	        $this->redirect("/contact_complete");
		}
	}

	//お問い合わせ完了ページ
	public function contact_complete(){
    	$this->set("naviType","contact");

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
			echo "raceCard already exists! race_id = ".$raceId;
			exit;
		}

		//htmlを取得
		$html = file_get_html('http://keiba.yahoo.co.jp/race/denma/'.$raceData["Race"]["html_id"].'/');
		
		//trのループ
		$i=0;
		$horseList = array();

		$recent_5race_results = array();

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

							//ここから直近レースの結果を取得する
							$horseUrl = $data->find("a")[0]->href;
							$horseHtml = file_get_html("http://keiba.yahoo.co.jp/".$horseUrl);
							$j = 0;
							foreach($horseHtml->find('#resultLs tr') as $key3 => $rowElements){
								if($j > 1 && $j < 7){
									echo $j;
									$tdCounter2 = 0;
									foreach($rowElements->find('td') as $key4 => $tdData){
										switch($tdCounter2){

											case 0 :
												$recent_5race_results[$i][$j]["race_date"] =  $tdData->plaintext;
												break;
											case 1:
												$recent_5race_results[$i][$j]["race_name"] =  $tdData->plaintext;
												break;
											case 2:
												$recent_5race_results[$i][$j]["place"] = $tdData->find("span")[0]->plaintext;
												break;
											case 3:
												$recent_5race_results[$i][$j]["cource"] =  $tdData->find("span")[0]->plaintext;
												break;
											case 4:
												$recent_5race_results[$i][$j]["baba"] =  $tdData->find("span")[0]->plaintext;
												break;
											case 5:
												$recent_5race_results[$i][$j]["number_of_heads"] = $tdData->plaintext;
												break;
											case 6:
												$recent_5race_results[$i][$j]["wk"] = $tdData->plaintext;
												break;
											case 7:
												$recent_5race_results[$i][$j]["uma"] = $tdData->plaintext;
												break;
											case 8:
												$recent_5race_results[$i][$j]["popularity"] = $tdData->plaintext;
												break;
											case 9:
												$recent_5race_results[$i][$j]["odds"] = $tdData->plaintext;
												break;
											case 10:
												$recent_5race_results[$i][$j]["order_of_arrival"] = $tdData->plaintext;	
												break;
											case 11:
												$recent_5race_results[$i][$j]["jockey"] = $tdData->find("a")[0]->plaintext;
												break;
										}
										$tdCounter2++;
									}
									
								}
								$j++;
							}


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
		$row = 1;
		foreach($horseList as $key=>&$horse){
			$horse["race_id"] = $raceId;
			$this->RaceCard->create();
			$this->RaceCard->save($horse);
			$last_id = $this->RaceCard->getLastInsertID();
			foreach($recent_5race_results[$row] as $eachResult){
				$eachResult["race_card_id"] = $last_id;
				//$eachResult["race_card_id"] = 1;
				$this->RecentRaceResult->create();
				$this->RecentRaceResult->save($eachResult);
			}
			$row++;
		}
		$this->set("horseList",$horseList);
		//$this->response->charset('Shift_JIS');
	}






	//後ほどシェルにする
	//レース結果（配当金）
	public function getResult($raceId=null){

		if(empty($raceId)||!is_numeric($raceId)){
			$raceId = 1;
		}

		//対象のレースが存在するか？
		$raceData = $this->Race->findById($raceId);
		if(empty($raceData)){
			echo "race not found ! race_id = ".$raceId;exit;
		}

		//すでに結果データが登録されていないか？
		$options = array(
			'conditions' => array(
				'race_id' => $raceData["Race"]["id"]
			)
		);
		$resultData = $this->RaceResult->find("all",$options);
		if(!empty($resultData)){
			echo "RaceResult already exists! race_id = ".$raceId;exit;
		}

		//htmlを取得
		$html = file_get_html('http://keiba.yahoo.co.jp/race/result/'.$raceData["Race"]["html_id"].'/');
		
		$nameArray = array("単勝","複勝","馬連","枠連","ワイド","馬単","3連複","3連単");
		$colsArray = array("tan","fuku","uma","wk","wide","umatan","sanrenpuku","sanrentan");

		//trのループ
		$resultData = array();
		foreach($html->find('.resultYen tr') as $key=>$element){
			//$targetCol = null;
			foreach($element->find('th') as $key2=>$data){
				if(in_array($data->plaintext, $nameArray)){
					$colKey = array_search($data->plaintext,$nameArray);
					$col = $colsArray[$colKey];
					$duplCounter = 1;
				}else{
					echo "ng!! data is ploblem";exit;
				}
			}

			if($colKey==1||$colKey==4){
				$col = $colsArray[$colKey].$duplCounter;
				$duplCounter++;
			}


			$tdCounter = 0;
			foreach($element->find('td') as $key2=>$data){
				switch ($tdCounter) {
					case 0://馬番
						$resultData[$col] = $data->plaintext;
						break;
					case 1://金額
						$price = mb_substr($data->plaintext, 0, -1);
						$price = str_replace(",", "", $price);
						$resultData[$col."_price"] = $price;
						break;
					case 2://人気
						$popularity = mb_substr($data->plaintext,0,mb_strlen($data->plaintext)-4);
						$resultData[$col."_popularity"] = $popularity;
						break;
				}
				$tdCounter++;
			}
		}
		$sanrentan = explode("－",$resultData["sanrentan"]);
		$resultData["horse1"] = $sanrentan[0];
		$resultData["horse2"] = $sanrentan[1];
		$resultData["horse3"] = $sanrentan[2];
		$resultData["race_id"] = $raceId;

		$this->RaceResult->create();
		$this->RaceResult->save($resultData);

		echo "RaceResult ok:".$raceId.",name=".$raceData["Race"]["name"];
		exit;
	}

	//後ほどシェルにする
	//結果詳細（着順）
	public function resultDetail($raceId=null){

		if(empty($raceId)||!is_numeric($raceId)){
			$raceId = 1;
		}

		//対象のレースが存在するか？
		$raceData = $this->Race->findById($raceId);
		if(empty($raceData)){
			echo "race not found ! race_id = ".$raceId;exit;
		}

		//すでに結果詳細データが登録されていないか？
		$options = array(
			'conditions' => array(
				'race_id' => $raceData["Race"]["id"]
			)
		);
		$resultDetail = $this->RaceResultDetail->find("all",$options);
		if(!empty($resultDetail)){
			echo "resultDetail already exists! race_id = ".$raceId;exit;
		}

		//htmlを取得
		$html = file_get_html('http://keiba.yahoo.co.jp/race/result/'.$raceData["Race"]["html_id"].'/');
		

		//trのループ
		$resultData = array();
		$i = 0;

		foreach($html->find('#resultLs tr') as $key=>$element){
			$tdCounter = 0;
			foreach($element->find('td') as $key2=>$data){
				switch ($tdCounter) {
					case 0://着順
						$resultData[$i]["result"] = $data->plaintext;
						break;
					case 1://枠
						$resultData[$i]["wk"] = $data->plaintext;
						break;
					case 2://馬
						$resultData[$i]["uma"] = $data->plaintext;
						break;
					case 3://馬名
						$resultData[$i]["name"] = $data->plaintext;
						break;
					case 4://性齢
						$resultData[$i]["sexage"] = $data->plaintext;
						break;
					case 5://騎手名
						$resultData[$i]["j_name"] = $data->plaintext;
						break;
					case 6://time
						$resultData[$i]["time"] = $data->plaintext;
						break;
					case 7://着差
						$resultData[$i]["difference"] = $data->plaintext;
						break;
					case 9://ラスト３ハロン
						$resultData[$i]["last_time"] = $data->plaintext;
						break;
					case 10://斤量
						$resultData[$i]["j_weight"] = $data->plaintext;
						break;
					case 11://体重
						$resultData[$i]["weight"] = $data->plaintext;
						break;
					case 12://人気
						$resultData[$i]["popularity"] = $data->plaintext;
						break;
					case 13://調教師
						$resultData[$i]["trainer"] = $data->plaintext;
						break;
				}
				$tdCounter++;
			}
			$i++;
		}

		foreach ($resultData as $key => $data) {
			$data["race_id"] = $raceId;
			$this->RaceResultDetail->create();
			$this->RaceResultDetail->save($data);
		}

		echo "RaceResultDetail Ok ! race_id = ".$raceId.",name:".$raceData["Race"]["name"];
		exit;
	}

}