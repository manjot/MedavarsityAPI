<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>
<?php
//print_r($result['facultyDetail']['profile_image_url']);
//die();
 ?>

		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 class="page-title">
				Dashboard 
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Faculty/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
					
						<li>
							<a href="#">Faculty Detail</a>
						</li>
					</ul>
					
				</div>
<?php
$img=base_url()."assets/images/faculty/".$result['facultyDetail']['profile_image_url'];
//echo"<pre>";
//print_r($img);
//die();

?>
				<div class="row">
					<div class="col-md-12">
						<div class="profile-sidebar" style="width:250px;">
							<div class="portlet light profile-sidebar-portlet">
								<div class="profile-userpic">
							<img src="<?php echo $img ?>" class="img-responsive" alt="">
								</div>
								<div class="profile-usertitle" style="margin-top: 20px;font-size: large;">
									<div class="profile-usertitle-name">
										<?php echo $result['facultyDetail']['name'];?>
									</div>
								</div>
								
							</div>
							<div class="portlet light">
								<div>
									<div class="margin-top-20 profile-desc-link">
										<i class="fa fa-envelope"></i>
										<a><small><?php echo $result['facultyDetail']['email'];?></small></a>
									</div>
									
									<div class="margin-top-20 profile-desc-link">
										<i class="fa fa-phone"></i>
										<a><?php echo $result['facultyDetail']['contact_no'];?></a>
									</div>
								</div>
							</div>
							<!-- END PORTLET MAIN -->
						</div>
						<div class="profile-content" style="margin-left: 300px; margin-top: -400px;">
							<div class="row">
								<div class="col-md-12">
									<div class="portlet light">
										<div class="portlet-title tabbable-line">
											<div class="caption caption-md">
												<i class="icon-globe theme-font hide"></i>
												<span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
											</div>
											<ul class="nav nav-tabs">
												<li class="active">
													<a href="#personal" data-toggle="tab">Personal Info</a>
												</li>
												<li>
													<a href="#college" data-toggle="tab">Video Info</a>
												</li>
												<?php if($result['facultyDetail']['user_id'] != 1) {?>
												<li>
													<a href="#bank" data-toggle="tab">Bank Info</a>
												</li>
												<?php }?>
											</ul>
										</div>
										<div class="portlet-body">
											<div class="tab-content">
												<!-- PERSONAL INFO TAB -->
												<div class="tab-pane active" id="personal">
													<form role="form" action="#">
												      <table class=" table table-responsive table-hover">
															<tr>
															   <td>First Name</td>
															   <td><?php echo $result['facultyDetail']['name'];?></td>	
															</tr>
															<tr>
															   <td>Email</td>
															   <td><?php echo $result['facultyDetail']['email'];?></td>	
															</tr>
															<tr>
															   <td>Address</td>
															   <td><?php echo $result['facultyDetail']['address'];?></td>	
															</tr>
															<tr>
																<tr>
															   <td>About</td>
															   <?php if(!empty($result['facultyDetail']['about'])) {?>
															   <td><?php echo $result['facultyDetail']['about'];?></td>
															   <?php } else {?>
                                                               <td>Address Empty</td>
															   <?php }?>	
														
															
														</table>
														
													</form>
												</div>
												<div class="tab-pane" id="college">
													<p>
														 <!-- <span style="color:grey; font-size: 14px;">ABOUT YOUR HEALTH</span> -->
													</p>
													<form action="#" role="form">
														<table class=" table table-responsive table-hover">
															<tr>
															   <td>Joining Date</td>
															   <td> <?php echo date("d/m/Y",strtotime($result['facultyDetail']['time_stamp']))?></td>	
															</tr>
															<tr>
															   <td>Subject</td>
															   <td> <?php echo $result['facultyDetail']['subject_name'];?></td>	
															</tr>
															<!-- <tr>
															   <td>About the Subject</td>
															   <td> Kg</td>	
															</tr> -->
															<tr>
															   <td>Video Url</td>
															  
															   <td>
                                                               <?php if(!empty($result1)) {?>
															   <?php foreach ($result1 as $value) {?>
															   	<a href="<?php echo $value['video_url'];?>" target="_blank"><?php echo $value['video_url'];?><br></a>
                                                                <?php }?>
															    </td>
														        <?php } else {?>
																<td>NULL</td>
															<?php }?>
															</tr>
															
														</table>
													
													</form>
												</div>
												<!-- END CHANGE AVATAR TAB -->
												<!-- CHANGE PASSWORD TAB -->
												<div class="tab-pane" id="bank">
											
													<form action="#">
														<table class=" table table-responsive table-hover ">
															<tr>
															   <td>Bank Name
                                                           </td>
                                                           <td><?php echo $result['facultyDetail']['bank_name'];?></td>	
															</tr>
															<tr>
															   <td>Account No.</td>   
															   <td><?php echo $result['facultyDetail']['account_no'];?></td>	
                                                             </tr><tr>
															    <td>IFSC
															   </td>   
															   <td><?php echo $result['facultyDetail']['ifsc_code'];?></td>	
															</tr>
														</table>
														
													</form>
												</div>
												<!-- END CHANGE PASSWORD TAB -->
												<!-- PRIVACY SETTINGS TAB -->
												
												<!-- END PRIVACY SETTINGS TAB -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- END PROFILE CONTENT -->
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
<?php $this->load->view('includes/footer');?>