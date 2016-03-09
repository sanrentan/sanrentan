<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>

<div id="raceDetailTxt">
	<div id="detailLeft">
		<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
		<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?>　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
		<p><?php echo $raceData["Race"]["note"];?></p>
		<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
		<p><a href="http://keiba.yahoo.co.jp/race/result/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース詳細（外部サイト)</a></p>
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
	<p class="titleLabel">払戻金</p>
	<div id="priceArea">
		<div id="leftPriceTable">
			<table border="1">
				<tr><th>単勝</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["tan"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["tan_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["tan_popularity"];?>番人気</td></tr>
				<tr><th rowspan="3">複勝</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["fuku1"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["fuku1_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["fuku1_popularity"];?>番人気</td></tr>
				<tr><td class="r_number"><?php echo $raceResultData["RaceResult"]["fuku2"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["fuku2_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["fuku2_popularity"];?>番人気</td></tr>
				<tr><td class="r_number"><?php echo $raceResultData["RaceResult"]["fuku3"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["fuku3_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["fuku3_popularity"];?>番人気</td></tr>
				<tr><th>枠連</th><td class="r_number"><?php echo $raceResultData["RaceResult"]["wk"];?></td><td><?php echo number_format($raceResultData["RaceResult"]["wk_price"]);?>円</td><td><?php echo $raceResultData["RaceResult"]["wk_popularity"];?>番人気</td></tr>
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

	<p class="titleLabel">競争成績</p>
	<div id="resultListArea">
		<table border="1">
		<tr><th>着順</th><th>枠</th><th>馬番</th><th>馬名</th><th>性齢</th><th>負担重量</th><th>騎手名</th><th class="pc">タイム</th><th class="pc">着差</th><th class="pc">推定上り</th><th class="pc">馬体重</th><th class="pc">調教師名</th><th>単勝人気</th></tr>
		<?php foreach($raceResultData["RaceResultDetail"] as $key=>$data):?>
			<tr>
				<td align="center"><?php if($data["result"]!=99):?><?php echo $data["result"];?><?php else:?>-<?php endif;?></td>
				<td align="center"><span class="wk<?php echo $data['wk'];?>"><?php echo $data["wk"];?></span></td>
				<td align="center"><?php echo $data["uma"];?></td>
				<td align="center"><?php echo $data["name"];?></td>
				<td align="center"><?php echo $data["sexage"];?></td>
				<td align="center"><?php echo $data["j_weight"];?></td>
				<td align="center"><?php echo $data["j_name"];?></td>
				<td align="center" class="pc"><?php echo $data["time"];?></td>
				<td align="center" class="pc"><?php echo $data["difference"];?></td>
				<td align="center" class="pc"><?php echo $data["last_time"];?></td>
				<td align="center" class="pc"><?php echo $data["weight"];?></td>
				<td align="center" class="pc"><?php echo $data["trainer"];?></td>
				<td align="center"><?php if($data["popularity"]!=0):?><?php echo $data["popularity"];?><?php else:?>-<?php endif;?></td>
			</tr>
		<?php endforeach;?>
		</table>
	</div>

	<p class="titleLabel">予想的中者</p>
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
