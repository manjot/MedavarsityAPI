<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Forgotpassword || Mediversity</title>
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
		<!-- modernizr JS
		============================================ -->		
        <script src="<?php echo HTTP_ASSETS_PATH;?>js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
	<?php require_once('header.php');?>
	<!--end mobile menu  area -->	
	<div class="">
		<div class="container">		
		<h3 class="enqfrmheading module-title" style="color: black">FORGOT<span style="color:#01bafd"> PASSWORD</span><br><span><?php print $this->session->flashdata('forgot');?></span></h3>		
			<div class="row">
				<form action="<?php echo base_url().'forgot';?>" method="post">
				<div class="col-md-12 col-sm-12">
					<div>
						<div class="form-group">
							<div class="col-md-4 col-sm-4">
								<p class="fnone"><label class="" for="name">Email</label></p>
							</div>
							<div class="col-md-8 col-sm-8">
								<div class="i_box input_box40">									
									<input type="text" name="email" id="email"/>								
									<span style="color:red;" id="error_email"></span>
								</div>						
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4 col-sm-4">
							</div>
							<div class="col-md-8 col-sm-8">
										<span><a href="<?php echo base_url().'registration';?>">
										  Don't have an account?</a></span>
							</div>			
						</div>			
						<div class="form-group">
							<div class="col-md-4 col-sm-4"></div>
							<div class="col-md-8 col-sm-8">
								<p class=""><button type="submit" class="read_more buttonc" id="forgotpassword">Submit</button></p>
							</div>							
						</div>					
					</div>
				</div>	
				</form>		
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
         <script>
  	$("#forgotpassword").click(function(e){
    var email = $("#email").val();
    if(email=='')
    {
  
    $("span#error_email").html('Please Enter your email');
    $("#email").focus();
    }else{
    $("span#error_email").html('');    
    }

    if(email=='')
    {
  
    return false;
    }

    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
       
    if((reg.test(email) == false))
      {
      $("span#error_email").html('Please enter valid email id');
      return false;
      }

    });
    </script>
    </body>
</html>