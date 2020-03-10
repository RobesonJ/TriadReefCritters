<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM Rewards";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'purchaseHistoryTotal'=>$row['Purchase_History_Total'],
		'rewardsID'=>$row['Reward_ID'],
		'rewardBal'=>$row['Reward_Balance'],
		'rewardEarn'=>$row['Rewards_Earned'],
		'rewardUsed'=>$row['Rewards_Used']
	));
}

echo json_encode(array('result'=>$result));
?>