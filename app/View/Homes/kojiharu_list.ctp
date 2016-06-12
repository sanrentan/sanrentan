<div id="mainBannerArea">
	<div id="mainBannerAreaLeft2">
	<p class="titleLabel">こじはる予想一覧</p>
			<img src="/img/common/koji_list.jpg" class="img1" alt="こじはる予想一覧">
	</div>
	<div id="mainBannerAreaRight" class="pc">
		<?php echo $this->element('recentKojiharu'); ?>
	</div>
	<div class="clearfix"></div>
</div>


<div id="mainContent">

	<div id="resultArea">

		<p class="subtitle" style="float:left;"><?php echo $year;?>年の戦績：<?php echo $myResultData["ExpectationResult"]["win"];?>勝<?php echo $myResultData["ExpectationResult"]["lose"];?>敗　収支 <?php if($myResultData["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($myResultData["ExpectationResult"]["price"]);?>円
		</p>
		<p style="float:left;margin-left:20px;">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com/kojiharu_list/" data-text="こじはるさんの３連単予想記録！" data-lang="ja" data-size="large" data-hashtags="３連単予想">ツイート</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</p>
		<div class="clearfix"></div>

		<div class="tableArea">
			<table border="1" class="pc">
				<tr><th>No.</th><th width="80">日付</th><th>レース名</th><th width="180">結果<br>１着/２着/３着</th><th width="100">配当金</th><th width="130">こじはる予想</th><th width="80">結果</th></tr>
				<?php foreach($raceData as $key=>$data):?>
					<tr <?php if($key%2==0):?>class="row2"<?php endif;?>>
						<th><?php echo count($raceData)-$key;?></th>
						<th><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></th>
						<td><a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?>(G<?php echo $data["Race"]["grade"];?>)</a></td>
						<td>
							<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
								<dl>
									<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][0]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?></dd>
									<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][1]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?></dd>
									<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][2]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?></dd>
								</dl>
								<div class="clearfix"></div>
							<?php else:?>
								結果待ち
							<?php endif;?>
						</td>
						<td align="center">
							<?php if(!empty($raceResultData[$data['Race']['id']])):?>
								<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?><span class="red"><?php endif;?>
									<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円
								<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?></span><?php endif;?>
								<br>
								<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>人気
							<?php else:?>
								結果待ち
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



		<div class="sp_resultArea sp">
			<ul>
				<?php foreach($raceData as $key=>$data):?>
					<li>
						<?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?>
						<a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?>(G<?php echo $data["Race"]["grade"];?>)</a>	
						
						<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
								<p>レース結果：</p>
								<dl>
									<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][0]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][0]["name"];?></dd>
									<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][1]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][1]["name"];?></dd>
									<dt class="wk<?php echo $raceResultData[$data['Race']['id']]['RaceResultDetail'][2]['wk'];?>"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["uma"];?></dt><dd class="wkname"><?php echo $raceResultData[$data["Race"]["id"]]["RaceResultDetail"][2]["name"];?></dd>
								</dl>
								<div class="clearfix"></div>

								<p>配当金：
								<?php if(!empty($raceResultData[$data['Race']['id']])):?>
									<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?><span class="red"><?php endif;?>
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円
									<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?></span><?php endif;?>&nbsp;
									<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>番人気
								<?php endif;?>
								</p>
						<?php endif;?>

						<p>
							こじはる予想：
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