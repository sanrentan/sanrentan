<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Flash',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password',
                    ),
                    'scope' => array('is_deleted' => 0),
                    'passwordHasher' => 'Blowfish'
                ),
                'TwitterKit.TwitterOauth',
            ),
            //ログインアクション
            'loginAction' => array(
                'plugin' => 'twitter_kit',
                'controller' => 'users',
                'action' => 'login',
            ),
            //ログイン後に遷移するURL
            'loginRedirect' => array(
                'plugin' => 'twitter_kit',
                'controller' => 'users',
                'action' => 'login',
            ),
        ),
        'TwitterKit.Twitter'
/**        'Auth' => array(
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
**/
    );

	public $helpers = array(
	 		'Session',
	 		'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
	 		'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
	 		'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	 );

	public $layout = 'bootstrap';
	

	function beforeFilter() {
		$typeArr = array("芝","ダート");
		$this->set("typeArr",$typeArr);
		$turnArr = array("右","左");
		$this->set("turnArr",$turnArr);

		$this->user = $this->Auth->user();
		$this->set("user",$this->user);
	
		$this->Auth->allow();
        //$this->Auth->allow('index', 'view','edit','detail');

        $this->set("naviType","top");
   	}

    function beforeRender(){
        if(empty($this->meta_description)){
            $this->meta_description = "こじはるさんと一緒に競馬の３連単５頭ボックスを当てましょう。こじはるさんやみんなの３連単予想をみて、是非予想してみましょう。目指せ万馬券！当サイトでは最新予想はもちろん、過去のこじはるさんの予想結果も見ることが可能です。";
        }
        $this->set("meta_description",$this->meta_description);

        if(empty($this->meta_keywords)){
            $this->meta_keywords = "３連単,ボックス,こじはる,競馬";
        }
        $this->set("meta_keywords",$this->meta_keywords);

        if(empty($this->title_tag)){
            $this->title_tag = null;
        }
        $this->set("title_tag",$this->title_tag);

    }

    public function getRss($key,$url,$num=5,$css=1){

        $cache = Cache::read($key,"rss");
        if($cache){
            //キャッシュがあれば
            $xml = simplexml_load_string($cache, 'SimpleXMLElement', LIBXML_NOCDATA);
        }else{
            //なければRSSを取得
            $fileData = file_get_contents($url);
            if(!empty($fileData)){
                Cache::write($key,$fileData,"rss");
                $cache = Cache::read($key,"rss");
                $xml = simplexml_load_string($cache, 'SimpleXMLElement', LIBXML_NOCDATA);
            }else{
                return null;
            }
        }
        $json = json_encode($xml);
        $tmpArray = json_decode($json,TRUE);

        $tmpRss = array();
        if(empty($tmpArray["channel"]["item"])){
            $tmpRss = $tmpArray["item"];
        }else{
            $tmpRss = $tmpArray["channel"]["item"];
        }

        $returnData = array();
        $counter = 0;
        foreach($tmpRss as $item){
            if($counter<$num){
                $item["css"] = $css;
                $item["blogTitle"] = $tmpArray["channel"]["title"];
                $returnData[] = $item;
                $counter++;
            }else{
                break;
            }
        }
        return $returnData;
    }


}
