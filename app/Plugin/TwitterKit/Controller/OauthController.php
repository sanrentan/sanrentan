<?php
/**
 * TwitterKit Oauth Controller
 *
 * for CakePHP 2.0+
 * PHP version 5.2+
 *
 * Copyright 2010, ELASTIC Consultants Inc. (http://elasticconsultants.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @version    1.0
 * @author     nojimage <nojima at elasticconsultants.com>
 * @copyright  2010, ELASTIC Consultants Inc.
 * @link       http://elasticconsultants.com
 * @package    twitter_kit
 * @subpackage twitter_kit.controller
 * @since      TwitterKit 1.0
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
class OauthController extends TwitterKitAppController {

    public $uses = array();

    public $components = array('TwitterKit.Twitter');

    /**
     *
     * @var TwitterComponent
     */
    public $Twitter;

    /**
     *
     * @var AuthComponent
     */
    public $Auth;

    /**
     * (non-PHPdoc)
     * @see cake/libs/controller/Controller#beforeFilter()
     */
    public function beforeFilter()
    {
        parent::beforeFilter();

        if ($this->Components->attached('Auth')) {

            $this->Auth->allow('authorize_url', 'authenticate_url', 'callback');

        }
    }

    /**
     * get authorize url
     *
     * @param string $datasource
     */
    public function authorize_url($datasource = null) {

        Configure::write('debug', 0);

        // -- set datasource
        $this->Twitter->setTwitterSource($datasource);

        // set Authorize Url
        $url = $this->Twitter->getAuthorizeUrl(null, true);
        echo json_encode(compact('url'));
		exit;
    }

    /**
     * get authenthicate url
     *
     * @param string $datasource
     */
    public function authenticate_url($datasource = null,$redirect_flg=false) {

        Configure::write('debug', 0);

        // -- set datasource
        $this->Twitter->setTwitterSource($datasource);

        // set Authenticate Url
        $url = $this->Twitter->getAuthenticateUrl(null, true);
        $url = str_replace('http://', 'https://', $url);
        if($redirect_flg==false){
            echo json_encode(compact('url'));
            exit;
        }else{
            return $url;
        }
    }


    /**
     * OAuth callback
     */
    public function callback($datasource = null)
    {
        $this->Twitter->setTwitterSource($datasource);

        // 正当な返り値かチェック
        if (!$this->Twitter->isRequested()) {
            $this->Twitter->deleteAuthorizeCookie();
            $this->flash(__d('twitter_kit', 'Authorization failure.'), '/', 5);
            return;
        }

        // $tokenを取得
        $token = $this->Twitter->getAccessToken();

        if (is_string($token)) {

            $this->flash(__d('twitter_kit', 'Authorization Error: %s', $token), '/', 5);
            return;

        }

        if (class_exists('TwitterUser') || ((true || App::uses('TwitterUser', 'Model')) && class_exists('TwitterUser'))) {
            /* @var $model TwitterUser */
            $model = ClassRegistry::init('TwitterUser');
        } else {
            /* @var $model TwitterKitUser */
            //$model = ClassRegistry::init('TwitterKit.TwitterKitUser');
            $model = ClassRegistry::init('User');
        }

        $create_flg = false;

        //既に登録済みか？
        $tmp = $model->findTwitterUser($token['user_id']);
        if(!empty($tmp)){
            $data = $model->updateSaveDataByToken($tmp,$token);
        }else{
            // 保存データの作成
            $data = $model->createSaveDataByToken($token);
            $model->create();
            $create_flg = true;
        }

        if (!$model->save($data,false)) {
            $this->flash(__d('twitter_kit', 'The user could not be saved'), array('plugin' => 'twitter_kit', 'controller' => 'users', 'action' => 'login'), 5);
            return;
        }

        if($create_flg==true){
            $data['User']['id'] = $model->getLastInsertId();
            //新規会員登録の際
            $ds = $this->Twitter->getTwitterSource();
            $ds->setToken($data['User']);

            //プロフィール画像の取得
            $params = array();
            $params['id'] = $data['User']['twitter_user_id'];
            $result = $ds->users_show($data['User']['twitter_user_id']);
            if(!empty($result['profile_image_url'])){
                $image_url = str_replace("_normal", "", $result['profile_image_url']);
                $image_data = file_get_contents($image_url);
                //MIMEタイプの取得
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_buffer($finfo, $image_data);
                finfo_close($finfo);
                //出力
                switch ($mime_type) {
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
                $file_name = md5(date("YmdHis").$data['User']['id']).".".$ext;
                file_put_contents(IMAGES.'profileImg/'.$file_name,$image_data);

                //profile_imgを更新
                $model->id = $data['User']['id'];
                $model->saveField('profile_img',$file_name);
                $data['User']['profile_img'] = $file_name;
            }

            //メール送信
            $email = new CakeEmail('smtp'); 
            $email->to('info@sanrentan-box.com');
            $email->subject( 'twitterから会員登録がありました');
            $email->emailFormat('text');
            $email->template('regist');
            $postData['User']['nickname'] = $data['User']['nickname'];
            $email->viewVars(compact('postData'));
            $email->send();
        }


        $this->Auth->login($data['User']);

        // Redirect
        if (ini_get('session.referer_check') && env('HTTP_REFERER')) {
            $this->flash(__d('twiter_kit', 'Redirect to %s', Router::url($this->Auth->redirect(), true) . ini_get('session.referer_check')), $this->Auth->redirect(), 0);
            return;
        }

        //$this->redirect($this->Auth->redirect());
        if($create_flg==true){
            $this->redirect("/users/edit");
        }else{
            $this->redirect("/");
        }

    }

}
