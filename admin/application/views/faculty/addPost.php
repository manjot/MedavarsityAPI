<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>

		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard <span id="success"></span></h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Faculty');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a>Post</a>
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
							                             
								<div class="tab-pane active" id="tab_0">
									
									
									<div class="portlet box yellow">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-gift"></i>Add Post
											</div>
											
										</div>
										<div class="portlet-body form">
											<!-- BEGIN FORM-->
											<!-- <form  class="form-horizontal"> -->
												
												<div class="form-body form-horizontal">
													<div class="form-group">
														<label class="col-md-3 control-label">Subject</label>
										<?php $i=0; foreach ($result['allLecture_fac'] as $value) { $i++;
										if($i == 1) { ?>
														<div class="col-md-4">
															<input type="text" class="form-control" value="<?php echo $value['subject_name']?>" disabled>
														<input type="hidden" id="subid" name="subid" value="<?php echo $value['subject_id']?>">
														</div>
													<?php } break;?>
													<?php }?>
													</div>
													
													
													<div class="form-group">
														<label class="col-md-3 control-label">Title</label>
														<div class="col-md-4">
															<input type="text" class="form-control" placeholder="Enter Title" name="tit" id="tit" minlength=10>
															
														</div>
														<span id="errortit"></span>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Content</label>
														<div class="col-md-4">
															<div class="input-icon right">
																
																<textarea type="text" name="con" id="con" class="form-control" placeholder="Content..." minlength=20></textarea>
															</div>
														</div>
														<span id="errorcon"></span>
													</div>
													
                                                    <div class="form-group">
														<label class="col-md-3 control-label">Attachment</label>
														<div class="col-md-4">
															<input type="file" name="att" id="att" class="form-control" placeholder="Add Attachment">
															
														</div>
														<span id="erroratt"></span>
													</div>	
												</div>
												<div class="form-actions fluid">
												
										
													
													
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<button type="submit" onclick="addPostfac();" class="btn green btn-addPostfac">Submit</button>
															<!-- <button type="button" class="btn red">Cancel</button> -->
															
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


<?php $this->load->view('includes/footer');?>


