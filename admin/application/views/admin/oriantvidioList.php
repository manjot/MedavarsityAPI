<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
<!-- BEGIN CONTENT -->


<div class="page-content-wrapper">
   <div class="page-content">
      <!-- END STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
       Orientation and Motivation  <span style="margin-left:40px;" id="notifysuccessQuery"></span>
      </h3>
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <i class="fa fa-home"></i>
               <a href="<?php echo site_url('Superadmin/index')?>">Home</a>
               <i class="fa fa-angle-right"></i>
            </li>
            <li>
               <a href="<?php echo site_url('Superadmin/oriantvidioList')?>">Orientation and Motivation</a>
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
            <!-- Begin: life time stats -->
            <div class="portlet light">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-users font-green-sharp"></i>
                     <span class="caption-subject font-green-sharp bold uppercase">Orientation and Motivation</span>
					 <span id="notifyvideodelete"></span>
                     <!--<span class="caption-helper">manage orders...</span>-->
                  </div>
                  <div class="actions">
				  <a href="<?php echo site_url();?>Superadmin/addoriantVideo"><button class="btn btn-sm btn-info">Add Video</button></a>
                  </div>
               </div>
               <div class="portlet-body">
                  <!--   <div class="btn-group">
                     <a href="<?php echo site_url();?>Medi_varsity/index">
                     <button  class="btn green">
                     Back
                     </button>
                     </a>
                     </div> -->
                  <div class="table-container filterSubject">
                     <table class="table table-striped table-bordered table-hover" >
                        <thead>
                           <tr role="row" class="heading">
                              <!--<th width="2%">
                                 <input type="checkbox" class="group-checkable">
                                 </th>-->
                              <th width="5%">
                                 Sr.No.
                              </th>
                              <th width="15%">
                                 Title
                              </th>
                              <th width="15%">
                                 Url
                              </th>
							  
							   <th width="15%">
                                 Image Url
                              </th>
                           
                              <th width="10%">
                                 Delete
                              </th>
                           </tr>
                       <?php
					   $i=1;
					   ?>
							 <?php foreach($result['getoriantvidio'] as $val){
								 
								
								 ?>
                           <tr >
                              <th width="5%">
                               <?php echo $i++;?>
                              </th>
                              <th width="15%">
                             <?php echo $val->title?>
                              </th>
                              <th width="15%">
                                 <?php echo $val->url?>
                              </th>
							    <th width="15%">
                                 <?php echo $val->image_url?>
                              </th>
                          
                              <th width="10%">
                                 <div class="btn-group">
                                    <a class="btn btn-danger" style="height:30px;" onclick="deleteoriant(<?php echo $val->id; ?>);">Delete</a>
                                 </div>
                              </th>
                           </tr>
							 <?php }?>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <!-- End: life time stats -->
         </div>
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