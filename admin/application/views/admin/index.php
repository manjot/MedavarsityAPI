<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>

		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				
				<h3 class="page-title">
				Dashboard <?php echo $result['getadmindetail']->name;?></h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo base_url();?>Superadmin/index">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo base_url();?>Superadmin/index">Dashboard <?php echo $result['getadmindetail']->name;?></a>
						</li>
					</ul>
					<div class="page-toolbar">
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN DASHBOARD STATS -->
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light blue-soft" href="<?php echo site_url('Superadmin/facultyVideoList')?>">
						<div class="visual">
						<i class="fal fa-presentation"></i>
							<i class="fa  fa-th-list"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $result['totvideo'];?>
							</div>
							<div class="desc">
								 Lectures
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light red-soft" href="<?php echo site_url();?>Superadmin/facultyList">
						<div class="visual">
							<i class="fa fa-user"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $result['totfaculty'];?>
							</div>
							<div class="desc">
								 Faculty
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light green-soft" href="<?php echo site_url();?>Superadmin/studentList">
						<div class="visual">
							<i class="fa fa-users"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $result['totsubscriber'];?>
							</div>
							<div class="desc">
								 Subscribed Students
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light purple-soft" href="<?php echo site_url();?>Superadmin/subjectList">
						<div class="visual">
							<i class="fa fa-book"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $result['totsubject'];?>
							</div>
							<div class="desc">
								 Subjects
							</div>
						</div>
						</a>
					</div>
				</div>
		
				<div class="clearfix">
				</div>
				
			</div>
		</div>
	</div>
	<!-- END CONTAINER -->
	<?php $this->load->view('includes/footeradmin');?>