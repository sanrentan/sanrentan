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

App::uses('Controller', 'Controller');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AdminController extends Controller {

    public $components = array(
        'Session',
        'Flash',
        'Paginator',
        'Auth' => array(
            'loginAction' => array(
            	'controller' => "manages",
            	'action' => 'admin_login'
            ),
            'loginRedirect' => array(
            	'controller' => "manages",
            	'action' => 'admin_index'
            ),
            'logoutRedirect' => array(
            	'controller' => "manages",
            	'action' => 'admin_login'
            ),
            'authenticate' => array(
                'Form' => array(
                	'userModel' => "AdminUser",
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password',
                    ),
                    'scope' => array('is_deleted' => 0),
					'passwordHasher' => array(
    	                'className' => 'Simple',
	                    'hashType' => 'sha256'
        	        )
                ),
            ),
        )
    );


	public function beforeFilter(){
        parent::beforeFilter();
        
        //Basic認証
        $this->autoRender = false;
        $loginId = 'yamaoka';
        $loginPassword = 'yamaoka';
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Please enter your ID and password"');
            header('HTTP/1.0 401 Unauthorized');
            die("id / password Required");
        }else {
            if ($_SERVER['PHP_AUTH_USER'] != $loginId || $_SERVER['PHP_AUTH_PW'] != $loginPassword) {
                header('WWW-Authenticate: Basic realm="Please enter your ID and password"');
                header('HTTP/1.0 401 Unauthorized');
                die("Invalid id / password combination.  Please try again");
            }
        }

        $typeArr = array("芝","ダート");
        $this->set("typeArr",$typeArr);
        $turnArr = array("右","左");
        $this->set("turnArr",$turnArr);

        $viewArr = array("非公開","公開");
        $this->set("viewArr",$viewArr);
        $acceptArr = array("停止","受付中");
        $this->set("acceptArr",$acceptArr);
        $kojiharuArr = array("-","対象レース");
        $this->set("kojiharuArr",$kojiharuArr);


		$this->user = $this->Auth->user();
		$this->set("user",$this->user);

		//アクセス許可
        $this->Auth->allow('admin_login','admin_logout');

        $this->autoRender = true;
    }

	public function beforeRender()
	{
	    $this->layout = 'admin';
	}

}