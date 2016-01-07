<?php echo $message;?>


<?php foreach($raceData as $key=>$data):?>
	<p><?php echo $data["Race"]["name"];?></p>
<?php endforeach;?>