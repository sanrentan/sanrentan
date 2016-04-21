<p class="titleLabel">お知らせ登録</p>

<div class="userForm">
	<?php echo $this->Form->create('Information'); ?>
	    <fieldset>
			<?php echo $this->Form->input('title',array("label"=>"title","required"=>true));?>
			<?php echo $this->Form->input('message',array("type"=>"textarea","label"=>"本文","required"=>false));?>
			<?php echo $this->Form->input('view_flg',array("type"=>"select","options"=>$view_flg ,"label"=>"表示フラグ","required"=>true,));?>
			<?php echo $this->Form->input('start_date', array(
					'type' => 'date',
					'dateFormat' => 'YMD',
					'monthNames' => false,
					'maxYear' => date('Y') + 1,
					'minYear' => date('Y') - 1,
					'label' => '公開日',
					'required' => true,
				));?>

		    <input type="submit" class="btn" value="登録">
	    </fieldset>
	<?php echo $this->Form->end();?>
</div>