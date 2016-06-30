<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel">ログイン</p>
			<div class="mainContent2">
				<?php echo $this->Flash->render('auth'); ?>
				<?php echo $this->Form->create('User'); ?>
				<p>既に会員登録済みの方や、Twitterアカウントでログインする方は下記からお願いします。</p>
				    <fieldset>
						<p class="titleLabel">ID・パスワードでログイン</p>
				    	<div class="tableArea">
					        <?php if(!empty($errorMsg)):?><p class="red"><?php echo $errorMsg;?></p><?php endif;?>
							<p>ログインID</p>
							<?php echo $this->Form->input('username',array('label'=>false));?>
							<p>パスワード</p>
							<?php echo $this->Form->input('password',array('label'=>false));?>
							<input type="image" src="/img/button/btn_login1.png" class="web_btn pc">
						    <input type="submit" class="sp" value="ログイン">
						</div>
						<p class="titleLabel">Twitterのアカウントでログイン</p>
				    	<div class="tableArea">
							<a href="/twitter_login"><img src="/img/common/twitter_logo.png" width="200"><br>Twitterアカウントでログイン</a>
						</div>
						<p class="titleLabel">新規会員登録の方</p>
				    	<div class="tableArea">
					        <a href="/regist"><img src="/img/button/btn_regist.png" alt="会員登録" class="web_btn"></a>
						</div>
				    </fieldset>
				<?php echo $this->Form->end();?>

			</div>
		</div>

	</div>
	<div id="rightContent">
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
	</div>
	<div class="clearfix"></div>
</div>	

