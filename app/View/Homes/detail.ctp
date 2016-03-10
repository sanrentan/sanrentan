<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
<!-- <pre>
	<?php //print_r($recentRaceResult[153][0]['RecentRaceResult']);exit; ?>
</pre> -->

<div id="raceDetailTxt">
	<div id="detailLeft">
		<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
		<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?>　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
		<p><?php echo $raceData["Race"]["note"];?></p>
		<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
		<p><a href="http://keiba.yahoo.co.jp/race/denma/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース詳細（外部サイト)</a></p>
		<p class="red2"><?php if(!$raceData["Race"]["accepting_flg"]):?>受付開始までお待ちください<?php elseif(empty($myData)):?>下記出走表から５頭選択してください。<?php else:?>既に予想を登録済みです。<?php endif;?></p>
		<?php if(empty($user)):?><p class="red2">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p><?php endif;?>
		<?php if(!empty($errorMessage)):?><p class="red2"><?php echo $errorMessage;?></p><?php endif;?>
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

<?php echo $this->Form->create('Expectation',array('type' => 'post','name'=>"ExpectationDetailForm"));?>
<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $raceData["Race"]["id"]));?>
<div id="horseListArea">
	<table border="1">
	<tr><?php if(!empty($user)&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?><th>選択</th><?php endif;?><th>枠番</th><th>馬番</th><th>馬名</th><th>性齢</th><th>馬体重</th><th>負担重量/<br>騎手名</th><th class="pc">前走</th><th class="pc">前々走</th><th class="pc">3走前</th><th class="pc">4走前</th><th class="pc">5走前</th></tr>
	<?php foreach($raceData["RaceCard"] as $key=>$data):?>
		<tr>
			<?php if(!empty($user)&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?><td align="center"><input type="checkbox" name="data[Expectation][item][]" value="<?php echo $data['id'];?>" <?php if(!empty($this->request->data['Expectation']['item'])&&in_array($data['id'],$this->request->data['Expectation']['item'])):?>checked<?php endif;?>></td><?php endif;?>
			<?php if($data["wk_flg"]):?>
				<td rowspan="<?php echo $raceData['wkData'][$data['wk']];?>" class="wk<?php echo $data['wk'];?>" align="center"><?php if($data["wk"]>0):?><?php echo $data["wk"];?><?php else:?>-<?php endif;?></td>
			<?php endif;?>
			<td align="center"><?php if($data["uma"]>0):?><?php echo $data["uma"];?><?php else:?>-<?php endif;?></td>
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
			<?php if(isset($recentRaceResult[$data['id']])): ?>
				<?php foreach($recentRaceResult[$data['id']] as $key=>$eachResult): ?>
					<td class = "pc recentResults <?php if($eachResult['order_of_arrival']==1):?>first<?php elseif($eachResult['order_of_arrival']==2):?>second<?php elseif($eachResult['order_of_arrival']==3):?>third<?php endif;?>">
					<span class = "lastRaceDate"><?php echo date("y.m.d.",strtotime($eachResult["race_date"])); ?></span>
					<span class = "lastRacePlace"><?php echo $eachResult['place'] ?></span>
					<br>
					<?php if(strstr($eachResult['race_name'],"(")):?>
						<?php $tmp = explode("(", $eachResult["race_name"]);?>
						<span class = "lastRaceName"><?php echo $tmp[0];?></span>
						<?php $tmp = explode(")", $tmp[1]);?>
							<?php if($tmp[0]=="GI"):?>
								<span class="g1"><?php echo $tmp[0];?></span>
							<?php elseif($tmp[0]=="GII"):?>
								<span class="g2"><?php echo $tmp[0];?></span>
							<?php elseif($tmp[0]=="GIII"):?>
								<span class="g3"><?php echo $tmp[0];?></span>
							<?php endif;?>

					<?php else:?>
						<span class = "lastRaceName"><?php echo $eachResult['race_name'] ?></span>
					<?php endif;?>
					<br>
					<span class = "lastOrderOfArrival <?php if($eachResult['order_of_arrival']  === "1"){echo "lastRaceWon";}elseif($eachResult['order_of_arrival'] === "2"){echo "lastRaceSecond";}elseif($eachResult['order_of_arrival'] ==="3"){echo"lastRaceThird";} ?>"><?php if($eachResult['order_of_arrival']==0):?>取消<?php else:?><?php echo $eachResult['order_of_arrival'] ?><?php endif;?></span>
					&nbsp;
					<span class = "lastNumberOfHead"><?php echo $eachResult['number_of_heads'] ?>頭</span>
					<span class = "lastPopularity"><?php echo $eachResult['popularity'] ?>番人気</span>
					<br>

					<span class = "lastJockey"><?php echo $eachResult['jockey'] ?></span>
					<br>
					<span class = "lastCource"><?php echo $eachResult['cource'] ?></span>
					<span class = "lastBaba"><?php echo $eachResult['baba'] ?></span>
					<br>
					</td>
				<?php endforeach; ?>
				<?php if(count($recentRaceResult[$data['id']]) < 5): ?>
					<?php for($i = count($recentRaceResult[$data['id']]); $i < 5 ; $i++): ?>
						<td align="center" class="pc">-</td>
					<?php endfor; ?>
				<?php endif; ?>
			<?php else: ?>
				<td align="center">-</td><td align="center">-</td><td align="center">-</td><td align="center">-</td><td align="center">-</td>
			<?php endif; ?>
		</tr>
	<?php endforeach;?>

	</table>

	<?php if(!empty($user["id"])):?>
		<?php if(empty($myData)&&$raceData["Race"]["accepting_flg"]):?>
			<p style="padding:10px 0 0 25px;" class="pc"><input type="submit" class="btn btn-primary" value="予想する"></p>
			<p class="sp"><input type="submit" class="btn btn-primary btn-block-sp" value="予想する"></p>
			<?php echo $this->Form->end();?>
		<?php endif;?>
	<?php else:?>
		<p class="red" style="padding:20px 0 0 20px;font-size:120%;">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p>
	<?php endif;?>
</div>

<p class="titleLabel">みんなの予想</p>
<?php if(!empty($otherExpectData)):?>
	<div id="userListArea">
	<?php foreach($otherExpectData as $key=>$data):?>
		<a href="/other/<?php echo $data['User']['id'];?>">
			<div class="userExpect">
				<?php if(!empty($data["User"]["profile_img"])):?>
					<img src="/img/profileImg/<?php echo $data['User']['profile_img'];?>" class="profileImg">
				<?php else:?>
					<img src="/img/common/noimage_person.png" class="profileImg">
				<?php endif;?>
				<p><?php echo $data["User"]["nickname"];?></p>
				<p>
					<span class="wk<?php echo $data["selectData"][0]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][0]["RaceCard"]["uma"];?></span>-
					<span class="wk<?php echo $data["selectData"][1]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][1]["RaceCard"]["uma"];?></span>-
					<span class="wk<?php echo $data["selectData"][2]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][2]["RaceCard"]["uma"];?></span>-
					<span class="wk<?php echo $data["selectData"][3]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][3]["RaceCard"]["uma"];?></span>-
					<span class="wk<?php echo $data["selectData"][4]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][4]["RaceCard"]["uma"];?></span>
					</p>
			</div>
		</a>
	<?php endforeach;?>
	<div class="clearfix"></div>
<?php else:?>
	<p style="padding-left:20px;">まだ予想がありません</p>
<?php endif;?>

