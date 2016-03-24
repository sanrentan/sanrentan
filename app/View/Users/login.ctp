<p class="titleLabel">ログイン</p>

<div class="userForm">
	<?php echo $this->Flash->render('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
	    <fieldset>
	        <legend>
	            <?php echo __('Twitterのアカウントでログイン'); ?>
	        </legend>
			<a href="/twitter_login"><img src="/img/common/twitter_logo.png" width="200"><br>Twitterアカウントでログイン</a>
			<br>
			<br>


	        <legend>
	            <?php echo __('ID・パスワードでログイン'); ?>
	        </legend>
	        <?php if(!empty($errorMsg)):?><p class="red"><?php echo $errorMsg;?></p><?php endif;?>
			<p>ログインID</p>
			<?php echo $this->Form->input('username',array('label'=>false));?>
			<p>パスワード</p>
			<?php echo $this->Form->input('password',array('label'=>false));?>
	    </fieldset>
	    <input type="submit" class="btn btn-primary btn-block-sp" value="ログイン">
	<?php echo $this->Form->end();?>

</div>