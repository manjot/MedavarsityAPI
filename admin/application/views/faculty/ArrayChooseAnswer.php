
<?php
if(!empty($allAnswerquest)) {
	if($_SESSION['check'] == 0)
	{
 $x = 1; foreach ($allAnswerquest as $value) { ?> 
<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td><?php echo $value['option_answer']?></td></tr>

<?php  }?>
<?php } else {?>

<?php
 $x = 1; foreach ($allAnswerquest as $value) 
 { 
 $qw = base_url('assets/test_img/'.$value['image_url']);
// echo "<pre>";print_r($qw);die;
 // if(file_exists($qw))
 	if (fopen($qw, 'r'))
 	// { echo "<pre>";print_r($qw);die;}
{?>

	<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td><img src="<?php echo base_url(); ?>assets/test_img/<?php echo $value['image_url']?>" height=50px" width="50px"/></td></tr>
<?php  } else{ ?>


<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td><?php echo $value['image_url']?></td></tr>

<?php  } ?>
<?php  } ?>


<?php  }?>


<?php  }?>




<!-- <?php
if(!empty($allAnswerquest)) {
	if($_SESSION['check'] == 0)
	{
 $x = 1; foreach ($allAnswerquest as $value) { ?> 
<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td><?php echo $value['option_answer']?></td></tr>
<?php  }?>
<?php } else {?>
<td style="width: 30px;">nisar</td>
<?php  }?>
<?php  }?> -->

