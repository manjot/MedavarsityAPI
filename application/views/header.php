
	<div class="header_area home-2">
		<div class="div container">
			<div class="row">
				<div class="col-md-7">
					<div class="phone_address clear">
						<p class="no-margin">
						  <small>
							  
							  <span class="icon-set"><i class="fa fa-phone"></i> +91 8527981551</span> 
							  <span class="icon-set"><i class="fa fa-envelope"></i> info@medivarsity.com</span> 
						  </small>
						</p>				
					</div>			
				</div>
				<div class="col-md-5">
			
					<div class="social_icon pull-right">
						<p>
						   <a target="_blank" href="https://www.facebook.com/Medivarsity-480584659102487/"class="icon-set"><i style="    padding-left: 10px;
    padding-right: 10px;"class="fa fa-facebook"></i></a> 
						   <a target="_blank" href="https://twitter.com/drdev555?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" class="icon-set"><i style="    padding-left: 8px;
    padding-right: 8px;"class="fa fa-twitter"></i></a> 
						
						</p>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<!--end header  area -->
	<!--Start mobile menu  area -->
	<div class="mobile_memu_area home-2">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<a href="<?php echo base_url();?>"><img src="<?php echo HTTP_ASSETS_PATH;?>img/home2/logo-white.png" width="24%" alt="" /></a>
					<div class="mobile_memu">
					<!--  nav menu-->
					<nav>
						<ul class="navid">

							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li><a href="<?php echo base_url();?>#about">About Us</a></li>
							<li><a href="<?php echo base_url();?>#course">Courses</a></li>
							<li><a href="<?php echo base_url();?>#faculty">Faculty</a></li>					
							<li><a href="<?php echo base_url();?>#Products">Books</a></li>
							<li><a href="<?php echo base_url();?>#query">Query</a></li>
							<li><a href="<?php echo base_url();?>#contact">Contact</a></li>
							<?php  if ($this->session->userdata('is_authenticate_user') == TRUE) {?>
                            <li><a href="<?php echo base_url().'profile';?>">My Profile</a></li>
							<li><a href="<?php echo base_url().'logout';?>">Logout</a></li>
							<?php }else{?>	
							<li><a href="<?php echo base_url().'login';?>">Login</a></li>
							<li><a href="<?php echo base_url().'registration';?>">Register</a></li>
						    <?php } ?>
						</ul>
					</nav>
					<!--end  nav menu-->
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="nav_area home-2" id="myHeader">
		<div class="container">
			<div class="row">
				<!--nav item-->
				<div class="col-md-2 col-sm-2 col-xs-2" >
					<div class="home2_logo"><a href="<?php echo base_url();?>"><img src="<?php echo HTTP_ASSETS_PATH;?>img/home2/logo-white.png" width="50%" alt="" /></a></div>
				</div>
				<div class="col-md-10 col-sm-10 col-xs-10">
					<!--  nav menu-->
					<nav class="menu">
						<ul class="navid pull-left">
							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li><a href="<?php echo base_url();?>#about">About Us</a></li>
							<li><a href="<?php echo base_url();?>#course">Courses</a></li>
							<li><a href="<?php echo base_url();?>#faculty">Faculty</a></li>					
							<li><a href="<?php echo base_url();?>#Products">Books</a></li>
							<li><a href="<?php echo base_url();?>#query">Query</a></li>
							<li><a href="<?php echo base_url();?>#contact">Contact</a></li>
							<?php  if ($this->session->userdata('is_authenticate_user') == TRUE) {?>
                            <li><a href="<?php echo base_url().'profile';?>">My Profile</a></li>
							<li><a href="<?php echo base_url().'logout';?>">Logout</a></li>
							<?php }else{?>	
							<li><a href="<?php echo base_url().'login';?>">Login</a></li>
							<li><a href="<?php echo base_url().'registration';?>">Register</a></li>
						    <?php } ?>
						</ul>
					</nav>
					<!--end  nav menu-->	
				</div>
				<!--end nav item -->
			</div>	
		</div>
	
	</div>