<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Thankyou Page || Mediversity</title>
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
		<?php if($this->session->flashdata('success')){?>
		<h3 class="enqfrmheading" style="color: black">THANK<span style="color:#01bafd"> YOU</span></h3>		
				<h4 align="center"><?php print $this->session->flashdata('success');?></h4>	
		<?php }else if($this->session->flashdata('fail')){?>
        <h3 class="enqfrmheading" style="color: black">OOP<span style="color:#01bafd">S</span></h3>		
				<h4 align="center"><?php print $this->session->flashdata('fail');?></h4>	
		<?php }?>
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
     <script>
       $(document).ready(function(){
      setTimeout(function() {
       window.location.href = '<?php echo base_url();?>'
      }, 5000);
    });	
     </script>
    </body>
</html>