<?php

class Article extends AppModel {


	//指定した記事を取得
	public function getArticle($article_id){

		$options = array(
			'conditions' => array(
				'id' => $article_id,
				'view_flg' => 1,
				'start_date <' => date('Y-m-d H:i:s'),
				'is_deleted' => 0,
			),
		);

		return $this->find('first',$options);

	}


	//最新記事一覧を取得
	public function getRecentArticleList($limit=5,$category_id=null){

		$conditions = array(
			'view_flg' => 1,
			'start_date <' => date('Y-m-d H:i:s'),
			'is_deleted' => 0,
		);
		if(!empty($category_id)&&is_numeric($category_id)){
			$conditions['article_category_id'] = $category_id;
		}

		$options = array(
			'fields' => 'id,title,start_date',
			'conditions' => $conditions,
			'order' => 'start_date desc,id desc',
			'limit' => $limit
		);

		return $this->find('all',$options);

	}

}
