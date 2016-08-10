<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class LoginHistory extends AppModel {

	public $useTable = 'login_histories';

	//ログイン履歴を保存
	public function saveLoginHistory($user_id, CakeRequest $request){
		if(empty($user_id)||!is_numeric($user_id)){
			return false;
		}

		$loginData = array(
			'user_id' => $user_id,
			'ip_address' => $request->clientIp(false),
			'user_agent' => $request->header('User-Agent'),
			'created' => date('Y-m-d H:i:s')
		);

		$this->create();
		$this->save($loginData);

		//ユーザーのログイン回数の更新
		$this->User = ClassRegistry::init('User');
		$user = $this->User->findById($user_id);

		if(empty($user['User']['login_count'])){
			$login_count = 1;
		}else{
			$login_count = $user['User']['login_count']+1;
		}

		$this->User->id = $user_id;
		$this->User->saveField('login_count',$login_count);
	}
}
