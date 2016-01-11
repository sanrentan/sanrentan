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

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
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
        $this->redirect('/');
	}

}