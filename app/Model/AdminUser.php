<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class AdminUser extends AppModel {
    
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'ログインIDを入力してください'
            ),
             'isUnique' => array(
                'rule' => 'isUnique', // 重複チェック
                'message' => '既に使用されているログインIDです'
            ), 
            'length' => array(
                'rule' => array( 'between', 4, 20),
                'message' => 'ログインIDは4文字以上、20文字以下で入力して下さい',
            ),
            'alpha' => array(
                'rule' => 'alphaNumeric',
                'message' => 'ログインIDは半角英数字のみ使用できます'
            ),

        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'パスワードを入力してください'
            ),
            'custom' => array(
                'rule' => array('custom', '/^[a-zA-Z0-9]{6,}$/i'), // 半角英数6文字以上
                'message' => 'パスワードは半角英数6文字以上入力してください'
            ),
            'length' => array(
                'rule' => array( 'between', 6, 20),
                'message' => 'パスワードは6文字以上、20文字以下で入力して下さい',
            ),
        ),
        'nickname' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'ニックネームを入力してください'
            ),
             'isUnique' => array(
                'rule' => 'isUnique', // 重複チェック
                'message' => '既に使用されているニックネームです'
            ), 
            'length' => array(
                'rule' => array( 'between', 2, 20),
                'message' => 'ニックネームは2文字以上、20文字以下で入力して下さい',
            ),
        ),
    );


	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
	    }
	    return true;
	}
    
}
