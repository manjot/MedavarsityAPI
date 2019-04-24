<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				      <h3 class="page-title">
				         Category  <span style="margin-left:40px;" id="notifysuccessQuery"></span>
				       <span style="margin-left: 50px;" class="hideflash">
				       	<?php if(!empty($this->session->flashdata('add_category'))) { ?>
				               <?php print $this->session->flashdata('add_category'); ?>
				        <?php }?>
				        </span>
  
				      </h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url();?>Superadmin">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo site_url();?>Superadmin/category">Category List</a>
						</li>
					</ul>
					<div class="page-toolbar">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-users font-green-sharp"></i>
									<span class="caption-subject font-green-sharp bold uppercase">Category Listing</span>
								</div>
								<div class="actions">
									<a href="<?php echo site_url('Superadmin/categoryAdded')?>" class="btn btn-circle btn-default">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
									Add Category </span>
									</a>
								</div>
							</div>
							<div class="portlet-body">
									<table class="table table-striped table-bordered table-hover" >
									<thead>
									<tr role="row" class="heading">
										<th width="5%">
											 Sr.No.
										</th>
										<th width="15%">
											 Faculty Name
										</th>
										<th width="15%">
											 Category Name
										</th>
										<th width="10%">
											 Delete
										</th>
									</tr>
									
									<?php if(!empty($qryList)) {?>
									<?php $i=1; foreach($qryList as $value):?>
                                    <tr id="row_<?php echo $value['id']; ?>">									
										<th width="5%">
											<?php echo $i++; ?>
										</th>
										<th width="5%">
											<?php echo $value['faculty'];?>
										</th>
										<th width="15%">
											<?php echo $value['cat_name']; ?>
										</th>
										<th width="20%">
											 <div class="btn-group">
											 <a href="<?php echo base_url().'Superadmin/editCategory/'.$value['id'];  ?>" class="btn btn-primary" style="height:30px;" >Edit</a>
											 <a class="btn btn-danger" style="height:30px;" onclick="deleteCat(<?php echo $value['id']?>);">Delete</a>
											</div>
										</th>
									</tr>
									<?php endforeach; ?>
									<?php } ?>
									</thead>
									<tbody>
									</tbody>
									</table>
							</div>
						</div>
						<!-- End: life time stats -->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout2/scripts/layout.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php $this->load->view('includes/footeradmin');?>
<style type="text/css">	
body { font-family: sans-serif; }
#confirmBox
{
    display: none;
    background-color: #eee;
    border-radius: 5px;
    border: 1px solid #aaa;
    position: fixed;
    width: 300px;
    height: 120px;
    left: 50%;
    margin-left: -150px;
    padding: 6px 8px 8px;
    box-sizing: border-box;
    text-align: center;
}
#confirmBox button {
    background-color: #ccc;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #aaa;
    padding: 2px;
    text-align: center;
    width: 80px;
    margin-top: 20px;
    cursor: pointer;
}
#confirmBox button:hover
{
    background-color: #ddd;
}
#confirmBox .message
{
    text-align: left;
    margin-bottom: 8px;
}
</style>
<script type="text/javascript">
   function deleteCat(id)
   {
   
   	if (confirm("Are you sure do you want to delete?"))
   	{
           $.ajax({
   				url: "<?php echo base_url();?>Superadmin/deleteCat",
   				method: "POST",
   				data: {'catId':id},
   				dataType: "json",
   				success: function(data)
   				{
   				  if(data.success == 1)
   				  {
   					$("#row_"+id).hide();
   					$('#notifysuccessQuery').html('<span class="notifq" style="color:green; font-family: cursive">Category Deleted Successfully</span>');
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

var timeout = 6000; // in miliseconds (3*1000)
$('.hideflash').delay(timeout).fadeOut(300);
</script>
