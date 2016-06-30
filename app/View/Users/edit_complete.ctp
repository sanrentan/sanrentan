<?php echo $this->element('mypageNavi',array("active"=>"edit","title"=>"登録情報の変更完了")); ?>
<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<div class="mainContent2">
				<p>登録情報の変更が完了しました。</p>
				<p>是非、３連単５頭ボックスの予想をしましょう！</p>
				<a href="/"><img src="/img/button/btn_top.png" alt="トップページ" class="web_btn"></a>
			</div>
		</div>
	</div>
	<div id="rightContent">
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
	</div>
	<div class="clearfix"></div>
</div>
