<?php echo $message;?>


<?php foreach($raceData as $key=>$data):?>
	<p><a href="/detail/<?php echo $data['Race']['id'];?>"><?php echo date("Y年m月d日",strtotime($data["Race"]["race_date"]));?> <?php echo $data['Race']['name'];?></a></p>
<?php endforeach;?>