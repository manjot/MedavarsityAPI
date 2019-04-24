<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>


		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				
				<h3 class="page-title">
				Dashboard</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url('Faculty');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a>invoice</a>
						</li>
					</ul>
					<div class="page-toolbar">
						
					</div>
				</div>
				<!-- END PAGE HEADER-->

				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-edit"></i>Invoice
								</div>
								
							</div>
							<div class="portlet-body">
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-12">
							                      
									</div>
								</div>
								<div class="filterInvoice">
								<table class="table table-striped table-hover table-bordered">
								<thead>
								<tr>
									<th>
										 Date
									</th>
									<th>
										 Invoice No.
									</th>
									<th>
										 Faculty Name
									</th>
									<th>
										 Order No.
									</th>
									<th>
										Student Name
									</th>
									<th>
										Address Of Student
									</th>
									<th>
										 Gross Total
									</th>
									<th>
										Taxable Amount
									</th>
									<th>
										 CGST
									</th>
									<th>
										SGST
									</th>
									<th>
										 Print Out
									</th>
								</tr>
								</thead>
								<tbody>
									<?php  foreach ($data['empInfo'] as  $value) { ?>
								<tr>
									<td>
										<?php echo $value['data_added'];?>
									</td>
									<td>
										<?php echo $value['invoice_no'];?>
									</td>
									<td>	<?php echo $value['name'];?>
									</td>
									<td>
										<?php echo $value['order_id'];?>
									</td>

									<td>
										 	<?php echo $value['first_name'];?><?php echo $value['last_name'];?>
									</td>
									<td>
										 	<?php 
                                            if(!empty($value['address']) && $value['address'] != 0){
                                            $address = $value['address'];
                                            }else{
                                            $address = '';	
                                            }
										 	echo $address;?>
									</td>
									<td class="center">
										 	<?php $netamt = $value['net_amount']-$value['tax_rate'];
                                             echo $netamt;
										 	?>
									</td>
									<td>
							<?php $cqgst = (($value['net_amount']*9)/100)+(($value['net_amount']*9)/100); 
                                              echo $cqgst;?>
									</td>
									<td>
										 	<?php $cgst = ($value['net_amount']*9)/100; 
                                              echo $cgst;?>
									</td>
									<td>
										<?php $cgst = ($value['net_amount']*9)/100; 
                                              echo $cgst;
										 	?>
									</td>
									
									<td>
									<div class="btn-group">
											<a href="<?php echo site_url('Faculty/createXLS/'.$value['student_id']);?>">
												<button  class="btn green">
												Print 
												</button></a>
											</div>
									
										
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
	</div>
	</div>
<?php $this->load->view('includes/footer');?>