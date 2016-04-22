<p class="titleLabel">お知らせ管理</p>

<p><a href="./add" class="btn">新規追加</a></p>


<?php echo $this->element('pager'); ?>
<table>
	<tr><th>ID</th><th>タイトル</th><th>表示フラグ</th><th>公開日</th><th>登録日</th><th>編集</th><th>削除</th></tr>
	<?php foreach($infoList as $key=>$data):?>
		<tr>
			<td><?php echo $data["Information"]["id"];?></td>
			<td><?php echo $data["Information"]["title"];?></td>
			<td><?php if($data["Information"]["view_flg"]==0):?>非表示<?php else:?>表示<?php endif;?></td>
			<td><?php echo $data["Information"]["start_date"];?></td>
			<td><?php echo $data["Information"]["created"];?></td>
			<td><a href="./edit/<?php echo $data['Information']['id'];?>">編集</a></td>
			<td><?php echo $this->Html->link('削除', './delete/'.$data['Information']['id'], array('title'=>'削除'), '削除しますがよろしいですか？');?></td>
		</tr>
	<?php endforeach;?>
</table>
<?php echo $this->element('pager'); ?>
