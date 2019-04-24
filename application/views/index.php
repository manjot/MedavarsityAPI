
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo SITENAME;?></title>
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
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    </head>
    <body>
      
<?php require_once('header.php');?>
	<!--end mobile menu  area -->	
	<div class="slide_wrap_area">
    <!--Start nav  area --> 
	
	<!--end nav  area -->	
	<!-- HOME SLIDER -->
	<div class="slider-wrap home-1-slider" id="home">
		<div id="mainSlider" class="nivoSlider slider-image">
			<img src="<?php echo HTTP_ASSETS_PATH;?>img/home1/ban2.jpg" alt="main slider" title="#htmlcaption1"/>
			<img src="<?php echo HTTP_ASSETS_PATH;?>img/home1/anatomy.jpg" alt="main slider" title="#htmlcaption1"/>
			<img src="<?php echo HTTP_ASSETS_PATH;?>img/home1/pathology.jpg" alt="main slider" title="#htmlcaption1"/>
		</div>
		<div id="htmlcaption1" class="nivo-html-caption slider-caption-1">
			<div class="slider-progress"></div>	
			<div class="container">
				<div class="row">
					<div class="col-md-12">						
						<div class="slide1-text slide-text">
							<div class="middle-text">
								<div class="left_sidet1">
									<div class="cap-title wow slideInRight" data-wow-duration=".9s" data-wow-delay="0s">
										<h1>Medivarsity </h1>
									</div>
									<div class="cap-dec wow slideInRight" data-wow-duration="1s" data-wow-delay=".5s">
										<h2>A Concept Of <span style="color:#02baff;">Dr. Devesh Mishra</span></h2>
									</div>	
									<?php  if ($this->session->userdata('is_authenticate_user') == FALSE) {?>
									<div class="cap-readmore animated fadeInUpBig" data-wow-duration="2s" data-wow-delay=".5s">
										<a href="<?php echo base_url().'login';?>" >Login</a>
									</div>
								    <?php }?>
								</div>				
							</div>	
						</div>		
					</div>
				</div>
			</div>					
		</div>	
	</div>
	<!-- HOME SLIDER -->
	</div>
    <!--Start about  area --> 
	<div class="about_area home-2" id="about">
		<div class="container">
		<h3 class="enqfrmheading module-title" style="color: black">ABOUT <span style="color:#01bafd">MEDIVARSITY</span></h3>
			<div class="row">
				<div class="col-md-6 col-sm-6">
					
							<div class="about_texts" style="line-height: 1.8;padding-top: 20px;text-align: justify;">
								<p>The idea of Medivarsity was conceived by Dr. Devesh Mishra to outreach the students online who were preparing for NEET PG and could not attend the live lectures.</p>
								
								<p>Medivarsity contains video recording of lectures with all diagrams and illustrations which will be as good as live lectures with the comfort of anytime/anywhere access.  Q-banks, TnD's, Test series and other innovative educational projects will be launched later.</p>
								<p>Medivarsity is committed to deliver the best to the students and to continuously grow and improve with the  help and support of the students.</p>

									
							</div>
						  
				</div>
				<div class="col-md-6 col-sm-6">
					<video style="margin-bottom: 15px;
					    position: relative;" width="100%" controls="true" autoplay>
					  <source src="<?php echo base_url().'assets/Promotion.mp4';?>" type="video/mp4">
					  <source src="<?php echo base_url().'assets/Promotion.ogg';?>" type="video/ogg">
					</video>
				</div>
			</div>
		</div>
	</div>
	<!--end about  area -->	
	<!--start courses  area -->
	<div class="courses_area home-2" id="course">
		<div class="container">
		<h3 class="enqfrmheading module-title" style="color: black">OUR <span style="color:#01bafd">COURSES</span></h3>
			<div class="row">
				<!--start course single  item -->
				<?php foreach($courseslist as $courses){ 
				
				  /*  $price              =  $courses['price'];
					$discount           = ($courses['price'] * DISCOUNTPERCENTAGE)/100;
                    $discountpercentage = $courses['price'] - $discount;*/

                      $discountpercentage = $courses['price'];
				?>
				<div class="col-md-6 col-sm-6 col-lg-6">
					<div class="course_item">
						<div class="courses_thumb">
							<a href=""><img src="<?php echo COURSESURL.$courses['image'];?>" width="100%" alt="" /></a>
							<div class="courses_thumb_text">
								<p><a></a></p>
							</div>
						</div>
						<div class="courses_content">
							<h2><a><?php echo $courses['subject_name'];?></a></h2>
							<p><?php echo $courses['subject_description'];?></p>
						</div>
						<?php if($courses['subject_id'] == 28 ){ ?>
						<div class="cap-readmore1">
								<?php  if ($this->session->userdata('is_authenticate_user') == TRUE) {
								
								

									$btntext='PreBook Now At Rs.'.intval($discountpercentage) ;
									$btnlink=base_url().'Home/orders/'.$courses['id'];
									if($courses['subscription_status'] && $courses['hours_remaining'] > 0)
									{
									   $btntext='Subscribed';
									   $btnlink='javascript:void(0);';
									}
									?>
								
										<a href="<?php echo  $btnlink; ?>" <?php if($btntext=='Subscribed'){ echo "style='background-color:green;'"; }?>><?php echo $btntext; ?></a>
								<?php }else{?>
                                        <a href="<?php echo base_url().'login';?>">Book Now At Rs. <?php  echo intval($discountpercentage);?>+18% GST</a>
                                 <?php } ?>
									</div>
									<?php }else{ ?>
									<div class="cap-readmore1">
                                     <a>Coming Soon </a>
                                    </div>
									<?php } ?>
						
					</div>
				
				</div>
			    <?php } ?>
				
				
				<!--End course single  item -->					
			</div>		
		</div>
	</div>	
	<!--end courses  area -->
	<!--start ads  area -->
	<div class="teacher_area home-2" id="faculty">
		<div class="container">
		<h3 class="enqfrmheading module-title" style="color: black">FACULTY <span style="color:#01bafd">MEMBERS</span></h3>	
		</div>	
		<div class="container">
			<div class="row">
				
				<!--start teacher single  item-->
				<?php foreach($facultylist as $faculty){ ?>
				<div class="col-md-3 col-lg-3 col-sm-6">
					<div class="single_teacher_item">
						<div class="teacher_thumb">
							<img src="<?php echo FACULTYURL.$faculty['profile_image_url'];?>" alt="" />
							<div class="thumb_text">
								<h2><?php echo $faculty['name'];?></h2>
								<p><?php echo $faculty['subject_name'];?></p>
							</div>
						</div>
						<div class="teacher_content">
							<h2><?php echo $faculty['name'];?></h2>
							<span><?php echo $faculty['subject_name'];?></span>
							<p><?php echo substr($faculty['about'],0,100);?></p>
							<div class="social_icons">
								<span><i class="fa fa-envelope"></i> <?php echo $faculty['email'];?></span><br>
								<span><i class="fa fa-phone"></i> <?php echo $faculty['contact_no'];?></span>
							</div>
						</div>
					</div>
				</div>
			    <?php } ?>
				
			
			
             
				<!--End teacher single  item -->				
			</div>
		</div>
	</div>	
	<!--end teacher  area -->
	<!--start offer  area -->
	<div class="offer_area home-2">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-lg-6">
					<div class="media-box">
						<a class=" video-button text-uppercase" target="_blank" href="https://www.youtube.com/channel/UC7XHrckkwejW2tKOy6yNLIQ?view_as=subscriber">
						  <i class="fa fa-play-circle-o"></i>
						  <span>Watch Video</span>
						</a>    
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6">
					<div class="title">
						<h3 class="offer-title module-title" style="text-shadow: 2px 2px #0e4c56;
    color:#ffffff;">
							Like what you're learning   <span> Get started today!</span>
						</h3>
					</div>				
					<div class="offer_item">
						<div class="offer_content">							
							<p style="text-shadow: 2px 2px #0e4c56;
    color: ##ffffff;"> To watch latest Videos of lectures delivered by Dr Devesh Mishra</p>
							<a href="#" class="readmore">Application Coming Soon</a>
						</div>
					</div>					
				</div>				
			</div>
		</div>
	</div>	
	<!--end offer  area -->
	<!--start priging  area -->
	<div class="priging_area home-2" id="Products">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-12 col-md-6">
					<div class="row">
						<div class="col-md-12">
							<div class="title">
								<h3 class="module-title animated fadeInRight">
									Develop skills with   <span style="color:#01bafd">Medivarsity</span>
								</h3>
							</div>
						</div>
					</div>				
					<div class="row">
						<!-- service single item --> 
						<div class="col-md-12 col-sm-6 col-lg-12">
							<div class="service_item">
								<span class="lnr lnr-film-play"></span>
								<h2>10 Years of Experience</h2>
								<p>We have step by step tutorials & instructions</p>
							</div>
						</div>
						<!-- end service single item -->
						<!-- service single item --> 
						<div class="col-md-12 col-sm-6 col-lg-12">
							<div class="service_item">
								<span class="lnr lnr-camera-video"></span>
								<h2>120k Facebook Members  </h2>
								<p>We have step by step tutorials & instructions </p>
							</div>
						</div>
						<!-- end service single item --> 
						<!-- service single item --> 
						<div class="col-md-12 col-sm-6 col-lg-12">
							<div class="service_item">
								<span class="lnr lnr-book"></span>
								<h2>Different book Available</h2>
								<p>We have step by step tutorials & instructions</p>
							</div>
						</div>
						<!-- end service single item -->
						<!-- service single item --> 
						
						<!-- end service single item -->  										
					</div>						
				</div>
				<div class="col-lg-6 col-sm-12 col-md-6">
					<div class="row">
						<div class="col-md-12">
							<div class="title">
								<h3 class="module-title title2">
									Our Latest  <span style="color:#01bafd">Publications</span>
								</h3>
							</div>
						</div>
					</div>			
					<div class="row">
						<!-- single item priging -->
						<div class="col-md-4 col-sm-4 col-lg-4">
							<div class="priging_item">
								<div class="priging_thumb">
									<a>
										<div class="atvImg">
										   <div class="atvImg-layer" data-img="<?php echo HTTP_ASSETS_PATH;?>img/home1/book/2.png"></div>
										</div>														
									</a>
								</div>
								<div class="priging_content">
									<!-- <h2>Dont Make me think</h2>	 -->						
									<!--<a href="http://drdeveshmishra.in/">Buy Now | Rs 1399</a>-->
								</div>
							</div>
						</div>
						<!-- end single item priging -->
						<!-- single item priging -->
						<div class="col-md-4 col-sm-4 col-lg-4">
							<div class="priging_item">
								<div class="priging_thumb">
									<a>
										<div class="atvImg">
										   <div class="atvImg-layer" data-img="<?php echo HTTP_ASSETS_PATH;?>img/home1/book/1.png"></div>
										</div>														
									</a>
								</div>
								<div class="priging_content">
									<!-- <h2>Dont Make me think</h2>	 -->						
									<!--<a href="http://drdeveshmishra.in/">Buy Now | Rs 1399</a>-->
								</div>
							</div>
						</div>
                        <div class="col-md-4 col-sm-4 col-lg-4">
							<div class="priging_item">
								<div class="priging_thumb">
									<a>
										<div class="atvImg">
										   <div class="atvImg-layer" data-img="<?php echo HTTP_ASSETS_PATH;?>img/home1/book/3.png"></div>
										</div>														
									</a>
								</div>
								<div class="priging_content">
									<!-- <h2>Dont Make me think</h2>	 -->						
									<!--<a href="http://drdeveshmishra.in/">Buy Now | Rs 1399</a>-->
								</div>
							</div>
						</div>
						<!-- end single item priging -->
					<!-- 	<div class="col-md-12">
							<div class="learnmore text-left">
								<a href="http://drdeveshmishra.in/" class="read_more2">More books  <i class="fa fa-arrow-right"></i></a>
							</div>
						</div> -->
					</div>
						
				</div>
			</div>
		</div>
	</div>	
	
	<div class="share_area home-2 sharre_top">
		<div class="container">
		<h3 class="enqfrmheading module-title" style="color:black">Get In <span style="color:#01bafd">Touch</span></h3>
			<div class="row">
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.faicon {
  padding: 20px;
  font-size: 30px;
 
  text-align: center;
  text-decoration: none;
  margin: 5px 2px;
}

