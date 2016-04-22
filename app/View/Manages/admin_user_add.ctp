<p class="titleLabel">管理者ユーザー登録</p>

<div class="userForm">
	<?php echo $this->Form->create('AdminUser'); ?>
	    <fieldset>
	        <?php if(!empty($errorMsg)):?><p class="red"><?php echo $errorMsg;?></p><?php endif;?>
			<p>ログインID  <span class="red">※必須</span></p>
			<?php echo $this->Form->input('username',array('label'=>false));?>
			<p>パスワード  <span class="red">※必須</span></p>
			<?php echo $this->Form->input('password',array('label'=>false));?>
			<p>ニックネーム</p>
			<?php echo $this->Form->input('nickname',array('label'=>false,'required'=>false));?>
			<p>権限</p>
			<?php echo $this->Form->input( 'role', array('type' => 'select', 'options' => $select1,'label'=>false));?>
		    <input type="submit" class="btn" value="登録">
	    </fieldset>
	<?php echo $this->Form->end();?>
</div>