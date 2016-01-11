<p class="titleLabel"><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)</p>

<div id="raceDetailTxt">
	<p><?php echo date("Y年m月d日",strtotime($raceData["Race"]["race_date"]));?>　</p>
	<p><?php echo $raceData["Race"]["place"];?>　<?php echo $raceData["Race"]["full_name"];?> (G<?php echo $raceData["Race"]["grade"];?>)　<?php echo $typeArr[$raceData["Race"]["type"]];?>　<?php echo $raceData["Race"]["distance"];?>m　<?php echo $turnArr[$raceData["Race"]["turn"]];?></p>
	<p><?php echo $raceData["Race"]["note"];?></p>
	<p>発走時刻：<?php echo date("H時i分",strtotime($raceData["Race"]["race_date"]));?></p>
	<br>
	<p class="red">登録しました。</p>
	<a href="/">トップページへ</a>
</div>



