<div id="mainBannerArea">
	<div id="mainBannerAreaLeft2">
		<p class="titleLabel"><?php echo $title;?></p>
		<div id="mypageNavi">
			<ul>
				<li><a href="/mypage"><img src="/img/button/btn_mymenu1.png" class="btn_mymenu"></a></li>
				<li><a href="/race_result_list"><img src="/img/button/btn_mymenu2.png" class="btn_mymenu"></a></li>
				<li><a href="/users/edit"><img src="/img/button/btn_mymenu3.png" class="btn_mymenu"></a></li>
				<li><a href="/favorite"><img src="/img/button/btn_mymenu4.png" class="btn_mymenu"></a></li>
				<!--<li><a href="/users/withdrawal"><img src="/img/button/btn_mymenu5.png" class="btn_mymenu"></a></li>-->
				<div class="clearfix"></div>
			<!--<li><a href="/race_result_list" class="btn btn-<?php if($active=='result'):?>primary<?php else:?>info<?php endif;?> btn-lg">過去のレース結果</a></li>
			<li><a href="/users/edit" class="btn btn-<?php if($active=='edit'):?>primary<?php else:?>info<?php endif;?> btn-lg">登録情報の変更</a></li>
			<li><a href="/favorite" class="btn btn-<?php if($active=='favorite'):?>primary<?php else:?>info<?php endif;?> btn-lg">お気に入り</a></li>
			<li><a href="/users/withdrawal" class="btn btn-<?php if($active=='withdrawal'):?>primary<?php else:?>info<?php endif;?> btn-lg">退会</a></li>
			-->	
			</ul>
		</div>
	</div>
	<div id="mainBannerAreaRight2" class="pc">
		<div id="myProfileArea">
			<div id="myIconArea">
				<a href="/users/edit">
				<?php if(!empty($user["profile_img"])):?>
					<img src="/img/profileImg/<?php echo $user['profile_img'];?>" class="myIcon">
				<?php else:?>
					<img src="/img/common/noimage_person.png" class="myIcon">
				<?php endif;?>
				</a>
			</div>
			<div id="myNameArea">
				<p><?php echo $user['nickname'];?></p>
				<?php if(!empty($myResultData)):?>
					<p>今年の戦績：<?php echo $myResultData["ExpectationResult"]["win"];?>勝<?php echo $myResultData["ExpectationResult"]["lose"];?>敗<br>
					収支：<?php if($myResultData["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($myResultData["ExpectationResult"]["price"]);?>円</p>
				<?php else:?>
					<p>今年の戦績：まだ予想をしていません</p>
				<?php endif;?>
			</div>
			<div class="clearfix"></div>
		</div>

	</div>
	<div class="clearfix"></div>
</div>


