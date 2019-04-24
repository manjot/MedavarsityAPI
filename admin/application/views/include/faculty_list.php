<?php include('header.php');?>
<?php include('sidebar.php');?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
	
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard <span style="margin-left: 50px;" id="notifyfacultydelete"></span>
				<span style="margin-left: 50px;" class="hideflash">
       	<?php if(!empty($this->session->flashdata('add_url_sussess'))) { ?>
               <?php print $this->session->flashdata('add_url_sussess'); ?>
        <?php }?>
                </span>
			</h3>

				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url();?>Medi_varsity/index">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Faculty List</a>
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
									<span class="caption-subject font-green-sharp bold uppercase">Faculty Listing</span>
									<!--<span class="caption-helper">manage orders...</span>-->
								</div>
								<div class="actions">
									<a href="<?php echo site_url('Medi_varsity/addFaculty_pg')?>" class="btn btn-circle btn-default">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
									Add Faculty </span>
									</a>
									<a href="<?php echo site_url('Medi_varsity/index')?>" class="btn btn-circle btn-default">
									
									<span class="hidden-480">
									Back </span>
									</a>
								
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
								<div class="table-container" id="allfaculty">
									

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
	<div class="page-footer">
		<div class="page-footer-inner">
			 2018 &copy; Medivarsity.
		</div>
		<div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		</div>
	</div>

	<!-- END FOOTER -->
</div>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout2/scripts/layout.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->


<script>
        jQuery(document).ready(function() {    
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
           EcommerceOrders.init();
        });
    </script>
    <script>
var timeout = 300; // in miliseconds (3*1000)
$('.hideflashurl').delay(timeout).fadeOut(300);
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
	<?php include('footer.php');?>
	<script>
var timeout = 3000; // in miliseconds (3*1000)
$('.hideflash').delay(timeout).fadeOut(300);
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
<script type="text/javascript">
	   function allFacultyli(){
   $.ajax({
                    url: "<?php echo site_url();?>Medi_varsity/facultyArrList",
                    method: "POST",
                    dataType: "html",
                    success: function(data)
                    {
                    jQuery('div#allfaculty').html(data);
                    }
                    
                });
   
}
allFacultyli(); // This will run on page load
setInterval(function(){
    allFacultyli() // this will run after every 5 seconds
}, 2000);
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