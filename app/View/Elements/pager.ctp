<div class="paging">
<?php echo $this->Paginator->first('<<', array('class'=>'prev'), null, array('class' => 'prev disabled'));?>
<?php echo $this->Paginator->prev('<', array('class'=>''), null, array('class' => 'prev disabled'));?>
<?php echo $this->Paginator->numbers(array('separator' => '','modulus'=>6));?>
<?php echo $this->Paginator->next('>', array('class' => 'next2'), null, array('class' => 'next disabled'));?>
<?php echo $this->Paginator->last('>>', array('class' => 'next'), null, array('class' => 'next disabled'));?>
</div>
