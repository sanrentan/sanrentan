<div id="mainContent">
	<div id="leftContent">
		<div class="sp">
				<?php //広告mini ?>
			<?php echo $this->element('adMini'); ?>
		</div>
		<div id="articleContent">
			<p class="titleLabel pc"><?php echo $article['Article']['title'];?></p>
			<p class="titleLabel sp" style="font-size:110%;"><?php echo $article['Article']['title'];?></p>

			<p class="articleTag"><?php echo date('Y年m月d日',strtotime($article['Article']['start_date']));?>更新<br>
			カテゴリ：<a href="/article/category/<?php echo $article['Article']['article_category_id'];?>"><?php echo $article_category['ArticleCategory']['name'];?></a>
			<?php if(!empty($article['Article']['race_id'])):?> > <a href="/detail/<?php echo $race['Race']['id'];?>"><?php echo $race['Race']['name'];?></a><?php endif;?></p>


			<?php echo $article["Article"]['body'];?>


			<?php if($article_category['ArticleCategory']['id']==2):?>
				<?php if($race['Race']['view_flg']==1):?>
					<p><?php echo $race['Race']['name'];?>の出走表は<a href="/detail/<?php echo $race['Race']['id'];?>">こちら</a>。予想登録も可能です。</p>
				<?php endif;?>
				
				<p class="titleLabel">お知らせ</p>
				<p>当サイトでは重賞レースを中心に予想を受け付けています！<br>競馬に詳しくない方はこじはるさんの予想はもちろん、当サイトの上位者の予想を参考にしてみてください！</p>
				<p>無料会員登録は<a href="/regist" style="text-decoration:underline;">こちら</a>から。予想を登録するだけでなく、他の方の予想を閲覧することが可能です！</p>
				<p>サイトへの要望等も受付ております！<a href="/contact" style="text-decoration:underline;">こちら</a>から。</p>
				<p>また<a href="https://twitter.com/sanrentan_box" style="text-decoration:underline;" target="_blank">公式Twitter</a>もありますので要チェック！</p>
				<p>最後までお読みいただきありがとうございました！</p>

			<?php endif;?>

			<p>ぜひ拡散してください*\(^o^)/*</p>
			<p><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com/article/<?php echo $article['Article']['id'];?>" data-text="<?php echo $article['Article']['title'];?>" data-lang="ja" data-size="large" data-hashtags="こじはる３連単">ツイート</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</p>

			<p style="text-align:center;">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle"
			     style="display:inline-block;width:300px;height:250px"
			     data-ad-client="ca-pub-3842502310763816"
			     data-ad-slot="8403630688"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			</p>

		</div>
	</div>
	<div id="rightContent">

		<?php //広告 ?>
		<div class="pc">
			<?php echo $this->element('ad'); ?>
		</div>

		<?php echo $this->element('ranking'); ?>

		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>

		<?php //PR ?>
		<?php //echo $this->element('pr'); ?>

	</div>
	<div class="clearfix"></div>
</div>


