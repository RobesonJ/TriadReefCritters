<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM User_Profile";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'loggedIn'=>$row['Logged_In'],
		'password'=>$row['Password'],
		'profileID'=>$row['Profile_ID'],
		'rewardID'=>$row['Reward_ID'],
		'securityQuestion'=>$row['Security_Question'],
		'securityQuestionAnswer'=>$row['Security_Question_Answer'],
		'userID'=>$row['User_ID'],
		'username'=>$row['Username']
	));
}

echo json_encode(array('result'=>$result));
?>