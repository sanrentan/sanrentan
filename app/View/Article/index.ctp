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

			<p>ぜひ拡散してください*\(^o^)/*</p>
			<p><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com/article/<?php echo $article['Article']['id'];?>" data-text="<?php echo $article['Article']['title'];?>" data-lang="ja" data-size="large" data-hashtags="こじはる３連単">ツイート</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
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
		<?php echo $this->element('pr'); ?>

	</div>
	<div class="clearfix"></div>
</div>


