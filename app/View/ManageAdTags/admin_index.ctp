<p class="titleLabel">広告管理</p>

<p><a href="./add" class="btn">新規追加</a></p>

<form action="?" method="post">
	<select name="type" onChange="this.form.submit()">
		<option value="9999" <?php if($type==9999):?>selected<?php endif;?>>全サイズ</option>	
		<?php foreach($banner_size as $key=>$data):?>
			<option value="<?php echo $key;?>" <?php if($type==$key):?>selected<?php endif;?>><?php echo $data;?></option>
		<?php endforeach;?>
	</select>
</form>

<?php echo $this->element('pager'); ?>
<table>
	<tr><th>ID</th><th>名前</th><th>タイプ</th><th>ランク</th><th>メモ</th><th>登録日</th><th>編集</th><th>削除</th></tr>
	<?php foreach($adTagList as $key=>$data):?>
		<tr>
			<td><?php echo $data["AdTag"]["id"];?></td>
			<td><?php echo $data["AdTag"]["name"];?></td>
			<td><?php echo $banner_size[$data["AdTag"]["type"]];?></td>
			<td><?php echo $data["AdTag"]["rank"];?></td>
			<td><?php echo $data["AdTag"]["note"];?></td>
			<td><?php echo $data["AdTag"]["created"];?></td>
			<td><a href="./edit/<?php echo $data['AdTag']['id'];?>">編集</a></td>
			<td><?php echo $this->Html->link('削除', './delete/'.$data['AdTag']['id'], array('title'=>'削除'), '削除しますがよろしいですか？');?></td>
		</tr>
	<?php endforeach;?>
</table>
<?php echo $this->element('pager'); ?>
