<p class="titleLabel">レポート</p>

<div>
	<a href="/admin/manageUser/report/2016">2016年</a>
	<!--<a href="/admin/manageUser/report/2017">2017年</a>-->
</div>

<table>
	<tr><th><?php echo $year;?>年</th><th>登録人数</th></tr>
	<?php foreach($result as $key=>$data):?>
		<tr>
			<td><?php echo $key;?></td>
			<td><?php echo $data;?></td>
		</tr>
	<?php endforeach;?>
	<tr><td>合計</td><td><?php echo $total;?></td></tr>
</table>
