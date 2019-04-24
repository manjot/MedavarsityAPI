<?php include('header.php');?>
<?php include('sidebar.php');?>


		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard <span style="margin-left:40px;" id="success"></span></h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Medi_varsity/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Add Post</a>
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
											    <a href="<?php echo site_url('Medi_varsity/postList')?>">
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
											<!-- <form  class="form-horizontal"> -->
												
												<div class="form-body form-horizontal">
													<div class="form-group">
														<label class="col-md-3 control-label">Subject</label>
										
														<div class="col-md-4">
															 <select class="table-group-action-input form-control input-inline input-small input-sm" id="subidad" name="subidad">
											<option value="">Select...</option>
											<?php foreach($result['getsubjectdetail'] as $value) {?>
										   <option value="<?php echo $value['id'];?>">
										   	<?php echo $value['subject_name'];?>
										   </option>
										    <?php }?>
											
										 
										 </select>
														</div>
														<span id="errorsubidad"></span>
													</div>
													
													
													<div class="form-group">
														<label class="col-md-3 control-label">Title</label>
														<div class="col-md-4">
															<input type="text" class="form-control" placeholder="Enter Title" name="titad" id="titad" minlength=10>
															
														</div>
														<span id="errortitad"></span>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Content</label>
														<div class="col-md-4">
															<div class="input-icon right">
																
																<textarea type="text" name="conad" id="conad" class="form-control" placeholder="Content..." minlength=20></textarea>
															</div>
														</div>
														<span id="errorconad"></span>
													</div>
													
                                                    <div class="form-group">
														<label class="col-md-3 control-label">Attachment</label>
														<div class="col-md-4">
															<input type="text" name="attad" id="attad" class="form-control" placeholder="Add Attachment">
															
														</div>
														<span id="errorattad"></span>
													</div>	
												</div>
												<div class="form-actions fluid">
												
										
													
													
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<button type="submit" onclick="adminpost();" class="btn green btn-addPostfac">Submit</button>
															<button type="button" class="btn red">Cancel</button>
															
														</div>
													</div>
												</div>
											<!-- </form> -->
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




<?php include('footer.php');?>
<script type="text/javascript">
	  function adminpost()
  {
    var subidad = document.getElementById("subidad").value;
     var titad = document.getElementById("titad").value;
     var conad = document.getElementById("conad").value;
     var attad = document.getElementById("attad").value;

    
      if(attad == ''){
      $("#errorattad").html("<div style='color:red'>Please Enter Attachment</div>");
      $("#attad").focus();
      //return false;
      }else{
      $("#errorattad").html("");
      }
       if(conad == ''){
      $("#errorconad").html("<div style='color:red'>Please Enter content</div>");
      $("#conad").focus();
     // return false;
      }else{
      $("#errorconad").html("");
      }
       if(titad == ''){
      $("#errortitad").html("<div style='color:red'>Please Enter Title</div>");
      $("#titad").focus();
     // return false;
      }else{
      $("#errortitad").html("");
      }
       if(subidad == ''){
      $("#errorsubidad").html("<div style='color:red'>Please Choose Subject</div>");
      $("#subidad").focus();
     // return false;
      }else{
      $("#errorsubidad").html("");
      }
      if(titad == '' || conad == '' || attad == '' || subidad == '')
      {
      return false;
      }
// //alert(subid);
     $.ajax({
                    url: "<?php echo site_url();?>Medi_varsity/addPost",
                    method: "POST",
                    data: {'subid':subidad,'tit':titad,'con':conad,'att':attad},
                    dataType: "json",
                    success: function(data)
                    {
                     if(data.success == 0){
                     jQuery('#success').html('<span style="color:green; font-family: Helvetica"  id="emA">Notification Posted Successfully</span>');
                     jQuery('#emA').delay(5000).fadeOut(300);
                     jQuery("#subidad").val('');
                     jQuery("#titad").val('');
                     jQuery("#conad").val('');
                     jQuery("#attad").val('');
                     }
                  }
                });
     
  }
</script>
