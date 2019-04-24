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
											 Subject
										</th>
										<th width="15%">
											 Faculty Name
										</th>
										
										<th width="10%">
											 Delete
										</th>
									</tr>

							<?php 
                            if(!empty($getAllsubject))
                            {
							$i=1; foreach($getAllsubject as $value) {?>
									<tr>
										<th width="5%">
											 <?php echo $i++;?>
										</th>
										<th width="15%">
											 
											 <?php echo $value['subject_name'];?>
										</th>
										<?php if($value['name'] == '') {?>
                                        <th width="15%">
											None
										</th>
										<?php } else {?>
										<th width="15%">
											<?php echo $value['name'];?>
										</th>
									<?php }?>
										<th width="10%">
											 <div class="btn-group">
   <!-- <a class="btn btn-success" style="height:30px;" onclick="deletesubject(<?php echo $value['id']?>);">Delete</a> -->
   <a class="btn btn-success" href="<?php echo site_url('Medi_varsity/editSubject/'.$value['id'])?>" style="height:30px;">Edit</a>
											</div>
											</th>
									
									</tr>
								<?php } }?>
								
									</thead>
									<tbody>
									</tbody>
									</table>