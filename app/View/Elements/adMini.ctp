<div class="blogAdWidth">
	<ul>
			<?php if($ad_mini==1):?>
				<?php //nend?>
				<li class="sp">
					<script type="text/javascript">
					var nend_params = {"media":41672,"site":225960,"spot":644213,"type":1,"oriented":1};
					</script>
					<script type="text/javascript" src="https://js1.nend.net/js/nendAdLoader.js"></script>
				</li>
			<?php elseif($ad_mini==2):?>
				<?php //adsense?>
				<li>
					<?php $testdata = 2;?>
					<?php if($testdata==1):?>
							<?php //以下 adsenseのpcメイン;?>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:inline-block;width:300px;height:250px"
							     data-ad-client="ca-pub-3842502310763816"
							     data-ad-slot="8403630688"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>

					<?php else:?>

						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- SPミニサイズ -->
						<ins class="adsbygoogle"
						     style="display:inline-block;width:320px;height:100px"
						     data-ad-client="ca-pub-3842502310763816"
						     data-ad-slot="2357097083"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>

					<?php endif;?>


				</li>
			<?php elseif($ad_mini==0):?>
				<?php echo $adTags3[0]['AdTag']['tag'];?>
			<?php endif;?>
	</ul>
</div>