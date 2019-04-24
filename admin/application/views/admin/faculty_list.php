<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Faculty List <span style="margin-left: 50px;" class="hideflash" id="notifyfacultydelete">
					<?php if(!empty($this->session->flashdata('add_faculty_sussess'))) {  print $this->session->flashdata('add_faculty_sussess'); ?>
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
							<a href="<?php echo site_url();?>Superadmin/facultyList">Faculty List</a>
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
									<span class="caption-subject font-green-sharp bold uppercase">Faculty Listing</span>
								</div>
								<div class="actions">
									<a href="<?php echo site_url('Superadmin/addFaculty_pg')?>" class="btn btn-circle btn-default">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
									Add Faculty </span>
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
											 Join Date
										</th>
										<th width="15%">
											 Full Name
										</th>
										<th width="10%">
											 No. Of Students
										</th>
										<th width="10%">
											 Avarage Rating
										</th>
									
										<th width="10%">
											Video
										</th>
										<th width="5%">
											Image
										</th>
										<th width="10%">
											 Delete
										</th>
									</tr>
									
									<?php 
                                  
									if(!empty($result['facultydetail'])) {?>
									<?php $i=1; foreach($result['facultydetail'] as $value) {
										//echo"<pre>";
										//print_r($result['facultydetail']);
										//die();
										
										?>
                                    <tr id="row_<?php echo $value['user_id']; ?>">									
										<th width="5%">
											<?php echo $i++; ?>
										</th>
										<th width="5%">
											<?php 
                                        echo date("d/m/Y",strtotime($value['time_stamp']));?>
										</th>
										<th width="15%">
										<a href="<?php echo base_url('Superadmin/facultyDetail/'.$value['user_id'])?>">
											<?php echo $value['name']; ?>
										</a>
										</th>
										<th width="10%">
											 <a href="<?php echo base_url('Superadmin/StudentDetail/'.$value['user_id'])?>"><?php echo $value['totstudents']; ?></a>
										</th>
										<th width="10%">
											 9/10
										</th>
										<th width="10%">
											<div class="btn-group">
												<a href="<?php echo base_url('Superadmin/addVideo/'.$value['user_id'])?>" class="add_button" title="Add field"><i class="fa fa-plus"></i>(<?php echo $value['totfacultyvidio']; ?>)
												</a>
											</div>
										</th>
										<th width="5%">
											<?php
											$image='NA';
											if($value['image'])
											{
												$img=base_url()."assets/images/faculty/".$value['image'];
												$image='<img src="'.$img.'" width="50" height="50"';
											}
											
											echo $image;
											?>
										</th>
										<th width="20%">
											 <div class="btn-group">
											 <a href="<?php echo base_url().'Superadmin/addFaculty_pg/'.$value['user_id'];  ?>" class="btn btn-primary" style="height:30px;" >Edit</a>
											 <a class="btn btn-danger" style="height:30px;" onclick="deletefaculty(<?php echo $value['user_id']?>);">Delete</a>
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