.fa:hover {
    opacity: 0.7;
}

.fa-facebook {
  background: #3B5998;
  color: white;
}

.fa-twitter {
  background: #55ACEE;
  color: white;
}

.fa-google {
  background: #dd4b39;
  color: white;
}

.fa-linkedin {
  background: #007bb5;
  color: white;
}

.fa-youtube {
  background: #bb0000;
  color: white;
}

.fa-instagram {
  background: #125688;
  color: white;
}



.fa-android {
  background: #a4c639;
  color: white;
}

.fa-apple {
  background: #125688;
  color: white;
}


</style>

<!-- Add font awesome icons -->
<div class="row" align="center">
<a Style="padding-right: 26px;
    padding-left: 24px;"href="https://www.facebook.com/pages/category/Education/Medivarsity-480584659102487/" target="_blank" class="faicon fa fa-facebook"></a>
<a href="https://twitter.com/drdev555?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" target="_blank" class="faicon fa fa-twitter"></a>


<a href="https://www.youtube.com/channel/UC7XHrckkwejW2tKOy6yNLIQ?view_as=subscriber" class="faicon fa fa-youtube" target="_blank"></a>

</div>
			</div>
		</div>
	</div>
<div class="share_area home sharre_top">
    
		<div class="container">
		
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.509693232024!2d77.16967425017462!3d28.644453590206833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02952c00fb49%3A0x2ef67978bba72e8f!2sOffice+no+205+%26+206%2C+7%2F9%2C+Block+7%2C+East+Patel+Nagar%2C+Patel+Nagar%2C+New+Delhi%2C+Delhi+110008!5e0!3m2!1sen!2sin!4v1550659563851" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	
	</div>	
