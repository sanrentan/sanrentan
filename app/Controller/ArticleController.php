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

App::uses('AppController', 'Controller');



/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ArticleController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array(
    );


    //トップページ
    public function index(){
        $this->meta_description = "AKBこじはるさんの3連単5頭ボックスの予想サイトです。当ページでは2016年8月の予想結果と会員様のランキングを発表し8月の競馬を振り返りたいと思います。";
        $this->meta_keywords = "こじはる,3連単,競馬予想,2016年8月";

        //print_R($this->request->params);exit;



        //$this->set(compact("newsRss", "expectRss","matomeRss","infoData"));
        $this->render(1);
    }

}