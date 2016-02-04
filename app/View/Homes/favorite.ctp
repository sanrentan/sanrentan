<p class="titleLabel">お気に入り</p>

<div id="mypage">

	<?php echo $this->element('mypageNavi',array("active"=>"favorite")); ?>

	<div id="resultArea">

		<?php if(!empty($favoList)):?>
			<p>お気に入りユーザー</p>
			<table border="1">
				<tr><th>No.</th><th>ニックネーム</th></tr>
				<?php foreach($favoList as $key=>$data):?>
					<tr <?php if($key%2==0):?>class="row2"<?php endif;?>>
						<th><?php echo $key;?></th>
						<td><a href="/other/<?php echo $data['User']['id'];?>"><?php echo $data["User"]["nickname"];?></a></td>
					</tr>
				<?php endforeach;?>
			</table>
		<?php else:?>
			<p>※お気に入りユーザーが登録されていません。</p>
		<?php endif;?>
	</div>

</div>