<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>

		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 class="page-title">
				Welcome User
				<span style="margin-left: 50px;" class="hideflash">
       	<?php if(!empty($this->session->flashdata('add_faculty_sussess'))) { ?>
               <?php print $this->session->flashdata('add_faculty_sussess'); ?>
        <?php }?>
                </span>
			   </h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="user.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Welcome User</a>
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
											   <a href="<?php echo site_url('Superadmin/facultyList')?>">
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
												<i class="fa fa-gift"></i>Add Video
											</div>
										</div>
										<div class="portlet-body form">
											<!-- BEGIN FORM-->
									<form action="<?php echo site_url('Superadmin/addVideoUrl/').$this->uri->segment(3);?>" method="post" class="form-horizontal" name="">
												<div class="form-body">
													<div class="form-group">
														<label class="col-md-3 control-label">Faculty Name:</label>
												<div class="col-md-4">
				                                  <input type="text" class="form-control" id="name" name="name" value="<?php echo $result['getfaculty']->name;?>" disabled>
												<input type="hidden" name="facid" id="facid" value="<?php echo $result['getfaculty']->user_id;?>">
												<input type="hidden" name="subid" id="subid" value="<?php echo $result['getfaculty']->subject_id;?>">		
														</div>
														<span id=""></span>
													</div>
													
												<div class="form-group">
														<label class="col-md-3 control-label">Video Category:</label>
												<div class="col-md-4">
												<select name="category" class="form-control" required="">
												<option value="">Select Type</option>	
												<?php foreach($result['catfaculty'] as $catvl): ?>
													<option value="<?php echo $catvl['cat_name'];?>"><?php echo $catvl['cat_name'];?></option>	
												<?php endforeach; ?>
												</select>
												</div>
												<span id=""></span>
												</div>
	

													<div class="form-group">
														<label class="col-md-3 control-label">Video URL :</label>
														<div class="col-md-6">
														
													<div class="field_wrapper">
                                                       <div>
													   
                                                       <input type="checkbox" name="videotype[]" id="videotype" value="0"/> &nbsp;&nbsp;<input type="text" class="form-control" name="field_name[]" value="" style="width:90%" id="vurl" />
													   <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus"></i>
														</a>
														
                                                       </div>
                                                    </div>
                                                   </div>
                                                   <span id="errorvurl"></span>
												   </div>
                                                    	
												<div class="row">
														<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn green btn-addVideo">Submit</button>
											<a href="<?php echo site_url('Superadmin/facultyList')?>" type="button" class="btn red">Cancel</a>
															
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


<script type="text/javascript">
$(document).ready(function(){
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = 0;
   
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append('<br><div> <input type="checkbox" name="videotype[]" id="videotype" value="'+x+'"/> &nbsp;&nbsp;<input type="text" class="form-control" name="field_name[]" value="" style="width:90%"/><a href="javascript:void(0);" class="remove_button"><i class="fa fa-trash"></i></a></div>'); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
<script>
var timeout = 6000; // in miliseconds (3*1000)
$('.hideflash').delay(timeout).fadeOut(300);
</script>


<!-- END JAVASCRIPTS -->
<?php $this->load->view('includes/footeradmin');?>