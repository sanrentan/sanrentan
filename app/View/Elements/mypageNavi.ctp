<div id="mypageNavi">
	<ul>
		<li <?php if($active=="index"):?>class="active"<?php endif;?>><a href="/mypage">あなたの予想記録</a></li>
		<li><a href="">こじはる予想記録</a></li>
		<li <?php if($active=="edit"):?>class="active"<?php endif;?>><a href="/users/edit">登録情報の変更</a></li>
		<li><a href="">退会</a></li>
	</ul>
	<div class="clearfix"></div>
</div>
