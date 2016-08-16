<div id="mainContent">
		<div id="leftContent">
		<div id="contactArea">
			<p class="titleLabel">プロフィール閲覧</p>
			<div class="mainContent2">
				<p class="description">ここから先は<a href="/regist" style="text-decoration:underline;">無料会員登録</a>または<a href="/login" style="text-decoration:underline;">ログイン</a>が必要です。</p>
				<p style="font-size:100%;" class="description">会員登録をすると、他の方のプロフィール閲覧や自分で３連単予想を登録することも可能です。</p>
			</div>
		</div>
		<div class="pc">
				<?php //広告よこなが ?>
			<?php echo $this->element('adWidth'); ?>
		</div>
		<div class="sp">
				<?php //広告mini ?>
			<?php echo $this->element('adMini'); ?>
		</div>
	</div>
	<div id="rightContent">
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
		<?php //公式twitter ?>
		<?php echo $this->element('ad'); ?>
	</div>
	<div class="clearfix"></div>
</div>