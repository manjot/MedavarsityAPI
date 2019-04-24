
<?php
if(!empty($allAnswerquest2)) {
	if($_SESSION['check'] == 0)
	{
 $x = 1; foreach ($allAnswerquest2 as $value) { ?>
 <?php if($value['correct_answer'] == 0) {?> 
<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td style=""><?php echo $value['option_answer']?></td></tr>
<?php  } else if($value['correct_answer'] == 1) {?>
<tr><td style="width: 30px; color:;
    font-weight: bold;"><?php echo $x++; ?></td>
	<td style=" color: #1fb73a;
    font-weight: bold;"><?php echo $value['option_answer']?></td></tr>
<?php  }?>
<?php  }?>
<?php } else {?>

<?php
 $x = 1; foreach ($allAnswerquest2 as $value) { 
 $qw = base_url('assets/test_img/'.$value['image_url']);
 	if (fopen($qw, 'r')) {?>
    <?php if($value['correct_answer'] == 0) {?>
	<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td><img style="margin-top: 4px;" src="<?php echo base_url(); ?>assets/test_img/<?php echo $value['image_url']?>" height="50px" width="50px"/></td></tr>
<?php } else if($value['correct_answer'] == 1) {?>
    <tr><td style="width: 30px;font-weight: bold;"><?php echo $x++; ?></td>
	<td><img style="margin-top: 4px; border: 2px solid #00ff4e;" src="<?php echo base_url(); ?>assets/test_img/<?php echo $value['image_url']?>" height="50px" width="50px"/></td></tr>
<?php }?>
<?php  } else{ ?>


<tr><td style="width: 30px;"><?php echo $x++; ?></td>
	<td><?php echo $value['image_url']?></td></tr>

<?php  } ?>
<?php  } ?>


<?php  }?>


<?php  }?>