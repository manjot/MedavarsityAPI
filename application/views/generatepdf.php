<?php 
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
     $html1='<!DOCTYPE>
<html xmlns>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PO</title>
<style>@media only print {
*, *:before, *:after {
  -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;
}
} 

@import url("https://fonts.googleapis.com/css?family=Lato");

table, th, td {border:0.1mm solid black; border-collapse:collapse;font-size:3.8mm;vertical-align: middle;}
body{
  
font-family: "Lato", sans-serif;
}

</style>
</head>

<body>

<div style="width:90%;padding:0mm 0mm 0mm 0mm;">
<div style="text-align:center;">

</h5>

</div>
<div>';

                              
$html1.='
<div>
<table style="width:110%;table-layout:fixed;text-align:center">
      <tr style="background-color:lightgrey">
      <th style="width:4%;text-align:center;">S.no.</th>
      <th style="width:20%;"><strong>Item</strong></th>
      <th style="width:15%;"><strong>Brand Name</strong></th>
      
      <th style="width:20%;"><strong>Quantity</strong></th>
      
      <th style="width:25%;"><strong>Packing Desc.</strong></th>
      <th style="width:10%;"><strong>Sub Unit</strong></th>
      <th style="width:8%;"><strong>Unit Rate<br/> (INR)</strong></th>
      <th style="width:8%;">Total<br/> (INR)</th>
      </tr>';
      
      
    
  
'</div>
</body>
</html>';

$dompdf->loadHtml($html1,'UTF-8'); 
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isPhpEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->set_option('isJavascriptEnabled', true);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

//$dompdf->stream('saurabh',array('Attachment'=>'0'));
$output = $dompdf->output();

//$pono=$this->uri->segment('3');


$popdflink='Purchase_Order_'.date('dmy').'.pdf';
//echo $popdflink;exit;
file_put_contents($popdflink, $output); 