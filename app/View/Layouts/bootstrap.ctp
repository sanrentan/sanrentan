<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php if(!empty($title_tag)):?><?php echo $title_tag; ?>｜こじはる３連単５頭ボックス<?php else:?>こじはる３連単５頭ボックス<?php endif;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $meta_description;?>">
	<meta name="keywords" content="<?php echo $meta_keywords;?>">
	<meta name="author" content="yamaty">

	<!-- Le styles -->
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<style>
	body {
		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	}
	</style>
	<?php echo $this->Html->css('bootstrap-responsive.min'); ?>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<!--
	<link rel="shortcut icon" href="/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
	-->
	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<?php echo $this->html->meta('icon','/ico/favicon.ico');?>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-73854308-1', 'auto');
	  ga('send', 'pageview');

	</script>
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="/"><img src="/img/common/logo.png" width="200" alt="3連単5頭BOXならだいたい当たる"></a>
				<?php if(!empty($user)):?><p class="sp navi-nickname"><?php echo $user["nickname"];?>さん</p><?php endif;?>
				<div class="nav-collapse">
					<ul class="nav">
						<li <?php if($naviType=="top"):?>class="active"<?php endif;?>><a href="/">Home</a></li>
						<li <?php if($naviType=="kojiharu"):?>class="active"<?php endif;?>><a href="/kojiharu_list">こじはる予想</a></li>
						<li <?php if($naviType=="about"):?>class="active"<?php endif;?>><a href="/about">当サイトについて</a></li>
						<li <?php if($naviType=="contact"):?>class="active"<?php endif;?>><a href="/contact">お問い合わせ</a></li>
						<?php if(!empty($user["id"])):?>
							<li <?php if($naviType=="mypage"):?>class="active"<?php endif;?>><a href="/mypage">マイページ</a></li>
							<li><a href="/logout">ログアウト</a></li>
						<?php else:?>
							<li <?php if($naviType=="regist"):?>class="active"<?php endif;?>><a href="/regist">無料会員登録</a></li>
							<li <?php if($naviType=="login"):?>class="active"<?php endif;?>><a href="/login">ログイン</a></li>
						<?php endif;?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

		<div id="footer">
			<div id="footerArea">

				<?php $footerAd = rand(1,10);?>

				<?php if($footerAd<=3):?>
					<?php //yahoo ;?>
					<a href="http://px.a8.net/svt/ejp?a8mat=2BY5X7+G6VFK2+2VOI+64C3L" target="_blank">
					<img border="0" width="728" height="90" alt="" src="http://www27.a8.net/svt/bgt?aid=141002107979&wid=003&eno=01&mid=s00000013437001028000&mc=1"></a>
					<img border="0" width="1" height="1" src="http://www14.a8.net/0.gif?a8mat=2BY5X7+G6VFK2+2VOI+64C3L" alt="">

				<?php elseif($footerAd<=5):?>
					<?php //さくら ;?>
					<a href="http://px.a8.net/svt/ejp?a8mat=2HJY3S+72TL8I+D8Y+C7TC1" target="_blank">
					<img border="0" width="728" height="90" alt="" src="http://www22.a8.net/svt/bgt?aid=150416488428&wid=003&eno=01&mid=s00000001717002052000&mc=1"></a>
					<img border="0" width="1" height="1" src="http://www12.a8.net/0.gif?a8mat=2HJY3S+72TL8I+D8Y+C7TC1" alt="">				

				<?php elseif($footerAd<=8):?>
					<?php //KLAN ;?>
					<a href="http://px.a8.net/svt/ejp?a8mat=2NDV7S+198ZIY+2KK8+HVFKX" target="_blank">
					<img border="0" width="728" height="90" alt="" src="http://www27.a8.net/svt/bgt?aid=160210504076&wid=003&eno=01&mid=s00000011996003002000&mc=1"></a>
					<img border="0" width="1" height="1" src="http://www18.a8.net/0.gif?a8mat=2NDV7S+198ZIY+2KK8+HVFKX" alt="">
				<?php else:?>
					<?php //オッズパーク ;?>
					<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+C3TD4Y+1JS2+C164X" target="_blank">
					<img border="0" width="728" height="90" alt="" src="http://www29.a8.net/svt/bgt?aid=160125251732&wid=003&eno=01&mid=s00000007229002021000&mc=1"></a>
					<img border="0" width="1" height="1" src="http://www18.a8.net/0.gif?a8mat=2NC1FN+C3TD4Y+1JS2+C164X" alt="">
				<?php endif;?>

			</div>

			<div id="bottomAd" class="sp">
				<?php $ad1 = rand(1,10);?>
				<?php if($ad1<=3):?>
						<?php //ターフィー競馬クラブ ?>
						<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+BZ1WAQ+3ETY+60OXD" target="_blank">
						<img border="0" width="300" height="250" alt="" src="http://www21.a8.net/svt/bgt?aid=160125251724&wid=003&eno=01&mid=s00000015919001011000&mc=1"></a>
						<img border="0" width="1" height="1" src="http://www12.a8.net/0.gif?a8mat=2NC1FN+BZ1WAQ+3ETY+60OXD" alt="">
				<?php elseif($ad1<=6):?>
						<?php //すご馬 ?>			
						<a href="http://px.a8.net/svt/ejp?a8mat=2NC1FN+C1FMPU+2W2E+62U35" target="_blank">
						<img border="0" width="300" height="250" alt="" src="http://www29.a8.net/svt/bgt?aid=160125251728&wid=003&eno=01&mid=s00000013487001021000&mc=1"></a>
						<img border="0" width="1" height="1" src="http://www12.a8.net/0.gif?a8mat=2NC1FN+C1FMPU+2W2E+62U35" alt="">
				<?php else:?>
						<?php //競馬データベース【KLAN】 ?>
						<a href="http://px.a8.net/svt/ejp?a8mat=2NDV7S+1990AQ+2KK8+HWAG1" target="_blank">
						<img border="0" width="350" height="240" alt="" src="http://www22.a8.net/svt/bgt?aid=160210504076&wid=003&eno=01&mid=s00000011996003006000&mc=1"></a>
						<img border="0" width="1" height="1" src="http://www15.a8.net/0.gif?a8mat=2NDV7S+1990AQ+2KK8+HWAG1" alt="">
				<?php endif;?>

			</div>

			<ul>
				<a href="/"><li>HOME</li></a>
				<a href="/kojiharu_list"><li>こじはる予想</li></a>
				<a href="/about"><li>当サイトについて</li></a>
				<a href="/contact"><li>お問い合わせ</li></a>
				<a href="/mypage" class="sp"><li>マイページ</li></a>
				<a href="/regist" class="sp"><li>無料会員登録</li></a>
				<a href="/login" class="sp"><li>ログイン</li></a>
				<a href="http://www.jra.go.jp/"  target="_blank"><li>JRA(外部サイト)</li></a>
				<a href="http://www.akb48.co.jp/" target="_blanl"><li>AKB公式サイト(外部サイト)</li></a>
			</ul>
			<div class="clearfix"></div>
			<p>Copyright © yamaty. All Rights Reserved.</p>


			
		</div>

	</div> <!-- /container -->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->fetch('script'); ?>
	<?php echo $this->element('sql_dump'); ?>

</body>
</html>
