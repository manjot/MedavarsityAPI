<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>
		<div class="page-content-wrapper">
			<div class="page-content">
				
				<h3 class="page-title">
				 Dashboard</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a>Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a>Welcome <?php echo $result['getadmindetail']->name;?></a>
						</li>
					</ul>
					<div class="page-toolbar">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light red-soft" href="<?php echo site_url('Faculty/invoice')?>">
						<div class="visual">
							<i class="fa fa-user"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $result['totinvoices'];?>
							</div>
							<div class="desc">
								 Invoices
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light blue-soft" href="<?php echo site_url('Faculty/Lectures')?>">
						<div class="visual">
						<i class="fal fa-presentation"></i>
							<i class="fa  fa-th-list"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $result['totvideo_fac'];?>
							</div>
							<div class="desc">
								 Lectures
							</div>
						</div>
						</a>
					</div>
					
					<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light green-soft" href="<?php echo site_url();?>Faculty/suscribedStudent">
						<div class="visual">
							<i class="fa fa-users"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $result['totsubscriber_fac'];?>
							</div>
							<div class="desc">
								 Subscribed Students
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
	<?php $this->load->view('includes/footer');?>