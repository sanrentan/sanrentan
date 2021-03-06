<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


// app/Model/User.php
class User extends AppModel {

    public $hasOne = array(
        'ExpectationResult' => array(
            'className' => 'ExpectationResult',
            'order' => 'ExpectationResult.id desc',
            'limit' => 1
        )
    );
    
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
                'rule' => 'alphaNumericDashUnderscore',
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
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
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
        'span' => array(
            'length' => array(
                'rule' => array( 'maxlength', 20),
                'message' => '競馬歴は20文字以下で入力して下さい',
            ),
        ),
        'favorite' => array(
            'length' => array(
                'rule' => array( 'maxlength', 50),
                'message' => '好きな馬は50文字以下で入力して下さい',
            ),
        ),
        'message' => array(
            'length' => array(
                'rule' => array( 'maxlength', 300),
                'message' => '自己紹介は300文字以下で入力して下さい',
            ),
        ),

        'profile_img' => array(

            // ルール：uploadError => errorを検証 (2.2 以降)
            'upload-file' => array( 
                'rule' => array( 'uploadError'),
                'message' => array( 'ファイルアップロードに失敗しました'),
                'allowEmpty' => true
            ),

            // ルール：extension => pathinfoを使用して拡張子を検証
            'extension' => array(
                'rule' => array('extension', array( 'jpg', 'jpeg', 'png', 'gif')),
                'message' => array('jpgまたはpngまたはgifファイルを指定してください'),
                'allowEmpty' => true
            ),

            // ルール：mimeType => 
            'mimetype' => array( 
                'rule' => array( 'mimeType', array('image/jpeg', 'image/png', 'image/gif')),
                'message' => array('jpgまたはpngまたはgifファイルを指定してください'),
                'allowEmpty' => true
            ),

            // ルール：fileSize => filesizeでファイルサイズを検証(2GBまで)  (2.3 以降)
            'size' => array(
                'maxFileSize' => array( 
                    'rule' => array( 'fileSize', '<=', '2MB'),  // 10M以下
                    'message' => array( 'ファイルサイズは2MB以下の画像を指定してください'),
                    'allowEmpty' => true
                ),
                'minFileSize' => array( 
                    'rule' => array( 'fileSize', '>',  0),    // 0バイトより大
                    'message' => array( 'ファイルサイズが不正です'),
                    'allowEmpty' => true
                ),
            ),


        ),
    );


	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new BlowfishPasswordHasher();
	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
	    }
	    return true;
	}

    //半角英数と_を許可する
    public function alphaNumericDashUnderscore($check) {
        // $data 配列はフォームの項目名をキーとして渡される。
        // この関数が汎用的に使えるように、値を展開する必要がある。
        $value = array_values($check);
        $value = $value[0];

        return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
    }

    public function createSaveDataByToken($token) {

        //既にusernameが存在するか？
        $options = array(
            'conditions' => array(
                'username' => $token['screen_name'],
                'is_deleted' => 0
            )
        );
        $tmp = $this->find('first',$options);
        if(!empty($tmp)){
            $username = $token['screen_name'].'_tw';
        }else{
            $username = $token['screen_name'];
        }

        //既にnicknameが存在するか？
        $options = array(
            'conditions' => array(
                'nickname' => $token['screen_name'],
                'is_deleted' => 0
            )
        );
        $tmp = $this->find('first',$options);
        if(!empty($tmp)){
            $nickname = $token['screen_name'].'_tw';
        }else{
            $nickname = $token['screen_name'];
        }


        $data = array(
            'User' => array(
                'username' => $username,
                'nickname' => $nickname,
                'password' => Security::hash($token['oauth_token']),
                'oauth_token' => $token['oauth_token'],
                'oauth_token_secret' => $token['oauth_token_secret'],
                'twitter_user_id' => (int)$token['user_id'],
                'twitter_user_name' => $token['screen_name'],
            ),
        );
        return $data;
    }

    public function updateSaveDataByToken($tmp,$token){
        $result = array();
        $result = $tmp;

        $result['User']['password'] = Security::hash($token['oauth_token']);
        $result['User']['oauth_token'] = $token['oauth_token'];
        $result['User']['oauth_token_secret'] = $token['oauth_token_secret'];

        return $result;
    }

    public function findTwitterUser($twitter_user_id){
        $options = array(
            "conditions" => array(
                'twitter_user_id' => $twitter_user_id,
                'is_deleted' => 0
            )
        );
        $result = $this->find("first",$options);
        return $result;

    }


    //金額によるランキング
    public function getRankingPrice($year){
        $optionsForRanking = array(
            'conditions'  => array(
                'User.is_deleted' => 0,
                'User.test_flg' => 0,
                'NOT' => array('ExpectationResult.price' => NULL),
                'ExpectationResult.price > ' => 0,
                'ExpectationResult.year' => $year
            ),
            'order' => array('ExpectationResult.price' => 'desc'),
            'limit' => 5
        );

        $result = $this->find('all',$optionsForRanking);
        return $result;
    }

}
