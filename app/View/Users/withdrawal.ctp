<p class="titleLabel">マイページ</p>
<div id="mypage">

	<?php if(empty($doneFlg)):?>
		<?php echo $this->element('mypageNavi',array("active"=>"withdrawal")); ?>

		<div class="userForm">
			<p>※本当に退会しますか？<br>退会するとこれまでの履歴も削除されます。</p>

			<?php echo $this->Form->create('Users',array('type' => 'post','action'=>'/withdrawal'));?>

			<div class="buttonArea">
				<ul>
					<li><a href="/mypage" class="btn">戻る</a></li>
					<li><?php echo $this->Form->end('退会する');?></li>
				</ul>
			</div>
		</div>
	<?php else:?>
		<div class="userForm">
			<p>退会処理が完了しました。<br>またのお越しをお待ちしております！</p>
		</div>
	<?php endif;?>
</div>