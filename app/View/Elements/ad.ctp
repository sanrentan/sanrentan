		<div class="adArea main">
				<ul>
					<li>
						<?php if($ad_ad==0):?>
							<?php //以下 a8;?>							
							<?php echo $adTags2[0]['AdTag']['tag'];?>
						<?php elseif($ad_ad==1):?>
							<?php //以下 nend(spのみなので使えない);?>	
							<script type="text/javascript">
							var nend_params = {"media":41672,"site":225960,"spot":644209,"type":1,"oriented":1};
							</script>
							<script type="text/javascript" src="https://js1.nend.net/js/nendAdLoader.js"></script>
						<?php elseif($ad_ad==2):?>
							<?php //以下 adsenseのpcメイン;?>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:inline-block;width:300px;height:250px"
							     data-ad-client="ca-pub-3842502310763816"
							     data-ad-slot="8403630688"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						<?php elseif($ad_ad=3):?>

						<?php endif;?>
					</li>
				</ul>
		</div>
