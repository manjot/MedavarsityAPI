<?php include('header.php');?>
<?php include('sidebar.php');?>

		<!-- END SIDEBAR -->
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
							<a href="<?php echo site_url('Medi_varsity/facultyVideoList')?>">Edit Video Url</a>
						</li>
					</ul>
					<div class="page-toolbar">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="tabbable tabbable-custom tabbable-noborder tabbable-reversed">
							<div class="tab-content">
							                <div class="btn-group">
											   <a href="<?php echo site_url('Medi_varsity/facultyList')?>">
												<button  class="btn green">
												Back
												</button>
												</a>
											</div>
							                             
											<br><br>
								<div class="tab-pane active" id="tab_0">
									
									<div class="portlet box yellow">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-gift"></i>Edit Video
											</div>
										</div>
										<div class="portlet-body form">
											<!-- BEGIN FORM-->
						<form action="<?php echo site_url('Medi_varsity/updateVideo')?>" method="post" class="form-horizontal" name="">
												
												<div class="form-body">
													<div class="form-group">
														<label class="col-md-3 control-label">Faculty Name:</label>
														<div class="col-md-4">
				                            <input type="text" class="form-control"  id="name" name="name" value="<?php echo $result['editVideo']['name'];?>" disabled>
										<input type="hidden" name="vid" id="vid" value="<?php echo $result['editVideo']['id'];?>">
										<input type="hidden" name="subid" id="subid" value="">		
														</div>
														<span id=""></span>
													</div>
													
													<div class="form-group">
														<label class="col-md-3 control-label">Video URL :</label>
														<div class="col-md-4">
														
													<div class="field_wrapper">
                                                       <div>
													 <input type="text" class="form-control" name="vurl" value="<?php echo $result['editVideo']['video_url'];?> " style="width:140%" id="vurl" />
													   <a href="javascript:void(0);" class="add_button" title="Add field">
														</a>
														
                                                       </div>
                                                    </div>
                                                   </div>
                                                   <span id="errorvurl"></span>
												   </div>
                                                    	
												<div class="row">
														<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn green btn-addVideo">Update</button>
											<a href="<?php echo site_url('Medi_varsity/facultyVideoList')?>" type="button" class="btn red">Cancel</a>
															
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
<?php include('footer.php');?>