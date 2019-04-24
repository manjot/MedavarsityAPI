<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>
		<!-- BEGIN CONTENT -->
<style type="">
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  font: -webkit-control;
}
.checkmark {
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #0000;
  border-radius: 50%;
}
.container:hover input ~ .checkmark {
  background-color: #ccc;
}
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}
</style>
<div class="page-content-wrapper">
<div class="page-content">
<h3 class="page-title">
DashBoard <?php if(!empty($this->session->flashdata('url_sussess'))) { ?>
<?php print $this->session->flashdata('url_sussess'); ?>
 <?php }?></h3>
<div class="page-bar">
<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Medivarsity_faculty');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							Add Test
						</li>
</ul>
</div>
				
				<div class="row">
					<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="<?php echo site_url('Faculty/addtestPage');?>" method="post" enctype="multipart/form-data">
<div class="portlet light">
<div class="portlet-title">
	<div class="caption">
		<i class="icon-check font-green-sharp"></i>
		<span class="caption-subject font-green-sharp bold uppercase">
		Test <?php echo $result['getLectureVideo']->video_title;?></span>
		<input type="hidden" value="<?php echo $result['getLectureVideo']->id;?>" name="id">
		<input type="hidden" value="<?php echo $result['getLectureVideo']->subject_id;?>" name="subid">
		<input type="hidden" value="<?php echo $result['getLectureVideo']->video_title;?>" name="vidtitle">
		<input type="hidden" name="input_num" id="input_num">
	</div>
	<div class="actions btn-set">
<a href="<?php echo site_url('Medivarsity_faculty/testList/'.$result['getLectureVideo']->id)?>"><button type="button" name="back" class="btn btn-default btn-circle"><i class="fa fa-angle-left"></i> Back</button></a>
		<button class="btn green-haze btn-circle btn-addtest" value="upload" name="upload" type="submit"><i class="fa fa-check-circle"></i> Save & Continue</button>
	</div>
</div>
								
								
 <div class="form-group">
 <label class="col-md-2 control-label">Question:</label>
  <div class="col-md-10">
  <textarea class="form-control" name="question" id="question"></textarea>
  <span id="errorquestion"></span>
 </div>
 </div>
													
<div class="portlet-body">
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active">
		
			<a href="#tab_general" data-toggle="tab">
			Text </a>
		</li>
		<li>
			<a href="#tab_images" data-toggle="tab">
			Images </a>
		</li>
	</ul>
    </div>
<div class="tab-content no-space">
																		
<div class="tab-pane active" id="tab_general">
<h4 style="padding-left:14px;">Add Options</h4>	
<div class="form-body">
<div class="form-group">
    <div class="col-md-8">	
	<input type="radio" class="checkmark" name="radiotxt" id="radiotxt" value="1" checked>
	<div class="col-md-6">
    <input class="form-control" name="option[]" id="option1"/>
    <span id="erroroption1"></span>
	</div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-8">
	<input type="radio" class="checkmark" name="radiotxt" id="radiotxt" value="2" >
	<div class="col-md-6">
	<input class="form-control" name="option[]" id="option2"/>
	<span id="erroroption2"></span>
	</div>
	</div>

<div class="col-md-2">           
            <button type="button" class="btn btn-warning" name="addtextbox" id="addtextbox"><i class="fa fa-plus"></i></button>
            </div>
</div>
<div class="col-md-12">
<div id="dynamictext"></div>
</div>
	<span style="padding-left: 14px;font-size: 14px;color:red;"><em>* Please select the radio button in front of correct answer</em></span>												
	
												</div>
											</div>

<div class="tab-pane" id="tab_images">
<h4 style="padding-left:14px;">Add Image Options</h4>	
<div class="form-body">
<div class="form-group">
<div class="col-md-10">
<div class="col-md-3">
<img id="blah1" class="img-circle" style="width:100px; height:100px;"  src="" alt=""/>
</div>
<div class="col-md-3">
<input type="file" accept="image/*" id="imgInp1" onChange="myfunction(imgInp1,1)" name="files[]" />
<span id="errorimage1"></span>
</div>
<div class="col-md-2 checkbox">
<input type="radio" class="checkmark" name="radioimg" id="radioimg" value="1" checked/>
</div>
</div>
</div>
<div class="form-group">
<div class="col-md-10">
<div class="col-md-3">
<img id="blah2" accept="image/*" class="img-circle" style="width:100px; height:100px;" src="" alt="" />
</div>
<div class="col-md-3">
<input type='file' id="imgInp2" name="files[]" onChange="myfunction(imgInp2,2)"  >
<span id="errorimage2"></span>
</div>
<div class="col-md-2 checkbox">
<input type="radio" class="checkmark" name="radioimg" id="radioimg" value="2" /></div>
<div class="col-md-2">           
<button type="button" class="btn btn-warning" name="add" id="addmore_btn"><i class="fa fa-plus"></i></button>
</div>
</div>
</div>
<div class="col-md-12">                                          
<div id="dynamictasks"></div>
<span style="padding-left:14px;font-size:14px;color:red;"><em>Please select the radio button in front of correct answer</em></span>	
</div>
</div>
</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
		
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="page-footer">
		<div class="page-footer-inner">
			 2019 &copy; Medivarsity.
		</div>
		<div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		</div>
	</div>
	<!-- END FOOTER -->
