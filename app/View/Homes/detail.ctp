<h1><?php echo $message;?></h1>

<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?></p>
<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
<p><?php echo $raceData["Race"]["note"];?></p>


<?php echo $this->Form->create('Expectation',array('type' => 'post'));?>
<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $raceData["Race"]["id"]));?>
<table border="1">
<tr><th>選択</th><th>枠番</th><th>馬番</th><th>馬名</th><th>馬体重</th><th>騎手</th></tr
<?php foreach($cardData as $key=>$data):?>
	<tr>
		<td><input type="checkbox" name="data[Expectation][item][]" value="<?php echo $data['RaceCard']['id'];?>"></td>
		<td><?php echo $data["RaceCard"]["wk"];?></td>
		<td><?php echo $data["RaceCard"]["uma"];?></td>
		<td><?php echo $data["RaceCard"]["name"];?></td>
		<td><?php echo $data["RaceCard"]["weight"];?></td>
		<td><?php echo $data["RaceCard"]["j_name"];?></td>
	</tr>
<?php endforeach;?>

</table>

<?php echo $this->Form->end('送信');?>
