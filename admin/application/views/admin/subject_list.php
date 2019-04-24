<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
	
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Subject List 
				<span style="margin-left: 50px;" class="hideflash">
					<?php 
					if($this->session->flashdata('message'))
					{
						$message    = $this->session->flashdata('message');
					}
					if($this->session->flashdata('error'))
					{
					 $error  = $this->session->flashdata('error');
					}
					
					?>
					
			
					<?php if(!empty($message)){ ?>
						<span class="notifq" style="color:green;    font-family: cursive"><?php echo $message; ?></span>
					<?php } if(!empty($error)) { ?>
					    <span class="notifq" style="color:red;    font-family: cursive"><?php echo $error; ?></span>	 
					<?php } ?>
 
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
							<a>Subject List</a>
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
									<span class="caption-subject font-green-sharp bold uppercase">Subject Listing</span>
								</div>
								<div class="actions">
									<a href="<?php echo site_url('Superadmin/addSubject')?>" class="btn btn-circle btn-default">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
									Add Subject </span>
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
										<th width="5%">
										Subject Name
										</th>
										<th width="5%">
										Price
										</th>
										<th width="5%">
										Hours
										</th>
										<th width="20%">
											Feature
										</th>
										<th width="30%">
											Description
										</th>
										<th width="5%">
											Image
										</th>
										<th width="20%">
											 Action
										</th>
									</tr>
									<tr>
									<?php 
                                  
									if(!empty($arrSubject)) {?>
									<?php $i=1; foreach($arrSubject as $subject) {?>	
										<th width="5%">
											<?php echo $i++; ?>
										</th>
										<th width="5%">
											<?php 
                                        echo $subject['subject_name'];?>
										</th>
										<th width="5%">
											<?php 
                                        echo $subject['price'];?>
										</th>
										<th width="5%">
											<?php 
                                        echo $subject['hours'];?>
										</th>
										<th width="20%">
										
											<?php echo $subject['subject_features']; ?>
						
										</th>
										<th width="30%">
											<?php echo $subject['subject_description']; ?>
										</th>
										<th width="5%">
											<?php 
										$image='NA';
										if($subject['image'])
										{
										    $img=base_url()."assets/images/subjects/".$subject['image'];
											$image='<img src="'.$img.'" width="50" height="50"';
										}
										
										echo $image;
											
											 ?>
										</th>
									
										<th width="20%">
											 <div class="btn-group">
                                                  <a class="btn btn-primary" href="<?php echo  base_url('Superadmin/addSubject/'.$subject['id']);?>" >Edit</a>
                                                 <a class="btn btn-danger" href="<?php echo  base_url('Superadmin/delete_subject/'.$subject['id']);?>" onclick="return areyousure();">Delete</a>

											</div>
											</th>
											</tr>
									<?php }?>
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
$('.notifq').delay(3200).fadeOut(300);
function areyousure()
{
	return confirm('Are you sure you want to delete this subject?');
}
</script>