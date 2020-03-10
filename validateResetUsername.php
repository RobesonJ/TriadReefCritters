<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

// Gets the username passed via URL
$link .= $_SERVER['REQUEST_URI']; 

$startOfParams = strpos($link,"=") + 1;
$param = substr($link,$startOfParams);

$sql = "SELECT Username, Security_Question FROM User_Profile WHERE Username = '" . $param . "';";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'securityQuestion'=>$row['Security_Question']
	));
}

echo json_encode(array('result'=>$result));
?>
