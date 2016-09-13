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
        'Article', 'ArticleCategory', 'Race', 'ArticleLog'
    );

    public $components = array(
        'Paginator',
    );

    //ブログページ
    public function index(){

        $this->meta_keywords = "３連単,こじはる,競馬予想";


        if(empty($this->request->params['id'])||!is_numeric($this->request->params['id'])){
            //トップページへリダイレクト
            $this->redirect('/');
        }

        $article_id = $this->request->params['id'];

        //記事を取得
        $article = $this->Article->getArticle($article_id);

        if(empty($article)){
            //トップページへリダイレクト
            $this->redirect('/');
        }

        //カテゴリーを取得
        $article_category = $this->ArticleCategory->findById($article['Article']['article_category_id']);

        $this->meta_keywords .= ','.$article_category['ArticleCategory']['name'];
        $this->meta_description = $article['Article']['title'].' 当サイトオリジナル記事、こじはるさんの３連単５頭ボックスの'.$article_category['ArticleCategory']['name'].'ページです。';

        //レース取得
        if(!empty($article['Article']['race_id'])){
            $options = array(
                'fields' => array('id','name','view_flg'),
                'conditions' => array(
                    'id' => $article['Article']['race_id']
                ),
                'recursive' => -1
            );

            $race = $this->Race->find('first',$options);
            $this->set('race', $race);
    
            $this->title_tag = $race['Race']['name'].' '.$article_category['ArticleCategory']['name'];
            $this->meta_keywords .= ','.$race['Race']['name'];
            $this->meta_description = $article['Article']['title'].' 当サイトオリジナル記事、こじはるさんの３連単５頭ボックスの'.$race['Race']['name'].'の'.$article_category['ArticleCategory']['name'].'ページです。';
        }

	//ログを書き込む
	$log_data = array();
	$log_data['article_id'] = $article_id;
	if(!empty($this->user['id'])){
		$log_data['user_id'] = $this->user['id'];
	}
	$this->ArticleLog->create();
	$this->ArticleLog->save($log_data);
	

        $this->set(compact('article', 'article_category'));
        //$this->render(1);
    }

    //カテゴリーの記事一覧
    public function category($category_id=null){

        if(empty($category_id)||!is_numeric($category_id)){
            //トップページへリダイレクト
            $this->redirect('/');
        }

        //対象のカテゴリーが存在するか？
        $category = $this->ArticleCategory->findById($category_id);
        if(empty($category)){
            //トップページへリダイレクト
            $this->redirect('/');
        }

        //対象のカテゴリ内の記事一覧を取得
        $this->Paginator->settings = array(
            'fields' => array('id', 'title', 'start_date', 'race_id'),
            'conditions' => array(
                'article_category_id' => $category_id,
                'view_flg' => 1,
                'is_deleted' => 0,
                'start_date <=' => date('Y-m-d H:i:s')
            ),
            "order" => "id desc",
            "recursive" => "-1",
            "limit" => 20
        );
        $articleList = $this->Paginator->paginate('Article');

        //記事が存在しない場合
        if(empty($articleList)){
            //トップページへリダイレクト
            $this->redirect('/');
        }
        
        $this->title_tag = $category['ArticleCategory']['name'].'一覧';
        $this->meta_keywords = "３連単,こじはる,競馬予想,".$category['ArticleCategory']['name'];
        $this->meta_description = '当サイトオリジナル記事、こじはるさんの３連単５頭ボックスの'.$category['ArticleCategory']['name'].'一覧ページです。';

        $this->set(compact('category', 'articleList'));

    }

}
