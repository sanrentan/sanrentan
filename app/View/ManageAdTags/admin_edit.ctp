<p class="titleLabel">広告編集</p>

<div class="userForm">
	<?php echo $this->Form->create('AdTag'); ?>
	    <fieldset>
			<?php echo $this->Form->input('name',array("label"=>"名前","required"=>true));?>
			<?php echo $this->Form->input('type',array("type"=>"select","options"=>$banner_size ,"label"=>"タイプ","required"=>true,));?>
			<?php echo $this->Form->input('tag',array("label"=>"タグ","required"=>true));?>
			<?php echo $this->Form->input('rank',array("label"=>"ランク","required"=>true));?>
			<?php echo $this->Form->input('note',array("label"=>"備考欄"));?>
		    <input type="submit" class="btn" value="更新">
	    </fieldset>
	<?php echo $this->Form->end();?>
</div>