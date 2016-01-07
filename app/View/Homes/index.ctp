<?php echo $message;?>


<?php foreach($raceData as $key=>$data):?>
	<p><a href="/detail/<?php echo $data['Race']['id'];?>"><?php echo $data['Race']['name'];?></a></p>
<?php endforeach;?>