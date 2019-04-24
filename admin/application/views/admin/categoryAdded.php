<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>

		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 class="page-title">
				Add Category
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
							<a href="">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Add Category</a>
						</li>
					</ul>
					<div class="page-toolbar">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="tabbable tabbable-custom tabbable-noborder tabbable-reversed">
							<div class="tab-content">
											<br><br>
								<div class="tab-pane active" id="tab_0">
									
									<div class="portlet box yellow">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-gift"></i>Add Category
											</div>
										</div>
										<div class="portlet-body form">
											<!-- BEGIN FORM-->
										<form action="<?php echo site_url('Superadmin/addCategoryList')?>" method="post" class="form-horizontal" name="">
												
												<div class="form-body">
													<div class="form-group">
														<label class="col-md-3 control-label">Faculty Name:</label>
														<div class="col-md-4">
				                                  
				                                  <select class="form-control" id="faculty" name="faculty" required="">
				                                  <option value=" ">Select</option>	
				                                  <?php foreach ($faculty_name as $facname):?>
					                                  <option value="<?php echo $facname['name'].','.$facname['user_id']; ?>"><?php echo $facname['name']; ?></option>	
				                                  <?php endforeach; ?>	
				                                  </select>	
														</div>
														<span id=""></span>
													</div>
													
													<div class="form-group">
														<label class="col-md-3 control-label">Category Name :</label>
														<div class="col-md-4">
														<input type="text" class="form-control" id="cat_name" name="cat_name" required="">
		                                           </div>
                                                   <span id="errorvurl"></span>
												   </div>
                                                    	
												<div class="row">
														<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn green btn-addVideo">Submit</button>
											<a href="<?php echo site_url('Superadmin/categoryAdded')?>" type="button" class="btn red">Cancel</a>
															
														</div>
													</div>	
												</div>
											</form>
											<!-- END FORM-->
										</div>
									</div>
									
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	

	<!-- END FOOTER -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
   FormSamples.init();
});
</script>

<script>
var timeout = 6000; // in miliseconds (3*1000)
$('.hideflash').delay(timeout).fadeOut(300);
</script>


<!-- END JAVASCRIPTS -->
<?php $this->load->view('includes/footeradmin');?>