
<?php  
class Thread extends AppModel {
	 public $validate = array(
		 		'comment' =>array(
		 			'rule' => array('maxLength', 200),
		 			'message' => '投稿内容は200文字以下で入力して下さい'
	            )
			);
	}
?>