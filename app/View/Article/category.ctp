<div id="mainContent">
	<div id="leftContent">
		<div class="sp">
				<?php //広告mini ?>
			<?php echo $this->element('adMini'); ?>
		</div>
		<div id="articleContent">
			<p class="titleLabel"><?php echo $category['ArticleCategory']['name'];?>一覧</p>
			<dl class="articleList">
				<?php foreach($articleList as $key => $data):?>
					<?php $target = date("Y-m-d H:i:s",strtotime("+6 day" ,strtotime($data['Article']['start_date'])));?>
					<dt><?php echo date('Y年m月d日',strtotime($data['Article']['start_date']));?><?php if($target>=date('Y-m-d H:i:s')):?> <span class="new">NEW</span><?php endif;?><dt>
					<dd><a href="/article/<?php echo $data['Article']['id'];?>"><?php echo $data['Article']['title'];?></a></dd>
				<?php endforeach;?>
			</dl>
			<?php //echo $this->element('pager_user'); ?>
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


