
<?php  
class Thread extends AppModel {
	 public $validate = array(
		 		'comment' =>array(
		 			'length' => array(
		 				'rule' => array('maxLength', 200),
			 			'message' => '投稿内容は200文字以下で入力して下さい'
			 		)
	            ),
	            'file_name' =>array(
	            	'size' => array(
	            		'rule' => array('extension',array('jpg','jpeg','gif','png')),
        				'message' => '拡張子はjpg,jpeg,gif,pngから選択してください',
        				'allowEmpty' => true,
        				'reqired' => false
	            	)
	            )
			);
	}
?>