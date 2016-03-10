<p class="titleLabel">レース登録</p>

<div class="userForm">
	<?php echo $this->Form->create('Race'); ?>
	    <fieldset>
			<?php echo $this->Form->input('name',array("label"=>"レース名"));?>
			<?php echo $this->Form->input('full_name',array("label"=>"レース正式名称"));?>
			<?php echo $this->Form->input('placeArray',array("label"=>"競馬場"));?>
			<?php echo $this->Form->input('raceArray',array("label"=>"第何レース"));?>
			<?php echo $this->Form->input('grade',array("label"=>"グレード"));?>
			<?php echo $this->Form->input('distance',array("label"=>"距離"));?>

			<?php echo $this->Form->input('type', array('type' => 'select', 'options' => $typeArrays,"label"=>"芝・ダート"));?>
			<?php echo $this->Form->input('turn', array('type' => 'select', 'options' => $turnArrays,"label"=>"回り"));?>


			<?php echo $this->Form->input('race_date', 
				array(
					'type' => 'datetime',
					'dateFormat' => 'YMD',
					'monthNames' => false,
					'timeFormat' => '24',
					'separator' => '/',
					'label' => "レース日時",
					'minYear' => date('Y') - 1,
					'maxYear' => date('Y') + 1,
		    	));
		    ?>
			<?php echo $this->Form->input('view_flg', array('type' => 'select', 'options' => $viewArrays,"label"=>"公開状態"));?>
			<?php echo $this->Form->input('accepting_flg', array('type' => 'select', 'options' => $acceptArrays,"label"=>"受付状態"));?>
			<?php echo $this->Form->input('kojiharu_flg', array('type' => 'select', 'options' => $kojiharuArrays,"label"=>"こじはるフラグ"));?>
			<?php echo $this->Form->input('html_id',array("type"=>"text","label"=>"html_id"));?>

			<?php echo $this->Form->input('note',array("label"=>"備考欄","required"=>false));?>

		    <input type="submit" class="btn" value="登録">
	    </fieldset>
	<?php echo $this->Form->end();?>
</div>