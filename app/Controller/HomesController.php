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
		'FavoUser',
		'Information',
		'Article'
	);

    var $helpers = array('Js');
    var $components = array( 'RequestHandler');

	public $kojiharu_id = 3;

	//トップページ
	public function index(){
		//$this->meta_description = "test";
		//$this->meta_keywords = "test";

		//受付中のレース
		$acceptingRace = $this->Race->getAcceptingRace();

		//過去５レース
		$recentRace = $this->Race->getRecentRace();
		$this->set(compact("acceptingRace", "recentRace"));

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

		//お知らせを取得
		$infoData = $this->Information->getInfoList(5);

		//記事を取得取得
		$articleData = $this->Article->getRecentArticleList(4,2);
		$articleData2 = $this->Article->getRecentArticleList(1,1);
		$articleData = array_merge($articleData, $articleData2);

		$this->set(compact('newsRss', 'expectRss', 'matomeRss', 'infoData', 'articleData'));

	}


	//レース詳細
	public function detail(){

		//パラメータのチェック
		if(empty($this->request->params['race_id']) || !is_numeric($this->request->params['race_id'])){
			$this->redirect('/');			
		}
		$raceId = $this->request->params['race_id'];

		//パラメータのチェック
		if(!empty($this->request->params['page']) && !is_numeric($this->request->params['page'])){
			$this->redirect('/');			
		}


		$this->set("message","出走表");
		$RecentRaceResult = array();

		$raceData = $this->Race->findById($raceId);

		//存在しない場合はTOPページへ
		if(empty($raceData)){
			$this->redirect('/');
		}


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
		$this->set("raceData",$raceData);

		//予想
		if($this->request->is('post')){
			if(!empty($this->request->data['Expectation']['item'])&&count($this->request->data['Expectation']['item'])==Configure::read('Base.box_count')){
				//ここでセッションにpost値を入れる
	            $this->Session->write('expectation', $this->request->data);
				$this->redirect('/confirm');
			}else{

				if(empty($this->request->data["Expectation"]["item"])){
					$errorMessage = '※'.Configure::read('Base.box_count').'頭選択してください。';
				}else{
					$errorMessage = '※'.Configure::read('Base.box_count').'頭選択してください。('.count($this->request->data["Expectation"]["item"])."頭選択されました)";
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


		//みんなの予想を取得(件数を取得)
		$otherExpectCount = $this->Expectation->getExpectationOtherCount($raceId);

		//ページング機能
		$page = 1;//ページ番号
		if(!empty($this->request->params['page'])){
			$page = $this->request->params['page'];
		}else{
			$page = 1;
		}
		$limit = 18;//1ページの表示件数
		$offset = $page*18-$limit;//スタート位置
		$otherExpectData = $this->Expectation->getExpectationOther($raceId, $offset, $limit);

		//ページ数は？
		if($otherExpectCount == 0){
			$page_num = 0;
		}else{
			if($otherExpectCount%$limit == 0){
				//+1しちゃだめ
				$page_num = $otherExpectCount/$limit;
			}else{
				$page_num = $otherExpectCount/$limit + 1;
			}
		}
		$this->set(compact('page', 'otherExpectCount', 'page_num'));


		//レースの開始時間が過ぎていないか？
		$timeOver = false;//falseレース前、trueレース受付終了
		if(date('Y-m-d H:i:s')>=$raceData['Race']['race_date']){
			$timeOver = true;
		}

		//レース結果が出ているか？
		$raceResultData = $this->RaceResult->findById($raceId);

		$this->set(compact("myData","kojiharuData","otherExpectData","timeOver","raceResultData"));

		//metaタグ設定
        $this->meta_description = "こじはるさんの「".$raceData["Race"]["name"]."」の３連単５頭ボックスの予想です。参考にして是非みなさんも予想してみましょう。目指せ万馬券！";
		$this->meta_keywords = "３連単,こじはる,予想,".$raceData["Race"]["name"];
		$this->title_tag = $raceData["Race"]["name"]." 出走表";

		$this->set('h1tag',$raceData['Race']['name']);

		//凱旋門賞対応
		if(in_array($raceId, Configure::read('sp_race'))){
			$this->render('detail_special_race');
		}

	}

	//確認画面
	public function confirm(){
		//metaタグ設定
		$this->title_tag = "予想登録の確認画面";

		$postData = $this->Session->read("expectation");
		if(empty($postData["Expectation"]["race_id"])){
			$this->redirect('/');			
		}

		$raceData = $this->Race->findById($postData["Expectation"]["race_id"]);

		if(empty($raceData)){
			$this->redirect('/');			
		}

		//レースの開始時間が過ぎていないか？
		if(date('Y-m-d H:i:s')>=$raceData['Race']['race_date']){
			$this->redirect('/');
		}

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

		//凱旋門賞対応
		if(in_array($postData["Expectation"]["race_id"], Configure::read('sp_race'))){
			$this->render('confirm_special_race');
		}


	}

	//登録機能
	public function complete(){
		//metaタグ設定
		$this->title_tag = "予想完了";

		if(empty($this->request->data['Expectation']['race_id'])){
			$this->redirect('/');			
		}

		$raceData = $this->Race->findById($this->request->data['Expectation']['race_id']);
		//レースの開始時間が過ぎていないか？
		if(date('Y-m-d H:i:s')>=$raceData['Race']['race_date']){
			$this->redirect('/');
		}

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
		
				$myData = $this->Expectation->getExpectationData($this->request->data['Expectation']['race_id'],$this->user["id"]);

				$this->set("raceData",$raceData);
				$this->set("expectationData",$myData);


				//こじはるが予想した場合は、こじはるフラグをONにする
				if($this->user['id']==$this->kojiharu_id){
					$this->Race->id = $this->request->data['Expectation']['race_id'];
					$this->Race->saveField('kojiharu_flg',1);
				}

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

		//metaタグ設定
        $this->meta_description = "こじはるさんの「".$raceData["Race"]["name"]."」の３連単５頭ボックスのレース結果です。みなさんの予想も当たったかどうか確認してください。";
		$this->meta_keywords = "こじはる,３連単,レース結果,".$raceData["Race"]["name"];
		$this->title_tag = $raceData["Race"]["name"]." レース結果";

		$this->set('h1tag',$raceData['Race']['name']);

		//凱旋門賞対応
		if(in_array($raceId, Configure::read('sp_race'))){
			$this->render('result_special_race');
		}

	}


	//マイページ
	public function mypage(){
		//metaタグ設定
        $this->meta_description = "マイページです。これまでの予想結果の確認や、登録情報の変更、お気に入りユーザーの確認が可能です。";
		$this->meta_keywords = "マイページ";
		$this->title_tag = "マイページ";

		$this->set("naviType","mypage");
		
		if(empty($this->user["id"])){
			//ログインページへリダイレクト
			$this->redirect('/login');
		}else{
			$user = $this->user;
		}

		if(!empty($this->request->query['year']) && is_numeric($this->request->query['year'])){
			$year = $this->request->query['year'];
		}else{
			$year = date("Y");
		}

		//対象の年のレースを取得
		$tmpRaceData = $this->Race->getRaceListYear($year);

		$raceIdArr = array();
		foreach($tmpRaceData as $key=>$data){
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
		$myData = $this->Expectation->getExpectaionList($user['id'],$raceIdArr);
		//こじはるの結果を取得
		$myResultData = $this->ExpectationResult->getResultData($user['id'],$year);


		//予想したレースだけ取得
		$raceData = array();
		$raceIdArr = array();
		if(!empty($myData)){
			foreach($myData as $key=>$data){
				$raceIdArr[] = $data['Expectation']['race_id'];
			}

			foreach($tmpRaceData as $key=>$data){
				if(in_array($data['Race']['id'], $raceIdArr)){
					$raceData[] = $data;
				}
			}
		}

		$this->set(compact("year","raceData", "raceResultData","myData","myResultData"));

	}

	//過去のレース
	public function mypage_result(){
		//metaタグ設定
        $this->meta_description = "マイページです。これまでの予想結果の確認や、登録情報の変更、お気に入りユーザーの確認が可能です。";
		$this->meta_keywords = "マイページ,レース結果";
		$this->title_tag = "過去のレース結果";

		$this->set("naviType","result");
		
		if(empty($this->user["id"])){
			//ログインページへリダイレクト
			$this->redirect('/login');
		}else{
			$user = $this->user;
		}

		if(!empty($this->request->query['year']) && is_numeric($this->request->query['year'])){
			$year = $this->request->query['year'];
		}else{
			$year = date("Y");
		}


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

		$this->set(compact("year","raceData", "raceResultData","myData","myResultData","kojiharuData","kojiharuResultData"));

	}


	//こじはるの予想一覧
	public function kojiharu_list(){
        $this->meta_description = "AKBこじはるさんのこれまでの３連単５頭ボックスの競馬予想一覧です。だいたい当たっています。みなさんもこじはるさんと一緒に是非予想してみましょう。";
		$this->meta_keywords = "こじはる,３連単,5頭ボックス,競馬,予想,AKB";
		$this->title_tag = "予想一覧";

		$this->set("naviType","kojiharu");
		
		if(!empty($this->request->params['year'])&& is_numeric($this->request->params['year'])){
			$year = $this->request->params['year'];
		}else{
			$year = date("Y");//TODO 引数で受け取りたい
		}

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
		}else{
			//ログインしていない場合は見れません
			$this->render("nonmember");
			return;
		}

		if(empty($user_id)||!is_numeric($user_id)){
			echo "user_id is wrong";exit;
		}

		$conditions = array(
			"User.id" => $user_id,
			"User.is_deleted" => 0,
			"User.test_flg" => 0
		);
		$otherUser = $this->User->find("first",array("conditions"=>$conditions));
		if(empty($otherUser)){
			$this->set("message","ユーザーが存在しません。または既に退会しています。");
			$this->render("error");
			return;
		}

		if(!empty($this->request->query['year']) && is_numeric($this->request->query['year'])){
			$year = $this->request->query['year'];
		}else{
			$year = date("Y");
		}

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

		$this->title_tag = $otherUser["User"]["nickname"]."さんの予想一覧";


		$this->set(compact("year","raceData", "raceResultData","myData","myResultData","otherUser","favoFlg","other_user_id"));

	}


	//当サイトについて
	public function about(){
		$this->title_tag = "当サイトについて";
		$this->set("naviType","about");
	}

	//お問い合わせ
	public function contact(){
		$this->title_tag = "お問い合わせ";
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
		$this->title_tag = "お問い合わせ確認画面";
    	$this->set("naviType","contact");

    	$data = $this->Session->read('contact');
    	$this->set("data",$data);

		if($this->request->is('post')&&!empty($data)){
	    	//メール送信
	    	$email = new CakeEmail('smtp'); 
		    $email->to($data["email"]);
		    $email->bcc('info@sanrentan-box.com');
		    $email->subject( 'お問い合わせ頂きありがとうございます');
			$email->emailFormat('text');
		    $email->template('contact');
		    $email->viewVars(compact('data'));
		    $email->send();

	    	//sessionから削除
	        $this->Session->write('contact', "");

	        //リダイレクト
	        $this->redirect("/contact_complete");
		}
	}

	//お問い合わせ完了ページ
	public function contact_complete(){
		$this->title_tag = "お問い合わせ確認完了";
    	$this->set("naviType","contact");

    	$this->Session->write('contact','');


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
		$this->title_tag = "お気に入り一覧";
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
				$mlength = 25;
				if (mb_strlen($userData[$data["FavoUser"]["other_user_id"]]["User"]['message']) > $mlength) {	
			    	$userData[$data["FavoUser"]["other_user_id"]]["User"]['message'] = mb_substr($userData[$data["FavoUser"]["other_user_id"]]["User"]['message'], 0, $mlength, 'UTF-8').'..';
			    }

				$data["User"] = $userData[$data["FavoUser"]["other_user_id"]]["User"];
				$data["ExpectationResult"] = $userData[$data["FavoUser"]["other_user_id"]]["ExpectationResult"];
			}
		}

		$this->set(compact("favoList"));
	}
}