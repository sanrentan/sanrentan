<p class="titleLabel">マイページ</p>

<div id="mypage">

	<?php echo $this->element('mypageNavi',array("active"=>"index")); ?>

	<div id="resultArea">
		<p>今年の戦績：<?php echo $myResultData["ExpectationResult"]["win"];?>勝<?php echo $myResultData["ExpectationResult"]["lose"];?>敗　収支 <?php if($myResultData["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($myResultData["ExpectationResult"]["price"]);?>円</p>

		<p>レース詳細</p>
		<table border="1" class="pc">
			<tr><th>日付</th><th>レース名</th><th>結果<br>１着/２着/３着</th><th>配当金</th><th>あなたの予想</th><th>結果</th></tr>
			<?php foreach($raceData as $key=>$data):?>
				<tr <?php if($key%2==0):?>class="row2"<?php endif;?>>
					<th><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></th>
					<td><a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?></a></td>
					<td>
						<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
							<span class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][0]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></span> <?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?><br>
							<span class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][1]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></span> <?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?><br>
							<span class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][2]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></span> <?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?>
						<?php else:?>
							結果前
						<?php endif;?>
					</td>
					<td>
						<?php if(!empty($raceResultData[$data['Race']['id']])):?>
							<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円<br>
							<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>人気
						<?php endif;?>
					</td>
					<td>
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
					<td>
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

		<div class="sp_resultArea sp">
			<ul>
				<?php foreach($raceData as $key=>$data):?>
					<li>
						<?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?>
						<a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?>(G<?php echo $data["Race"]["grade"];?>)</a>	
						
						<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
						<p>
							レース結果：<br>
								<span class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][0]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></span> <?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?><br>
								<span class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][1]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></span> <?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?><br>
								<span class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][2]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></span> <?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?>

								<p>配当金：
								<?php if(!empty($raceResultData[$data['Race']['id']])):?>
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>番人気
								<?php endif;?>
								</p>

						</p>
						<?php endif;?>

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

</div>