<?php

class AdTag extends AppModel {

	//指定したtypeのタグを返す
	public function getAdTag($type,$limit=1){
		$options = array(
			'conditions' => array(
				'type' => $type,
				'rank >' => 0 ,
				'is_deleted' => 0
			),
			'order' => 'rank desc,id desc'
		);
		$tags = $this->find('all',$options);
		$returnData = array();

		$endFlg = false;
		$tmpArray = array();
		while ($endFlg==false) {
			foreach($tags as $key=>$data){
				if(!in_array($data['AdTag']['id'],$tmpArray)){
					$rand = rand(0,10);
					if($rand<=5){
						$returnData[] = $data;
						$tmpArray[] = $data['AdTag']['id'];
						//必ず指定したlimitに達するように値を返す
						if(count($returnData)==$limit){
							$endFlg = true;
							break;
						}
					}
				}
			}
		}
		return $returnData;
	}

}
