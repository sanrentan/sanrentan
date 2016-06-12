<div id="mainBannerArea">
	<div id="mainBannerAreaLeftDetail">
		<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
		<div id="detailInfoText">
			<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
			<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?>　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
			<p><?php echo $raceData["Race"]["note"];?></p>
			<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
			<p><a href="http://keiba.yahoo.co.jp/race/denma/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース詳細（外部サイト)</a></p>
			<p class="red2"><?php if($timeOver):?>予想受付が終了しました。<?php elseif(!$raceData["Race"]["accepting_flg"]):?>受付開始までお待ちください<?php elseif(empty($myData)):?>下記出走表から５頭選択してください。<?php else:?>既に予想を登録済みです。<?php endif;?></p>
			<?php if(empty($user)):?><p class="red2">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p><?php endif;?>
			<?php if(!empty($errorMessage)):?><p class="red2"><?php echo $errorMessage;?></p><?php endif;?>
			<p style="font-size:80%;">※単勝オッズはリアルタイム更新ではない為ご注意ください。</p>
		</div>
	</div>
	<div id="mainBannerAreaRightDetail" class="pc">
		<img src="/img/common/label_your_expect.png" class="label1">
		<div id="recentYourArea">
			<div class="expectArea">
				<?php if(!empty($myData["selectData"])):?>
					<dl>
						<?php foreach($myData["selectData"] as $key=>$data):?>
							<div class="expect">
								<dt class="wk<?php echo $data["RaceCard"]['wk'];?>"><?php echo $data["RaceCard"]["uma"];?></dt><dd class="wkname"><?php echo $data["RaceCard"]["name"];?></dd>
							</div>
						<?php endforeach;?>
					</dl>
					<div class="clearfix"></div>
				<?php else:?>
					<?php if($timeOver):?>予想受付が終了しました。<?php elseif(!$raceData["Race"]["accepting_flg"]):?>受付開始までお待ちください<?php elseif(empty($myData)):?>まだ予想をしていません。<br>下記出走表から５頭選択してください。<?php else:?>既に予想を登録済みです。<?php endif;?>
				<?php endif;?>
			</div>
		</div>
		<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
		<div class="clearfix"></div>

	</div>
	<div class="clearfix"></div>
</div>

<!--
<div id="raceDetailTxt">
	<div id="detailLeft">
		<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
		<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?>　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
		<p><?php echo $raceData["Race"]["note"];?></p>
		<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
		<p><a href="http://keiba.yahoo.co.jp/race/denma/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース詳細（外部サイト)</a></p>
		<p class="red2"><?php if($timeOver):?>予想受付が終了しました。<?php elseif(!$raceData["Race"]["accepting_flg"]):?>受付開始までお待ちください<?php elseif(empty($myData)):?>下記出走表から５頭選択してください。<?php else:?>既に予想を登録済みです。<?php endif;?></p>
		<?php if(empty($user)):?><p class="red2">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p><?php endif;?>
		<?php if(!empty($errorMessage)):?><p class="red2"><?php echo $errorMessage;?></p><?php endif;?>
		<p style="font-size:80%;">※単勝オッズはリアルタイム更新ではない為ご注意ください。</p>
	</div>
	<div id="detailRight">
		<div class="confirmSelect">
			<?php if(!empty($myData)):?>
				<ul class="selectList">
					<p id="myList">あなたの予想</p>
					<dl>
						<?php foreach($myData["selectData"] as $key=>$data):?>
							<dt class="wk<?php echo $data["RaceCard"]['wk'];?>"><?php echo $data["RaceCard"]["uma"];?></dt><dd class="wkname"><?php echo $data["RaceCard"]["name"];?></dd>
						<?php endforeach;?>
					</dl>
					<div class="clearfix"></div>
				</ul>
			<?php endif;?>
			<?php if(!empty($kojiharuData)):?>
				<ul class="selectList">
					<p id="kojiharuList">こじはるの予想</p>
					<dl>
						<?php foreach($kojiharuData["selectData"] as $key=>$data):?>
							<dt class="wk<?php echo $data["RaceCard"]['wk'];?>"><?php echo $data["RaceCard"]["uma"];?></dt><dd class="wkname"><?php echo $data["RaceCard"]["name"];?></dd>
						<?php endforeach;?>
					</dl>
					<div class="clearfix"></div>
				</ul>
			<?php endif;?>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="clearfix"></div>
</div>
-->

