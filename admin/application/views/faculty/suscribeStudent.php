<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Faculty')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							All Students
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
									<span class="caption-subject font-green-sharp bold uppercase">Student Listing</span>
									<!--<span class="caption-helper">manage orders...</span>-->
								</div>
								<div class="actions">
									
								</div>
							</div>
							<div class="portlet-body">
											
											
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
											 Full Name
										</th>
									<!-- 	<th width="15%">
											 Faculty Name
										</th> -->
										<th width="15%">
											 Subject
										</th>
										<th width="15%">
											 Year Of MBBS
										</th>
										<th width="15%">
											 College Of MBBS
										</th>
										<th width="15%">
											 Phone Number
										</th>
										<th width="15%">
											 Address
										</th>
										<th width="15%">
											 Email
										</th>
										<th width="20%">
											 Joining Date
										</th>
									
										<!--<th width="10%">
											View
										</th>-->
										
									</tr>
							<?php $i=1; foreach($result['getstudentdetail_fac'] as $value) {?>
									<tr>
										<th width="5%">
											 <?php echo $i++;?>
										</th>
										<th width="15%"><a href="<?php echo base_url('Faculty/StudentDetail/'.$value['student_id'])?>">
											  <?php echo $value['name'];?>
							             </a>
										</th>
										<!-- <th width="15%">
											<a href="<?php echo base_url('Medivarsity_faculty/facultyDetail/'.$value['facid'])?>"><?php echo $value['facname'];?></a>
										</th> -->
										<th width="10%">
											 <?php echo $value['subject_name'];?>
										</th>
										<th width="10%">
											 <?php echo $value['mbbs_year'];?>
										</th>
										<th width="10%">
											<?php echo $value['college_name'];?>
										</th>
										<th width="10%">
											 <?php echo $value['contact_no'];?> 
										</th>

										<th width="10%">
											<?php if(!empty($value['address'])){
											 echo $value['address']; }else {
                                             echo "No";
											 	}?> 
										</th>

										<th width="10%">
											<?php echo $value['email'];?>
										</th>
									
										<th width="10%">

			<?php echo date('d/m/Y', $value['created_date']);?>
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
	
	<?php $this->load->view('includes/footer');?>