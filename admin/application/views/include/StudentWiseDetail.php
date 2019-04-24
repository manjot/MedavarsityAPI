<?php include('header.php');?>
<?php include('sidebar.php');?>

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
							<a href="<?php echo site_url('Medi_varsity/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
					
						<li>
							<a href="<?php echo site_url('Medi_varsity/studentList')?>">Student Detail</a>
						</li>
					</ul>
					
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="profile-sidebar" style="width:250px;">
							<div class="portlet light profile-sidebar-portlet">
								<div class="profile-userpic">
							<img src="http://healthoptim.com/profilepicture/avatar.png" class="img-responsive" alt="">
								</div>
								<div class="profile-usertitle">
									<div class="profile-usertitle-name">
										<?php echo $result['StudentWiseDetail']['name'];?>
									</div>
								</div>
								
							</div>
							<div class="portlet light">
								<div>
									<div class="margin-top-20 profile-desc-link">
										<i class="fa fa-envelope"></i>
										<a><small><?php echo $result['StudentWiseDetail']['email'];?></small></a>
									</div>
									
									<div class="margin-top-20 profile-desc-link">
										<i class="fa fa-phone"></i>
										<a><?php echo $result['StudentWiseDetail']['contact_no'];?></a>
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
													<a href="#college" data-toggle="tab">College Info</a>
												</li>
												<!-- <li>
													<a href="#bank" data-toggle="tab">Bank Info</a>
												</li> -->
												
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
															   <td><?php echo $result['StudentWiseDetail']['name'];?></td>	
															</tr>
															<tr>
															   <td>Email</td>
															   <td><?php echo $result['StudentWiseDetail']['email'];?></td>	
															</tr>
															<tr>
															   <td>Address</td>
															   <td><?php echo $result['StudentWiseDetail']['address'];?></td>	
															</tr>
															<tr>
																
															   <td>Age Range</td>
															   <td></td>	
															</tr>
															<tr>
															   <td>Gender</td>
															</tr>
														</table>
														
													</form>
												</div>
												<div class="tab-pane" id="college">
													<p>
														 <span style="color:grey; font-size: 14px;">ABOUT YOUR HEALTH</span>
													</p>
													<form action="#" role="form">
														<table class=" table table-responsive table-hover">
															<tr>
															   <td>Join Date</td>
															   <td> <?php echo date("d/m/Y",date($result['StudentWiseDetail']['created_date']))?></td>	
															</tr>
															<tr>
															   <td>Subject</td>
															   <td> <?php echo $result['StudentWiseDetail']['subject_name'];?></td>	
															</tr>
															<tr>
															   <td>College Name</td>
															   <td> <?php echo $result['StudentWiseDetail']['college_name'];?></td>	
															</tr>
															<tr>
																<td>Faculty Name</td>
																<td> <?php echo $result['StudentWiseDetail']['facname'];?></td>
															</tr>
															<tr>
																<td>MBBS Year</td>
																<td> <?php echo $result['StudentWiseDetail']['mbbs_year'];?></td>
															</tr>
															
														</table>
													
													</form>
												</div>
												<!-- END CHANGE AVATAR TAB -->
												<!-- CHANGE PASSWORD TAB -->
											
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

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->




<?php include('footer.php');?>