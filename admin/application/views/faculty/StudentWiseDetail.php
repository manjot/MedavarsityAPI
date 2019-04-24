<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>

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
							<a href="<?php echo site_url('Faculty/suscribedStudent')?>">Subscribed Students</a>
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
								<div class="profile-usertitle" style="margin-top: 20px;font-size: large;">
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
													<a href="#college" data-toggle="tab">Subscription Info</a>
												</li>
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
														</table>
														
													</form>
												</div>
												<div class="tab-pane" id="college">
													
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
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('includes/footer');?>