<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
   <div class="page-content" style="width: 1266px;">
      <!-- END STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
         Query  <span style="margin-left:40px;" id="notifysuccessQuery"></span>
      </h3>
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <i class="fa fa-home"></i>
               <a href="<?php echo site_url('Superadmin/index')?>">Home</a>
               <i class="fa fa-angle-right"></i>
            </li>
            <li>
               <a href="<?php echo site_url('Superadmin/querylist')?>">All Query</a>
            </li>
         </ul>
         <div class="page-toolbar">
            <!--</div>-->
         </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->
                   <div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue" style="width: 1159px;">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-edit"></i>Query Listing
								</div>
								
							</div>
							<div class="portlet-body">
								<div class="table-toolbar">
								<div class="filterInvoice">
								<table class="table table-striped table-hover table-bordered">
								<thead>
								<tr>
									<th>
									  Sr.No.
									</th>
									<th>
										Name
									</th>
									
									<th>
										Email
									</th>
									<th>
										Phone Number
									</th>
									<th>
									 Address
									</th>
									<th>
									  Messages
									</th>
									<th>
									   Delete
									</th>
								
								</tr>
								</thead>
								<tbody>
									 <?php $i=1; foreach($arrQuery as $query) {?>
								<tr id="row_<?php echo $query['id'];  ?>">
									<th>
										 <?php echo $i++;?>
									  </th>
									  
									<th>
                                 <?php echo $query['name'];?>
                                   </th>
									
									 <th>
                                 <?php echo $query['email'];?>
                              </th>
							  
									
								 <th>
                                 <?php echo $query['contact_num'];?>
                              </th>
							  

								 <th>
                                 <?php echo $query['address'];?>
                              </th>
							  
									
							  <th>
                                 <?php echo $query['message'];?>
                              </th>
							    <th width="10%">
                                 <div class="btn-group">
                                    <a class="btn btn-danger" style="height:30px;" onclick="deleteQuery(<?php echo $query['id']; ?>);">Delete</a>
                                 </div>
                              </th>
							  
								  	
							
								
								</tr>
								<?php }?>
								</tbody>
								</table>
								</div>				
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
			</div>
      <!-- END PAGE CONTENT-->
   </div>
</div>
<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
<!--Cooming Soon...-->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php $this->load->view('includes/footeradmin');?>
<script type="text/javascript">
   function deleteQuery(id)
   {
   
   	if (confirm("Are you sure do you want to delete?"))
   	{
           $.ajax({
   				url: "<?php echo base_url();?>Superadmin/deleteQuery",
   				method: "POST",
   				data: {'queryId':id},
   				dataType: "json",
   				success: function(data)
   				{
   				  if(data.success == 1)
   				  {
   					$("#row_"+id).hide();
   					$('#notifysuccessQuery').html('<span class="notifq" style="color:green; font-family: cursive">Query Delete Successfully</span>');
   					$('.notifq').delay(3200).fadeOut(300);
   				 }else{
   					 $("#row_"+id).hide();
   					$('#notifysuccessQuery').html('<span class="notifq" style="color:green; font-family: cursive">Something went worng.</span>');
   					$('.notifq').delay(3200).fadeOut(300);
   				 }
   				}
           });
       }
   	
   }
</script>