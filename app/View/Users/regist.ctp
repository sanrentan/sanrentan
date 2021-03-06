<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel">会員登録</p>
			<div class="mainContent2">
				<p>※本サイトで予想するためには会員登録が必要です。下記必要事項を入力し登録してください。
				<br>既に会員の方は<a href="/users/login" style="text-decoration:underline;">こちら</a>からログインしてください。</a></p>
				<p>会員登録すると、３連単の予想をできるだけでなくこれまでの収支を見ることが可能です。</p>
				<p><span class="red">※注意事項※</span><br>本サイトはあくまで予想をするだけです。馬券の購入は各自行ってください。</p>
				
				<p class="titleLabel" style="margin-top:20px;">Twitterアカウントで登録（簡単）</p>
				<div class="tableArea">
					<a href="/twitter_login" style="text-decoration:underline;"><img src="/img/common/twitter_logo.png" width="200"><br>Twitterアカウントで登録</a>
					<br>
					<br>
					※簡単にサイトに登録やログインを行うことが可能です。<br>
					※登録後に本サイトのプロフィール情報を更新することが可能です。
				</div>

				<p class="titleLabel" style="margin-top:20px;">登録情報の入力</p>
				<div class="tableArea">

					<?php echo $this->Form->create('User',array('enctype' => 'multipart/form-data')); ?>
					<fieldset>
					<p>ログインID (半角英数4文字以上) <span class="red">※必須</span></p>
					<?php echo $this->Form->input('username',array('label'=>false));?>
					<p>パスワード (半角英数6文字以上) <span class="red">※必須</span></p>
					<?php echo $this->Form->input('password',array('label'=>false));?>
					<p>ニックネーム <span class="red">※必須</span></p>
					<?php echo $this->Form->input('nickname',array('label'=>false));?>
					<p>競馬歴(単位もご記入ください）<br>例：１年、半年、初心者 など</p>
					<?php echo $this->Form->input('span',array('label'=>false,'required'=>false));?>
					<p>好きな馬</p>
					<?php echo $this->Form->input('favorite',array('label'=>false,'required'=>false));?>
					<p>自己紹介</p>
					<span style="color:#b94a48;"><?php echo $this->Form->error('message');?></span>
					<?php echo $this->Form->textarea('message', array('cols' => 40, 'rows' => 10,'required'=>false));?>
					<p>プロフィール画像</p>
				    <?php echo $this->Form->input('profile_img', array('type' => 'file','label'=>false,'required'=>false));?>


					</fieldset>
					<input type="image" src="/img/button/btn_next.png" class="web_btn pc" value="確認画面へ">
					<input type="submit" class="btn btn-primary btn-block-sp sp" value="確認画面へ">
					<?php echo $this->Form->end(); ?>
				</div>
			</div>


		</div>

	</div>
	<div id="rightContent">
		<?php //ad ?>
		<div class="pc">
			<?php echo $this->element('ad'); ?>
		</div>
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
		<?php //PR ?>
		<?php echo $this->element('pr'); ?>
	</div>
	<div class="clearfix"></div>
</div>
