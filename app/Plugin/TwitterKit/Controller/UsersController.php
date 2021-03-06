<?php

/**
 * TwitterKit Users Controller
 *
 * for CakePHP 2.0+
 * PHP version 5.2+
 *
 * Copyright 2010, ELASTIC Consultants Inc. (http://elasticconsultants.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @version    1.1
 * @author     nojimage <nojima at elasticconsultants.com>
 * @copyright  2011, ELASTIC Consultants Inc.
 * @link       http://elasticconsultants.com
 * @package    twitter_kit
 * @subpackage twitter_kit.controller
 * @since      TwitterKit 1.0
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * */
class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array();
    public $helpers = array('Html', 'Form', 'Js', 'TwitterKit.Twitter');

    /**
     * (non-PHPdoc)
     * @see cake/libs/controller/Controller#beforeFilter()
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout');
    }

    public function login() {
        $linkOptions = array();

        if (!empty($this->params['named']['datasource'])) {
            $linkOptions['datasource'] = $this->params['named']['datasource'];
        }

        if (!empty($this->params['named']['authenticate'])) {
            $linkOptions['authenticate'] = $this->params['named']['authenticate'];
        }

        $this->set('linkOptions', $linkOptions);
    }

    public function logout() {
				$this->Session->delete('Auth.User') ;
        $this->Session->destroy();
        $this->Session->setFlash(__d('twitter_kit', 'Signed out'));
        $this->redirect($this->Auth->logoutRedirect);
    }

}
