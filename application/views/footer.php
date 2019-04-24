<div class="footer_area" id="contact">
		<div class="container">
			<div class="row">
				<div class="borderbottom">			
					<div class="col-md-6 col-sm-12">
						<div class="footer_top_left">
                         <img src="<?php echo HTTP_ASSETS_PATH;?>img/home2/logo-white.png" width="12%"/>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="footer_top_right">
						 <span></span>
						 	<?php  if ($this->session->userdata('is_authenticate_user') == TRUE) {?>
						 <a href="<?php echo base_url().'profile';?>" class="read_more">My Profile</a>
						<?php }else{?>
						<a href="<?php echo base_url().'registration';?>" class="read_more">Sign Up</a>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<!-- widget area -->
			<div class="row">
				<div class="col-md-4 col-sm-12">
					<!--single widget item -->
					<div class="contact-address">
					<h3 style="color:white">Contact Detail</h3>	
						<div class="media">
							<div class="media-left">
								<i class="fa fa-phone" style="color:white" ></i>
							</div>
							<div class="media-body">
								
								<p>
									<span style="color:white" class="contact-emailto">+911147034800</span>
								</p>
							</div>
						</div>
						<div class="media">
							<div style="color:white" class="media-left">
								<i class="fa fa-envelope"></i>
							</div>
							<div class="media-body">
								
								<p>
									<span  style="color:white" class="contact-emailto"><a href="#">info@medivarsity.com</a></span>
								</p>
							</div>
						</div>
						<div class="media">
							<div style="color:white" class="media-left">
								<i class="fa fa-map-marker"></i>
							</div>
							<div class="media-body">
								
								<p>
									<span style="color:white"class="contact-emailto">
										Medivarsity<br>
										Office no 205 & 206<br>
										Second floor<br>
										9/2, East Patel Nagar<br>
										New Delhi - 110008
														
									</span>
								</p>
							</div>
						</div>							
					</div>
					<!--single widget item -->
									
				</div>
				<div class="col-md-8 col-sm-12">
				<h3 style="color:white">About Us</h3>	
				<p style="color:#ffff; text-align: left;">The idea of Medivarsity was conceived by Dr. Devesh Mishra to outreach the students online who were preparing for NEET PG and could not attend the live lectures.Medivarsity contains video recording of lectures with all diagrams and illustrations which will be as good as live lectures with the comfort of anytime/anywhere access.  Q-banks, TnD's, Test series and other innovative educational projects will be launched later.Medivarsity is committed to deliver the best to the students and to continuously grow and improve with the  help and support of the students.</p>
				<a href="<?php echo base_url().'privacypolicy';?>" class="read_more">Privacy Policy</a>					
				</div>
       
       
       
			
			</div>
			<!-- end widget area -->
		</div>
	</div>
	<!-- end footer  area -->
	<!-- footer bottom area -->
	<div class="footer_bottom_area">
		<div class="container">
			<div class="row">
				<div class=" col-sm-6 col-md-6 col-lg-6">
					<div class="footer_text">
						<p>
							Copyright © 2019 All Rights Reserved.
						</p>
					</div>
				</div>
				<div class=" col-sm-6 col-md-6 col-lg-6">
					<p class="text-right">Design By Ajath</a></p>
				</div>				
			</div>
		</div>	
	</div>	