<script type="text/javascript">

		function add_favorite(user_id){
			$(".favo_btn").css('display', 'none');
			$(".favo_send").css('display', 'block');
		    $.ajax({
		        url:  "<?php echo $this->Html->url(array('controller' =>'homes','action' => 'favorite_add'));?>",
		        type: "POST",
		        data: { other_user_id : user_id },
		        dataType: "json",
		        success : function(data){
		            //通信成功時の処理
		            if(data.status=="ok"){
						$(".favo_end").css('display', 'block');
						$(".favo_send").css('display', 'none');
		            }else if(data.status=="already"){
		            	alert("すでにお気に入りに登録済みのユーザーです。")
						$(".favo_end").css('display', 'block');
						$(".favo_send").css('display', 'none');
		            }else if(data.status=="non-member"){
		            	alert("お気に入りに登録するためには会員登録が必要です。")
						$(".favo_btn").css('display', 'block');
						$(".favo_send").css('display', 'none');
		            }else{
			            alert('通信失敗');
		            }
		        },
		        error: function(response){
		            //通信失敗時の処理
		            alert('通信失敗');
		        }
		    });
		}

		function delete_favorite(user_id){
			$(".favo_end").css('display', 'none');
			$(".favo_send").css('display', 'block');
		    $.ajax({
		        url:  "<?php echo $this->Html->url(array('controller' =>'homes','action' => 'favorite_delete'));?>",
		        type: "POST",
		        data: { other_user_id : user_id },
		        dataType: "json",
		        success : function(data){
		            //通信成功時の処理
		            if(data.status=="ok"){
						$(".favo_btn").css('display', 'block');
						$(".favo_send").css('display', 'none');
		            }else{
			            alert('通信失敗');
		            }
		        },
		        error: function(response){
		            //通信失敗時の処理
		            alert('通信失敗');
		        }
		    });
		}


</script>


<div id="mainBannerArea">

	<div class="mypageAd">
		<div class="pc">
			<?php //広告よこなが ?>
			<?php echo $this->element('adWidth'); ?>
		</div>
		<div class="sp">
			<?php //広告mini ?>
			<?php echo $this->element('adMini'); ?>
		</div>
	</div>

	<div id="mainBannerAreaLeft2">
		<p class="titleLabel"><?php echo $otherUser["User"]["nickname"];?>さんの予想記録</p>
		<div id="profileArea">
			<div id="profileLeft">
				<?php if(!empty($otherUser["User"]["profile_img"])):?>
					<img src="/img/profileImg/<?php echo $otherUser['User']['profile_img'];?>">
				<?php else:?>
					<img src="/img/common/noimage_person.png">
				<?php endif;?>
			</div>
			<div id="profileRight">
				<p class="nickname">ニックネーム：<?php echo $otherUser["User"]["nickname"];?></p>
				<p class="keibareki">競馬歴：<?php if(!empty($otherUser["User"]["span"])):?><?php echo $otherUser["User"]["span"];?><?php else:?>未登録<?php endif;?></p>
				<p class="favorite">好きな馬：<?php if(!empty($otherUser["User"]["favorite"])):?><?php echo $otherUser["User"]["favorite"];?><?php else:?>未登録<?php endif;?></p>
			</div>
			<?php if(empty($user)||$user["id"]!=$otherUser["User"]["id"]):?>
				<div id="profileFavo">
					<p class="favo_btn" <?php if($favoFlg):?>style="display:none;"<?php endif;?>><a href="#" onclick="add_favorite(<?php echo $otherUser['User']['id'];?>);return false;" class="btn btn-danger">お気に入りに登録する</a>	
					<p class="favo_send" style="display:none;"><a href="#" class="btn btn-info" >送信中..</a></p>
					<p class="favo_end" <?php if(!$favoFlg):?>style="display:none;"<?php endif;?>><a href="#" onclick="delete_favorite(<?php echo $otherUser['User']['id'];?>);return false;" class="btn btn-warning" >お気に入り登録済み</a></p>
				</div>
			<?php endif;?>
			<div class="clearfix"></div>
			<div id="messageArea">
				<p class="message">自己紹介：<br><?php if(!empty($otherUser["User"]["message"])):?><?php echo nl2br(h($otherUser["User"]["message"]));?><?php else:?>未登録<?php endif;?></p>
			</div>
		</div>

	</div>
	<div id="mainBannerAreaRight" class="pc">
		<?php echo $this->element('recentKojiharu'); ?>
	</div>
	<div class="clearfix"></div>
</div>

<div id="mainContent">

	<div id="resultArea">
		<?php if(!empty($myResultData)):?>
			<p class="subtitle"><?php echo $year;?>年の戦績：<?php echo $myResultData["ExpectationResult"]["win"];?>勝<?php echo $myResultData["ExpectationResult"]["lose"];?>敗　収支 <?php if($myResultData["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($myResultData["ExpectationResult"]["price"]);?>円</p>

			<p><a href="/other/<?php echo $otherUser['User']['id'];?>">2017年</a>｜<a href="/other/<?php echo $otherUser['User']['id'];?>?year=2016">2016年</a></p>

			<div class="tableArea pc">
				<table border="1">
					<tr><th>No.</th><th width="80">日付</th><th>レース名</th><th width="180">結果<br>１着/２着/３着</th><th width="100">配当金</th><th width="130">予想</th><th width="80">結果</th></tr>
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
									結果前
								<?php endif;?>
							</td>
							<td>
								<?php if(!empty($raceResultData[$data['Race']['id']])):?>
									<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?><span class="red"><?php endif;?>
										<?php echo number_format($raceResultData[$data['Race']['id']]["RaceResult"]["sanrentan_price"]);?>円
									<?php if($myData[$data["Race"]["id"]]["Expectation"]["result"]==1):?></span><?php endif;?>
									<br>
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

			</div>


			<div class="tableArea sp">
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
								予想：
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

		<?php else:?>
			<p><?php echo $year;?>年のレースの予想をしていません。</p>
			<p><a href="/other/<?php echo $otherUser['User']['id'];?>">2017年</a>｜<a href="/other/<?php echo $otherUser['User']['id'];?>?year=2016">2016年</a></p>

		<?php endif;?>
	</div>
	<div id="rightContent" class="sp">
		<?php //ranking ?>
		<?php echo $this->element('ranking'); ?>
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
		<?php //PR ?>
		<?php echo $this->element('pr'); ?>
	</div>
	<div class="clearfix"></div>

</div>