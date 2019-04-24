<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>

		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
			
				<h3 class="page-title">
				Admin Details 
				</h3>
		<h2>Change Password</h2>
<br>
<form method="post" action=''>
		<label>Old Password :</label>
		<input type="password" name="old_pass" id="name" placeholder="Old Pass"/><br /><br />
		<label>New Password :</label>
		<input type="password" name="new_pass" id="password" placeholder="New Password"/><br/><br />

		<label>Confirm Password :</label>
		<input type="password" name="confirm_pass" id="password" placeholder="Confirm Password"/><br/><br />
		<input type="submit" value="changepassword" name="change_pass"/><br />
</form>

				
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
<?php $this->load->view('includes/footeradmin');?>