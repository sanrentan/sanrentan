<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $components = array(
        'Session',
        'Flash',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => '/',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login',
                'home'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
	    $this->Auth->allow('add', 'logout');
    }

    //会員登録
    public function regist(){
        $this->title_tag = "会員登録";
        $this->set("naviType","regist");
        if ($this->request->is('post')) {


            $this->User->set($this->request->data);
            if ($this->User->validates()) {

                //画像アップロード
                if(!empty($this->request->data['User']['profile_img']['tmp_name'])){
                    $fileInfo = getimagesize($this->request->data['User']['profile_img']['tmp_name']);
                    switch ($fileInfo["mime"]) {
                        case 'image/gif':
                            $ext = "gif";
                            break;
                        case 'image/png':
                            $ext = "png";
                            break;
                        case 'image/jpg':
                        case 'image/jpeg':
                            $ext = "jpg";
                            break;
                        
                    }
                    $file_name = md5(date("YmdHis").$this->request->data['User']['profile_img']['name']).".".$ext;
                    move_uploaded_file( $this->request->data['User']['profile_img']['tmp_name'], IMAGES . "profileImg/".$file_name);
                    $this->request->data["User"]["profile_img"] = $file_name;
                }

                //セッションにセットして確認画面へ
                $this->Session->write('regist', $this->request->data);
                $this->redirect('/regist_confirm');
            }

            //$this->User->create();
            //if ($this->User->save($this->request->data)) {
            //    //ログインしてトップページへ
            //    $this->login();
            //}
        }
    }

    //会員登録確認画面
    public function regist_confirm(){
        $this->title_tag = "会員登録確認画面";
        $this->set("naviType","regist");
        $postData = $this->Session->read("regist");

        if($this->request->is('post')){
            if(!empty($this->request->data["agree"])&&$this->request->data["agree"]==1){
                $this->redirect("/regist_complete");
            }else{
                $postData["agreeError"] = 1;
            }
        }
        $this->set("postData",$postData);
    }

    //会員登録完了
    public function regist_complete(){
        $this->title_tag = "会員登録完了";
        $this->set("naviType","regist");
        $postData = $this->Session->read("regist");
        if(!empty($postData)){
            $user_id = $this->User->create();
            unset($this->User->validate["profile_img"]);
            if ($this->User->save($postData)) {
                //ログインしてトップページへ
                $user_id = $this->User->getLastInsertID();
                $this->Session->write("regist","");
                $postData["User"]["id"] = $user_id;
                unset($postData['User']['password']);
                $result = $this->Auth->login($postData['User']);
                $this->user = $this->Auth->user();
                $this->set("user",$this->user);
            }else{
                $this->Session->setFlash(__('※不正な遷移です。'));
            }
        }
    }

    //会員情報変更
    public function edit() {
        $this->title_tag = "会員登録内容変更";
        $this->set("naviType","mypage");
        if(empty($this->user["id"])){
            $this->redirect("/login");
        }

        $this->User->id = $this->user["id"];
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data["User"]["id"]       = $this->user["id"];
            $this->request->data["User"]["username"] = $this->user["username"];

            //パスワードがpostされなかった場合はバリデーションを消す
            if(empty($this->request->data["User"]["password"])){
                unset($this->User->validate['password']);
            }

            if(empty($this->request->data["User"]["profile_img"]["name"])){
                unset($this->User->validate['profile_img']);
            }

            $this->User->set($this->request->data);
            if ($this->User->validates()) {

                if(!empty($this->request->data["User"]["profile_img"]["name"])){
                    //画像アップロード
                    $fileInfo = getimagesize($this->request->data['User']['profile_img']['tmp_name']);
                    switch ($fileInfo["mime"]) {
                        case 'image/gif':
                            $ext = "gif";
                            break;
                        case 'image/png':
                            $ext = "png";
                            break;
                        case 'image/jpg':
                        case 'image/jpeg':
                            $ext = "jpg";
                            break;
                        
                    }
                    $file_name = md5(date("YmdHis").$this->request->data['User']['profile_img']['name']).".".$ext;
                    move_uploaded_file( $this->request->data['User']['profile_img']['tmp_name'], IMAGES . "profileImg/".$file_name);
                    $this->request->data["User"]["profile_img"] = $file_name;
                }else{
                    $this->request->data["User"]["profile_img"] = "";
                }


                //セッションにセットして確認画面へ
                $this->Session->write('edit', $this->request->data);
                $this->redirect('/users/edit_confirm');
            }

        } else {
            $this->request->data = $this->User->findById($this->user["id"]);
            unset($this->request->data['User']['password']);
        }
    }

    //会員登録変更　確認
    public function edit_confirm(){
        $this->title_tag = "会員登録内容変更の確認";
        $this->set("naviType","mypage");
        $postData = $this->Session->read("edit");

        if(empty($postData["User"]["profile_img"])&&!empty($postData["profile_img_text"])){
            $postData["User"]["profile_img"] = $postData["profile_img_text"];
            $this->Session->write('edit', $postData);
        }

        if($this->request->is('post')){
            $this->redirect("/users/edit_complete");
        }
        $this->set("postData",$postData);
    }

    //会員登録変更　完了
    public function edit_complete(){
        $this->title_tag = "会員登録内容変更の完了";
        $this->set("naviType","mypage");
        $postData = $this->Session->read("edit");
        if(!empty($postData)){

            if(empty($postData["User"]["password"])){
                unset($postData["User"]["password"]);
            }
            $postData["User"]["id"] = $this->user["id"];
            $postData["User"]["username"] = $this->user["username"];


            unset($this->User->validate["profile_img"]);
 
            if ($this->User->save($postData)) {
                $this->Session->write("edit","");

                //sessionを更新する
                if(!empty($postData["User"]["password"])){
                    unset($postData['User']['password']);
                }
                $this->Session->write('Auth', $postData);
                $this->user = $this->Auth->user();
                $this->set("user",$this->user);

            }else{
                $this->Session->setFlash(__('※不正な遷移です。'));
            }
        }
    }


    //退会
    public function withdrawal(){
        $this->title_tag = "退会の確認";
        if(empty($this->user["id"])){
            $this->redirect("/login");
        }

        if ($this->request->is('post')) {
            //退会処理
            $data = array(
                "User"=>array(
                    "id" => $this->user["id"],
                    "is_deleted" => 1,
                    "deleted_date" => date("Y-m-d H:i:s")
                )
            );
            $this->User->save($data);

            //ログアウトして
            $this->Auth->logout();
            $doneFlg = true;
            $this->set("doneFlg",$doneFlg);

        }
    }

    //ログイン
	public function login() {
        $this->title_tag = "ログイン";
        $this->set("naviType","login");
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
				$this->redirect('/');
	            //$this->redirect($this->Auth->redirect());
	        } else {
	            $this->Flash->error(__('Invalid username or password, try again'));
	        }
	    }
	}

    //ログアウト
	public function logout() {
        $this->title_tag = "ログアウト";
	    //$this->redirect($this->Auth->logout());
        $this->Auth->logout();
        //$this->redirect('/');
	}

}