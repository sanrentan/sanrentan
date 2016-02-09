<p class="titleLabel">マイページ</p>
<div id="mypage">

	<p class="titleLabel">入力内容の確認</p>
	<div class="userForm">
		<p>下記内容でよろしいでしょうか？</p>

		<?php echo $this->Form->create('User',array('type' => 'post','action'=>'/edit_confirm'));?>
		<fieldset>
		<p class="inputLabel">ログインID</p>
		<p><?php echo $postData["User"]["username"];?></p>
		<?php echo $this->Form->hidden('username' ,array('value' => $postData["User"]["username"]));?>

		<p class="inputLabel">パスワード</p>
		<p><?php if(empty($postData["User"]["password"])):?>変更なし<?php else:?>*********<?php endif;?></p>
		<?php echo $this->Form->hidden('password' ,array('value' => $postData["User"]["password"]));?>

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
				<li><?php echo $this->Form->button('戻る',array('onclick'=>'history.back()','class'=>"btn"));?></li>
				<li><input type="submit" class="btn btn-primary" value="変更する"></li>
			</ul>
			<?php echo $this->Form->end();?>			
			<div class="clearfix"></div>
		</div>
	</div>
</div>