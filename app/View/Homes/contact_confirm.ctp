<p class="titleLabel">お問い合わせ</p>
<div class="userForm">
	<p>※本サイトに関するお問い合わせやご要望等はこちらのフォームからお願いいたします。<br>
		ご返信につきましては、お時間を頂く場合がございます。<br>
		また、お問い合わせ内容によってはご返信をいたしかねる場合がございますので、予めご了承ください。</p>
		<br>

	<?php echo $this->Form->create('Home'); ?>
	<fieldset>
	<p>お名前</p>
	<p><?php echo $data["name"];?></p>
	<p>メールアドレス</p>
	<p><?php echo $data["email"];?></p>
	<p>お問い合わせ内容</p>
	<p><?php echo $data["message"];?></p>
	</fieldset>
	<div class="buttonArea">
		<ul>
			<li><input type="submit" class="btn btn-primary btn-block-sp" value="送信する"></li>
			<li><?php echo $this->Form->button('戻る',array('onclick'=>'history.back()','class'=>"btn btn-block-sp"));?></li>
		</ul>
		<?php echo $this->Form->end();?>
		<div class="clearfix"></div>
	</div>
</div>
