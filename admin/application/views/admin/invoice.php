<?php $this->load->view('includes/headeradmin');?>
<?php $this->load->view('includes/sidebaradmin')?>


		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				
				<h3 class="page-title">
				Invoice</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo base_url();?>Superadmin/index">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo base_url();?>Superadmin/invoice">Invoice</a>
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
								<!----
									<div class="row">
										<div class="col-md-12">
											<div class="btn-group">
											<a href="<?php echo site_url('Medi_varsity/index');?>">
												<button  class="btn green">
												Back 
												</button></a>
											</div>
											
											<div class="table-actions-wrapper btn-group">
										
										<select id="getsubjectdetail" class="table-group-action-input form-control input-inline input-small input-sm btn-group">
											<option value="111">All</option>
											<?php foreach($result['getsubjectdetail'] as $value) {?>
										   <option value="<?php echo $value['id'];?>">
										   	<?php echo $value['subject_name'];?>
										   </option>
										    <?php }?>
										</select>
				<a href="javascript:void(0)" onclick="btnfilterinvoice();" class="btn btn-sm yellow table-group-action-submit btn-group"><i class="fa fa-check"></i> Submit</a>
									</div>       
											<br><br>
											
									</div>
								</div> -->
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
									<!-- <th>
										 Product Name
									</th> -->
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
										  Payable Total
									</th>
									<th>
										Taxable Amount
									</th>
									<th>
										 Gross Total
									</th>
								<!-- 	<th>
										 IGST
									</th> -->
									<th>
										 CGST
									</th>
									<th>
										SGST
									</th>
									<!--<th>
										 Delete
									</th>-->
									<th>
										 Print Out
									</th>
								</tr>
								</thead>
								<tbody>
									<?php $iny=111; foreach ($data['empInfo'] as  $value) {
                                     	 $date= $value['data_added'];
										 
										 $newformat = date('d-m-Y',$date);

										?>
								<tr>
									<td>
									<?php echo $newformat;?>
									</td>
									<td>
										 <a href="#">	<?php echo $value['invoice_no'];?></a>
									</td>
									<!-- <td>
										  <a href="#">	<?php echo $value['data_added'];?></a>
									</td> -->
									<td>
											<?php echo $value['name'];?>
									</td>
									<td>
										<a href="#">	<?php echo $value['order_id'];?></a>
									</td>

									<td>
											<?php echo $value['first_name'];?><?php echo $value['last_name'];?>
									</td>
									<td>
										 	<?php echo $value['address'];?>
									</td>
									<td class="center">
										 	<?php $netamt = $value['net_amount'];
                                             echo $netamt;
										 	?>
									</td>
									<td>
							<?php $cqgst = (($value['tax_rate'])); 
                                              echo $cqgst;?>
									</td>
									<td class="center">
										 	<?php $totalamt = $value['net_amount'] + $value['tax_rate'];
                                             echo $totalamt;
										 	?>
									</td>
									<td>
										 	<?php $cgst = ($value['tax_rate'])/2; 
                                              echo $cgst;?>
									</td>
									<td>
										<?php $cgst = ($value['tax_rate'])/2; 
                                              echo $cgst;
										 	?>
									</td>
									
									
									<!-- <td>
											<?php echo $value['data_added'];?>
									</td> -->
									<!--<td>
										<a class="delete" href="">
										Delete </a>
									</td>-->
									<td>
									<div class="btn-group">
											<a href="<?php echo site_url('Superadmin/createXLS/'.$iny);?>">
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
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->

<?php  $this->load->view('includes/footer');?>