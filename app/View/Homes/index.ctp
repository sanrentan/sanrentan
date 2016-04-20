<div id="mainBannerArea">
	<div id="mainBannerAreaLeft">
		<img src="/img/common/koji1.jpg">
	</div>
	<div id="mainBannerAreaRight" class="pc">
		<p class="titleLabelKojiharu">最新のこじはる予想！</p>
		<div id="recentKojiharuArea">
			<p><?php echo date("m月d日",strtotime($recentKojiharu["Race"]["race_date"]));?> <a href="/detail/<?php echo $recentKojiharu['Race']['id'];?>"><?php echo $recentKojiharu["Race"]["name"];?><?php if($recentKojiharu['Race']['grade']>0):?> (G<?php echo $recentKojiharu['Race']['grade'];?>)<?php endif;?></a></p>
			<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?>
				<p><span class="wk<?php echo $data['wk'];?>"><?php echo $data["uma"];?></span><?php echo $data["name"];?></p>
			<?php endforeach;?>
		</div>

		<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com" data-text="<?php echo $recentKojiharu['Race']['name'];?>の３連単予想！「<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?><?php if($key==0):?><?php echo $data["uma"];?><?php else:?>-<?php echo $data["uma"];?><?php endif;?><?php endforeach;?>
」" data-via="sanrentan_box" data-lang="ja" data-size="large" data-hashtags="こじはる３連単予想">ツイート</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


		<div id="subBannerArea"><img src="/img/common/umairasto.png" style="max-width:150px;"></div>	
	</div>
	<div class="clearfix"></div>
</div>
<div id="mainContent">
	<div id="leftContent">

		<div id="mainBannerAreaRight" class="sp">
			<p class="titleLabelKojiharu">最新のこじはる予想！</p>
			<p style="padding-left:10px;"><?php echo date("m月d日",strtotime($recentKojiharu["Race"]["race_date"]));?> <a href="/detail/<?php echo $recentKojiharu['Race']['id'];?>"><?php echo $recentKojiharu["Race"]["name"];?><?php if($recentKojiharu['Race']['grade']>0):?> (G<?php echo $recentKojiharu['Race']['grade'];?>)<?php endif;?></a></p>
			<div id="recentKojiharuArea">
				<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?>
					<p><span class="wk<?php echo $data['wk'];?>"><?php echo $data["uma"];?></span><?php echo $data["name"];?></p>
				<?php endforeach;?>

				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.sanrentan-box.com" data-text="<?php echo $recentKojiharu['Race']['name'];?>の３連単予想！「<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?><?php if($key==0):?><?php echo $data["uma"];?><?php else:?>-<?php echo $data["uma"];?><?php endif;?><?php endforeach;?>
		」" data-via="sanrentan_box" data-lang="ja" data-size="large" data-hashtags="こじはる３連単予想">ツイート</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

			</div>
			<div id="subBannerArea"><img src="/img/common/umairasto.png" style="max-width:150px;"></div>	
			<div class="clearfix"></div>
		</div>

		<p class="titleLabel">現在受付中のレース（※当サイト受付分のみ）</p>
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

		<p class="titleLabel light">お知らせ</p>
		<ul class="information">
			<li class="news"> 2016年4月3日　<a href="/result/44">桜花賞(G1)</a>で当サイトから予想的中者がでました。おめでとうござます！</li>
			<li class="news"> 2016年4月3日　<a href="/result/42">阪神牝馬ステークス(G2)</a>で当サイトから予想的中者がでました。おめでとうござます！</li>
			<li class="news"> 2016年4月3日　<a href="/result/41">ダービー卿チャレンジトロフィー(G3)</a>で当サイトから予想的中者がでました。おめでとうござます！</li>
			<li class="news"> 2016年4月3日　<a href="/result/40">産経大阪杯(G2)</a>で当サイトから予想的中者がでました。おめでとうござます！</li>
			<li class="news"> 2016年3月27日　<a href="/result/38">マーチステークス</a>で当サイトから予想的中者がでました。おめでとうござます！</li>
			<li class="news"> 2016年3月26日　<a href="/result/36">毎日杯</a>で当サイトから予想的中者がでました。おめでとうござます！</li>
			<li class="news"> 2016年3月24日　<a href="/users/twitter_login">Twitterアカウント連携</a>を行いました。会員登録やログインが簡単に可能になりました。</li>
		</ul>

		<?php if(!empty($newsRss)):?>
			<p class="titleLabel light">競馬ニュース(競馬JAPAN)</p>
			<ul class="information keibajapan">
				<?php foreach($newsRss as $key=>$data):?>
					<li class="icontype0">　<a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?></a></li>
				<?php endforeach;?>
			</ul>
		<?php endif;?>

		<!--
		<p class="titleLabel light">競馬予想</p>
		<ul class="information">
			<?php foreach($expectRss as $key=>$data):?>
				<li><a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?>(<?php echo $data["blogTitle"];?>)</a></li>
			<?php endforeach;?>
		</ul>
		-->

		<p class="titleLabel light">まとめサイト</p>
		<ul class="information matomeList">
			<?php foreach($matomeRss as $key=>$data):?>
				<li class="icontype<?php echo $data['css'];?>"><a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?>(<?php echo $data["blogTitle"];?>)</a></li>
			<?php endforeach;?>
		</ul>

	</div>
	<div id="rightContent">

