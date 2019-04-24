								<table class="table table-striped table-hover table-bordered">
								<thead>
								<tr>
								    <th>
										 Sr. No.
									</th>
									<th>
										 Date
									</th>
									
									<th>
										 Faculty Name
									</th>
									<th>
										 Title
									</th>
									<th width="200px">
										 Content
									</th>
									<th>
										Attachment
									</th>
									
									<th>
										 Status
									</th>
									<th>
										 Delete
									</th>
								</tr>
								</thead>
								<tbody>
					<?php $i=1; foreach ($postallList as  $value) {  ?>
								<tr>
									<td>
										<?php echo $i++;?>
									</td>
									<td>
									<?php 
                                        echo date("d/m/Y",strtotime($value['date']));?>
									</td>
									<td>
									<a href="<?php echo base_url('Medi_varsity/facultyDetail/'.$value['user_id'])?>"><?php echo $value['name'];?></a>
									</td>
									<td class="center">
								    <a href="<?php echo base_url('Medi_varsity/postDetail/'.$value['id'])?>"><?php echo $value['title'];?></a>
									</td>
									<td>
										 <?php echo $value['content'];?>
									</td>
									<td>
										<?php echo $value['attachment'];?>
									</td>
									
									
									
									<td>
									<div class="btn-group" >
						<?php if($value['status'] == 0) {?>
						<a class="btn btn-success blockunblock" data-stat="<?php echo $value['status'];?>" data-id="<?php echo $value['id'];?>" style="height:30px;" >Approve</a>
										<?php } else {?>
										<a class="btn btn-success blockunblock" data-stat="<?php echo $value['status'];?>" data-id="<?php echo $value['id'];?>" style="height:30px;" >Unapprove</a>
										<?php }?>		
										<!-- <a class="btn btn-danger" style="height:30px;" onclick="deletepost(<?php echo $value['id']?>);">Delete</a>
											</div> -->
											</td>
											<td>
									<a class="btn btn-danger" style="height:30px;" 
onclick="doConfirm('Are you sure?', function yes() {
	deletepost(<?php echo $value['id']?>);}, function no() { //alert('no')
	 });">Delete</a>
										
									</td>
								</tr>
							<?php }?>
								</tbody>
								</table>

								<script type="text/javascript">
  $(".blockunblock").click(function()  
  { 
  	  	var $btn = $(this);
  	 $btn.button('loading'); 
  	 setTimeout(function(){
  	 	$btn.button('reset');
  	 },200000);
     var status = $(this).data('stat');
     var id = $(this).data('id');
      // alert(status+'aa'+id);
  $.ajax({
                    url: "<?php echo site_url();?>Medi_varsity/approveunapprovepost",
                    method: "POST",
                    data: {'status':status,'id':id},
                    dataType: "json",
                    success: function(data)
                    {
                     if(data.exist == 1){
                
                    jQuery('#notifysuccesspost').html('<span style="color:green; font-family: Helvetica"  id="emA">One User Approve</span>');
                    jQuery('#emA').delay(3200).fadeOut(300);

                     }else if(data.exist == 0){
                 
                    jQuery('#notifysuccesspost').html('<span style="color:green; font-family: Helvetica"  id="emA">One User Unpprove</span>');  
                    jQuery('#emA').delay(3200).fadeOut(300);
                     }
                    }
                    
                });
  });               
</script>

