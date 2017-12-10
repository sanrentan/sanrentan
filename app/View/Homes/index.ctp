<div id="mainBannerArea">
	<?php if(!$isSp):?>
		<div id="mainBannerAreaLeft">
			<img src="/img/common/koji1.jpg">
		</div>
	<?php else:?>
		<div class="sp">
			<?php echo $this->element('adMini'); ?>
		</div>
	<?php endif;?>
	<p class="titleLabel sp">こじはる最新予想</p>
	<div id="mainBannerAreaRight">
		<?php echo $this->element('recentKojiharu'); ?>
	</div>

	<?php //広告 ?>
	<div class="sp">
		<?php echo $this->element('ad'); ?>
	</div>
	<div class="clearfix"></div>
</div>
<div id="mainContent">
	<div id="leftContent">

		<div id="leftContentMain">
			<div class="listArea">
				<h3 class="titleLabel">現在受付中のレース（※当サイト受付分のみ)</h3>
				<ul class="raceList">
					<?php if(!empty($acceptingRace)):?>
						<?php foreach($acceptingRace as $key=>$data):?>
							<li class="pc">
								<span><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></span>
								<span class="racePlace"><?php echo $data['Race']['place'];?></span>　
								<span class="raceName">
									<a href="/detail/<?php echo $data['Race']['id'];?>">
										<?php echo $data['Race']['name'];?><?php if($data['Race']['grade']>0):?> (G<?php echo $data['Race']['grade'];?>)<?php endif;?>
									</a>
								</span>
								<?php if($data['Race']['kojiharu_flg']):?>　<span class="kojiharuRace">こじはる予想レース</span><?php endif;?>
							</li>
							<li class="sp">
								<span><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></span>
								<span class="racePlace"><?php echo $data['Race']['place'];?></span><br>
								<span class="raceName">
									<a href="/detail/<?php echo $data['Race']['id'];?>">
										<?php echo $data['Race']['name'];?><?php if($data['Race']['grade']>0):?> (G<?php echo $data['Race']['grade'];?>)<?php endif;?>
									</a>
								</span>
								<?php if($data['Race']['kojiharu_flg']):?>　<br><span class="kojiharuRace">こじはる予想レース</span><?php endif;?>
							</li>
						<?php endforeach;?>
					<?php else:?>
						<li>※現在受付中のレースはありません。</li>
					<?php endif;?>
				</ul>
			</div>

			<!--
			<div class="listArea">
				<h3 class="titleLabel">特集記事</h3>
				<ul class="raceList">
					<?php foreach($articleData as $key=>$data):?>
						<li>
							<?php $target = date("Y-m-d H:i:s",strtotime("+6 day" ,strtotime($data['Article']['start_date'])));?>
							<span class="racePlace"><a href="/article/<?php echo $data['Article']['id'];?>"><?php echo $data['Article']['title'];?></a><?php if($target>=date('Y-m-d H:i:s')):?> <span class="kojiharuRace">NEW</span><?php endif;?></span><br>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
			-->

			<div class="listArea">
				<h3 class="titleLabel">過去５レースの結果（※当サイト受付分のみ）</h3>
				<ul class="raceList pc">
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
				<ul class="raceList sp">
					<?php foreach($recentRace as $key=>$data):?>
						<li>
							<span><?php echo date("m月d日",strtotime($data["Race"]["race_date"]));?></span>
							<span class="racePlace"><?php echo $data['Race']['place'];?></span><br>
							<span class="raceName">
								<a href="/result/<?php echo $data['Race']['id'];?>">
									<?php echo $data['Race']['name'];?><?php if($data['Race']['grade']>0):?> (G<?php echo $data['Race']['grade'];?>)<?php endif;?>
								</a>
							</span>
							<?php if($data['Race']['kojiharu_flg']):?>　<br><span class="kojiharuRace">こじはる予想レース</span><?php endif;?>
						</li>
					<?php endforeach;?>
				</ul>
			</div>

			<div class="listArea">
				<h3 class="titleLabel">お知らせ</h3>
				<ul class="raceList">
					<?php foreach($infoData as $key=>$data):?>
						<li class="news"> <?php echo date("Y年m月d日",strtotime($data["Information"]["start_date"]));?><br>&nbsp;<?php echo $data['Information']['title'];?></li>
					<?php endforeach;?>
				</ul>
			</div>

			<?php if(!empty($newsRss)):?>
				<div class="listArea">
						<h3 class="titleLabel">競馬ニュース(競馬JAPAN)</h3>
						<ul class="information keibajapan">
							<?php foreach($newsRss as $key=>$data):?>
								<li class="icontype0">　<a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?></a></li>
							<?php endforeach;?>
						</ul>
				</div>
			<?php endif;?>

			<div class="listArea">
				<h3 class="titleLabel">まとめサイト</h3>
				<ul class="information matomeList">
					<?php foreach($matomeRss as $key=>$data):?>
						<li class="icontype<?php echo $data['css'];?>"><a href="<?php echo $data['link'];?>" target="_blank"><?php echo $data['title'];?>(<?php echo $data["blogTitle"];?>)</a></li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>

	</div>
	<div id="rightContent">

		<?php //広告 ?>
		<div class="pc">
			<?php echo $this->element('ad'); ?>
		</div>

		<?php //ranking ?>
		<?php echo $this->element('ranking'); ?>

		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>

		<?php //PR ?>
		<?php echo $this->element('pr'); ?>


	</div>
	<div class="clearfix"></div>
</div>

