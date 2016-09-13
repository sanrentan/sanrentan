<?php echo $target_date;?>


<?php foreach($logs as $key=>$data):?>
	
	<?php echo $data['ArticleLog']['name'];?>

	閲覧数：<?php echo $data['ArticleLog']['cnt'];?>


<?php endforeach;?>
