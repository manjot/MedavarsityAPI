<?php include('header.php');?>
<?php include('sidebar.php');?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
	
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard<span style="margin-left: 50px;" id="notifyfacultydelete"></span>
				<span style="margin-left: 50px;" class="hideflash">
       	
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
							<a href="<?php echo site_url();?>Medi_varsity/postList">Post Detail</a>
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
									<span class="caption-subject font-green-sharp bold uppercase">
									 <?php echo $result['postDetail']->name;?>
                                  
									<!--<span class="caption-helper">manage orders...</span>-->
								</div>
								<div class="actions">
									<a href="<?php echo site_url();?>Medi_varsity/postList" class="btn btn-circle btn-default">
									
									<span class="hidden-480">
									Back </span>
									</a>
								
								</div>
							</div>
							<div class="portlet-body">
								<div class="table-container" id="">
									
									<table class="table table-striped table-bordered table-hover" >
									<tr>
										<td class="col-md-2">Post Date :</td>
										<td><?php echo date('d/m/Y',strtotime($result['postDetail']->date));?></td>
									</tr>
						            <tr>
						            	<td>Title :</td>
						            	<td> <?php echo $result['postDetail']->title;?></td>
						            </tr>
							       <tr>
						            	<td>content :</td>
						            	<td><?php echo $result['postDetail']->content;?></td>
						            </tr> 
						            <tr>
						            	<td>Attachment :</td>
						            	<td><?php echo $result['postDetail']->attachment;?></td>
						            </tr>
									
								
								
									
									</table>
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