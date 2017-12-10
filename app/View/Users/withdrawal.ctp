<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel">退会</p>

			<?php if(empty($doneFlg)):?>

				<div class="userForm">
					<p>※本当に退会しますか？<br>退会するとこれまでの履歴も削除されます。<br>また、元に戻すこともできません</p>

					<?php echo $this->Form->create('Users',array('type' => 'post','action'=>'/withdrawal'));?>

					<div class="buttonArea">
						<ul>
							<li><a href="/mypage" class="btn btn-block-sp">戻る</a></li>
							<li><input type="submit" class="btn btn-primary btn-block-sp" value="退会する"></li>
						</ul>
						<?php echo $this->Form->end();?>
						<div class="clearfix"></div>
					</div>
				</div>
			<?php else:?>
				<div class="userForm">
					<p>退会処理が完了しました。<br>またのお越しをお待ちしております！</p>
					<a href="/" class="btn btn-primary btn-block-sp">トップページへ</a>
				</div>
			<?php endif;?>
		</div>
	</div>
</div>
