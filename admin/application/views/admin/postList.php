<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				View Post <span style="margin-left:40px;" id="notifysuccesspost"></span></h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Superadmin/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo site_url('Superadmin/postList')?>">All Post</a>
						</li>
					</ul>
					<div class="page-toolbar">
						
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-edit"></i>List Of Post
								</div>
								
							</div>
<!-- ////////////////////////////////  CONFIRMATION BOX ///////////////////////////////// -->
							<div id="confirmBox">
							<div class="message"></div>
							<button class="yes">Yes</button>
							<button class="no">No</button>
                            </div>
 <!-- ////////////////////////////////  CONFIRMATION BOX ///////////////////////////////// -->
							<div class="portlet-body">
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-12">
											<div class="btn-group"></div>
											<?php echo $this->session->flashdata('success');?>
											<div class="btn-group pull-right">
											
											<span>
											<div class="btn-group">
											<a href="<?php echo site_url('Superadmin/postAdmin')?>">
												<button  class="btn green">
												Add Post
												</button></a>
											</div>
											</span>
											</div>
										</div>
										
									</div>
								</div>
<!-- //////////////// -->       <div id="allpostlist">
	                                 <div class="portlet-body">
									<table class="table table-striped table-bordered table-hover" >
									<thead>
									<tr role="row" class="heading">
										<th width="5%">
											 Sr.No.
										</th>
										<th width="15%">
											Title
										</th>
										<th width="15%">
											Post By
										</th>
										<th width="15%">
											 content
										</th>
									<!-- 	<th width="15%">
											 Attachment
										</th> -->
										
										<th width="10%">
											 Delete
										</th>
									</tr>
									
									<?php 
                                  
									if(!empty($arrPosts)) {?>
									<?php $i=1; foreach($arrPosts as $post) {?>
                                    <tr id="row_<?php echo $post['id']; ?>">									
										<th width="5%">
											<?php echo $i++; ?>
										</th>
										<th width="10%">
											<?php 
                                        echo ucfirst($post['title']);?>
										</th>
										<th width="10%">
											<?php 
                                        echo ucfirst($post['name']);?>
										</th>
										
										<th width="10%">
											 <?php echo $post['content']; ?>
										</th>
									<!-- 	<th width="10%">
											<?php echo $post['attachment']; ?>
										</th> -->
										<th width="15%">
											 <div class="btn-group">
											
											</div>
											 <?php if($post['user_id'] !=1 && $post['status'] == 0) { ?>
											 <a href="<?php echo base_url().'Superadmin/sendnotification/'.$post['id'].'/'.$post['subject_id']; ?>" class="btn btn-primary" style="height:30px;">Send</a>
											 <?php } ?>

											 &nbsp;&nbsp;
											 <a class="btn btn-danger" style="height:30px;" onclick="deletePost(<?php echo $post['id']; ?>);">Delete</a>
										</th>
									</tr>
									<?php }?>
									<?php } ?>
									</thead>
									<tbody>
									</tbody>
									</table>
							</div>
                                </div>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
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

<?php $this->load->view('includes/footeradmin');?>
<script type="text/javascript">
function deletePost(id)
{
	if (confirm("Are you sure do you want to delete?"))
	{
        $.ajax({
				url: "<?php echo base_url();?>Superadmin/deletepost",
				method: "POST",
				data: {'postId':id},
				dataType: "json",
				success: function(data)
				{
				  if(data.success == 1)
				  {
					$("#row_"+id).hide();
					$('#notifysuccesspost').html('<span class="notifq" style="color:green; font-family: cursive">Post Delete Successfully</span>');
					$('.notifq').delay(3200).fadeOut(300);
				 }else{
					 $("#row_"+id).hide();
					$('#notifysuccesspost').html('<span class="notifq" style="color:green; font-family: cursive">Something went worng.</span>');
					$('.notifq').delay(3200).fadeOut(300);
				 }
				}
        });
    }
	
}
</script>
<style type="text/css">
				
body { font-family: sans-serif; }
#confirmBox
{
    display: none;
    background-color: #eee;
    border-radius: 5px;
    border: 1px solid #aaa;
    position: fixed;
    width: 300px;
    height: 120px;
    left: 50%;
    margin-left: -150px;
    padding: 6px 8px 8px;
    box-sizing: border-box;
    text-align: center;
}
#confirmBox button {
    background-color: #ccc;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #aaa;
    padding: 2px;
    text-align: center;
    width: 80px;
    margin-top: 20px;
    cursor: pointer;
}
#confirmBox button:hover
{
    background-color: #ddd;
}
#confirmBox .message
{
    text-align: left;
    margin-bottom: 8px;
}
</style>