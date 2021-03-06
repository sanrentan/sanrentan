<script type="text/javascript">

		function add_favorite(user_id){
			$(".favo_btn"+user_id).css('display', 'none');
			$(".favo_send"+user_id).css('display', 'block');
		    $.ajax({
		        url:  "<?php echo $this->Html->url(array('controller' =>'homes','action' => 'favorite_add'));?>",
		        type: "POST",
		        data: { other_user_id : user_id },
		        dataType: "json",
		        success : function(data){
		            //通信成功時の処理
		            if(data.status=="ok"){
						$(".favo_end"+user_id).css('display', 'block');
						$(".favo_send"+user_id).css('display', 'none');
		            }else if(data.status=="already"){
		            	alert("すでにお気に入りに登録済みのユーザーです。")
						$(".favo_end"+user_id).css('display', 'block');
						$(".favo_send"+user_id).css('display', 'none');
		            }else if(data.status=="non-member"){
		            	alert("お気に入りに登録するためには会員登録が必要です。")
						$(".favo_btn"+user_id).css('display', 'block');
						$(".favo_send"+user_id).css('display', 'none');
		            }else{
			            alert('通信失敗');
		            }
		        },
		        error: function(response){
		            //通信失敗時の処理
		            alert('通信失敗');
		        }
		    });
		}

		function delete_favorite(user_id){
			$(".favo_end"+user_id).css('display', 'none');
			$(".favo_send"+user_id).css('display', 'block');
		    $.ajax({
		        url:  "<?php echo $this->Html->url(array('controller' =>'homes','action' => 'favorite_delete'));?>",
		        type: "POST",
		        data: { other_user_id : user_id },
		        dataType: "json",
		        success : function(data){
		            //通信成功時の処理
		            if(data.status=="ok"){
						$(".favo_btn"+user_id).css('display', 'block');
						$(".favo_send"+user_id).css('display', 'none');
		            }else{
			            alert('通信失敗');
		            }
		        },
		        error: function(response){
		            //通信失敗時の処理
		            alert('通信失敗');
		        }
		    });
		}

</script>

<?php echo $this->element('mypageNavi',array("active"=>"favorite","title"=>"お気に入り")); ?>

<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel">お気に入りユーザーリスト</p>
			<div id="favoUserList">
				<?php if(!empty($favoList)):?>
					<?php foreach($favoList as $key=>$data):?>
						<div class="favoUser type<?php echo $key%3;?> sp_type<?php echo $key%2;?>">
							<div class="favoUserImg">
								<a href="/other/<?php echo $data['User']['id'];?>">
									<?php if($data['User']['profile_img']):?>
										<img src="/img/profileImg/<?php echo $data['User']['profile_img'];?>">
									<?php else:?>
										<img src="/img/common/noimage_person.png">
									<?php endif;?>
								</a>
							</div>
							<div class="favoBtn">
								<p class="favo_btn<?php echo $data['User']['id'];?>" style="display:none;"><a href="#" onclick="add_favorite(<?php echo $data['User']['id'];?>);return false;" class="btn btn-danger">＋フォロー</a>	
								<p class="favo_send<?php echo $data['User']['id'];?>" style="display:none;"><a href="#" class="btn btn-info" >送信中..</a></p>
								<p class="favo_end<?php echo $data['User']['id'];?>"><a href="#" onclick="delete_favorite(<?php echo $data['User']['id'];?>);return false;" class="btn btn-warning" onmouseover="this.className='btn btn-danger';this.innerText='　解除　　';this.class='fabo_btn'" onmouseout="this.className='btn btn-warning';this.innerText='フォロー中'">フォロー中</a></p>
							</div>
							<div class="clearfix"></div>
							<div class="favoUserName"><a href="/other/<?php echo $data['User']['id'];?>"><?php echo $data["User"]["nickname"];?></a></div>
							<div class="favoUserDetail pc">
								今年の戦績：
								<?php if($data["ExpectationResult"]["win"]!=0||$data["ExpectationResult"]["lose"]!=0):?>
									<?php echo $data["ExpectationResult"]["win"];?>勝
									<?php echo $data["ExpectationResult"]["lose"];?>敗
									<?php if($data["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($data["ExpectationResult"]["price"]);?>円
								<?php else:?>
									なし
								<?php endif;?>
							</div>
							<div class="favoUserDetail sp">
								今年の戦績<br>
								<?php if($data["ExpectationResult"]["win"]!=0||$data["ExpectationResult"]["lose"]!=0):?>
									<?php echo $data["ExpectationResult"]["win"];?>勝
									<?php echo $data["ExpectationResult"]["lose"];?>敗<br>
									収支：
									<?php if($data["ExpectationResult"]["price"]>0):?>+<?php endif;?><?php echo number_format($data["ExpectationResult"]["price"]);?>円
								<?php else:?>
									なし
								<?php endif;?>
							</div>
							<div class="favoUserMessage pc">
								<?php echo $data["User"]["message"];?>
							</div>
						</div>
					<?php endforeach;?>
					<div class="clearfix"></div>
				<?php else:?>
					<p>※お気に入りユーザーが登録されていません。</p>
				<?php endif;?>
			</div>
		</div>

	</div>
	<div id="rightContent">
		<?php //ranking ?>
		<?php echo $this->element('ranking'); ?>
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
		<?php //PR ?>
		<?php echo $this->element('pr'); ?>
	</div>
	<div class="clearfix"></div>
</div>