<script type="text/javascript">

		function delete_image(){
			document.UserEditForm.profile_img_text.value = "";
			document.getElementById("profileImgArea").style.display="none";
		}

</script>

<?php echo $this->element('mypageNavi',array("active"=>"edit","title"=>"登録情報の変更")); ?>
<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel">登録情報</p>
			<div class="mainContent2">
				<div class="tableArea">
					<?php echo $this->Form->create('User',array('enctype' => 'multipart/form-data',"name"=>"UserEditForm")); ?>
					<fieldset>
						<?php if(empty($this->request->data["User"]["twitter_user_id"])):?>
							<p>ログインID：<?php echo $this->request->data["User"]["username"];?>（変更不可）</p>
							<p>パスワード (半角英数6文字以上)　※変更する場合は入力</p>
							<?php echo $this->Form->input('password',array('label'=>false,'required'=>false));?>
						<?php endif;?>
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
					<input type="submit" class="btn btn-primary btn-block-sp" value="確認画面へ">
					<?php echo $this->Form->end(); ?>

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

