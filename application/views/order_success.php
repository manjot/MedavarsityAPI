<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="refresh" content="10;url='<?php echo base_url().'profile'; ?>'>  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title> Medivarsity</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	   /* Everything but the jumbotron gets side spacing for mobile first views */
.header,
.marketing,
.footer {
  padding-right: 15px;
  padding-left: 15px;
}

/* Make the masthead heading the same height as the navigation */
.header h3 {
  margin-top: 0;
  margin-bottom: 0;
  line-height: 40px;
}

.table {
    margin-bottom: 0px;
}

.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}

/* Customize container */
@media (min-width: 768px) {
  .container {
    max-width: 730px;
    background:#ffffff;
  }
}
.container-narrow > hr {
  margin: 30px 0;
      background:#ffffff;
}

.main {
  background:#f1f1f1;
}

/* Supporting marketing content */
.marketing {
  margin: 20px 0 0 0;
}
.marketing p + h4 {
  margin-top: 28px;
}

/* Responsive: Portrait tablets and up */
@media screen and (min-width: 768px) {
  /* Remove the padding we set earlier */
  .header,
  .marketing,
  .footer {
    padding-right: 0;
    padding-left: 0;
  }
  /* Space out the masthead */
  .header {
    margin-bottom: 30px;
  }
  /* Remove the bottom border on the jumbotron for visual effect */
  .jumbotron {
    border-bottom: 0;
  }
}

body {
    padding-top: 0px;
    padding-bottom: 0px;
}

.panel-title {display: inline;font-weight: bold;}
.checkbox.pull-right { margin: 0; }
.pl-ziro { padding-left: 0px; }

.panel {
    border: 0px solid transparent;
    background: #f1f1f1;
}

.panel-default>.panel-heading .badge {
    color: #ffffff;
    background-color: transparent;
}

.container {
    background: #ffffff;
    border-radius:10px;
    margin-top:20px;
    margin-bottom:20px;
}

.panel-heading {
    border-bottom: 0px solid #555555 !important;
}

.panel-default>.panel-heading {
    color: #ffffff;
    background-color: #428bca;
    padding-bottom: 1px !important;
}
	</style>
  </head>

  <body class="main">
    <div class="row" style="background:#fff">
   <br><center><img border="0" src="https://medivarsity.com/assets/Congratulations.png"><br><span style="font-size: 20px;"><strong>Congratulations!</strong> You have successfully subscribed <span style="color:#b498c1;"><?php echo ucfirst($arrCourses['subject_name']); ?></span></span></center><br>
 </div>
    <div class="container">
     
      <div class="row marketing">
      
        <div class="col-lg-12">
          <h4><b><?php echo ucfirst($arrCourses['subject_name']); ?></b></h4>
<hr />

<div>
<center>  
<h4>Success - your order is confirmed!</h4>
<h5>Invoice Number: <?php echo $arrOrders['invoice_no']; ?></h5>
<hr />  
</div>
</center>
        </div>

    <div class="row">
        <div class="col-xs-12">
    		<div class="row">
    			<div class="col-xs-6">
        			<address>
    				<strong>Billing Address:</strong><br>
                        <?php echo $arrOrders['first_name']; ?><br>
                        <?php echo $arrOrders['email']; ?><br>
                        <?php echo $arrOrders['contact_no']; ?><br>
    					<?php echo $arrOrders['address']; ?>
    					
    				</address>

    			</div>
    			<div class="col-xs-6 text-right">
                <!--<h1><span class="glyphicon glyphicon glyphicon-cloud-download" aria-hidden="true"></span></h1>-->
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<center><p><span class="glyphicon glyphicon glyphicon-question-sign" aria-hidden="true"></span> 
                   Your subscription plans heve been activated for one year.</p> </center>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Course Name</strong></td>
            						<td class="text-right"><strong>Subscription Type</strong></td>
            						<td class="text-right"><strong>Price</strong></td>
                                    
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td><?php echo ucfirst($arrCourses['subject_name']); ?></td>
            						
            						<td class="text-right">Yearly</td>
                                    <td class="text-right"><?php echo number_format($arrOrders['net_amount'],2); ?></td>
    							</tr>
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                    <?php
                    if($state == 1 || $state == 5){ ?>
                    <td class="thick-line text-right"><strong>Tax (UTGST (18%))  </strong></td>
                    <td class="thick-line text-right"><?php echo number_format($arrOrders['tax_rate'],2); ?></td>
                   
                   <?php  }else  if($state == 7){ ?>
                      <td class="thick-line text-right"><strong>Tax (SGST (9%) + CGST (9%)  </strong></td>
                    <td class="thick-line text-right"><?php echo number_format($arrOrders['tax_rate'],2); ?></td>
                  <?php  }else{?>
                    <td class="thick-line text-right"><strong>Tax (IGST (18%))  </strong></td>
                    <td class="thick-line text-right"><?php echo number_format($arrOrders['tax_rate'],2); ?></td>
                  <?php  }?>
    							
    							</tr>
    							
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Total</strong></td>
    								<td class="no-line text-right">
									<?php 
									$total=$arrOrders['net_amount']+$arrOrders['tax_rate'];
									echo number_format($total,2); 
									
									?>
									
									</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    		</div>
    	</div>
    </div>
</div>

      </div>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>