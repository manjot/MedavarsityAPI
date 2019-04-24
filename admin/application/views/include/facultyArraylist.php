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
											 Join Date
										</th>
										<th width="15%">
											 Full Name
										</th>
										<th width="10%">
											 No. Of Students
										</th>
										<th width="10%">
											 Avarage Rating
										</th>
									
										<th width="10%">
											Video
										</th>
										<th width="10%">
											 Delete
										</th>
									</tr>
									<tr>
									<?php if(!empty($getfacultydetail)) {?>
									<?php $i=1; foreach($getfacultydetail as $value) {?>	
										<th width="5%">
											<?php echo $i++; ?>
										</th>
										<th width="15%">
											<?php 
                                        echo date("d/m/Y",strtotime($value['time_stamp']));?>
										</th>
										<th width="15%">
										<a href="<?php echo base_url('Medi_varsity/facultyDetail/'.$value['user_id'])?>">
											<?php echo $value['name']; ?>
										</a>
										</th>
										<th width="10%">
											 <a href="<?php echo base_url('Medi_varsity/StudentDetail/'.$value['user_id'])?>"><?php echo $value['num_students']; ?></a>
										</th>
										<th width="10%">
											 9/10
										</th>
									
										<th width="10%">
											<div class="btn-group">
		<a href="<?php echo base_url('Medi_varsity/addVideo/'.$value['user_id'])?>" class="add_button" title="Add field"><i class="fa fa-plus"></i>
											</a>
											<!-- <a href="#">
												<button  class="btn green">
												View 
												</button></a> -->
											</div>
										</th>
										<th width="10%">
											 <div class="btn-group">

<a class="btn btn-danger" style="height:30px;" 
onclick="doConfirm('Are you sure?', function yes() {
	deletefaculty(<?php echo $value['user_id']?>);}, function no() { //alert('no')
	 });">Delete</a>

											</div>
											</th>
											</tr>
									<?php }?>
									<?php } ?>
									</thead>
									<tbody>
									</tbody>
									</table>