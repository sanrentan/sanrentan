<?php echo $message;?>


<?php echo $this->Form->create('Expectation',array('type' => 'post'));?>
<?php echo $this->Form->input( 'Expectation.item', array( 
    'type' => 'select', 
    'multiple'=> 'checkbox',
    'options' => $horseData, 
    'label' => '選んでください', 
//  'selected' => $selected  // 規定値は、valueを配列にしたもの
//  'div' => false           // div親要素の有無(true/false)
));?>
<?php echo $this->Form->end('送信');?>
