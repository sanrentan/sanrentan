<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel pc"><?php echo $raceData["Race"]["full_name"];?><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
			<p class="titleLabel sp"><?php if($raceData["Race"]["grade"]>=1):?> (G<?php echo $raceData["Race"]["grade"];?>)<?php endif;?></p>
			<div id="raceDetailTxt">
				<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
				<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
				<p><?php echo $raceData["Race"]["note"];?></p>
				<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
			</div>
		
			<p style="padding-left:10px;">以下の内容で登録しますか？</p>

			<div id="mainBannerArea">

				<?php echo $this->Form->create('Expectation',array('type' => 'post','action'=>'/complete'));?>
				<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $postData["Expectation"]["race_id"]));?>


				<div class="mainBannerAreaRightDetail confirm1">
					<img src="/img/common/label_your_expect.png" class="label1">
					<div class="recentYourArea">
						<div class="expectArea">
							<dl>
								<?php foreach($selectArray as $key=>$data):?>
									<div class="expect">
										<dt class="wk1"><?php echo $data["uma"];?></dt><dd class="wkname"><?php echo $data["name"];?></dd>
										<?php echo $this->Form->hidden('item][',array("value"=>$data["id"]));?>
									</div>
								<?php endforeach;?>
							</dl>
							<div class="clearfix"></div>
						</div>
					</div>
					<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
					<div class="clearfix"></div>
				</div>

				<?php if(!empty($kojiharuData)):?>
				<div class="mainBannerAreaRightDetail confirm2">
					<img src="/img/common/label_kojiharu_expect.png" class="label1">
					<div class="recentYourArea">
						<div class="expectArea">
							<dl>
								<?php foreach($kojiharuData["selectData"] as $key=>$data):?>
									<div class="expect">
										<dt class="wk1"><?php echo $data['RaceCard']["uma"];?></dt><dd class="wkname"><?php echo $data['RaceCard']["name"];?></dd>
									</div>
								<?php endforeach;?>
							</dl>
							<div class="clearfix"></div>
						</div>
					</div>
					<!--<div id="subBannerArea" style="float:right; padding-right:10px;padding-top:20px;"><img src="/img/common/umairasto.png" style="max-width:90px;"></div>-->
					<div class="clearfix"></div>
				</div>
				<?php endif;?>
				<div class="clearfix"></div>


				<div class="buttonArea">
					<ul>
							<li>
								<input type="image" src="/img/button/btn_regist_end.png" class="web_btn pc">
								<input type="submit" class="btn btn-primary btn-block-sp sp" value="登録する">
							</li>
						<li><?php echo $this->Form->button('戻る',array('onclick'=>'history.back()','class'=>"btn btn-block-sp"));?></li>
					</ul>
					<?php echo $this->Form->end();?>
					<div class="clearfix"></div>
				</div>
					
			</div>


		</div>
	</div>
	<div class="clearfix"></div>
</div>



