<p class="titleLabel">管理者管理</p>

<p><a href="./user_add" class="btn">新規追加</a></p>

<table>
	<tr><th>ID</th><th>ログインID</th><th>ニックネーム</th><th>権限</th><th>作成日</th><th>更新日</th><th>編集</th><th>削除</th></tr>
	<?php foreach($adminUser as $key=>$data):?>
		<tr>
			<td><?php echo $data["AdminUser"]["id"];?></td>
			<td><?php echo $data["AdminUser"]["username"];?></td>
			<td><?php echo $data["AdminUser"]["nickname"];?></td>
			<td><?php if($data["AdminUser"]["role"]==1):?>システム管理者<?php else:?>一般管理者<?php endif;?></td>
			<td><?php echo $data["AdminUser"]["created"];?></td>
			<td><?php echo $data["AdminUser"]["modified"];?></td>
			<td><a href="/admin/manages/user_edit/<?php echo $data['AdminUser']['id'];?>">編集</a></td>
			<td><?php echo $this->Html->link('削除', './user_delete/'.$data['AdminUser']['id'], array('title'=>'削除'), '削除しますがよろしいですか？');?></td>
		</tr>
	<?php endforeach;?>
</table>
