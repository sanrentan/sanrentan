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
		<div id="subBannerArea"><img src="/img/common/umairasto.png" style="max-width:150px;"></div>	
	</div>
	<div class="clearfix"></div>
</div>
<div id="mainContent">
	<div id="leftContent">

		<div id="mainBannerAreaRight" class="sp">
			<p class="titleLabelKojiharu">最新のこじはる予想！</p>
			<div id="recentKojiharuArea">
				<p><?php echo date("m月d日",strtotime($recentKojiharu["Race"]["race_date"]));?> <a href="/detail/<?php echo $recentKojiharu['Race']['id'];?>"><?php echo $recentKojiharu["Race"]["name"];?><?php if($recentKojiharu['Race']['grade']>0):?> (G<?php echo $recentKojiharu['Race']['grade'];?>)<?php endif;?></a></p>
				<?php foreach($recentKojiharu["Expectation"]["view"] as $key=>$data):?>
					<p><span class="wk<?php echo $data['wk'];?>"><?php echo $data["uma"];?></span><?php echo $data["name"];?></p>
				<?php endforeach;?>
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
			<li>2016年1月10日　[こじはる]<a href="http://ameblo.jp/akihabara48/entry-12115448437.html" target="_blank">「祝 高橋みなみ卒業“148.5cmの見た夢”in 横浜スタジアム」／チケット先行発売のご案内</a></li>
			<li>2016年1月10日　[競馬]シンザン記念の受付を開始しました</li>
			<li>2016年1月10日　サイトをオープンしました。</li>
		</ul>

		<?php if(!empty($newsRss)):?>
			<p class="titleLabel light">競馬ニュース(競馬JAPAN)</p>
			<ul class="information matomeList">
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
		<li>
			<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+BZ1VIY+3ETY+60OXD" target="_blank">
			<img border="0" width="300" height="250" alt="" src="http://www24.a8.net/svt/bgt?aid=160125251724&wid=002&eno=01&mid=s00000015919001011000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www18.a8.net/0.gif?a8mat=2NC1FN+BZ1VIY+3ETY+60OXD" alt="">
		</li>
		<li>
			<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+C1FLY2+2W2E+62U35" target="_blank">
			<img border="0" width="300" height="250" alt="" src="http://www20.a8.net/svt/bgt?aid=160125251728&wid=002&eno=01&mid=s00000013487001021000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www17.a8.net/0.gif?a8mat=2NC1FN+C1FLY2+2W2E+62U35" alt="">
		</li>
		<li>
			<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+CAD40Q+2QQG+61JSH" target="_blank">
			<img border="0" width="336" height="280" alt="" src="http://www27.a8.net/svt/bgt?aid=160125251743&wid=002&eno=01&mid=s00000012796001015000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www13.a8.net/0.gif?a8mat=2NC1FN+CAD40Q+2QQG+61JSH" alt="">
		</li>
		<li>
			<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+BZNB4Q+2X50+626XT" target="_blank">
			<img border="0" width="320" height="50" alt="" src="http://www25.a8.net/svt/bgt?aid=160125251725&wid=002&eno=01&mid=s00000013626001018000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www17.a8.net/0.gif?a8mat=2NC1FN+BZNB4Q+2X50+626XT" alt="">
		</li>
		<li>
			<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+C3TCD6+1JS2+C9QS1" target="_blank">
			<img border="0" width="350" height="80" alt="" src="http://www20.a8.net/svt/bgt?aid=160125251732&wid=002&eno=01&mid=s00000007229002061000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www16.a8.net/0.gif?a8mat=2NC1FN+C3TCD6+1JS2+C9QS1" alt=""></li>
		<li>
			<a href="http://px.a8.net/svt/ejp?a8mat=1ZOP8H+85IQSA+50+2HK0TD" target="_blank">
			<img border="0" width="350" height="80" alt="" src="http://www21.a8.net/svt/bgt?aid=120405185493&wid=002&eno=01&mid=s00000000018015042000&mc=1"></a>
			<img border="0" width="1" height="1" src="http://www16.a8.net/0.gif?a8mat=1ZOP8H+85IQSA+50+2HK0TD" alt="">
		</li>
	</ul>

	<div id="inner_space"><img src="http://blogparts.blogmura.com/pts/pvcount.GIF?chid=1026830" border="0" width="0" height="0" alt="blogmura_pvcount"><iframe id="parts_frame" name="testframe" src="http://blogparts.blogmura.com/pts/blogmura_parts.html?var=20130204ver1&amp;chid=1026830&amp;bgcolor=ffffff&amp;link=001eff&amp;size=160&amp;time=600000&amp;cat=134&amp;subcat=9141&amp;select=rank&amp;host=http://umasoku.doorblog.jp/&amp;border=2&amp;dspSize=0&amp;bgcolor2=F7F7F7&amp;link2=001eff&amp;frameWindow=http://umasoku.doorblog.jp/&amp;frameParent=https://www.google.co.jp/&amp;isFrame=false" width="160px" frameborder="0" border="0" scrolling="no" bordercolor="#00CC00" hspace="0" vspace="0" marginheight="0" marginwidth="0" style="height: 569px;"></iframe>
	</div>
</div>


	</div>
	<div class="clearfix"></div>
</div>