<div class="courses_area home-2 sharre_top" id="query">
    
		<div class="container">
			<div class="row">
		<h3 class="enqfrmheading module-title" style="color: black">Email <span style="color:#01bafd">Us</span></h3>
	    <form action="<?php echo base_url().'sendquery';?>" method="post">
    <div class="col-md-6 col-sm-6 col-lg-6">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name">
      <span style="color:red;" id="error_name"></span>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-lg-6">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email">
      <span style="color:red;" id="error_email"></span>
    </div>
</div>
 
  <div class="col-md-6 col-sm-6 col-lg-6">
    <div class="form-group ">
      <label for="contact number">Contact</label>
      <input type="text" class="form-control" name="contact_num" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" id="contact_num" placeholder="Enter Your Mobile Number">
      <span style="color:red;" id="error_contact_num"></span>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-lg-6">
    <div class="form-group ">
      <label for="address">Address</label>
      <input type="text" class="form-control" name="address" id="address" placeholder="Enter Your Address">
    </div>
</div>
  
  <div class="col-md-6 col-sm-6 col-lg-12">
  <div class="form-group">
    <label for="message">Message</label>
    <textarea class="form-control" name="message" id="message" placeholder="Enter Your Query"></textarea>
    <span style="color:red;" id="error_message"></span>
  </div>
