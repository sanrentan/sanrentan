<div id="mainBannerArea">
	<?php if($isSp):?>
		<div class="sp">
			<?php //広告 ?>
			<?php echo $this->element('ad'); ?>
		</div>
	<?php endif;?>

	<?php if(!$isSp):?>
		<div id="mainBannerAreaLeft2">
			<p class="titleLabel">こじはる予想一覧</p>
			<img src="/img/common/koji_list.jpg" class="img1" alt="こじはる予想一覧">
		</div>
	<?php endif;?>

	<p class="titleLabel sp">こじはる最新予想</p>
	<div id="mainBannerAreaRight">
		<?php echo $this->element('recentKojiharu'); ?>
	</div>

	<?php //広告 ?>
	<?php if($isSp):?>
		<div class="sp">
			<?php echo $this->element('adMini'); ?>
		</div>
	<?php endif;?>

	<div class="clearfix"></div>
</div>

<?php if(!$isSp):?>
	<div class="pc">
		<?php //広告よこなが ?>
		<?php echo $this->element('adWidth'); ?>
	</div>
<?php endif;?>


<div id="mainContent">

	<p class="titleLabel sp">こじはる予想一覧</p>
	<div id="resultArea">

		<h3 class="subtitle" style="float:left;"><?php echo $year;?>年の戦績：<?php echo $myResultData["ExpectationResult"]["win"];?>勝<?php echo $myResultData["ExpectationResult"]["lose"];?>敗　収支 <?php if($myResultData["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($myResultData["ExpectationResult"]["price"]);?>円
		</h3>
		<p style="float:left;margin-left:20px;" class="pc">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com/kojiharu_list/" data-text="こじはるさんの３連単予想記録！" data-lang="ja" data-size="large" data-hashtags="３連単予想">ツイート</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</p>
		<div class="clearfix"></div>

		<div class="tableArea pc">
			<table border="1" class="pc">
				<tr><th>No.</th><th width="80">日付</th><th>レース名</th><th width="180">結果<br>１着/２着/３着</th><th width="100">配当金</th><th width="180">こじはる予想</th><th width="80">結果</th></tr>
				<?php foreach($raceData as $key=>$data):?>
					<tr <?php if($key%2==0):?>class="row2"<?php endif;?>>
						<th><?php echo count($raceData)-$key;?></th>
						<th><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></th>
						<td><a href="/result/<?php echo $data['Race']['id'];?>"><?php echo $data["Race"]["full_name"];?>(G<?php echo $data["Race"]["grade"];?>)</a></td>
						<td>
							<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
								<dl>
									<?php if($data['Race']['id']==97):?>

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
								<dl>
									<?php if($data['Race']['id']==97):?>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_name'];?></dd>


									<?php else:?>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item1_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item2_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item3_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item4_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item5_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_name'];?></dd>

									<?php endif;?>
								</dl>
								<div class="clearfix"></div>
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
							こじはる予想：
							<?php if(!empty($myData[$data["Race"]["id"]])):?>
								<dl>
									<?php if($data['Race']['id']==97):?>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_name'];?></dd>
										<dt class="wk1"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_name'];?></dd>

									<?php else:?>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item1_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item1_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item2_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item2_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item3_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item3_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item4_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item4_name'];?></dd>
										<dt class="wk<?php echo $myData[$data['Race']['id']]['Expectation']['item5_wk'];?>"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_uma'];?></dt><dd class="wkname"><?php echo $myData[$data['Race']['id']]['Expectation']['item5_name'];?></dd>

									<?php endif;?>

								</dl>
								<div class="clearfix"></div>
							<?php elseif($data["Race"]["accepting_flg"]==1):?>
								<a href="/detail/<?php echo $data['Race']['id'];?>">予想する</a>
							<?php else:?>
								-
							<?php endif;?>
						</p>

						
						<?php if(!empty($raceResultData[$data["Race"]["id"]])):?>
								<p style="margin-top:25px;font-size:100%;">レース結果：</p>
								<dl>
									<?php if($data['Race']['id']==97):?>
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
									<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?><span class="red"><?php endif;?>
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円
									<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?></span><?php endif;?>&nbsp;
									<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_popularity"]);?>番人気
								<?php endif;?>
								</p>
						<?php endif;?>

						<p>
							こじはる結果：
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

		<?php if($year==2017):?>
			<p style="margin-top:10px;">2016年の結果は<a href="/kojiharu_list/2016" style="text-decoration:underline;">こちら</a></p>
		<?php else:?>
			<p style="margin-top:10px;">2017年の結果は<a href="/kojiharu_list/2017" style="text-decoration:underline;">こちら</a></p>
			<p style="margin-top:10px;">2016年の結果は<a href="/kojiharu_list/2016" style="text-decoration:underline;">こちら</a></p>
		<?php endif;?>
	</div>

	<div id="rightContent" class="sp">

		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
		<?php //広告正方形 ?>
		<?php echo $this->element('pr'); ?>

	</div>
	<div class="clearfix"></div>

</div>


<?php if(!$isSp):?>
	<div class="pc">
		<?php //広告よこなが ?>
		<?php echo $this->element('adWidth'); ?>
	</div>
<?php endif;?>