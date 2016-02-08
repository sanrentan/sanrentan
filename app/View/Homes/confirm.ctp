<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)</p>

<div id="raceDetailTxt">
	<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
	<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
	<p><?php echo $raceData["Race"]["note"];?></p>
	<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
</div>

<div id="confirmArea">
	<p>以下の内容で登録しますか？</p>

	<?php echo $this->Form->create('Expectation',array('type' => 'post','action'=>'/complete'));?>
	<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $postData["Expectation"]["race_id"]));?>
	<div class="confirmSelect">
		<ul class="selectList">
			<p id="myList">あなたの予想</p>
			<?php foreach($selectArray as $key=>$data):?>
				<li><span class="wk<?php echo $data['wk'];?>"><?php echo $data["uma"];?></span> <?php echo $data["name"];?></li>
				<?php echo $this->Form->hidden('item][',array("value"=>$data["id"]));?>
			<?php endforeach;?>
		</ul>
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

	<div class="buttonArea">
		<ul>
			<li><?php echo $this->Form->button('戻る',array('onclick'=>'history.back()','class'=>"btn"));?></li>
			<li><input type="submit" class="btn btn-primary" value="登録する"></li>
		</ul>
		<?php echo $this->Form->end();?>
		<div class="clearfix"></div>
	</div>
		
</div>
