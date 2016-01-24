<p class="titleLabel">お問い合わせ</p>
<div class="userForm">
	<p>※本サイトに関するお問い合わせやご要望等はこちらのフォームからお願いいたします。<br>
		ご返信につきましては、お時間を頂く場合がございます。<br>
		また、お問い合わせ内容によってはご返信をいたしかねる場合がございますので、予めご了承ください。</p>
		<br>

	<?php echo $this->Form->create('Home'); ?>
	<fieldset>
	<p>お名前 <span class="red">※必須</span></p>
	<?php if(!empty($errMessage["name"])):?><p class="red"><?php echo $errMessage["name"];?></p><?php endif;?>
	<?php echo $this->Form->input('name',array('label'=>false));?>
	<p>メールアドレス <span class="red">※必須</span></p>
	<?php if(!empty($errMessage["email"])):?><p class="red"><?php echo $errMessage["email"];?></p><?php endif;?>
	<?php echo $this->Form->input('email',array('label'=>false,'required'=>false));?>
	<p>お問い合わせ内容 <span class="red">※必須</span></p>
	<?php if(!empty($errMessage["message"])):?><p class="red"><?php echo $errMessage["message"];?></p><?php endif;?>
	<span style="color:#b94a48;"><?php echo $this->Form->error('message');?></span>
	<?php echo $this->Form->textarea('message', array('cols' => 40, 'rows' => 10,'required'=>false));?>
	</fieldset>
	<?php echo $this->Form->end(__('確認画面へ')); ?>
</div>
