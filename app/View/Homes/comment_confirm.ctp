	<h3>以下の内容で投稿しますか？</h3>
	<?php echo $this->Form->create('Thread',array('type' => 'post','action' => '/commentComplete', 'name' => 'commentComplete')); ?>
	<?php echo $this->Form->hidden('Thread.race_id', array('value' => $comment['race_id'], 'name' => 'race_id')) ?>
	<p><?php echo $comment['Thread']['comment'] ?></p>
	<?php if(isset($encryptionFileName)): ?>
	<img src="/img/thread/<?php echo $comment['race_id']. DS . $encryptionFileName; ?>" alt="">
	<?php endif; ?>
	<?php echo $this->Form->end('投稿'); ?>
	<a href="<?php echo $comment['url'] ?>">出走表に戻る</a>
	<?php echo $encryptionFileName ?>