<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin');?>
<?php
   //echo"<pre>";
   //print_r($data);
  // die();
    ?>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
   <div class="page-content">
      <h3 class="page-title">
         Add Faculty
         <span style="margin-left: 50px;" class="hideflash">
         <?php if(!empty($this->session->flashdata('add_faculty_sussess'))) { ?>
         <?php print $this->session->flashdata('add_faculty_sussess'); ?>
         <?php }?>
         </span>
      </h3>
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <i class="fa fa-home"></i>
               <a href="<?php echo base_url();?>Superadmin/index">Home</a>
               <i class="fa fa-angle-right"></i>
            </li>
            <li>
               <a href="#">Add Faculty</a>
            </li>
         </ul>
         <div class="page-toolbar">
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="tabbable tabbable-custom tabbable-noborder tabbable-reversed">
               <div class="tab-content">
                  <div class="btn-group">
                     <a href="<?php echo site_url('Superadmin/facultyList')?>">
                     <button  class="btn green">Back</button>
                     </a>
                  </div>
                  <br><br>
                  <div class="tab-pane active" id="tab_0">
                     <div class="portlet box yellow">
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="fa fa-gift"></i>Add Faculty
                           </div>
                        </div>
                        <div class="portlet-body form">
                           <!-- BEGIN FORM-->
                           <form action="<?php echo site_url('Superadmin/addFaculty')?>" method="post" class="form-horizontal" name="myForm" enctype="multipart/form-data">
                              <input type="hidden" name="facultyId" id="facultyId" value="<?php echo $result['id']; ?>">
                              <div class="form-body">
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Full Name:</label>
                                    <div class="col-md-4">
                                       <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" value="<?php echo $result['name'];  ?>">
                                    </div>
                                    <span id="errorname"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Subject <?php echo $result['subject_id'];  ?></label>
                                    <div class="col-md-4">
                                       <!-- <input type="text" class="form-control" placeholder="Enter Subject" id="sub" name="sub"> -->
                                       <select class="form-control" id="sub" name="sub">
                                          <?php if($result['id']){ ?>
                                          <option value="<?php echo $result['subject_id']; ?>" selected><?php echo $result['subject_name']; ?></option>
                                          <?php } ?>
                                          <option value="">Select...</option>
                                          <?php foreach($data as $value) {
                                             ?>
                                          <option value="<?php echo $value['id'];?>" >
                                             <?php echo $value['subject_name'];?>
                                          </option>
                                          <?php }?>
                                       </select>
                                    </div>
                                    <span id="errorsub"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Email Address:</label>
                                    <div class="col-md-4">
                                       <div class="input-group">
                                          <span class="input-group-addon">
                                          <i class="fa fa-envelope"></i>
                                          </span>
                                          <input type="email" class="form-control" placeholder="Email Address" id="email" name="email" <?php if(empty($result['id'])){ echo 
                                             'onkeyup="checkemail();"'; }?> value="<?php echo $result['email']; ?>">
                                       </div>
                                    </div>
                                    <span id="erroremail"></span>
                                 </div>
                                 <?php if(empty($result['id'])){?>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Password:</label>
                                    <div class="col-md-4">
                                       <div class="input-group">
                                          <input type="password" <?php if(empty($result['id'])){ echo 
                                             'onkeyup="checkpassfirst()"'; }?> class="form-control" placeholder="Password" id="pass" name="pass">
                                          <span class="input-group-addon">
                                          <i class="fa fa-user"></i>
                                          </span>
                                       </div>
                                    </div>
                                    <span id="errorpass"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Re-Enter Password:</label>
                                    <div class="col-md-4">
                                       <div class="input-group">
                                          <input type="password" <?php if(empty($result['id'])){ echo 
                                             'onkeyup="checkpass()"'; }?> class="form-control" placeholder="Re-Enter Password" id="cpass" name="cpass">
                                          <span class="input-group-addon">
                                          <i class="fa fa-user"></i>
                                          </span>
                                       </div>
                                    </div>
                                    <span id="errorcpass"></span>
                                 </div>
                                 <?php }?>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Phone No:</label>
                                    <div class="col-md-4">
                                       <div class="input">
                                          <input type="number" class="form-control" placeholder="Phone No." id="mobile" name="mobile"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                             type = "number"
                                             maxlength = "12" onkeyup="checkmobile();" value="<?php echo $result['contact_no']; ?>">
                                       </div>
                                    </div>
                                    <span id="errormobile"></span>
                                 </div>
                                 <?php if(empty($result['id'])){?>	
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Alternate Phone No:</label>
                                   <!-- <div class="col-md-4">
                                       <div class="input">
                                          <input type="text" class="form-control" placeholder=" Alternate Phone No." id="amobile" name="amobile" maxlength="12" minlength="10">
                                       </div>
                                    </div>-->
									
									  <div class="col-md-4">
                                       <div class="input">
                                          <input type="number" class="form-control" placeholder="Phone No." id="amobile" name="amobile"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                             type = "number"
                                             maxlength = "12" onkeyup="checkamobile();" value="<?php echo $result['contact_no']; ?>">
                                       </div>
                                    </div>
									 <span id="aerroramobile"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Date Of Birth</label>
                                    <div class="col-md-4">
                                       <div class="input">
                                          <input type="date" class="form-control" placeholder="Enter Date Of Birth" id="bday" name="bday">
                                       </div>
                                    </div>
                                    <span id="errorbday"></span>
                                 </div>
                                 <?php } ?>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Address:</label>
                                    <div class="col-md-4">
                                       <div class="input-icon right">
                                          <textarea type="text" class="form-control" placeholder="Address..." id="add" name="add" style=" resize: none;"><?php echo $result['address']; ?></textarea>
                                       </div>
                                    </div>
                                    <span id="erroradd"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">About The Subject:</label>
                                    <div class="col-md-4">
                                       <div class="input-icon right">
                                          <textarea type="text" class="form-control" placeholder="About The Subject" id="asub" name="asub" style=" resize: none;"><?php echo $result['about']; ?></textarea>
                                       </div>
                                    </div>
                                    <div id="errorasub"></div>
                                 </div>
                                 <div class="form-group">
                                    <input type="hidden" name="image_name" value="<?php echo $result['image']; ?>"> 
                                    <label class="col-md-3 control-label">Faculty Image:</label>
                                    <div class="col-md-4">
                                       <div class="input-append">
                                          <?php echo form_upload(array('name'=>'image'));?>
                                       </div>
                                       <br>
                                       <?php if($result['id'] && $result['image'] != ''):?>
                                       <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url('assets/images/faculty/'.$result['image']);?>" alt="current" width="100" height="100" /></div>
                                       <?php endif;?>
                                    </div>
                                    <div id="errorasub"></div>
                                 </div>
                                 <!-- <div class="form-group">
                                    <label class="col-md-3 control-label">Video URL :</label>
                                    <div class="col-md-4">
                                    
                                    <div class="field_wrapper">
                                                                             <div>
                                      
                                                                             <input type="text" class="form-control" name="field_name[]" value="" style="width:90%" id="vurl" />
                                      <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus"></i>
                                    </a>
                                    
                                                                             </div>
                                                                          </div>
                                                                         </div>
                                     </div> -->
                              </div>
                              <div class="form-actions fluid">
                                 <center>
                                    <h2><strong>Bank Details</strong></h2>
                                 </center>
                                 <br><br>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Bank Name:</label>
                                    <div class="col-md-4">
                                       <div class="input">
                                          <input type="text" class="form-control" placeholder="Bank Name" id="bname" name="bname" value="<?php echo $result['bank_name']; ?>">
                                       </div>
                                    </div>
                                    <span id="errorbname"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Account Number:</label>
                                    <div class="col-md-4">
