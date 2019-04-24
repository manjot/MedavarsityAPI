<script type="text/javascript">
    $(".btn-login").click(function(e){
    
      var name = $("#name").val();
      var pass = $("#pass").val();

     if(name == ''){
      $("#errorname").html("<div style='color:red'>Please Enter Name</div>");
      $("#name").focus();
      return false;
      }else{
      $("#errorname").html("");
      }
     if(pass == ''){
      $("#errorpass").html("<div style='color:red'>Please Enter Password</div>");
      $("#pass").focus();
      return false;
      }else{
      $("#errorpass").html("");
      }
    });


    $(".btn-forget").click(function(e){
   
     var email = $("#useremail").val();
     if(email == ''){
      $("#erroremail").html("<div style='color:red'>Please Enter Email</div>");
      $("#useremail").focus();
      return false;
      }else{
      $("#erroremail").html("");
      }
    });


   $(".btn-addfaculty").click(function(e){
     // alert('hi');
      var name = $("#name").val();
      var sub = $("#sub").val();
      var email = $("#email").val();
      var pass = $("#pass").val();
      var cpass = $("#cpass").val();
      var mobile = $("#mobile").val();
      var amobile = $("#amobile").val();
      var bday = $("#bday").val();
      var add = $("#add").val();
      // var asub = $("#asub").val();
      var bname = $("#bname").val();
      var anum = $("#anum").val();
      var icode = $("#icode").val();
      var pnum = $("#pnum").val();
      var gnum = $("#gnum").val();
      var bmnum = $("#bmnum").val();
      var cp = $('#reep').html();
      var mob = $('#moB').html();
      var em = $('#emA').html();
      var acn = $('#acn').html();
      var ifs = $('#ifs').html();
     // alert(ifs);
     

     if(name == ''){
      $("#errorname").html("<div style='color:red'>Please Enter Name</div>");
      $("#name").focus();
     // return false;
      }else{
      $("#errorname").html("");
      }
     if(sub == ''){
      $("#errorsub").html("<div style='color:red'>Please Enter Subject</div>");
      $("#sub").focus();
    //  return false;
      }else{
      $("#errorsub").html("");
      }
       if(email == ''){
      $("#erroremail").html("<div style='color:red'>Please Enter Email</div>");
      $("#email").focus();
    //  return false;
      }
     if(pass == ''){
      $("#errorpass").html("<div style='color:red'>Please Enter Password</div>");
      $("#pass").focus();
   //   return false;
      }else{
      $("#errorpass").html("");
      }
      if(cpass == ''){
      $("#errorcpass").html("<div style='color:red'>Please Enter Conifrm Password</div>");
      $("#cpass").focus();
    //  return false;
      }
      if(mobile == ''){
      $("#errormobile").html("<div style='color:red'>Please Enter Mobile Number</div>");
      $("#mobile").focus();
    //  return false;
      }
      if(add == ''){
      $("#erroradd").html("<div style='color:red'>Please Enter Address</div>");
      $("#add").focus();
    //  return false;
      }else{
      $("#erroradd").html("");
      }
      if(bname == ''){
      $("#errorbname").html("<div style='color:red'>Please Enter Bank Name</div>");
      $("#bname").focus();
    //  return false;
      }else{
      $("#errorbname").html("");
      }
       if(anum == ''){
      $("#erroranum").html("<div style='color:red'>Please Enter A/C Number</div>");
      $("#anum").focus();
     // return false;
      // }else{
      // $("#erroranum").html("");
      }

     if(icode == ''){
      $("#erroricode").html("<div style='color:red'>Please Enter IFSC Code</div>");
      $("#icode").focus();
      //return false;
      // }else{
      // $("#erroricode").html("");
      }
      if(name == '' || sub == '' || email == '' || pass == '' || cpass == '' || mobile == '' || add == '' || bname == '' || anum == '' || icode == '' || cp == 'Wrong Password! Please Enter Conifrm Password'|| em == 'Email Id Already Exist'
         || mob == 'Mobile Number Already Exist' || mob == 'Mobile Number Not Valid' || acn == 'Please Enter Valid Account Number' || Ifs == 'Please Enter Valid IFSC Code')
       {
        return false;
       }
    });

    function checkpassfirst()
  {
      var pass = $("#pass").val();
      var cpass = $("#cpass").val();

     if(pass != cpass){
      $("#errorcpass").html("<span style='color:red' id='reep'>Wrong Password! Please Enter Conifrm Password</span>");
      $("#pass").focus();
     // return false;
      }else{
      $("#errorcpass").html("");
      }
     
  }

  function checkpass()
  {
      var pass = $("#pass").val();
      var cpass = $("#cpass").val();

     if(pass != cpass){
      $("#errorcpass").html("<span style='color:red' id='reep'>Wrong Password! Please Enter Conifrm Password</span>");
      $("#cpass").focus();
     // return false;
      }else{
      $("#errorcpass").html("");
      }
     
  }



  function checkemail()
  {
    var email = $("#email").val();

     $.ajax({
                    url: "<?php echo site_url();?>Superadmin/checkEmail",
                    method: "POST",
                    data: {'email':email},
                    dataType: "json",
                    success: function(data)
                    {
                     if(data.success == 1){
                    jQuery('#erroremail').html('<span style="color:red;" id="emA">Email Id Already Exist</span>');
                     }else if(data.success == 101){
                    jQuery('#erroremail').html('');   
                    }
                  }
                });
     
  }

   function checkmobile()
  {
    var phone = document.forms["myForm"]["mobile"].value;
	
    var phoneNum = phone.replace(/[^\d]/g, '');
    if(phoneNum.length > 9 && phoneNum.length <= 10) 
    {
    var mobile = $("#mobile").val();

     $.ajax({
                    url: "<?php echo site_url();?>Superadmin/checkMobile",
                    method: "POST",
                    data: {'mobile':mobile},
                    dataType: "json",
                    success: function(data)
                    {
                     if(data.success == 1){
                    jQuery('#errormobile').html('<span style="color:red;" id="moB">Mobile Number Already Exist</span>');
                     }else if(data.success == 101){
                    jQuery('#errormobile').html('');   
                    }
                  }
                });
   }else{
   jQuery('#errormobile').html('<span style="color:red;" id="moB">Mobile Number Not Valid</span>');
   }
     
  }
  /*amobile no*/
    function checkamobile()
  {
    var phone = document.forms["myForm"]["amobile"].value;
	
    var phoneNum = phone.replace(/[^\d]/g, '');
    if(phoneNum.length > 9 && phoneNum.length <= 10) 
    {
    var amobile = $("#amobile").val();
	jQuery('#aerroramobile').html('');
	  
   }else{
   jQuery('#aerroramobile').html('<span style="color:red;" id="moB">Alternet Mobile Number Not Valid</span>');
   }
     
  }
  /*end*/
  /*alternet n*/

  function checkaccountno()
  {
   // alert('ki');
    var acnv = document.forms["myForm"]["anum"].value;
	
    var ac = acnv.replace(/[^\d]/g, '');
    if(ac.length > 13 && ac.length < 17) 
    {
   jQuery("#erroranum").html("");
   }else{
   jQuery('#erroranum').html('<span style="color:red;" id="acn">Please Enter Valid Account Number</span>');
   //return false;
   }  
  }

    function checkifsc()
  {
    var icodeqq = document.forms["myForm"]["icode"].value;
	
    var icode = icodeqq.replace(/[^\d]/g, '');
	
    if(icodeqq.length > 3 && icode.length < 11) 
    {
   jQuery("#erroricode").html("");
   }else{
   jQuery('#erroricode').html('<span style="color:red;" id="ifs">Please Enter Valid IFSC Code</span>');
   }
     
  }