<div id="mainContent">
	<div id="horseListArea">

		<p class="subtitle" style="font-size:120%;font-weight:bold;">出走表：<?php echo $raceData['Race']['name'];?></p>

		<?php echo $this->Form->create('Expectation',array('type' => 'post','name'=>"ExpectationDetailForm"));?>
		<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $raceData["Race"]["id"]));?>

		<div class="tableArea">
			<table border="1">
				<tr><?php if(!$timeOver&&!empty($user)&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?><th>選択</th><?php endif;?><th>枠番</th><th>馬番</th><th>馬名</th><th>性齢</th><th>馬体重</th><th>負担重量/<br>騎手名</th><th>単勝オッズ<br>人気</th><th class="pc">前走</th><th class="pc">前々走</th><th class="pc">3走前</th><th class="pc">4走前</th></tr>
				<?php foreach($raceData["RaceCard"] as $key=>$data):?>
					<tr>
						<?php if(!$timeOver&&!empty($user)&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?><td align="center"><input type="checkbox" name="data[Expectation][item][]" value="<?php echo $data['id'];?>" <?php if(!empty($this->request->data['Expectation']['item'])&&in_array($data['id'],$this->request->data['Expectation']['item'])):?>checked<?php endif;?>></td><?php endif;?>
						<?php if($data["wk_flg"]):?>
							<td rowspan="<?php echo $raceData['wkData'][$data['wk']];?>" class="wk<?php echo $data['wk'];?>_pre" align="center"><?php if($data["wk"]>0):?><?php echo $data["wk"];?><?php else:?>-<?php endif;?></td>
						<?php endif;?>
						<td align="center"><?php if($data["uma"]>0):?><?php echo $data["uma"];?><?php else:?>-<?php endif;?></td>
						<td><span class='horseName'><?php echo $data["name"];?></span></td>
						<td align="center"><span class='sexage'><?php echo $data["sexage"];?></span></td>
						<td align="center">
							<?php if($data["weight"]>0):?>
								<span class="umaweight"><?php echo $data["weight"];?><br><?php echo $data["plus"];?></span>
							<?php else:?>
								-
							<?php endif;?>
						</td>
						<td align="center"><span class='jName'><?php echo $data["j_weight"];?><br><?php echo $data["j_name"];?></span></td>
						<td align="center"><span class='odds'><?php if(!empty($data['odds'])):?><?php if($data['odds']<10):?><span class="red"><?php endif;?><?php echo $data['odds'];?><?php if($data['odds']<10):?></span><?php endif;?><br><span style="font-size:80%;">(<?php echo $data['ninki'];?>人気)</span><?php else:?>-<?php endif;?></span></td>
						<?php if(isset($recentRaceResult[$data['id']])): ?>
							<?php foreach($recentRaceResult[$data['id']] as $key=>$eachResult): ?>
								<?php if($key<4):?>
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
								<?php endif;?>
							<?php endforeach; ?>
							<?php if(count($recentRaceResult[$data['id']]) < 5): ?>
								<?php for($i = count($recentRaceResult[$data['id']]); $i < 4 ; $i++): ?>
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
				<?php if(!$timeOver&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?>
					<p style="padding:10px 0 0 25px;" class="pc"><input type="submit" class="btn btn-primary" value="予想する"></p>
					<p class="sp"><input type="submit" class="btn btn-primary btn-block-sp" value="予想する"></p>
					<?php echo $this->Form->end();?>
				<?php endif;?>
			<?php else:?>
				<p class="red" style="padding:20px 0 0 20px;font-size:120%;">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p>
			<?php endif;?>
		</div>

	</div>

	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel" style="margin-bottom:5px;">みんなの予想</p>
			<div class="mainContent2">

				<?php if(!empty($otherExpectData)):?>
					<div id="userListArea">
					<?php foreach($otherExpectData as $key=>$data):?>
						<a href="/other/<?php echo $data['User']['id'];?>">
							<div class="userExpect type<?php echo $key%3;?>">
								<div class="profileImgArea">
									<?php if(!empty($data["User"]["profile_img"])):?>
										<img src="/img/profileImg/<?php echo $data['User']['profile_img'];?>" class="profileImg">
									<?php else:?>
										<img src="/img/common/noimage_person.png" class="profileImg">
									<?php endif;?>
								</div>
								<div class="profileDetailArea">
									<p><?php echo $data["User"]["nickname"];?></p>
									<?php if(!empty($data['User']['span'])):?>
										<p>競馬歴:<?php echo $data['User']['span'];?></p>
									<?php endif;?>
									<?php if(!empty($data['ExpectationResult'])):?>
										<p><?php echo $data['ExpectationResult']['win'];?>勝<?php echo $data['ExpectationResult']['lose'];?>敗</p>
									<?php endif;?>
								</div>
								<div class="clearfix"></div>
								<div class="expectArea">
									<dl>
										<dt class="wk<?php echo $data["selectData"][0]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][0]["RaceCard"]["uma"];?></dt><dd class='wkname'><?php echo $data['selectData'][0]['RaceCard']['name'];?></dd>
										<dt class="wk<?php echo $data["selectData"][1]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][1]["RaceCard"]["uma"];?></dt><dd class='wkname'><?php echo $data['selectData'][1]['RaceCard']['name'];?></dd>
										<dt class="wk<?php echo $data["selectData"][2]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][2]["RaceCard"]["uma"];?></dt><dd class='wkname'><?php echo $data['selectData'][2]['RaceCard']['name'];?></dd>
										<dt class="wk<?php echo $data["selectData"][3]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][3]["RaceCard"]["uma"];?></dt><dd class='wkname'><?php echo $data['selectData'][3]['RaceCard']['name'];?></dd>
										<dt class="wk<?php echo $data["selectData"][4]["RaceCard"]["wk"];?>"><?php echo $data["selectData"][4]["RaceCard"]["uma"];?></dt><dd class='wkname'><?php echo $data['selectData'][4]['RaceCard']['name'];?></dd>
									<dl>
									<div class="clearfix"></div>
								</div>
							</div>
						</a>
					<?php endforeach;?>
					</div>
					<div class="clearfix"></div>
				<?php else:?>
					<p style="padding-left:20px;">まだ予想がありません</p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<div id="rightContent">
		<?php //ranking ?>
		<?php echo $this->element('ranking'); ?>

		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
	</div>
	<div class="clearfix"></div>

</div>
