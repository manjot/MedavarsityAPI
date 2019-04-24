<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Registration Page || Medivarsity</title>
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
	<!--start header  area --> 
	<?php require_once('header.php');?>
	<!--end mobile menu  area -->
	<!--end mobile menu  area -->	
	<div class="">
		<form action="<?php echo base_url().'saveregistration';?>" method="post">
		<div class="container">
				<h3 class="enqfrmheading" style="color: black; font-size: 35px;margin-top: 41px;
    margin-bottom: 24px;">REGIS<span style="color:#01bafd">TRATION</span></h3>
			<div class="row">
				 <div class="col-md-4 col-sm-4 col-lg-4">
				 
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name">
      <span style="color:red;" id="error_name"></span>
    </div>
</div>
<div class="col-md-4 col-sm-4 col-lg-4">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email">
      <span style="color:red;" id="error_email"></span>
      <span style="color:red;" id="msg_email"></span>
    </div>
</div>

 <div class="col-md-4 col-sm-4 col-lg-4">
    <div class="form-group">
      <label for="contact number">Contact Number</label>
      <input type="text" class="form-control" name="contact_num" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" id="contact_num" placeholder="Enter Your Contact NUmber">
      <span style="color:red;" id="error_contact_num"></span>
      <span style="color:red;" id="msg_contact"></span>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-4 col-sm-4 col-lg-4">
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password">
      <span style="color:red;" id="error_password"></span>
    </div>
</div>

 <div class="col-md-4 col-sm-4 col-lg-4">
    <div class="form-group">
      <label for="confirm password">Confirm Password</label>
      <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm password">
      <span style="color:red;" id="error_cpassword"></span>
    </div>
</div>

<div class="col-md-4 col-sm-4 col-lg-4">
    <div class="form-group">
      <label for="year of college">Year of College</label>
   <select name="year" id="year" class="form-control">
										<option value="" selected>Select Year</option>
										<option value="1">1st Year</option>
										<option value="2">2nd Year</option>
										<option value="3">3rd Year</option>
										<option value="4">4th Year</option>
										<option value="5">5th Year</option>
                                        <option value="Intern">Intern</option>
                                        <option value="Other">Other</option>
									</select>	
									  <span style="color:red;" id="error_year"></span>		
    </div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-lg-6">
    <div class="form-group">
      <label for="state list">State List</label>
    <select name="State" id="state" class="form-control">
										<option value="" selected>Select State</option>
										<?php foreach($statelist as $element){ ?>
										<option value="<?php echo $element['id'];?>"><?php echo $element['state'];?></option>
									    <?php } ?>
									</select>		
									  <span style="color:red;" id="error_state"></span>
    </div>
</div>

<div class="col-md-6 col-sm-6 col-lg-6">
    <div class="form-group">
      <label for="college list">College List</label>
   <select name="college" id="college" class="form-control">
										<option value="" selected>Select College</option>
									</select>	
									<span style="color:red;" id="error_college"></span>	
    </div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-lg-12">
    <div class="form-group">
      <label for="address">Address</label>
      <textarea class="form-control" name="address" id="address"></textarea>
    </div>
</div>
</div>
			<div class="row" align="right">
	                             <p class="">
									<button type="submit" class="read_more buttonc" name="register" id="register">Register</button>
									<button type="reset" class="read_more buttonc">Cancel</button>
								</p>
							</div>

		</div>
	</form>
	</div>	
	<!--end courses  area -->
	<!--start share  area -->

	

	<!-- breadcrumb-area end -->	
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
    $("#register").click(function(e){
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
         $("span#error_contact_num").html('Please enter a valid phone number.');
			return false;
		}else{
			$("span#error_contact_num").html('');    
			}

    var password  = $("#password").val();
    if(password=='')
    {
  
    $("span#error_password").html('Please enter password');
    $("#password").focus();
    }else{
    $("span#error_password").html('');    
    }

    var cpassword  = $("#cpassword").val();
    if(cpassword=='')
    {
  
    $("span#error_cpassword").html('Please enter confirm password');
    $("#cpassword").focus();
    }else{
    $("span#error_cpassword").html('');    
    }

    var state  = $("#state").val();
    if(state=='')
    {
  
    $("span#error_state").html('Please select state');
    $("#state").focus();
    }else{
    $("span#error_state").html('');    
    }

     var college  = $("#college").val();
    if(college=='')
    {
  
    $("span#error_college").html('Please select college');
    $("#college").focus();
    }else{
    $("span#error_college").html('');    
    }


     var year  = $("#year").val();
    if(year=='')
    {
  
    $("span#error_year").html('Please select year');
    $("#year").focus();
    }else{
    $("span#error_year").html('');    
    }
   
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(name=='' || email=='' || contact_num=='' || password=='' || cpassword=='' || state=='' || college=='' || year=='')
    {
    return false;
    }else if((reg.test(email) == false))
      {
      $("span#error_email").html('Please enter valid email id');
      return false;
      }
    else if(password != cpassword){
     $("span#error_cpassword").html('Password and confirm password does not match');
    return false;
    }

    });
 
    </script>

    <script>
    	
   // check existing mail
	jQuery(document).on('keyup', '#email', function () {
	    var email = jQuery(this).val();
	    if (email != '') {
	        checkExistingEmail(email);
	    }
	});
    // check existing contact num
	jQuery(document).on('keyup', '#contact_num', function () {
	    var contactno = jQuery(this).val();
	    if (contactno != '') {
	        checkExistingContactNo(contactno);
	    }
	});

	// check existing email address
    function checkExistingEmail(email) {
    jQuery.ajax({
        url:  'home/checkemail',
        type: 'post',
        data: {email: email},
        dataType: 'json',
        success: function (json) {
            if (json.contact_email_valid == 0) {
                jQuery('span#msg_email').html('<small>This email ID is already registered with us . Please try another one.</small>');
                jQuery('button#register').attr('disabled', true);
            } else {
            	jQuery('span#msg_email').html('');
                jQuery('button#register').attr('disabled', false);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// check existing email address
function checkExistingContactNo(contactNo) {
    jQuery.ajax({
        url: 'home/checkContactNum',
        type: 'post',
        data: {contactNo: contactNo},
        dataType: 'json',
        success: function (json) {
            if (json.contact_count > 0) {
                jQuery('span#msg_contact').html('<small>This mobile no. is already registered with us . Please try another one.</small>');
                jQuery('button#register').attr('disabled', true);
            }else {
            	jQuery('span#msg_contact').html('');
                jQuery('button#register').attr('disabled', false);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

    </script>
      <script type="text/javascript">
	    var url = '<?php echo site_url();?>'
		$("#state").change(function(){
		var state=$("#state").val();
		$.ajax({
		type:"post",
		url: url + "home/getcolleges",
		data:"state="+state,
		success:function(data){
		$("#college").html(data);
		}
		});
		});
											
	    </script>
    </body>
</html>