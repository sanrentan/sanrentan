<?php echo $this->element('mypageNavi',array("active"=>"result","title"=>"過去のレース結果")); ?>
<div id="mainContent">

	<div id="resultArea">
		<?php if(!empty($myResultData)):?>
			<p><?php echo h($year);?>年の戦績：<?php echo $myResultData["ExpectationResult"]["win"];?>勝<?php echo $myResultData["ExpectationResult"]["lose"];?>敗　収支 <?php if($myResultData["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($myResultData["ExpectationResult"]["price"]);?>円</p>
		<?php else:?>
			<p><?php echo h($year);?>年の戦績：まだ予想をしていません</p>
		<?php endif;?>

		<p><a href="/race_result_list">2018年</a>｜<a href="/race_result_list?year=2017">2017年</a>｜<a href="/race_result_list?year=2016">2016年</a></p>

		<p>レース詳細</p>
		<div class="tableArea pc">
			<table border="1">
				<tr><th width="80">日付</th><th>レース名</th><th width="180">結果<br>１着/２着/３着</th><th width="100">配当金</th><th width="150">あなたの予想</th><th width="80">結果</th></tr>
				<?php foreach($raceData as $key=>$data):?>
					<tr <?php if($key%2==0):?>class="row2"<?php endif;?>>
						<th><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></th>
						<td><a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?></a></td>
						<td>
							<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
								<dl>
									<?php if($data["Race"]['id']==97):?>
										<dt></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?></dd>
										<dt></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?></dd>
										<dt></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?></dd>
									<?php else:?>
										<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][0]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?></dd>
										<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][1]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?></dd>
										<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][2]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?></dd>

									<?php endif;?>

								</dl>
								<div class="clearfix"></div>
							<?php else:?>
								結果待ち
							<?php endif;?>
						</td>
						<td align="center">
							<?php if(!empty($raceResultData[$data['Race']['id']])):?>
								<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円<br>
								<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>人気
							<?php else:?>
								結果待ち
							<?php endif;?>
						</td>
						<td align="center">
							<?php if(!empty($myData[$data["Race"]["id"]])):?>
								<?php echo $myData[$data['Race']['id']]['Expectation']['item1_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item2_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item3_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item4_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item5_uma'];?>
							<?php elseif($data["Race"]["accepting_flg"]==1):?>
								<a href="/detail/<?php echo $data['Race']['id'];?>">予想する</a>
							<?php else:?>
								-
							<?php endif;?>
						</td>
						<td align="center">
							<?php if(!empty($myData[$data["Race"]["id"]])):?>
								<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?>
									<span class="winmark">当たり</span>
								<?php elseif($myData[$data["Race"]["id"]]["Expectation"]["result"]==2):?>
									外れ
								<?php else:?>
									結果待ち
								<?php endif;?>
							<?php else:?>
								-
							<?php endif;?>
						</td>
					</tr>
				<?php endforeach;?>
			</table>
		</div>

		<div class="tableArea sp">
			<ul>
				<?php foreach($raceData as $key=>$data):?>
					<li>
						<?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?>
						<a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?>(G<?php echo $data["Race"]["grade"];?>)</a>	

						<p>
							あなたの予想：
							<?php if(!empty($myData[$data["Race"]["id"]])):?>
								<?php echo $myData[$data['Race']['id']]['Expectation']['item1_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item2_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item3_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item4_uma'];?>-
								<?php echo $myData[$data['Race']['id']]['Expectation']['item5_uma'];?>
							<?php elseif($data["Race"]["accepting_flg"]==1):?>
								<a href="/detail/<?php echo $data['Race']['id'];?>">予想する</a>
							<?php else:?>
								-
							<?php endif;?>
						</p>
						
						<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
								<p>レース結果：</p>
								<dl>
									<?php if($data["Race"]['id']==97):?>
										<dt class="wk1"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?></dd>
										<dt class="wk1"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?></dd>
										<dt class="wk1"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?></dd>

									<?php else:?>
										<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][0]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?></dd>
										<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][1]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?></dd>
										<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][2]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?></dd>

									<?php endif;?>

								</dl>
								<div class="clearfix"></div>

								<p>配当金：
								<?php if(!empty($raceResultData[$data['Race']['id']])):?>
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>番人気
								<?php endif;?>
								</p>
						<?php endif;?>

						<p>
							結果：
							<?php if(!empty($myData[$data["Race"]["id"]])):?>
								<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?>
									<span class="winmark">当たり</span>
								<?php elseif($myData[$data["Race"]["id"]]["Expectation"]["result"]==2):?>
									外れ
								<?php else:?>
									結果待ち
								<?php endif;?>
							<?php else:?>
								-
							<?php endif;?>
						</p>



					</li>
				<?php endforeach;?>
			</ul>
		</div>

	</div>

	<div id="rightContent" class="sp">
		<?php echo $this->element('twitter_timeline'); ?>
		<?php //PR ?>
		<?php echo $this->element('pr'); ?>
	</div>
	<div class="clearfix"></div>


</div>