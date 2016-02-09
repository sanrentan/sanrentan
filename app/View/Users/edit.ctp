<script type="text/javascript">

		function delete_image(){
			document.UserEditForm.profile_img_text.value = "";
			document.getElementById("profileImgArea").style.display="none";
		}

</script>

<p class="titleLabel">マイページ</p>
<div id="mypage">
	<?php echo $this->element('mypageNavi',array("active"=>"edit")); ?>

	<div class="userForm">
	<p class="titleLabel">登録情報の変更</p>
	<?php echo $this->Form->create('User',array('enctype' => 'multipart/form-data',"name"=>"UserEditForm")); ?>
		<fieldset>
			<p>ログインID</p>
			<?php echo $this->request->data["User"]["username"];?>
			<p>パスワード (半角英数6文字以上)　※変更する場合は入力</p>
			<?php echo $this->Form->input('password',array('label'=>false,'required'=>false));?>
			<p>ニックネーム <span class="red">※必須</span></p>
			<?php echo $this->Form->input('nickname',array('label'=>false));?>
			<p>競馬歴</p>
			<?php echo $this->Form->input('span',array('label'=>false,'required'=>false));?>
			<p>好きな馬</p>
			<?php echo $this->Form->input('favorite',array('label'=>false,'required'=>false));?>
			<p>自己紹介</p>
			<span style="color:#b94a48;"><?php echo $this->Form->error('message');?></span>
			<?php echo $this->Form->textarea('message', array('cols' => 40, 'rows' => 10,'required'=>false));?>
			<p>プロフィール画像</p>
		    <?php echo $this->Form->input('profile_img', array('type' => 'file','label'=>false,'required'=>false));?>
		    <?php if($this->request->data["User"]["profile_img"]):?>
		    	<p id="profileImgArea">
		    		<img src="/img/profileImg/<?php echo $this->request->data['User']['profile_img'];?>" width="200">
		    		　<input type="button" onclick="delete_image();return false" value="画像を削除">
		    	</p>
			    <input type="hidden" name="profile_img_text" value="<?php echo $this->request->data['User']['profile_img'];?>">

		    <?php else:?>
			    <input type="hidden" name="profile_img_text" value="">
		    <?php endif;?>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="確認画面へ">
	<?php echo $this->Form->end(); ?>
	</div>
</div>

