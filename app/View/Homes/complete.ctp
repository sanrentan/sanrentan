<div id="mainContent">
	<div id="leftContent">
		<div id="userArea">
			<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)</p>
			<div id="raceDetailTxt">
				<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
				<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
				<p><?php echo $raceData["Race"]["note"];?></p>
				<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
			</div>

			<p class="red" style="padding-left:10px">登録しました。</p>

			<div class="buttonArea">
				<ul>
					<li>
						<a href="https://twitter.com/share" class="twitter-share-button btn-block-sp" data-url="http://www.sanrentan-box.com/detail/<?php echo $raceData['Race']['id'];?>" data-text="<?php echo $raceData['Race']['name'];?>の３連単予想！「<?php foreach($expectationData["selectData"] as $key=>$data):?><?php if($key==0):?><?php echo $data["RaceCard"]["uma"];?><?php else:?>-<?php echo $data["RaceCard"]["uma"];?><?php endif;?><?php endforeach;?>」" data-lang="ja" data-size="large" data-hashtags="３連単予想">ツイート</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</li>
					<li><a href="/" class="btn btn-primary btn-block-sp">トップページへ</a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div id="rightContent">
		<?php //公式twitter ?>
		<?php echo $this->element('twitter_timeline'); ?>
	</div>
	<div class="clearfix"></div>
</div>

