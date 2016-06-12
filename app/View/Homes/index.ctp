<div id="mainBannerArea">
	<div id="mainBannerAreaLeft">
		<img src="/img/common/koji1.jpg">
	</div>
	<div id="mainBannerAreaRight" class="pc">
		<?php echo $this->element('recentKojiharu'); ?>
	</div>
	<div class="clearfix"></div>
</div>
<div id="mainContent">
	<div id="leftContent">

		<div id="mainBannerAreaRight" class="sp">
			<p class="titleLabelKojiharu">最新のこじはる予想！</p>
			<p style="padding-left:10px;"><?php echo date("m月d日",strtotime($recentKojiharu["Race"]["race_date"]));?> <a href="/detail/<?php echo $recentKojiharu['Race']['id'];?>"><?php echo $recentKojiharu["Race"]["name"];?><?php if($recentKojiharu['Race']['grade']>0):?> (G<?php echo $recentKojiharu['Race']['grade'];?>)<?php endif;?></a></p>
			<div id="recentKojiharuArea">
				<dl>
					<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?>
						<dt class="wk<?php echo $data['wk'];?>"><?php echo $data["uma"];?></dt><dd class="wkname"><?php echo $data["name"];?></dd>
					<?php endforeach;?>
				</dl>
				<div class="clearfix"></div>
				<div style="margin-top:10px;">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com" data-text="<?php echo $recentKojiharu['Race']['name'];?>の３連単予想！「<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?><?php if($key==0):?><?php echo $data["uma"];?><?php else:?>-<?php echo $data["uma"];?><?php endif;?><?php endforeach;?>
			」" data-via="sanrentan_box" data-lang="ja" data-size="large" data-hashtags="こじはる３連単予想">ツイート</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				</div>
			</div>
			<div id="subBannerArea"><img src="/img/common/umairasto.png" style="max-width:150px;"></div>	
			<div class="clearfix"></div>
		</div>

		<div id="leftContentMain">
			<div class="listArea">
				<p class="titleLabel">現在受付中のレース（※当サイト受付分のみ)</p>
				<ul class="raceList">
					<?php if(!empty($acceptingRace)):?>
						<?php foreach($acceptingRace as $key=>$data):?>
							<li>
								<span><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></span>
								<span class="racePlace"><?php echo $data['Race']['place'];?></span>　
								<span class="raceName">
									<a href="/detail/<?php echo $data['Race']['id'];?>">
										<?php echo $data['Race']['name'];?><?php if($data['Race']['grade']>0):?> (G<?php echo $data['Race']['grade'];?>)<?php endif;?>
									</a>
								</span>
								<?php if($data['Race']['kojiharu_flg']):?>　<span class="kojiharuRace">こじはる予想レース</span><?php endif;?>
							</li>
						<?php endforeach;?>
					<?php else:?>
						<li>※現在受付中のレースはありません。</li>
					<?php endif;?>
				</ul>
			</div>

			<div class="listArea">
				<p class="titleLabel note">過去５レースの結果（※当サイト受付分のみ）</p>
				<ul class="raceList">
					<?php foreach($recentRace as $key=>$data):?>
						<li>
							<span><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></span>
							<span class="racePlace"><?php echo $data['Race']['place'];?></span>　
							<span class="raceName">
								<a href="/result/<?php echo $data['Race']['id'];?>">
									<?php echo $data['Race']['name'];?><?php if($data['Race']['grade']>0):?> (G<?php echo $data['Race']['grade'];?>)<?php endif;?>
								</a>
							</span>
							<?php if($data['Race']['kojiharu_flg']):?>　<span class="kojiharuRace">こじはる予想レース</span><?php endif;?>
						</li>
					<?php endforeach;?>
				</ul>
			</div>

			<div class="listArea">
				<p class="titleLabel light">お知らせ</p>
				<ul class="raceList">
					<?php foreach($infoData as $key=>$data):?>
						<li class="news"> <?php echo date("Y年m月d日",strtotime($data["Information"]["start_date"]));?><br>&nbsp;<?php echo $data['Information']['title'];?></li>
					<?php endforeach;?>
				</ul>
			</div>

			<div class="listArea">
				<?php if(!empty($newsRss)):?>
					<p class="titleLabel light">競馬ニュース(競馬JAPAN)</p>
					<ul class="information keibajapan">
						<?php foreach($newsRss as $key=>$data):?>
							<li class="icontype0">　<a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?></a></li>
						<?php endforeach;?>
					</ul>
				<?php endif;?>
			</div>

			<!--
			<p class="titleLabel light">競馬予想</p>
			<ul class="information">
				<?php foreach($expectRss as $key=>$data):?>
					<li><a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?>(<?php echo $data["blogTitle"];?>)</a></li>
				<?php endforeach;?>
			</ul>
			-->

			<div class="listArea">
				<p class="titleLabel light">まとめサイト</p>
				<ul class="information matomeList">
					<?php foreach($matomeRss as $key=>$data):?>
						<li class="icontype<?php echo $data['css'];?>"><a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?>(<?php echo $data["blogTitle"];?>)</a></li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>

	</div>
	<div id="rightContent">

		<?php //ranking ?>
		<?php echo $this->element('ranking'); ?>

		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>



		<div class="rightContentArea">
			<div class="rightMainContent">

				<div class="adArea pc">
					<ul>
						<?php foreach($adTags2 as $key=>$data):?>
							<li>
								<?php echo $data['AdTag']['tag'];?>
							</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</div>

		<!--
		<div class="adArea">
			<div class="adheight">

				<?php foreach($adTags5 as $key=>$data):?>
					<div class="adheightLeft">
						<?php echo $data['AdTag']['tag'];?>
					</div>
				<?php endforeach;?>
				<div class="clearfix"></div>
			</div>
		</div>
		-->
	</div>
	<div class="clearfix"></div>
</div>

