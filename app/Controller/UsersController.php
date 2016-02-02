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
        $this->set("naviType","regist");
        if ($this->request->is('post')) {

            $this->User->set($this->request->data);
            if ($this->User->validates()) {
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
        $this->set("naviType","regist");
        $postData = $this->Session->read("regist");
        if(!empty($postData)){
            $user_id = $this->User->create();
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

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

    //会員情報変更
    public function edit() {
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

            $this->User->set($this->request->data);
            if ($this->User->validates()) {
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
        $this->set("naviType","mypage");
        $postData = $this->Session->read("edit");

        if($this->request->is('post')){
            $this->redirect("/users/edit_complete");
        }
        $this->set("postData",$postData);
    }

    //会員登録変更　完了
    public function edit_complete(){
        $this->set("naviType","mypage");
        $postData = $this->Session->read("edit");
        if(!empty($postData)){

            if(empty($postData["User"]["password"])){
                unset($postData["User"]["password"]);
            }
            $postData["User"]["id"] = $this->user["id"];
            $postData["User"]["username"] = $this->user["username"];

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


    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    //ログイン
	public function login() {
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
	    //$this->redirect($this->Auth->logout());
        $this->Auth->logout();
        //$this->redirect('/');
	}

}