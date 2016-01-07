<?php echo $message;?>

<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?></p>
<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
<p><?php echo $raceData["Race"]["note"];?></p>


<?php echo $this->Form->create('Expectation',array('type' => 'post','action'=>'/complete'));?>
<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $postData["Expectation"]["race_id"]));?>
<?php foreach($selectArray as $key=>$data){
	echo $data["uma"].":".$data["name"]."<br>";
	echo $this->Form->hidden('item][',array("value"=>$data["id"]));
}
?>


<?php echo $this->Form->button('戻る',array('onclick'=>'history.back()'));?>
<?php echo $this->Form->end('送信');?>
