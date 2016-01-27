	<h3>以下の内容で投稿しますか？</h3>
	<?php echo $this->Form->create('thread',array('type' => 'post','action' => '/commentComplete', 'name' => 'commentComplete')); ?>
	<?php echo $this->Form->hidden('thread.race_id', array('value' => $comment['race_id'], 'name' => 'race_id')) ?>
	<p><?php echo $comment['thread']['comment'] ?></p>
	<?php echo $this->Form->end('投稿'); ?>
	<a href="<?php echo $comment['url'] ?>">出走表に戻る</a>