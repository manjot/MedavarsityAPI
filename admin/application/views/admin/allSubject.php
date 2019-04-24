<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
<!-- END HEADER -->

		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard   <span style="margin-left: 50px;" id="notifySubjectdelete"></span>
                <span style="margin-left: 50px;" class="hideflash">
       	<?php if(!empty($this->session->flashdata('sub_sussess'))){ ?>
               <?php print $this->session->flashdata('sub_sussess'); ?>
        <?php }?>
                </span>
			</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
							<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Superadmin/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">All Subject</a>
						</li>
					</ul>
					<div class="page-toolbar">
						
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-users font-green-sharp"></i>
									<span class="caption-subject font-green-sharp bold uppercase">All Subject</span>
									<!--<span class="caption-helper">manage orders...</span>-->
								</div>
								<div class="actions">
									<a href="<?php echo base_url('Superadmin/addSubject');?>" class="btn btn-circle btn-default">
									
									<span class="hidden-480">
									Add subject</span>
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="table-container" id="all_Subject">
								

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
	

	<!-- END FOOTER -->

<?php include('footer.php')?>
	<script>
var timeout = 3000; // in miliseconds (3*1000)
$('.hideflash').delay(timeout).fadeOut(300);
</script>