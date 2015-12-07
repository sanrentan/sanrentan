<?php echo $message;?>

<?php echo $this->Form->create('Expectation',array('type' => 'post','action'=>'/complete'));?>
<?php foreach($postData["Expectation"]['item'] as $key=>$data){
	echo "選択".$key.":".$data."<br>";
	echo $this->Form->hidden('item][',array("value"=>$data));
}
?>


<?php echo $this->Form->button('戻る',array('onclick'=>'history.back()'));?>
<?php echo $this->Form->end('送信');?>
