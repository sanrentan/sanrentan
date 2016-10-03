<div id="mainBannerArea">
	<div class="mainBannerAreaLeftDetail">
		<p class="titleLabel"><?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
		<p id="list_result">
			<a href="/detail/<?php echo $raceData['Race']['id'];?>"><img src="/img/button/btn_race_list2.png"></a>
			<img src="/img/button/btn_race_result.png">
		</p>
		<div id="detailInfoText">
			<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
			<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?>　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
			<p><?php echo $raceData["Race"]["note"];?></p>
			<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
			<p><a href="http://keiba.yahoo.co.jp/race/result/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース結果詳細（外部サイト)</a></p>
			<?php if(empty($user)):?><p class="red2">※予想をするためには<a href="/login">ログイン</a>または<a href="/regist">無料会員登録</a>を行ってください。</p><?php endif;?>
			<?php if(!empty($errorMessage)):?><p class="red2"><?php echo $errorMessage;?></p><?php endif;?>
		</div>
	</div>
	<?php if(!empty($kojiharuData)):?>
		<div class="mainBannerAreaRightDetail">
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
					<?php else:?>
						予想をしていません。
					<?php endif;?>
				</div>
			</div>
			<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>

	<?php else:?>
		<?php if(empty($myData["selectData"])):?>
			<div class="pc">
		<?php endif;?>
			<div class="mainBannerAreaRightDetail">
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
							予想をしていません。
						<?php endif;?>
					</div>
				</div>
				<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
			</div>

		<?php if(empty($myData["selectData"])):?>
			</div>
		<?php endif;?>
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

		<h3 class="titleLabel full">払戻金</h3>
		<div class="tableArea" style="margin-bottom:20px;">
			<div id="priceArea">
				<div id="leftPriceTable">
					<table border="1">
						<tr><th>単勝</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["tan"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["tan_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["tan_popularity"];?>番人気</td></tr>
						<tr><th rowspan="3">複勝</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["fuku1"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["fuku1_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["fuku1_popularity"];?>番人気</td></tr>
						<tr><td class="r_number"><?php echo $raceResultData["RaceResult"]["fuku2"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["fuku2_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["fuku2_popularity"];?>番人気</td></tr>
						<tr><td class="r_number"><?php echo $raceResultData["RaceResult"]["fuku3"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["fuku3_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["fuku3_popularity"];?>番人気</td></tr>
						<tr><th>枠連</th><td class="r_number">-</td><td>-</td><td>-</td></tr>
						<tr><th>馬連</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["uma"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["uma_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["uma_popularity"];?>番人気</td></tr>
					</table>
				</div>
				<div id="rightPriceTable">
					<table border="1">
						<tr><th rowspan="3">ワイド</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["wide1"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["wide1_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["wide1_popularity"];?>番人気</td></tr>
						<tr><td class="r_number"><?php echo $raceResultData["RaceResult"]["wide2"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["wide2_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["wide2_popularity"];?>番人気</td></tr>
						<tr><td class="r_number"><?php echo $raceResultData["RaceResult"]["wide3"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["wide3_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["wide3_popularity"];?>番人気</td></tr>
						<tr><th>馬単</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["umatan"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["umatan_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["umatan_popularity"];?>番人気</td></tr>
						<tr><th>3連複</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["sanrenpuku"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["sanrenpuku_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["sanrenpuku_popularity"];?>番人気</td></tr>
						<tr><th>3連単</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["sanrentan"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["sanrentan_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["sanrentan_popularity"];?>番人気</td></tr>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<h3 class="titleLabel full">競争成績</h3>
		<div class="tableArea">

			<div id="resultListArea">
				<table border="1">
				<tr><th>着順</th><th>ゲート</th><th>馬番</th><th>馬名</th><th>性齢</th><th>負担重量<br>騎手名</th><th class="pc">タイム</th><th class="pc">着差</th><th class="pc">推定上り</th><th class="pc">馬体重</th><th class="pc">調教師名</th><th>単勝人気</th></tr>
				<?php foreach($raceResultData["RaceResultDetail"] as $key=>$data):?>
					<tr>
						<td align="center"><?php if($data["result"]!=99):?><?php echo $data["result"];?><?php else:?>-<?php endif;?></td>
						<td align="center"><span class="wk1"><?php echo $data["wk"];?></span></td>
						<td align="center"><?php echo $data["uma"];?></td>
						<td align="left"><span class='horseName'><?php echo $data["name"];?></span></td>
						<td align="center"><span class='sexage'><?php echo $data["sexage"];?></span></td>
						<td align="center"><span class='jName'><?php echo $data["j_weight"];?><br><?php echo $data["j_name"];?></span></td>
						<td align="center" class="pc"><?php echo $data["time"];?></td>
						<td align="center" class="pc"><?php echo $data["difference"];?></td>
						<td align="center" class="pc"><?php echo $data["last_time"];?></td>
						<td align="center" class="pc"><?php echo $data["weight"];?></td>
						<td align="center" class="pc"><?php echo $data["trainer"];?></td>
						<td align="center"><span class='odds'><?php if($data["popularity"]!=0):?><?php echo $data["popularity"];?><?php else:?>-<?php endif;?></span></td>
					</tr>
				<?php endforeach;?>
				</table>
			</div>


		</div>
	</div><!--#hourseList-->

	<div id="leftContent">
		<div id="userArea">
			<h3 class="titleLabel" style="margin-bottom:10px;">予想的中者</h3>
			<div id="winUserArea">
				<?php if(!empty($winUser)):?>
					<?php foreach($winUser as $key=>$data):?>
						<a href="/other/<?php echo $data['User']['id'];?>">
							<div class="winUser">
								<div class="profileLeft">
									<?php if(!empty($data["User"]["profile_img"])):?>
										<img src="/img/profileImg/<?php echo $data['User']['profile_img'];?>" class="profileImg">
									<?php else:?>
										<img src="/img/common/noimage_person.png" class="profileImg">
									<?php endif;?>
								</div>
								<div class="profileRight">
									<p>
										<?php echo $data["User"]["nickname"];?>
										<?php if(!empty($data["User"]["span"])):?>
											<br>(競馬歴：<?php echo $data["User"]["span"];?>)
										<?php endif;?>
									</p>
								</div>
							</div>
						</a>
						<?php if(($key+1)%6==0):?>
						<?php endif;?>
					<?php endforeach;?>
					<div class="clearfix"></div>
				<?php else:?>
					<p>残念ながら本サイトからは当選者はいませんでした。</p>
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