</div>

<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>

<script>
var seq=0;
function myFunction() {
seq=seq+1;
    document.getElementById("demo").value = seq;
}
</script>

<script>
$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<div class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" />" +
            "<br><div class=\"remove\">Delete</div>" +
            "</div>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>

<script>


 function showMyImage(fileInput) {
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById("thumbnil");            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }    
    }

</script>

<script>
function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>
<script type="text/javascript">
         $(document).ready(function(){
 var i=2;



 $('#addmore_btn').click(function(){

 i++;
 
 $('#dynamictasks').append('<div id="row'+i+'" class="row"><div class="form-group"><div class="col-md-10"><div class="col-md-3"><img id="blah'+i+'" class="img-circle" style="width:100px; height:100px;" src="" alt="" /></div><div class="col-md-3"><input type="file" accept="image/*" id="imgInp'+i+'" name="files[]" onChange="myfunction(imgInp'+i+','+i+')"  ></div><span id="errorimage2"></span><div class="col-md-2 checkbox"><input type="radio" class="checkmark" name="radioimg" id="radioimg" value="'+i+'" /></div><div class="col-md-2"><button type="button" name="add" class="btn_remove  btn btn-danger" id="'+i+'"><i class="fa fa-close"></i></button></div></div></div></div>');
 

 });

 $(document).on('click', '.btn_remove', function(){
 var button_id = $(this).attr("id");
 $('#row'+button_id+'').remove();
 });

 
 
});

    function myfunction(input,id){       
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#blah'+id).attr('src', e.target.result);
    }
   reader.readAsDataURL(input.files[0]);
  }         
};


      </script> 
<script type="text/javascript">
	function radiocheck()
	{
		// alert('hi');
		// $( "#radiot" ).prop( "checked", false );
 
 $("input:radio[name='radiot']").each(function(i) {
       this.checked = false;
});
// // Uncheck #x
// $( "#x" ).prop( "checked", false );
	}
</script>
	<script>
function check() {
  document.getElementById("checkbox1").checked = false;
  document.getElementById("checkbox2").checked = false;
  document.getElementById("checkbox3").checked = true;
 // alert('ff');
}
</script>
      <script type="text/javascript">
         $(document).ready(function(){
 var i=2;

 $(document).on("click","#addtextbox",function() {
 i++;
 $('#dynamictext').append('<div id="row'+i+'" class="row"><div class="form-group"><div class="col-md-8"><input type="radio" class="checkmark" name="radiotxt" id="radiotxt" value="'+i+'"><div class="col-md-6"><input class="form-control" name="option[]" id="option'+i+'"/></div></div><div class="col-md-2"><button type="button" name="add" class="btn_remove  btn btn-danger" id="'+i+'"><i class="fa fa-close"></i></button></div></div></div>');
 

 });

 $(document).on('click', '.btn_remove', function(){
 var button_id = $(this).attr("id");
 $('#row'+button_id+'').remove();
 });

 
 
});


      </script> 
<script type="text/javascript">
	
   $(".btn-addtest").click(function(e){

     // alert('hi');
      var question = $("#question").val();
      var option1 = $("#option1").val();
      var option2 = $("#option2").val();

      var image1 = $("#imgInp1").val();
      var image2 = $("#imgInp2").val();

      //var radioimg = $("#radioimg").val();
     // var selected = $("#checkout").find("input[type='radio']");
     // alert(selected);

     if(question == ''){
      $("#errorquestion").html("<div style='color:red'>Please Fill Question</div>");
     // return false;
      }else{
      $("#errorquestion").html("");
      }
     if(option1 == ''){
      $("#erroroption1").html("<div style='color:red'>Please Fill option1</div>");
    //  return false;
      }else{
      $("#erroroption1").html("");
      }
      if(option2 == ''){
      $("#erroroption2").html("<div style='color:red'>Please Fill option2</div>");
    //  return false;
      }else{
      $("#erroroption2").html("");
      }
     
      if(image2 == ''){
      $("#errorimage2").html("<div style='color:red; margin-top: 40px;'>Please Upload Image2</div>");
    //  return false;
      }else{
      $("#errorimage2").html("");
      }
      if(image1 == ''){
      $("#errorimage1").html("<div style='color:red;margin-top: 40px;'>Please Upload Image1</div>");
    //  return false;
      }else{
      $("#errorimage1").html("");
      }

      if(question == '' || option1 == '' || option2 == '' || 
      	$('input[name=radiotxt]:checked').length <= 0)
      {
      if(question == '' || image1 == '' || image2 == '' || 
      	$('input[name=radioimg]:checked').length <= 0)
      {
      	return false;
      }
      else{
      var option1 = $("#option1").val('');
      var option2 = $("#option2").val('');
      document.getElementById("input_num").value = 1;
      }
      }
      else{
            var image1 = $("#imgInp1").val('');
      var image2 = $("#imgInp2").val('');
      document.getElementById("input_num").value = 0;
      }//exit();

    });
</script>

<script>
var timeout = 6000; // in miliseconds (3*1000)
$('.hideflash').delay(timeout).fadeOut(300);
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>