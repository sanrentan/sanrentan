<?php echo $target_date;?>

全体の閲覧数：<?php echo $total;?>


<?php foreach($logs as $key=>$data):?>
	
	<?php echo $data['ArticleLog']['name'];?>

	閲覧数：<?php echo $data['ArticleLog']['cnt'];?>


<?php endforeach;?>
