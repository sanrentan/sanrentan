<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)</p>

<div id="raceDetailTxt">
	<div id="detailLeft">
		<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
		<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
		<p><?php echo $raceData["Race"]["note"];?></p>
		<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
		<p><a href="http://keiba.yahoo.co.jp/race/denma/<?php echo $raceData['Race']['html_id'];?>/" target="_blank">レース詳細（外部サイト)</a></p>
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

<?php echo $this->Form->create('Expectation',array('type' => 'post','name' =>'expectation'));?>
<?php echo $this->Form->hidden('Expectation.race_id' ,array('value' => $raceData["Race"]["id"]));?>
<div id="horseListArea">
	<table border="1">
	<tr><?php if(empty($myData)):?><th>選択</th><?php endif;?><th>枠番</th><th>馬番</th><th>馬名</th><th>性齢</th><th>馬体重</th><th>負担重量/騎手名</th></tr
	<?php foreach($raceData["RaceCard"] as $key=>$data):?>
		<tr>
			<?php if(empty($myData)):?><td align="center"><input type="checkbox" name="data[Expectation][item][]" value="<?php echo $data['id'];?>"></td><?php endif;?>
			<?php if($data["wk_flg"]):?>
				<td rowspan="<?php echo $raceData['wkData'][$data['wk']];?>" class="wk<?php echo $data['wk'];?>" align="center"><?php echo $data["wk"];?></td>
			<?php endif;?>
			<td align="center"><?php echo $data["uma"];?></td>
			<td><?php echo $data["name"];?></td>
			<td align="center"><?php echo $data["sexage"];?></td>
			<td align="center">
				<?php if($data["weight"]>0):?>
					<?php echo $data["weight"];?><?php echo $data["plus"];?>
				<?php else:?>
					-
				<?php endif;?>
			</td>
			<td><?php echo $data["j_weight"];?><br><?php echo $data["j_name"];?></td>
		</tr>
	<?php endforeach;?>

	</table>

	<?php if(!empty($user["id"])):?>
		<?php if(empty($myData)):?>
			<?php echo $this->Form->submit('送信', array('name' => 'expectation')); ?>
			<?php echo $this->Form->end();?>
		<?php endif;?>
	<?php else:?>
		<a href="/users/login">ログイン</a>
		<?php echo $this->Form->end();?>
	<?php endif;?>
	<br>
	<?php if(!empty($user["id"])):?>
	
	<?php echo $this->Form->create('Thread',array('type'=>'file', 'enctype' => 'multipart/form-data')); ?>
	<div class="postComment">
	<p>コメントする</p>
	<?php echo $this->Form->hidden('Thread.race_id', array('value' => $raceData["Race"]["id"], 'name' => 'race_id')) ?>
	<?php echo $this->Form->hidden('Thread.url', array('value' => Router::url(), 'name' =>	 'url' )) ?>
	<?php echo $this->Form->textarea('Thread.comment',array( "rows"=>5, "cols" => 100, "class" => "form-horizontal" )); ?>
	<?php echo $this->Form->input('Thread.file_name', array('label' => false, 'type' => 'file')); ?>
	<?php echo $this->Form->submit('投稿', array('name' => 'thread')); ?>
	<?php echo $this->Form->end(); ?>
	<?php else: ?>
	<?php endif; ?>
	</div>

	<div class="posts">
			<h4>コメント一覧</h4>
			<?php foreach($posts as $post): ?>
			<div class = "post">
				<span><?php echo $post['Thread']['userName']; ?></span>
				<span>|</span>
				<span class = "date"><?php echo $post['Thread']['created'] ; ?></span>
				<p class = "comment"><?php echo $post['Thread']['comment']; ?></p>
				<?php if(!empty($post['Thread']['file_name'])): ?>
				<img src="/img/thread/<?php echo $raceData["Race"]["id"]. DS .$post['Thread']['file_name'] ?>" class = "img-responsive" alt="">
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
			<div class ="pagination">
			<span><?php echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled')); ?></span>
			<span><?php echo $this->Paginator->numbers(array('separator' => '')); ?></span>
			<span><?php echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled')); ?></span>
			</div>
	</div>
	</div>
