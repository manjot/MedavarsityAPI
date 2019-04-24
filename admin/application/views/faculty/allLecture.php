<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo base_url('Medivarsity_faculty/index');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a>All Lectures</a>
						</li>
					</ul>
					<div class="page-toolbar">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-edit"></i>List Of Lectures
								</div>
							</div>
							<div class="portlet-body">
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-12">
											<div class="btn-group pull-right">
											
											</div>
										</div>
										
									</div>
								</div>
								<table class="table table-striped table-hover table-bordered">
								<thead>
								<tr>
								    <th>
										 Sr. No.
									</th>
									<th>
										 Uploaded On
									</th>
									
									<!-- <th>
										 Subject Name
									</th> -->
									<th>
										Subject Name
									</th>
									
									<th>
										Video Link
									</th>
									
									<th>
										 Test
									</th>
								</tr>
								</thead>
								<tbody>
						<?php $i=1; foreach ($result['allLecture_fac'] as $value) { ?>
								<tr>
									<td>
										<?php echo $i++;?>
									</td>
									<td>
										<?php echo $value['date']?>
									</td>
									 <td>
										<?php echo $value['subject_name']?>
									</td> 
									<!--<td class="center">
										 <?php 
                                        /* if(!empty($value['video_title'])){
										 $title =  $value['video_title'];
										 }else{
                                         $title = '';
										 }
                                         echo $title;*/
										  ?>
									</td>-->
									
									<td>
								<a href="<?php echo $value['video_url']?>" target="_blank"><?php echo $value['video_url']?></a>
									</td>
									<td>
						<a href="<?php echo base_url('Faculty/testquestions/'.$value['id'])?>" title="Test for the Lecture"><i class="fa fa-check" aria-hidden="true"></i> Test
											</a>
									</td>
								</tr>
								<?php }?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			</div>
	
<?php $this->load->view('includes/footer');?>