<div class="input-icon right">
  <input type="number" onkeyup="checkaccountno();" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
	 type = "number" maxlength = "16" onkeyup="checkmobile();" class="form-control" placeholder="Account Number" id="anum" name="anum" value="<?php echo $result['account_no']; ?>">
</div>
                                    </div>
                                    <span id="erroranum"></span>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">IFSC Code:</label>
                                    <div class="col-md-4">
                                       <div class="input-icon right">
                                          <input type="text" onkeyup="checkifsc();" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                             type = "number" maxlength = "11" onkeyup="checkmobile();" class="form-control" placeholder="IFSC Code" id="icode" name="icode" value="<?php echo $result['ifsc_code']; ?>">
                                       </div>
                                    </div>
                                    <span id="erroricode"></span>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                       <button type="submit" class="btn green btn-addfaculty">Submit</button>
                                       <a href="<?php echo base_url().'Superadmin/facultyList'; ?>" class="btn red">Cancel</a>
                                    </div>
                                 </div>
                              </div>
                           </form>
                           <!-- END FORM-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END PAGE CONTENT-->
</div>
</div>
<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
<!--Cooming Soon...-->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- END FOOTER -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
   jQuery(document).ready(function() {    
      // initiate layout and plugins
      Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   Demo.init(); // init demo features
      FormSamples.init();
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
       var maxField = 20; //Input fields increment limitation
       var addButton = $('.add_button'); //Add button selector
       var wrapper = $('.field_wrapper'); //Input field wrapper
       var fieldHTML = '<br><div><input type="text" class="form-control" name="field_name[]" value="" style="width:90%"/><a href="javascript:void(0);" class="remove_button"><i class="fa fa-trash"></i></a></div>'; //New input field html 
       var x = 1; //Initial field counter is 1
       
   	
   	
   	
       //Once add button is clicked
       $(addButton).click(function(){
           //Check maximum number of input fields
           if(x < maxField){ 
               x++; //Increment field counter
               $(wrapper).append(fieldHTML); //Add field html
           }
       });
       
       //Once remove button is clicked
       $(wrapper).on('click', '.remove_button', function(e){
           e.preventDefault();
           $(this).parent('div').remove(); //Remove field html
           x--; //Decrement field counter
       });
   });
</script>
<script>
   var timeout = 6000; // in miliseconds (3*1000)
   $('.hideflash').delay(timeout).fadeOut(300);
</script>
<!-- END JAVASCRIPTS -->
<?php  $this->load->view('includes/footer');?>