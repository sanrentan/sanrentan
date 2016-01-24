<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)</p>
<!-- <pre>
	<?php //print_r($recentRaceResult[153][0]['RecentRaceResult']);exit; ?>
</pre> -->

<div id="raceDetailTxt">
	<div id="detailLeft">
		<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
		<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
		<p><?php echo $raceData["Race"]["note"];?></p>
		<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
		<p><a href="http://keiba.yahoo.co.jp/race/denma/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース詳細（外部サイト)</a></p>
	</div>
	<div id="detailRight">
		<div class="confirmSelect">
			<?php if(!empty($myData)):?>
				<ul class="selectList">
					<p id="myList">あなたの予想</p>
					<?php foreach($myData["selectData"] as $key=>$data):?>
						<li><span class="wk<?php echo $data["RaceCard"]['wk'];?>"><?php echo $data["RaceCard"]["uma"];?></span> <?php echo $data["RaceCard"]["name"];?></li>
					<?php endforeach;?>
				</ul>
			<?php endif;?>
			<?php if(!empty($kojiharuData)):?>
				<ul class="selectList">
					<p id="kojiharuList">こじはるの予想</p>
					<?php foreach($kojiharuData["selectData"] as $key=>$data):?>
						<li><span class="wk<?php echo $data["RaceCard"]['wk'];?>"><?php echo $data["RaceCard"]["uma"];?></span> <?php echo $data["RaceCard"]["name"];?></li>
					<?php endforeach;?>
				</ul>
			<?php endif;?>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="clearfix"></div>
</div>

<?php echo $this->Form->create('Expectation',array('type' => 'post'));?>
<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $raceData["Race"]["id"]));?>
<div id="horseListArea">
	<table border="1">
	<tr><?php if(empty($myData)):?><th>選択</th><?php endif;?><th>枠番</th><th>馬番</th><th>馬名</th><th>性齢</th><th>馬体重</th><th>負担重量/騎手名</th><th>前走</th><th>前々走</th><th>3走前</th><th>4走前</th><th>5走前</th></tr>
	<?php foreach($raceData["RaceCard"] as $key=>$data):?>
		<tr>
			<?php if(empty($myData)):?><td align="center"><input type="checkbox" name="data[Expectation][item][]" value="<?php echo $data['id'];?>"></td><?php endif;?>
			<?php if($data["wk_flg"]):?>
				<td rowspan="<?php echo $raceData['wkData'][$data['wk']];?>" class="wk<?php echo $data['wk'];?>" align="center"><?php echo $data["wk"];?></td>
			<?php endif;?>
			<td align="center"><?php echo $data["uma"];?></td>
			<td><?php echo $data["name"];?></td>
			<td align="center"><?php echo $data["sexage"];?></td>
			<td align="center">
				<?php if($data["weight"]>0):?>
					<?php echo $data["weight"];?><?php echo $data["plus"];?>
				<?php else:?>
					-
				<?php endif;?>
			</td>
			<td><?php echo $data["j_weight"];?><br><?php echo $data["j_name"];?></td>
			<?php foreach($recentRaceResult as $eachResult): ?>
				<?php if($eachResult['RecentRaceResult']['race_card_id'] ===  $data['id']): ?>
				<td class = "recentResults">
				<span class = "lastRaceName"><?php echo $eachResult['RecentRaceResult']['race_name'] ?></span>
				<span class = "lastRacePlace"><?php echo $eachResult['RecentRaceResult']['place'] ?></span>
				<br>
				<span class = "lastRaceDate"><?php echo date("y.m.d.",strtotime($eachResult["RecentRaceResult"]["race_date"])); ?></span>
				<span class = "lastJockey"><?php echo $eachResult['RecentRaceResult']['jockey'] ?></span>
				<br>
				<span class = "lastOrder">着順:</span>
				<span class = "lastOrderOfArrival <?php if($eachResult['RecentRaceResult']['order_of_arrival']  === "1"){echo "lastRaceWon";}elseif($eachResult['RecentRaceResult']['order_of_arrival'] === "2"){echo "lastRaceSecond";}elseif($eachResult['RecentRaceResult']['order_of_arrival'] ==="3"){echo"lastRaceThird";} ?>"><?php echo $eachResult['RecentRaceResult']['order_of_arrival'] ?></span>
				<span class = "lastCource"><?php echo $eachResult['RecentRaceResult']['cource'] ?></span>
				<span class = "lastBaba"><?php echo $eachResult['RecentRaceResult']['baba'] ?></span>
				<br>
				<span class = "lastNumberOfHead"><?php echo $eachResult['RecentRaceResult']['number_of_heads'] ?>頭</span>
				<span class = "lastPopularity"><?php echo $eachResult['RecentRaceResult']['popularity'] ?>番人気</span>
				</td>
				<?php endif; ?>
			<?php endforeach; ?>
		</tr>
	<?php endforeach;?>

	</table>

	<?php if(!empty($user["id"])):?>
		<?php if(empty($myData)):?>
			<?php echo $this->Form->end('送信');?>
		<?php endif;?>
	<?php else:?>
		<a href="/users/login">ログイン</a>
	<?php endif;?>
</div>
