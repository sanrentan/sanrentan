<p class="titleLabel">レース管理</p>

<p><a href="./race_add" class="btn">新規追加</a></p>

<table>
	<tr><th>ID</th><th>日付</th><th>場所</th><th>レース名</th><th>正式名称</th><th>情報</th><th>公開状態</th><th>予想受付</th><th>こじはる</th><th>詳細</th><th>編集</th><th>削除</th></tr>
	<?php foreach($raceList as $key=>$data):?>
		<tr>
			<td><?php echo $data["Race"]["id"];?></td>
			<td><?php echo date("Y年m月d日",strtotime($data["Race"]["race_date"]));?></td>
			<td><?php echo $data["Race"]["place"];?></td>
			<td><?php echo $data["Race"]["name"];?><?php if($data["Race"]["grade"]>=1):?>(G<?php echo $data["Race"]["grade"];?>)<?php endif;?></td>
			<td><?php echo $data["Race"]["full_name"];?></td>
			<td><?php echo $typeArr[$data["Race"]["type"]];?>　<?php echo $data["Race"]["distance"];?>m</td>
			<td><?php echo $viewArr[$data["Race"]["view_flg"]];?></td>
			<td><?php echo $acceptArr[$data["Race"]["accepting_flg"]];?></td>
			<td><?php echo $kojiharuArr[$data["Race"]["kojiharu_flg"]];?></td>
			<td><a href="./race_view/<?php echo $data['Race']['id'];?>">詳細</a></td>
			<td><a href="./race_edit/<?php echo $data['Race']['id'];?>">編集</a></td>
			<td><?php echo $this->Html->link('削除', './race_delete/'.$data['Race']['id'], array('title'=>'削除'), '削除しますがよろしいですか？');?></td>
		</tr>
	<?php endforeach;?>
</table>
