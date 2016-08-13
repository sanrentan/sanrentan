<p class="titleLabel">ユーザー管理</p>

<!--<p><a href="./race_add" class="btn">新規追加</a></p>-->


<div>
ここに検索エリアをつける
</div>


<?php echo $this->element('pager'); ?>
<table>
	<tr><th>ID</th><th>username</th><th>nickname</th><th>twitter</th><th>ログイン回数</th><th>登録日</th><th>詳細</th><th>編集</th></tr>
	<?php foreach($userList as $key=>$data):?>
		<tr>
			<td><?php echo $data["User"]["id"];?></td>
			<td><?php echo $data["User"]["username"];?></td>
			<td><?php echo $data["User"]["nickname"];?></td>
			<td><?php echo $data["User"]["twitter_user_name"];?></td>
			<td><?php echo $data["User"]["login_count"];?></td>
			<td><?php echo $data["User"]["created"];?></td>
			<td><a href="/admin/manageUser/user_view/<?php echo $data['User']['id'];?>">詳細</a></td>
			<td><a href="/admin/manageUser/user_edit/<?php echo $data['User']['id'];?>">編集</a></td>
		</tr>
	<?php endforeach;?>
</table>

<?php echo $this->element('pager'); ?>
