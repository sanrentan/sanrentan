<?php echo $target_month;?>

全体の閲覧数：<?php echo $total;?>


<?php foreach($logs as $key=>$data):?>
	
	<?php echo $data['ArticleDailyCount']['name'];?>

	閲覧数：<?php echo $data['ArticleDailyCount']['sum'];?>


<?php endforeach;?>
