<p class="titleLabel">ユーザー編集</p>

<p>とりあえずパスワードのみ変更</p>
<div class="userForm">
	<?php echo $this->Form->create('User'); ?>
	    <fieldset>
			<?php echo $this->Form->input('password',array('label'=>'パスワード','required'=>false));?>

		    <input type="submit" class="btn" value="登録">
	    </fieldset>
	<?php echo $this->Form->end();?>
</div>