<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->css('admin');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php if(!empty($user["id"])):?>

				<div style="display:block;">
					<div style="float:left;display:block;">
						<h1><?php echo $this->Html->link('３連単５頭ボックス管理画面', '/admin/manages'); ?></h1>
					</div>
					<div style="float:right;display:block;">
							<p>ようこそ　<?php echo $user["username"];?>さん　<a href="/admin/manages/logout">ログアウト</a></p>
							<p style="text-algin:right;"></p>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="adminNavi">
					<ul>
						<li><a href="/admin/manageRaces/">レース管理</a></li>
						<li><a href="/admin/manageUser/">ユーザー管理</a></li>
						<li><a href="">予想管理</a></li>
						<li><a href="">掲示板管理</a></li>
						<li><a href="">こじはる管理</a></li>
						<li><a href="/admin/manageInformations/">お知らせ管理</a></li>
						<li><a href="/admin/manageAdTags/">広告管理</a></li>
						<li><a href="/admin/manages/user/">管理者管理</a></li>
						<li><a href="/" target="_blank">サイトを見る</a></li>
					</ul>
				</div>
				<div class="clearfix"></div>
			<?php else:?>
				<h1><?php echo $this->Html->link('３連単５頭ボックス管理画面', '/admin/manages'); ?></h1>


			<?php endif;?>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
