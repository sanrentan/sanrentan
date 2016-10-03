<div id="mainBannerArea">

	<div class="sp" style="margin-bottom:20px;">
		<script type="text/javascript">
		var nend_params = {"media":41672,"site":225960,"spot":644213,"type":1,"oriented":1};
		</script>
		<script type="text/javascript" src="https://js1.nend.net/js/nendAdLoader.js"></script>
	</div>

	<div class="mainBannerAreaLeftDetail">

		<p class="titleLabel pc"><?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
		<p class="titleLabel sp"><?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
		<p id="list_result">
			<?php if(!empty($raceResultData)):?>
				<img src="/img/button/btn_race_list.png">
				<a href="/result/<?php echo $raceData['Race']['id'];?>"><img src="/img/button/btn_race_result2.png"></a>
			<?php endif;?>
		</p>

		<div id="detailInfoText">
			<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?> <?php echo $raceData["Race"]["place"];?> シャンティイ競馬場</p>
			<p><?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?>　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
			<p><?php echo $raceData["Race"]["note"];?></p>
			<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?> (日本時間)</p>
			<p><a href="http://www.jra.go.jp/keiba/overseas/" target="_blank">レース詳細（外部サイト)</a></p>
			<p class="red2"><?php if($timeOver):?>予想受付が終了しました。<?php elseif(!$raceData["Race"]["accepting_flg"]):?>受付開始までお待ちください<?php elseif(empty($myData)):?>下記出走表から５頭選択してください。<?php else:?>既に予想を登録済みです。<?php endif;?></p>
			<?php if(!$timeOver&&empty($user)):?><p class="red2">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p><?php endif;?>
			<?php if(!empty($errorMessage)):?><p class="red2"><?php echo $errorMessage;?></p><?php endif;?>
			<p style="font-size:80%;">※馬体重の発表はありません。
			※単勝オッズはリアルタイム更新ではない為ご注意ください。</p>
		</div>
	</div>
	<div class="mainBannerAreaRightDetail pc">
		<img src="/img/common/label_your_expect.png" class="label1">
		<div class="recentYourArea">
			<div class="expectArea">
				<?php if(!empty($myData["selectData"])):?>
					<dl>
						<?php foreach($myData["selectData"] as $key=>$data):?>
							<div class="expect">
								<dt class="wk1"><?php echo $data["RaceCard"]["uma"];?></dt><dd class="wkname"><?php echo $data["RaceCard"]["name"];?></dd>
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

	<?php if($raceData['Race']['kojiharu_flg']==1 && !empty($raceData['Race']['note2'])):?>
		<div class="mainBannerAreaLeftDetail type2">
			<p class="titleLabel">こじはるさんの３連単５頭ボックス</p>
			<div id="note2">
				<p><?php echo nl2br($raceData['Race']['note2']);?></p>
			</div>
		</div>
		<div class="mainBannerAreaRightDetail type2">
			<h2><img src="/img/common/label_kojiharu_expect2.png" class="label1" alt="AKBこじはるの競馬予想"></h2>			
			<div class="recentYourArea">
				<div class="expectArea">
					<?php if(!empty($kojiharuData["selectData"])):?>
						<dl>
							<?php foreach($kojiharuData["selectData"] as $key=>$data):?>
								<div class="expect">
									<dt class="wk1"><?php echo $data["RaceCard"]["uma"];?></dt><dd class="wkname"><?php echo $data["RaceCard"]["name"];?></dd>
								</div>
							<?php endforeach;?>
						</dl>
						<div class="clearfix"></div>
					<?php endif;?>
				</div>
			</div>
			<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
			<div class="clearfix"></div>

		</div>
		<div class="clearfix"></div>
	<?php endif;?>

	<?php //広告 ?>
	<div class="sp">
		<?php echo $this->element('adMini'); ?>
	</div>


</div>


<div class="pc">
		<?php //広告よこなが ?>
	<?php echo $this->element('adWidth'); ?>
</div>


<div id="mainContent">
	<div id="horseListArea">
		<h3 class="subtitle" style="font-size:120%;font-weight:bold;">出走表：<?php echo $raceData['Race']['name'];?></h3>

		<?php echo $this->Form->create('Expectation',array('type' => 'post','name'=>"ExpectationDetailForm"));?>
		<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $raceData["Race"]["id"]));?>

		<div class="tableArea raceListTable">
			<table border="1">
				<tr><?php if(!$timeOver&&!empty($user)&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?><th>選択</th><?php endif;?><th>馬番</th><th>馬名</th><th>性齢</th><th>負担重量/<br>騎手名</th><th>単勝オッズ<br>人気</th><th class="pc">前走</th><th class="pc">前々走</th><th class="pc">3走前</th><th class="pc">4走前</th><th>ゲート</th></tr>
				<?php foreach($raceData["RaceCard"] as $key=>$data):?>
					<tr>
						<?php if(!$timeOver&&!empty($user)&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?><td align="center"><input type="checkbox" name="data[Expectation][item][]" value="<?php echo $data['id'];?>" <?php if(!empty($this->request->data['Expectation']['item'])&&in_array($data['id'],$this->request->data['Expectation']['item'])):?>checked<?php endif;?>></td><?php endif;?>
						<td align="center"><?php if($data["uma"]>0):?><?php echo $data["uma"];?><?php else:?>-<?php endif;?></td>
						<td><span class='horseName'><?php echo $data["name"];?></span></td>
						<td align="center"><span class='sexage'><?php echo $data["sexage"];?></span></td>
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
							<td align="center" class="pc">-</td><td align="center" class="pc">-</td><td align="center" class="pc">-</td><td align="center" class="pc">-</td>
						<?php endif; ?>
						<?php if($data["wk_flg"]):?>
							<td rowspan="<?php echo $raceData['wkData'][$data['wk']];?>" class="wk1_pre" align="center"><?php if($data["wk"]>0):?><?php echo $data["wk"];?><?php else:?>-<?php endif;?></td>
						<?php endif;?>
					</tr>
				<?php endforeach;?>

			</table>

			<?php if(!empty($user["id"])):?>	
				<?php if(!$timeOver&&empty($myData)&&$raceData["Race"]["accepting_flg"]):?>
					<p style="padding:10px 0 0 25px;" class="pc"><input type="image" src="/img/button/btn_expect.png" class="web_btn"></p>
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
			<div class="mainContent2 detailpage">

				<?php if(!empty($otherExpectData)):?>
					<div id="userListArea">
					<?php foreach($otherExpectData as $key=>$data):?>
						<a href="/other/<?php echo $data['User']['id'];?>">
							<div class="userExpect type<?php echo $key%3;?> sp_type<?php echo $key%2;?>">
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
										<?php for($i=0;$i<5;$i++):?>
											<?php 
											$tmpName = $data['selectData'][$i]['RaceCard']['name'];
											$tmpName = explode('(', $tmpName);
											$tmpName = $tmpName[0];
											if (mb_strlen($tmpName) > 9) {	
										    	$tmpName = mb_substr($tmpName, 0, 9, 'UTF-8').'..';
										    }
										    ?>

											<dt class="wk1"><?php echo $data["selectData"][$i]["RaceCard"]["uma"];?></dt><dd class='wkname'><?php echo $tmpName;?></dd>

										<?php endfor;?>

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

		<?php //PR ?>
		<?php echo $this->element('pr'); ?>

	</div>
	<div class="clearfix"></div>

</div>
