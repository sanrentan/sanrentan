<?php echo $this->element('mypageNavi',array("active"=>"edit","title"=>"登録情報の変更確認")); ?>
<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel">入力内容の確認</p>
			<div class="mainContent2">
				<p>下記内容でよろしいでしょうか？</p>
				<div class="tableArea">
					<?php echo $this->Form->create('User',array('type' => 'post','action'=>'/edit_confirm'));?>
					<fieldset>
					<?php if(empty($postData['User']['twitter_user_id'])):?>
						<p class="inputLabel">ログインID(変更不可)</p>
						<p><?php echo $postData["User"]["username"];?></p>
						<?php echo $this->Form->hidden('username' ,array('value' => $postData["User"]["username"]));?>

						<p class="inputLabel">パスワード</p>
						<p><?php if(empty($postData["User"]["password"])):?>変更なし<?php else:?>*********<?php endif;?></p>
						<?php echo $this->Form->hidden('password' ,array('value' => $postData["User"]["password"]));?>
					<?php endif;?>

					<p class="inputLabel">ニックネーム</p>
					<p><?php echo $postData["User"]["nickname"];?></p>
					<?php echo $this->Form->hidden('nickname' ,array('value' => $postData["User"]["nickname"]));?>

					<p class="inputLabel">競馬歴</p>
					<p><?php if(!empty($postData["User"]["span"])):?><?php echo $postData["User"]["span"];?><?php else:?>未入力<?php endif;?></p>
					<?php echo $this->Form->hidden('span' ,array('value' => $postData["User"]["span"]));?>

					<p class="inputLabel">好きな馬</p>
					<p><?php if(!empty($postData["User"]["favorite"])):?><?php echo $postData["User"]["favorite"];?><?php else:?>未入力<?php endif;?></p>
					<?php echo $this->Form->hidden('favorite' ,array('value' => $postData["User"]["favorite"]));?>


					<p class="inputLabel">自己紹介</p>
					<p><?php if(!empty($postData["User"]["message"])):?><?php echo $postData["User"]["message"];?><?php else:?>未入力<?php endif;?></p>
					<?php echo $this->Form->hidden('message' ,array('value' => $postData["User"]["message"]));?>


					<p class="inputLabel">プロフィール画像</p>
					<p><?php if(!empty($postData["User"]["profile_img"])):?><img src="/img/profileImg/<?php echo $postData["User"]["profile_img"];?>" width="200"><?php else:?>未登録<?php endif;?></p>


					</fieldset>

					<div class="buttonArea">
						<ul>
							<li><input type="submit" class="btn btn-primary btn-block-sp" value="変更する"></li>
							<li><?php echo $this->Form->button('戻る',array('onclick'=>'history.back()','class'=>"btn btn-block-sp"));?></li>
						</ul>
						<?php echo $this->Form->end();?>			
						<div class="clearfix"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div id="rightContent">
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
	</div>
	<div class="clearfix"></div>
</div>

