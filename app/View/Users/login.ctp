<p class="titleLabel">ログイン</p>

<div class="userForm">
	<?php echo $this->Flash->render('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
	    <fieldset>
	        <legend>
	            <?php echo __('ログインIDとパスワードを入力してください'); ?>
	        </legend>
			<p>ログインID</p>
			<?php echo $this->Form->input('username',array('label'=>false));?>
			<p>パスワード</p>
			<?php echo $this->Form->input('password',array('label'=>false));?>
	    </fieldset>
	<?php echo $this->Form->end(__('ログイン')); ?>
</div>