<p class="titleLabel light sp">公式Twitter</p>
<div class="twitterArea">
	<a class="twitter-timeline" href="https://twitter.com/sanrentan_box" data-widget-id="695993921566932996">@sanrentan_boxさんのツイート</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>


<div class="adArea pc">
	<ul>
		<?php foreach($adTags2 as $key=>$data):?>
			<li>
				<?php echo $data['AdTag']['tag'];?>
			</li>
		<?php endforeach;?>
		<?php foreach($adTags3 as $key=>$data):?>
			<li>
				<?php echo $data['AdTag']['tag'];?>
			</li>
		<?php endforeach;?>

	</ul>
	<div class="adheight">

		<?php foreach($adTags5 as $key=>$data):?>
			<div class="adheightLeft">
				<?php echo $data['AdTag']['tag'];?>
			</div>
		<?php endforeach;?>
		<div class="clearfix"></div>

	</div>

	<?php /**
	<div class="adheight">
		<div class="adheightLeft">
			<?php //極ウマ ?>
			<a href="http://px.a8.net/svt/ejp?a8mat=2NDV7S+169U9U+2UEY+61C2P" target="_blank">
			<img border="0" width="120" height="600" alt="" src="http://www24.a8.net/svt/bgt?aid=160210504071&wid=003&eno=01&mid=s00000013273001014000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www13.a8.net/0.gif?a8mat=2NDV7S+169U9U+2UEY+61C2P" alt="">
		</div>
		<div class="adheightRight">
			<div id="inner_space"><img src="http://blogparts.blogmura.com/pts/pvcount.GIF?chid=1026830" border="0" width="0" height="0" alt="blogmura_pvcount"><iframe id="parts_frame" name="testframe" src="http://blogparts.blogmura.com/pts/blogmura_parts.html?var=20130204ver1&amp;chid=1026830&amp;bgcolor=ffffff&amp;link=001eff&amp;size=160&amp;time=600000&amp;cat=134&amp;subcat=9141&amp;select=rank&amp;host=http://umasoku.doorblog.jp/&amp;border=2&amp;dspSize=0&amp;bgcolor2=F7F7F7&amp;link2=001eff&amp;frameWindow=http://umasoku.doorblog.jp/&amp;frameParent=https://www.google.co.jp/&amp;isFrame=false" width="160px" frameborder="0" border="0" scrolling="no" bordercolor="#00CC00" hspace="0" vspace="0" marginheight="0" marginwidth="0" style="height: 569px;"></iframe>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	*/?>

</div>


	</div>
	<div class="clearfix"></div>
</div>

