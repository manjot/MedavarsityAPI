<html>
<head>
<title> Medivarsity</title>
</head>
<body>
<center>

<?php 
include('Crypto.php')?>
<?php 

	error_reporting(0);
	
$merchant_data='206963';
$working_key='E079BF65C6003492A2D0DEB811AAC817';//Shared by CCAVENUES
$access_code='AVSM83GA20CN49MSNC';//Shared by CCAVENUES
	foreach ($details as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
   
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.


?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
 <script language='javascript'>document.redirect.submit();</script> 
</body>
</html>

