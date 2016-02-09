<div id="mypageNavi">
	<ul style="float:left;">
		<li><a href="/mypage" class="btn btn-<?php if($active=='index'):?>primary<?php else:?>info<?php endif;?> btn-lg">あなたの予想記録</a></li>
		<li><a href="/users/edit" class="btn btn-<?php if($active=='edit'):?>primary<?php else:?>info<?php endif;?> btn-lg">登録情報の変更</a></li>
		<li><a href="/favorite" class="btn btn-<?php if($active=='favorite'):?>primary<?php else:?>info<?php endif;?> btn-lg">お気に入り</a></li>
		<li><a href="/users/withdrawal" class="btn btn-<?php if($active=='withdrawal'):?>primary<?php else:?>info<?php endif;?> btn-lg">退会</a></li>
	</ul>
	<div class="myProfileImg">
		<a href="/users/edit">
		<?php if(!empty($user["profile_img"])):?>
			<img src="/img/profileImg/<?php echo $user['profile_img'];?>" width="72">
		<?php else:?>
			<img src="/img/common/noimage_person.png" width="72">
		<?php endif;?>
		</a>
		<span style="padding:10px;margin-top:10px;">
			<?php echo $user["nickname"];?>さんのマイページ
		</span>
	</div>
	<div class="clearfix"></div>
</div>