function deletefaculty(id)
 {
	

    var facultyid = id;
	//alert(facultyid);
	//return false;
	if (confirm("Are you sure do you want to delete?"))
	{
        $.ajax({
				url: "<?php echo base_url();?>Superadmin/deleteFaculty",
				method: "POST",
				data: {'facultyid':facultyid},
				dataType: "json",
				success: function(data)
				{ 
	               //alert(data);
				  if(data.success == 1)
				  {
					$("#row_"+facultyid).hide();
					$('#notifyfacultydelete').html('<span class="notifq" style="color:green; font-family: cursive">Faculty Delete Successfully</span>');
					$('.notifq').delay(3200).fadeOut(300);
				 }
				}
        });
    }
 }
 
  /* delete stud */
 function deletestud(id)
 {
	
    var studid = id;
	//alert(studid);
	if (confirm("Are you sure do you want to delete?"))
	{
        $.ajax({
				url: "<?php echo base_url();?>Superadmin/deleteStudent",
				method: "POST",
				data: {'studid':studid},
				dataType: "json",
				success: function(data)
				{ 
	
				  if(data.success == 1)
				  {
					$("#row_"+studid).hide();
					$('#studelt').html('<span class="notifq" style="color:green; font-family: cursive">Faculty Delete Student</span>');
					$('.notifq').delay(3200).fadeOut(300);
					location.reload();
				 }
				}
        });
    }
 }
 
 /* delete lacture vidio */
 function deletelacvidio(id)
 {

    var v_id = id;
	//alert(v_id);
	//return false;
	if (confirm("Are you sure do you want to delete?"))
	{
        $.ajax({
				url: "<?php echo base_url();?>Superadmin/deletelacvidio",
				method: "POST",
				data: {'v_id':v_id},
				dataType: "json",
				success: function(data)
				{ 
	
				  if(data.success == 1)
				  {
					  location.reload();
					  /*alert('hiii working fine');
					  return false;
					$("#row_"+facultyid).hide();
					$('#notifyfacultydelete').html('<span class="notifq" style="color:green; font-family: cursive">Faculty Delete Successfully</span>');
					$('.notifq').delay(3200).fadeOut(300);*/
				 }
				}
        });
    }
 }
 /* end delete lacture vidio */

    function allSubjectlist(){
   $.ajax({
                    url: "<?php echo site_url();?>Superadmin/SubjectArraylist",
                    method: "POST",
                    dataType: "html",
                    success: function(data)
                    {
                    jQuery('div#all_Subject').html(data);
                    }
                    
                });
   
}
	function btnfilterSubject() 
	{
	//  alert('hi');
		var subid = $("#getsubjectdetail").val();;
			$.ajax({
				url: "<?php echo site_url();?>Superadmin/filter_Subject",  
				method: "POST",
				data: {'subid':subid}, 
				success: function(data)
				{ 
				  $(".filterSubject").html(data); 
				}
			});
	}

    function btnfilterSubject_fac() {
    var subid = $("#getsubjectdetail").val();;
     $.ajax({
                  url: "<?php echo site_url();?>Medivarsity_faculty/filter_Subject",  
                    method: "POST",
                    data: {'subid':subid}, 
                    success: function(data){ 
                    $(".filterSubject").html(data); 
                    }
                });
  }

  function btnfilterinvoice() {
    var subid = $("#getsubjectdetail").val();;
     $.ajax({
                  url: "<?php echo site_url();?>Superadmin/filter_Invoice",  
                    method: "POST",
                    data: {'subid':subid}, 
                    success: function(data){ 
                    $(".filterInvoice").html(data); 
                    }
                });
  }

  function vidDelete(){
   $.ajax({
                    url: "<?php echo site_url();?>Superadmin/videoArrList",
                    method: "POST",
                    dataType: "html",
                    success: function(data)
                    {
                    jQuery('div#allvideo').html(data);
                    }
                    
                });
   
}


   function deletesubject(id)
   {
     var subid = id;
   // alert(facultyid);
     $.ajax({
				url: "<?php echo base_url();?>Superadmin/deleteSubject",
				method: "POST",
				data: {'subid':subid},
				dataType: "json",
				success: function(data)
				{ 
				  // alert(data);
				  if(data.success == 1)
				  {
					jQuery('#notifySubjectdelete').html('<span class="notifq" style="color:red;font-family: cursive">Subject Delete Successfully</span>');
					jQuery('.notifq').delay(3200).fadeOut(300);
				  }
				}
            });
    }

    $(".btn-addVideo").click(function(e)
    {
      var video = $("#vurl").val();     
		if(video == '')
		{
		  $("#errorvurl").html("<div style='color:red'>Please Add Url</div>");
		  $("#vurl").focus();
		  return false;
		}else
		{
		  $("#errorvurl").html("");
		}

    });

    function deleteVideo(id)
    {
     var videoid = id;
   // alert(facultyid);
     $.ajax({
                    url: "<?php echo base_url();?>Superadmin/deleteVideo",
                    method: "POST",
                    data: {'videoid':videoid},
                    dataType: "json",
                    success: function(data)
                    { 
                      // alert(data);
                      if(data.success == 1){
                    jQuery('#notifyvideodelete').html('<span class="notifq" style="color:red; font-family: cursive">Video Delete Successfully</span>');
                    jQuery('.notifq').delay(3200).fadeOut(300);
                     }
                    }
                });
 }
 
 /* delete oriant vidio */
    function deleteoriant(id)
    {
		//alert('hii');
     var Orvideoid = id;
	// alert(Orvideoid);
	
     $.ajax({
                    url: "<?php echo base_url();?>Superadmin/deleteoriantVideo",
                    method: "POST",
                    data: {'videoid':Orvideoid},
                    dataType: "json",
                    success: function(data)
                    { 
                      // alert(data);
                      if(data.success == 1){
                    jQuery('#notifyvideodelete').html('<span class="notifq" style="color:red; font-family: cursive">Video Delete Successfully</span>');
                	location.reload();
                     }
                    }
                });
 }
 /* end */

  function addPostfac()
  {
    //alert('hi');
    var subid =  document.getElementById("subid").value;
    var tit = document.getElementById("tit").value;
    var con = document.getElementById("con").value;
    var att = document.getElementById("att").value;

     if(att == ''){
      $("#erroratt").html("<div style='color:red'>Please Enter Attachment</div>");
      $("#att").focus();
     // return false;
      }else{
      $("#erroratt").html("");
      }
      if(con == ''){
      $("#errorcon").html("<div style='color:red'>Please Enter content</div>");
      $("#con").focus();
     // return false;
      }else{
      $("#errorcon").html("");
      }
      if(tit == ''){
      $("#errortit").html("<div style='color:red'>Please Enter Title</div>");
      $("#tit").focus();
      //return false;
      }else{
      $("#errortit").html("");
      }
      if(tit == '' || con == '' || att == '')
      {
      return false;
      }
// //alert(subid);
     $.ajax({
                    url: "<?php echo site_url();?>Faculty/addPost",
                    method: "POST",
                    data: {'subid':subid,'tit':tit,'con':con,'att':att},
                    dataType: "json",
                    success: function(data)
                    {
                     if(data.success == 0){
                     jQuery('#success').html('<span style="color:green; font-family: cursive"  id="emA">Post Added Successfully</span>');
                     jQuery('#emA').delay(4000).fadeOut(300);
                     }
                  }
                });
     
  }

//   function allpost(){
//    $.ajax({
//                     url: "<?php echo site_url();?>Superadmin/postArrayList",
//                     method: "POST",
//                     dataType: "html",
//                     success: function(data)
//                     {
//                     jQuery('div#allpostlist').html(data);
//                     }
                    
//                 });
   
// }
// allpost(); // This will run on page load
// setInterval(function(){
//     allpost() // this will run after every 5 seconds
// }, 2000);


function deletepost(id)
 {
     var postid = id;
    // alert(postid);
     $.ajax({
                    url: "<?php echo base_url();?>Superadmin/deletepost",
                    method: "POST",
                    data: {'postid':postid},
                    dataType: "json",
                    success: function(data)
                    { 
                      // alert(data);
                      if(data.success == 1){
                    jQuery('#notifysuccesspost').html('<span class="notifq" style="color:red;    font-family: cursive">Successfully Delete Referral Code</span>');
                    jQuery('.notifq').delay(3200).fadeOut(300);
                     }
                    }
                });
 }
</script>