<p class="titleLabel">レース詳細表示</p>

<table>
	<tr><th>ID</th><td><?php echo $raceData['Race']['id'];?></td></tr>
	<tr><th>name</th><td><?php echo $raceData['Race']['name'];?></td></tr>
	<tr><th>正式名称</th><td><?php echo $raceData['Race']['full_name'];?></td></tr>
	<tr><th>場所</th><td><?php echo $raceData['Race']['place'];?></td></tr>
	<tr><th>グレード</th><td><?php echo $raceData['Race']['grade'];?></td></tr>
	<tr><th>距離</th><td><?php echo $raceData['Race']['distance'];?>m</td></tr>
	<tr><th>芝/ダート</th><td><?php echo $typeArr[$raceData['Race']['type']];?></td></tr>
	<tr><th>右/左</th><td><?php echo $turnArr[$raceData['Race']['turn']];?></td></tr>
	<tr><th>レース日時</th><td><?php echo $raceData['Race']['race_date'];?></td></tr>
	<tr><th>レース備考</th><td><?php echo $raceData['Race']['note'];?></td></tr>
	<tr><th>表示状態</th><td><?php echo $raceData['Race']['view_flg'];?></td></tr>
	<tr><th>受付状態</th><td><?php echo $raceData['Race']['accepting_flg'];?></td></tr>
	<tr><th>こじはる予想</th><td><?php echo $raceData['Race']['kojiharu_flg'];?></td></tr>
	<tr><th>html_id</th><td><?php echo $raceData['Race']['html_id'];?></td></tr>
	<tr><th>作成日</th><td><?php echo $raceData['Race']['created'];?></td></tr>
	<tr><th>更新日</th><td><?php echo $raceData['Race']['modified'];?></td></tr>
</table>


<?php if(!empty($raceData['RaceCard'])):?>
	<p class="titleLabel">レースコメント用（コピペ用）</p>
	<?php foreach($raceData['RaceCard'] as $key =>$data):?>
		&lt;p>&lt;span class="wk<?php echo $data['wk'];?>_note"><?php echo $data['uma'];?>&lt;/span><?php echo $data['name'];?>&lt;/p><br>
	<?php endforeach;?>
<?php endif;?>