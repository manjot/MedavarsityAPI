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
											 Faculty name
										</th>
										<th width="15%">
											 Video
										</th>
										<th width="10%">
											 Delete
										</th>
										<th width="10%">
											 Edit
										</th>
										
										
									</tr>
						        <?php
                                 if(!empty($facultyVideoList))
                                 {
						         $i=1; foreach ($facultyVideoList as $value) {
						         ?>
									<tr>
									    <th width="3%">
									<?php echo $i++; ?>
										</th>
										<th width="5%">
									
									<?php echo $value['name']; ?>
										</th>
										<th width="15%">
									<?php echo $value['video_url']; ?>
										</th>
										<th width="15%">

	<a class=" " style="height:30px; color: red" onclick="doConfirm('Are you sure?', function yes() {
	deleteVideo(<?php echo $value['id']?>);}, function no() { //alert('no')
	 });""><i class="fa fa-trash"></i></a>

										</th>
										<th width="15%">
									<a class="btn btn-success" href="<?php echo site_url('Medi_varsity/editVideo/'.$value['id'])?>" style="height:30px;">Edit</a>
										</th>
									</tr>
								<?php }?>
							<?php } else {
								echo "No Video Found";
							 }?>
									</thead>
									<tbody>
									</tbody>
									</table>