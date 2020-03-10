<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM Payments";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'cashAmt'=>$row['Cash_Amt'],
		'creditCardCVV'=>$row['Credit_Card_CVV'],
		'creditCardExpiration'=>$row['Credit_Card_Expiration_Date'],
		'creditCardNumber'=>$row['Credit_Card_Number'],
		'paymentAmt'=>$row['Payment_Amount'],
		'paymentDate'=>$row['Payment_Date'],
		'userID'=>$row['User_ID']
	));
}

echo json_encode(array('result'=>$result));
?>