<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content" style="width: 1348px;">
			
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Students</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Superadmin/index')?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo site_url('Superadmin/studentList')?>">All Students</a>
						</li>
						<span id="studelt"></span>
					</ul>
					<div class="page-toolbar">
						
						<!--</div>-->
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						
						<!-- Begin: life time stats -->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-users font-green-sharp"></i>
									<span class="caption-subject font-green-sharp bold uppercase">Student Listing</span>
									<!--<span class="caption-helper">manage orders...</span>-->
								</div>
								<div class="actions">
									
								</div>
							</div>
							<div class="portlet-body">
							                 <!--   <div class="btn-group">
											    <a href="<?php echo site_url();?>Medi_varsity/index">
												<button  class="btn green">
												Back
												</button>
												</a>
											</div> -->
							        <div class="table-actions-wrapper btn-group">
										
										<select id="getsubjectdetail" onchange="btnfilterSubject();" class="table-group-action-input form-control input-inline input-small input-sm btn-group">
											<option value="111">All</option>
											<option value="112">Unsubscribed students</option>
											<?php foreach($result['getsubjectdetail'] as $value) {?>
										   <option value="<?php echo $value['id'];?>">
										   	<?php echo $value['subject_name'];?>
										   </option>
										    <?php }?>
										</select>
	<!--	<a href="javascript:void(0)" onclick="btnfilterSubject();" class="btn btn-sm yellow table-group-action-submit btn-group">
	<i class="fa fa-check"></i> Submit</a> -->
									<button onclick="exportTableToCSV('members.csv')" class="btn btn-info" style="padding:4px 12px 4px 12px;margin-left:20px;">Export</button></a>
								    </div>
     
											<br><br>
											
											
								<div class="table-container filterSubject">

									<table class="table table-striped table-bordered table-hover" >
									<thead>
									<tr role="row" class="heading">
										<!--<th width="2%">
											<input type="checkbox" class="group-checkable">
										</th>-->
										<th width="5%">
											 Sr.No.
										</th>
										
										<th width="15%">
											 Full Name
										</th>
										<th width="15%">
											 Faculty Name
										</th>
											<th width="15%">
											 Remaining Hours
										</th>
										<th width="15%">
											 Subject
										</th>
										<th width="15%">
											 Year Of MBBS
										</th>
										<th width="15%">
											 College Of MBBS
										</th>
										<th width="15%">
											 Phone Number
										</th>
										<th width="15%">
											 Address
										</th>
										<th width="15%">
											 Email
										</th>
										<th width="20%">
											 Join Date
										</th>
									
										<th width="10%">
											Action
										</th>
										
									</tr>
							<?php $i=1; foreach($result['getstudentdetail'] as $value) {
								
							      $colid=$value['college_id'];
								  $result = $this->All_model->getcol($colid);
						        
								
								?>
									<tr>
										<th width="5%">
											 <?php echo $i++;?>
										</th>
										<th width="15%"><a href="<?php echo base_url('Superadmin/StudentWiseDetail/'.$value['student_id'])?>">
											  <?php echo $value['name'];?>
							             </a>
										</th>
										<th width="15%">
											<a href="<?php echo base_url('Superadmin/facultyDetail/'.$value['faculty_id'])?>"><?php echo $value['faculty_name'];?></a>
										</th>
										<th width="10%">
											 <?php if(!empty($value['hours_remaining']))
											 {echo $value['hours_remaining'];}
											 else{ 
											 
											 	 }?>
										</th>
										<th width="10%">
											 <?php echo $value['subject_name'];?>
										</th>
										<th width="10%">
											 <?php echo $value['mbbs_year'];?>
										</th>
										<th width="10%">
											<?php echo $result[0]->college_name;?>
										</th>
										<th width="10%">
											 <?php echo $value['contact_no'];?> 
										</th>

										<th width="10%">
											<?php if(!empty($value['address'])){
											 echo $value['address']; }else {
                                             echo "No";
											 	}?> 
										</th>

										<th width="10%">
											<?php echo $value['email'];?>
										</th>
									
										<th width="10%">

										<?php echo date('d/m/Y', $value['created_date']);?>
										</th>	
										
										<th width="10%">
                                           <a class="btn btn-danger" style="height:30px;" onclick="deletestud(<?php echo $value['student_id']; ?>);">Delete</a>
										</th>	
									</tr>
									<?php }?>
									</thead>
									<tbody>
									</tbody>
									</table>
							</div>
							</div>
						</div>
						<!-- End: life time stats -->
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

<script type="text/javascript">
 function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}   
</script>



	<!-- BEGIN FOOTER -->
<?php $this->load->view('includes/footeradmin');?>