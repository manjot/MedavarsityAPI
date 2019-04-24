<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login Page || Medivarsity</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- favicon
		============================================ -->		
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_ASSETS_PATH;?>img/favicon.ico">		
		<!-- Google Fonts
		============================================ -->		
		<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<!--linearicons font-->
		<link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/linearfont.css">
		<!-- Bootstrap CSS
		============================================ -->		
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/bootstrap.min.css">
		<!-- meanmenu CSS
		============================================ -->		
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/meanmenu.min.css">
		<!-- Bootstrap CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/font-awesome.min.css">
		<!-- owl.carousel CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/owl.theme.css">
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/owl.transitions.css">
		<!-- animate CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/animate.css">
		<!-- normalize CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/normalize.css">
		<!-- Nivo Slider CSS -->
		<link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/nivo-slider.css">
		<!-- Add venobox css -->
		<link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>venobox/venobox.css"> 
		<!-- main CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/main.css">
		<!-- Nivo Slider CSS -->
		<link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/nivo-slider.css">		
		<!-- style CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>style.css">
		<!-- responsive CSS
		============================================ -->
        <link rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/responsive.css">
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ASSETS_PATH;?>css/jquery.growl.css">
		<!-- modernizr JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
	<!--start header  area --> 
	<?php require_once('header.php');?>
	<!--end mobile menu  area -->	
	<div class="">
		<div class="container">		
		<h3 class="enqfrmheading" style="color: black">LOG<span style="color:#01bafd">IN</span><br><span style="color:red;"><?php print $this->session->flashdata('login');?></span></h3>		
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div>
						<form action="<?php echo base_url().'doLogin';?>" method="post">
						<div class="form-group">
							<div class="col-md-4 col-sm-4">
								<p class="fnone"><label class="" for="name">Username</label></p>
							</div>
							<div class="col-md-8 col-sm-8">
								<div class="i_box input_box40">									
									<input type="text" name="username" id="username"/>
									<em style="color:#695d46">Please enter your email id or contact number as username</em>								
								</div>
								<span style="color:red;" id="error_username"></span>						
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4 col-sm-4">
								<p class="fnone"><label class="" for="Password">Password</label></p>
							</div>
							<div class="col-md-8 col-sm-8">
								<div class="i_box input_box40">									
									<input type="password" name="password" id="password"/>							
								</div>	
								<span style="color:red;" id="error_pass"></span>					
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4 col-sm-4">
							</div>
							<div class="col-md-8 col-sm-8">
									 <span><a href="<?php echo SITEURL.'forgotpassword';?>">
										Forgot your password?</a></span><br>
										<span><a href="<?php echo SITEURL.'registration';?>">
										  Don't have an account?</a></span>
							</div>			
						</div>			
						<div class="form-group">
							<div class="col-md-4 col-sm-4"></div>
							<div class="col-md-8 col-sm-8">
								<p class=""><button type="submit" id="loginstudent" class="read_more buttonc">Login</button></p>
							</div>							
						</div>
						</form>					
					</div>
				</div>			
			</div>
		</div>
	</div>	
	<!--end courses  area -->
	<!--start share  area -->
	
	
	<!--end offer  area -->
	<!-- breadcrumb-area start -->
	<!-- breadcrumb-area end -->	
	<?php require_once('footer.php');?>
		<!-- jquery
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/vendor/jquery-1.11.3.min.js"></script>
		<!-- bootstrap JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/bootstrap.min.js"></script>
		<!-- wow JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/wow.min.js"></script>
		 <!-- Nivo Slider JS -->
		<script src="<?php echo HTTP_ASSETS_PATH;?>js/jquery.nivo.slider.pack.js"></script> 		
		<!-- meanmenu JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/jquery.meanmenu.min.js"></script>
		<!-- owl.carousel JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/owl.carousel.min.js"></script>
		<!-- scrollUp JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/jquery.scrollUp.min.js"></script>
		<!-- Apple TV Effect -->
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/atvImg-min.js"></script>
		<!-- Add venobox js -->
		<script type="text/javascript" src="<?php echo HTTP_ASSETS_PATH;?>venobox/venobox.min.js"></script>
		<!-- plugins JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/plugins.js"></script>
		<!-- main JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/main.js"></script>
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/jquery.growl.js"></script>

     <script>
    $("#loginstudent").click(function(e){
    var username = $("#username").val();
    if(username=='')
    {
    $("span#error_username").html('Please enter your username');
    $("#username").focus();
    }else{
     $("span#error_username").html('');  
    }
    var password = $("#password").val();
    if(password=='')
    {
  
    $("span#error_pass").html('Please Enter Password');
    $("#password").focus();
    }else{
    $("span#error_pass").html('');    
    }

   

    if(username=='' || password=='')
    {
  
    return false;
    }
});
     </script>
    </body>
</html>