<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
<style>
.error{color:red;}
</style>

<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/ckeditor/config.js" type="text/javascript"></script>

		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Add Subject 
				<span style="margin-left: 50px;" class="hideflash">
					<?php 
					if($this->session->flashdata('message'))
					{
						$message    = $this->session->flashdata('message');
					}
					if($this->session->flashdata('error'))
					{
					 $error  = $this->session->flashdata('error');
					}
					
					?>
					
			
					<?php if(!empty($message)){ ?>
						<span class="notifq" style="color:green;    font-family: cursive"><?php echo $message; ?></span>
					<?php }  ?>
					<?php if(!empty($error)) { ?>
					    <span class="notifq" style="color:red;    font-family: cursive"><?php echo $error; ?></span>	 
					<?php } ?>
 
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
							<a href="#">Add Subject</a>
						</li>
					</ul>
					<div class="page-toolbar">
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
               
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<div class="tabbable tabbable-custom tabbable-noborder tabbable-reversed">
							<div class="tab-content">
								<div class="btn-group">
									<a href="<?php echo site_url('Superadmin/subjectList')?>">
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
												<i class="fa fa-gift"></i>Add Post
											</div>
											
										</div>
										<div class="portlet-body form">
											<!-- BEGIN FORM-->
											 <form  class="form-horizontal" method="post" name="sunjectForm" id="sunjectForm" action="<?php echo base_url().'Superadmin/addSubject/'.$id; ?>" enctype="multipart/form-data"> 
								
												<div class="form-body form-horizontal">
													<div class="form-group">
														<label class="col-md-3 control-label">Name</label>
														<div class="col-md-4">
															<input type="text" class="form-control" placeholder="Subject Name" name="name" id="name" value="<?php echo set_value('name', $name); ?>">
															
														</div>
														<span id="errortitad"><?php echo form_error('name', '<div class="error">', '</div>'); ?></span>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Price</label>
														<div class="col-md-4">
															<input type="number" class="form-control" placeholder="Price" name="price" id="price" value="<?php echo set_value('price', $price); ?>">
															
														</div>
														<span id="error_price"><?php echo form_error('price', '<div class="error">', '</div>'); ?></span>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Hours</label>
														<div class="col-md-4">
															<input type="number" class="form-control" placeholder="Hour" name="hour" id="hour" value="<?php echo set_value('hour', $hour); ?>">
															
														</div>
														<span id="error_hour"><?php echo form_error('hour', '<div class="error">', '</div>'); ?></span>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Feature</label>
														<div class="col-md-4">
															<div class="input-icon right">
																<textarea type="text" name="feature" id="feature" class="form-control" placeholder="Feature" style=" resize: none;"><?php echo set_value('feature', $feature); ?></textarea>
															</div>
														</div>
														<span id="errorconad"><?php echo form_error('feature', '<div class="error">', '</div>'); ?>
														</span>
													</div>
													
                                                    <div class="form-group">
														<label class="col-md-3 control-label">Description</label>
														<div class="col-md-4">
													 <textarea type="text" class="form-control" placeholder="Description..."name="description" style=" resize: none;"><?php echo set_value('description', $disciption); ?></textarea>
															<!--<textarea  name="description" id="description" class="form-control" placeholder="Description" ><?php //echo set_value('description', $disciption); ?></textarea>-->
															
														</div>
														<span id="errorattad"><?php echo form_error('description', '<div class="error">', '</div>'); ?></span>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Image </label>
														<div class="col-md-4">
															<div class="input-append">
															<?php echo form_upload(array('name'=>'image'));?>
															</div><br>
															
														<?php if($id && $image != ''):?>
														<div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url('assets/images/subjects/'.$image);?>" alt="current" width="100" height="100" /></div>

														<?php endif;?>
														
														</div>
														<span id="errorattad"></span>
													</div>	
												</div>
												<div class="form-actions fluid">
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<button type="submit"  class="btn green btn-addPostfac">Submit</button>
															<a href="<?php echo base_url().'Superadmin/subjectList'; ?>" class="btn red">Cancel</a>
															
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

<?php $this->load->view('includes/footeradmin')?>
<script>
CKEDITOR.replace('description');
</script>
