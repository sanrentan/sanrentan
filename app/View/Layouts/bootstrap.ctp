<!DOCTYPE html>
<html lang="jp">
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


	<script type="text/javascript">
	var nend_params = {"media":41672,"site":225960,"spot":644214,"type":2,"oriented":1};
	</script>
	<script type="text/javascript" src="https://js1.nend.net/js/nendAdLoader.js"></script>	
</head>

<body>
	<div class="navbar navbar-fixed-top2">
		<div class="navbar-inner2">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<div id="naviTop">
					<div id="logoArea">
						<h1><a class="brand" href="/"><img src="/img/common/logo.png" width="200" alt="AKBこじはる３連単５頭ボックス｜競馬予想<?php if(!empty($h1tag)):?>｜<?php echo $h1tag;?><?php endif;?>"></a></h1>
					</div>
					<div class="navi-profileImg">
						<?php if(!empty($user)):?>
							<a href="/users/edit">
								<?php if(!empty($user["profile_img"])):?>
									<img src="/img/profileImg/<?php echo $user['profile_img'];?>">
								<?php else:?>
									<img src="/img/common/noimage_person.png" style="max-height:58px;">
								<?php endif;?>
							</a>
						<?php endif;?>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="navi-collapse pc">
					<ul class="navi">
						<li><a href="/"><img src="/img/common/navi1.png"></a></li>
						<li><a href="/kojiharu_list"><img src="/img/common/navi2.png"></a></li>
						<li><a href="/about"><img src="/img/common/navi3.png"></a></li>
						<li class="pc"><a href="/contact"><img src="/img/common/navi4.png"></a></li>
						<?php if(!empty($user["id"])):?>
							<li><a href="/mypage"><img src="/img/common/navi_mypage.png"></a></a></li>
							<li><a href="/logout"><img src="/img/common/navi_logout.png"></a></a></li>
						<?php else:?>
							<li><a href="/regist"><img src="/img/common/navi5.png"></a></li>
							<li><a href="/login"><img src="/img/common/navi6.png"></a></li>
						<?php endif;?>
						<div class="clearfix"></div>
					</ul>
				</div><!--/.nav-collapse -->
				<div class="nav-collapse sp">
					<ul class="navi">
						<a href="/"><li>HOME</li></a>
						<a href="/kojiharu_list"><li>こじはる予想</li></a>
						<a href="/about"><li>当サイトについて</li></a>
						<a href="/contact"><li>お問い合わせ</li></a>
						<?php if(!empty($user["id"])):?>
							<a href="/mypage"><li>マイページ</li></a>
							<a href="/logout"><li>ログアウト</li></a>
						<?php else:?>
							<a href="/regist"><li>無料会員登録</li></a>
							<a href="/login"><li>ログイン</li></a>
							<a href="/twitter_login"><li>Twitter簡単ログイン</li></a>
						<?php endif;?>
						<div class="clearfix"></div>
					</ul>
				</div><!--/.nav-collapse -->
				<div class="navi-collapse2 sp">
					<ul class="navi2">
						<li class="pc"><a href="/"><img src="/img/common/navi1.png"></a></li>
						<li><a href="/kojiharu_list"><img src="/img/common/navi2.png"></a></li>
						<li><a href="/about"><img src="/img/common/navi3.png"></a></li>
						<li class="pc"><a href="/contact"><img src="/img/common/navi4.png"></a></li>
						<?php if(!empty($user["id"])):?>
							<li><a href="/mypage"><img src="/img/common/navi_mypage.png"></a></a></li>
							<li class="pc"><a href="/logout"><img src="/img/common/navi_logout.png"></a></a></li>
						<?php else:?>
							<li class="pc"><a href="/regist"><img src="/img/common/navi5.png"></a></li>
							<li><a href="/login"><img src="/img/common/navi6.png"></a></li>
						<?php endif;?>
						<div class="clearfix"></div>
					</ul>
				</div><!--/.nav-collapse -->
		</div>
	</div>

	<div class="containerBg">
		<div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

			<!--<div class="sp">
				<?php echo $this->element('ad'); ?>
			</div>
			-->

		</div> <!-- /container -->
	</div>

	<p class="titleLabel sp">メニュー</p>
	<div id="footer">

		<div id="footerContent">
			<div style="margin-bottom:10px">
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
					<div class="clearfix"></div>
				</ul>
			</div>
			<img src="/img/common/line_green_white.png">
			<p>Copyright © yamaty. All Rights Reserved.</p>
		</div>
	</div> <!-- /footer -->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->fetch('script'); ?>
	<?php echo $this->element('sql_dump'); ?>

</body>
</html>
