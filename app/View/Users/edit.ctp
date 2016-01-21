<p class="titleLabel">マイページ</p>
<div id="mypage">
	<?php echo $this->element('mypageNavi',array("active"=>"edit")); ?>

	<div class="userForm">
	<p class="titleLabel">登録情報の変更</p>
	<?php echo $this->Form->create('User'); ?>
		<fieldset>
			<p>ログインID</p>
			<?php echo $this->request->data["User"]["username"];?>
			<p>パスワード (半角英数6文字以上)　※変更する場合は入力</p>
			<?php echo $this->Form->input('password',array('label'=>false,'required'=>false));?>
			<p>ニックネーム <span class="red">※必須</span></p>
			<?php echo $this->Form->input('nickname',array('label'=>false));?>
			<p>競馬歴</p>
			<?php echo $this->Form->input('span',array('label'=>false,'required'=>false));?>
			<p>好きな馬</p>
			<?php echo $this->Form->input('favorite',array('label'=>false,'required'=>false));?>
			<p>自己紹介</p>
			<span style="color:#b94a48;"><?php echo $this->Form->error('message');?></span>
			<?php echo $this->Form->textarea('message', array('cols' => 40, 'rows' => 10,'required'=>false));?>
		</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
	</div>
</div>

