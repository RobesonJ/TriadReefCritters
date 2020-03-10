<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM User_Credits";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'paymentID'=>$row['Payment_ID'],
		'reasonCode'=>$row['Reason_Code'],
		'refundAmt'=>$row['Refund_Amount'],
		'refundDate'=>$row['Refund_Date'],
		'remarks'=>$row['Remarks_Text'],
		'rewardID'=>$row['Reward_ID'],
		'storeCreditAmt'=>$row['Store_Credit_Amount'],
		'storeCreditDate'=>$row['Store_Credit_Date'],
		'userCreditID'=>$row['User_Credit_ID'],
		'userID'=>$row['User_ID']
	));
}

echo json_encode(array('result'=>$result));
?>