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
		'RecentRaceResult',
		'User',
		'FavoUser'
	);

    var $helpers = array('Js');
    var $components = array( 'RequestHandler');

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

		//RSS 競馬ニュース
		$newsRss = $this->getRss("keiba_news","http://keiba.jp/rss/news.xml");

		//競馬コラム
		$expectRss = $this->getRss("expectRss","http://keiba.jp/rss/column.xml");

		//まとめサイト
		$matomeRss = $this->getRss("umasoku","http://umasoku.doorblog.jp/index.rdf",5,1);
		$keibaKyodai = $this->getRss("keibakyodai","http://keibakyoudai.com/feed.xml",5,2);
		$keibayosou = $this->getRss("keibayosou","http://blog.livedoor.jp/win_keibayosou/index.rdf",5,3);
		$umachannel = $this->getRss("umachannel","http://bspear.com/feed",5,4);


		$matomeRss = array_merge($matomeRss,$keibaKyodai,$keibayosou,$umachannel);

		//ランキング
		$optionsForRanking = array(
			'conditions'  => array(
				'NOT' => array(
					'ExpectationResult.price' => NULL)
				),
			'order' => array('ExpectationResult.price' => 'desc'),
			'limit' => 5
			);
		$rankedUsers = $this->User->find("all", $optionsForRanking);

		$this->set(compact("newsRss", "expectRss","matomeRss", "rankedUsers"));

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

				if(empty($this->request->data["Expectation"]["item"])){
					$errorMessage = '※'.Configure::read('Base.box_count').'つ選択してください。';
				}else{
					$errorMessage = '※'.Configure::read('Base.box_count').'つ選択してください。('.count($this->request->data["Expectation"]["item"])."頭選択されました)";
				}
				$this->set("errorMessage",$errorMessage);
			}
		}

		//すでに予想しているか	
		$myData = array();
		if(!empty($this->user["id"])){
			$myData = $this->Expectation->getExpectationData($raceId,$this->user["id"]);
		}

		//こじはるの予想
		$kojiharuData = $this->Expectation->getExpectationData($raceId);


		//みんなの予想を取得
		$otherExpectData = $this->Expectation->getExpectationOther($raceId);

		$this->set(compact("myData","kojiharuData","otherExpectData"));


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

		//当選者を取得
		$winUser = $this->Expectation->getWinUsers($raceId);

		$this->set(compact("raceData","raceResultData","myData","kojiharuData","winUser"));
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

		$this->set(compact("year","raceData", "raceResultData","myData","myResultData"));

	}


	//他人の予想結果
	public function other($user_id=3){
			
		if(!empty($this->user["id"])){
			$this->set("user",$this->user);
		}

		if(empty($user_id)||!is_numeric($user_id)){
			echo "user_id is wrong";exit;
		}

		$otherUser = $this->User->find("first",array("conditions"=>array("User.id"=>$user_id)));
		if(empty($otherUser)){
			echo "user is not exist!";exit;
		}

		$year = date("Y");//TODO 引数で受け取りたい

		//対象の年のレースを取得
		$raceData = $this->Race->getRaceListYear($year);

		$raceIdArr = array();
		foreach($raceData as $key=>$data){
			$raceIdArr[] = $data["Race"]["id"];
		}

		//予想一覧を取得
		$myData = $this->Expectation->getExpectaionList($user_id,$raceIdArr);
		//結果を取得
		$myResultData = $this->ExpectationResult->getResultData($user_id,$year);

		//予想したレースのみ
		$raceIdArr = array();
		foreach($myData as $key=>$data){
			$raceIdArr[] = $data["Expectation"]["race_id"];
		}

		$tmpRaceData = array();
		foreach($raceData as $key=>$data){
			if(in_array($data["Race"]["id"], $raceIdArr)){
				$tmpRaceData[] = $data;
			}	
		}
		$raceData = $tmpRaceData;


		//レース結果を取得
		$options = array("conditions"=>array("race_id"=>$raceIdArr));
		$tmpData = $this->RaceResult->find("all",$options);
		$raceResultData = array();
		foreach($tmpData as $key=>$data){
			$raceResultData[$data["RaceResult"]["race_id"]] = $data;
		}

		//お気に入りに登録しているか
		$favoFlg = false;
		if(!empty($this->user["id"])){
			$conditions = array(
				"conditions" => array(
					"user_id" => $this->user["id"],
					"other_user_id" => $user_id
				)
			);
			$favoData = $this->FavoUser->find("first",$conditions);
			if(!empty($favoData)){
				$favoFlg = true;
			}
		}



		$this->set(compact("year","raceData", "raceResultData","myData","myResultData","otherUser","favoFlg"));

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
								if($j > 0 && $j < 6){
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
												$recent_5race_results[$i][$j]["jockey"] = $tdData->plaintext;
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


	//お気に入りに登録(ajaxを使用)
	public function favorite_add(){
        $this->autoRender = false;
        if($this->request->is('ajax')) {
        	if(!empty($this->user)){

        		//すでに登録されていないか？
        		$conditions = array(
        			"conditions" => array(
        				"user_id" => $this->user["id"],
        				"other_user_id" => $this->request->data["other_user_id"]
        			)
        		);
        		$favoData = $this->FavoUser->find("first",$conditions);

        		if(empty($favoData)){
	        		$data = array();
	        		$data["user_id"] = $this->user["id"];
	        		$data["other_user_id"] = $this->request->data["other_user_id"];
	        		$this->FavoUser->save($data);
		        	$messageData["status"] = "ok";
		        	$messageData["other_user_id"] = $this->request->data["other_user_id"];
					echo json_encode($messageData);
					exit;

        		}else{
		        	$messageData["status"] = "already";
		        	$messageData["other_user_id"] = $this->request->data["other_user_id"];
					echo json_encode($messageData);
					exit;
        		}

        	}else{
	        	$messageData = array();
	        	$messageData["status"] = "non-member";
		        $messageData["other_user_id"] = $this->request->data["other_user_id"];
				echo json_encode($messageData);
				exit;

        	}
        }
	}


	//お気に入りに削除(ajaxを使用)
	public function favorite_delete(){
        $this->autoRender = false;
        if($this->request->is('ajax')) {
        	if(!empty($this->user)){

        		//すでに登録されていないか？
        		$conditions = array(
        			"conditions" => array(
        				"user_id" => $this->user["id"],
        				"other_user_id" => $this->request->data["other_user_id"]
        			)
        		);
        		$favoData = $this->FavoUser->find("first",$conditions);
        		if(!empty($favoData)){
	        		$this->FavoUser->delete($favoData["FavoUser"]["id"]);
		        	$messageData["status"] = "ok";
		        	$messageData["other_user_id"] = $this->request->data["other_user_id"];
					echo json_encode($messageData);
					exit;

        		}else{
		        	$messageData["status"] = "error";
		        	$messageData["other_user_id"] = $this->request->data["other_user_id"];
					echo json_encode($messageData);
					exit;
        		}

        	}else{
	        	$messageData = array();
	        	$messageData["status"] = "error";
		        $messageData["other_user_id"] = $this->request->data["other_user_id"];
				echo json_encode($messageData);
				exit;

        	}
        }
	}

	//お気に入り一覧
	public function favorite(){
		if(empty($this->user["id"])){
			$this->redirect("/");
		}

		//お気に入りユーザーを取得
		$options = array(
			"conditions" => array(
				"FavoUser.user_id" => $this->user["id"]
			),
			"order" => "FavoUser.id desc",
		);
		$favoList = $this->FavoUser->find("all",$options);

		if(!empty($favoList)){
			foreach($favoList as $key=>$data){
				$user_ids[] = $data["FavoUser"]["other_user_id"];
			}

			$userDataTmp = $this->User->find("all",array("conditions"=>array("User.id"=>$user_ids)));
			$userData = array();
			foreach($userDataTmp as $key=>$data){
				$userData[$data["User"]["id"]] = $data;
			}

			foreach($favoList as $key=>&$data){
				$data["User"] = $userData[$data["FavoUser"]["other_user_id"]]["User"];
				$data["ExpectationResult"] = $userData[$data["FavoUser"]["other_user_id"]]["ExpectationResult"];
			}
		}

		$this->set(compact("favoList"));
	}
}