</div>
  <div class="col-md-6 col-sm-6 col-lg-3">
  <button type="submit" class="btn btn-info" Style="width:100px;border-radius:0px;background-color: #01bafd;
    border-color: #01bafd;text-align: center; " id="sendquery">Submit</button>
</div>

</form>
		</div>
	</div>
	</div>	
	<!--end share  area -->	
	<!-- footer  area -->	
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
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 1500, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});
</script>
  <script>
    $("#sendquery").click(function(e){
    var name = $("#name").val();
    if(name=='')
    {
    $("span#error_name").html('Please enter name.');
    $("#name").focus();
    }else{
     $("span#error_name").html('');  
    }

    var email = $("#email").val();
    if(email == '')
    {
    $("span#error_email").html('Please enter email.');
    $("#email").focus();
    }else{
     $("span#error_email").html('');  
    }
    var contact_num = $("#contact_num").val();
	intRegex = /[0-9 -()+]+$/;
    if(contact_num=='')
    {
  
    $("span#error_contact_num").html('Please enter contact number');
    $("#contact_num").focus();
    }else if((contact_num.length < 10) || (!intRegex.test(contact_num))){
      $("span#error_contact_num").html('Please enter vailid contact number');
	    return false;
    }else{
	   $("span#error_contact_num").html('');  
	}

     var message  = $("#message").val();
    if(message=='')
    {
  
    $("span#error_message").html('Please enter your query');
    $("#message").focus();
    }else{
    $("span#error_message").html('');    
    }
   
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(name=='' || email=='' || contact_num=='' || message=='')
    {
    return false;
    }else if((reg.test(email) == false))
      {
      $("span#error_email").html('Please enter valid email id');
      return false;
      }

    });
 
    </script>


    </body>
</html>