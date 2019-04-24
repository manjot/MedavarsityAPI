<?php include('header.php');?>
<?php include('sidebar.php');?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard <span style="margin-left:40px;" id="notifysuccesspost"></span></h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Medi_varsity/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo site_url('Medi_varsity/index')?>">All Post</a>
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
											<div class="btn-group">
											<a href="<?php echo site_url('Medi_varsity/postList')?>">
												<button  class="btn green">
												Back 
												</button></a>
											</div>
											<div class="btn-group pull-right">
											
											<span>
											<div class="btn-group">
											<a href="<?php echo site_url('Medi_varsity/postAdmin')?>">
												<button  class="btn green">
												Add Post
												</button></a>
											</div>
											</span>
											</div>
										</div>
										
									</div>
								</div>
<!-- //////////////// --><div id="allpostlist">
	
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

<?php include('footer.php');?>
<script type="text/javascript">
	  function allpost(){
   $.ajax({
                    url: "<?php echo site_url();?>Medi_varsity/postArrayList",
                    method: "POST",
                    dataType: "html",
                    success: function(data)
                    {
                    jQuery('div#allpostlist').html(data);
                    }
                    
                });
   
}
allpost(); // This will run on page load
setInterval(function(){
    allpost() // this will run after every 5 seconds
}, 2000);
</script>
<script type="text/javascript">
	function doConfirm(msg, yesFn, noFn)
{
    var confirmBox = $("#confirmBox");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function()
    {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();
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