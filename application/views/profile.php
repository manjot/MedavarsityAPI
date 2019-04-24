

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Profile || Medivarsity</title>
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
        <style>
      body{
    background: #01bafd;
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 2%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}

        </style>
     
    </head>
    <body>
	<!--start header  area --> 
	<?php require_once('header.php');?>
	<!--end mobile menu  area -->	


<!------ Include the above in your HEAD tag ---------->

<div class="container emp-profile">
	<span><?php print $this->session->flashdata('success');?></span>
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
					
					    <div class="row">
						   <div class="profile-img">
							<?php
							
							$imgurl=base_url().'profilepicture/img.png';
							  if(!empty($studentdetails['image_url']))
							  {
								 $imgurl=base_url().'profilepicture/'.$studentdetails['image_url'];
							  }
							?>
							 <img src="<?php echo $imgurl; ?>" alt="" height="100" width="100"/>
							</div>
						</div>
						 <div class="row">
						    <div class="profile-work">
                            <p><i class="fa fa-envelope"></i> <?php echo $studentdetails['email'];?></p>
                            <p><i class="fa fa-phone"></i> <?php echo $studentdetails['contact_no'];?></p>
                            </div>
						  
						</div>
                      
                    </div>
                    <div class="col-md-8">
					    <div class="row">
						    <div class="col-md-10">
								<div class="profile-head">
											<h6>
											 <?php echo ucwords($studentdetails['name']);?>
											</h6>
											<!--<p class="proile-rating">RANKINGS : <span>8/10</span></p>-->
									<ul class="nav nav-tabs" id="myTab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
										</li>
									</ul>
								</div>
							</div>
							 <div class="col-md-2">
                        <a href="<?php echo base_url().'logout';?>"class="profile-edit-btn">Logout</a>
                    </div>
							
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="tab-content profile-tab" id="myTabContent">
									<div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="home-tab">
										<!--<div class="row">
											<div class="col-md-6">
												<label>User Id</label>
											</div>
											<div class="col-md-6">
												<p><?php echo $studentdetails['student_id']; ?></p>
											</div>
										</div>-->
										<div class="row">
											<div class="col-md-6">
												<label>Name</label>
											</div>
											<div class="col-md-6">
												<p><?php echo ucfirst($studentdetails['name']); ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label>Email</label>
											</div>
											<div class="col-md-6">
												<p><?php echo $studentdetails['email']; ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label>Phone</label>
											</div>
											<div class="col-md-6">
												<p><?php echo $studentdetails['contact_no']; ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label>College Name</label>
											</div>
											<div class="col-md-6">
												<p><?php echo $studentdetails['college_name']; ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label>Address</label>
											</div>
											<div class="col-md-6">
												<p><?php echo $studentdetails['address']; ?></p>
											</div>
										</div>
										 <div class="row">
											<div class="col-md-6">
												<label>Joining Date</label>
											</div>
											<div class="col-md-6">
												<p><?php echo date('d-M-Y',$studentdetails['created_date']); ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label>Activate  Subscriptions</label>
											</div>
											<div class="col-md-6">
											
												<p><?php 
												
												if(!empty($courseName)){
												echo rtrim($courseName,", ");
											    }else{
											    echo 'No Active Subscriptions';	
											    }

												?></p>
											</div>
										</div>
									</div>
								   
								</div>
							 </div>
						</div>
                       
                    </div>
                    
                </div>
                <?php if(!empty($arrCourses)){?>
                <div class="row">
				<div class="col-md-12"> <h3> Booking Subscriptions</h3></div>
				 <?php 
				    foreach($arrCourses as $course) {
					$coutCourseLen=strlen($course['subject_name']);
					
					$marginStyle='margin-top:5%;';
					if($coutCourseLen > 20)
					{
						$marginStyle='';
					}
					 
					 ?>
				    <div class="col-md-4">
						<div class="panel-group">
							<div class="panel panel-default">
							  <div class="panel-heading" style="height: 70px;">
							    <div class="row">
								   <div class="col-md-8">
										<h4 class="panel-title" >
										  <a data-toggle="collapse" href="#collapse1"><?php echo ucfirst($course['subject_name']); ?></a>
										
										</h4>
								   </div>
								   	 <div class="col-md-4">
									 <h5 class="panel-title pull-right">
										  <a href="<?php echo base_url().'Home/orders/'.$course['id']; ?>" class="btn btn-primary btn-xs" style="color:#fff;"> Buy Now</a>
										
										</h5>
									 
								   </div>
								</div>
							    
								<div class="row">
									<div class="col-md-12">
										<p class="pull-right" style="<?php echo $marginStyle; ?>">Rs. 
										<?php 
											  /* $discount = ($course['price'] * DISCOUNTPERCENTAGE)/100;
											   $discountpercentage = $course['price'] - $discount;*/
											   $discountpercentage = $course['price'];
											   echo intval($discountpercentage);
											   echo "+18% GST";
									   ?>
									   </p>
								   </div>
							   </div>
							  </div>
							  
							</div>
						</div>
					</div>
				 <?php } ?>
				
                </div>
            <?php } ?>
            </form>           
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
  var ok='true';
  var username=$('#username').val();
  if(username=='')
  {
 $.growl.error({ message: "Please Enter Username." });
 $('#username').focus();
  ok= false;
  return ok;
  }
  var password=$('#password').val();
  if(password=='')
  {
 $.growl.error({ message: "Please Enter Password." });
 $('#password').focus();
  ok= false;
  return ok;
  }
  return ok;
});
     </script>
    </body>
</html>