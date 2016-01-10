<div id="mainBannerArea">
	<div id="mainBannerAreaLeft">
		<img src="/img/common/koji1.jpg">
	</div>
	<div id="mainBannerAreaRight">
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
		<p class="titleLabel">現在受付中のレース</p>
		<ul class="raceList">
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
		</ul>


		<p class="titleLabel">過去５レースの結果（※当サイト受付分のみ）</p>
		<ul class="raceList">
			<?php foreach($recentRace as $key=>$data):?>
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
		</ul>
		もっとみる

		<p class="titleLabel">お知らせ</p>
		<ul class="information">
			<li>2016年1月10日　[こじはる]<a href="http://ameblo.jp/akihabara48/entry-12115448437.html" target="_blank">「祝 高橋みなみ卒業“148.5cmの見た夢”in 横浜スタジアム」／チケット先行発売のご案内</a></li>
			<li>2016年1月10日　[競馬]シンザン記念の受付を開始しました</li>
			<li>2016年1月10日　サイトをオープンしました。</li>
		</ul>

	</div>
	<div id="rightContent">
		<ul>
			<li><img src="/img/common/rightBanner1.jpg"></li>
			<li><a href="http://www.jra.go.jp/" target="_blank"><img src="/img/common/jra_log.jpeg"></a></li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>

