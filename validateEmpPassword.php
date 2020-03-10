<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");


$link .= $_SERVER['REQUEST_URI']; 

$startOfParamOne = strpos($link,"=") + 1;
$endOfParamOne = strpos($link,",");
$empID = substr($link,$startOfParamOne, ($endOfParamOne - $startOfParamOne));

// Gets the password passed via URL
$secondParam = strpos($link,",") + 1;
$pass = substr($link,$secondParam);

// Checks where BOTH are present in one record


$sql = "SELECT Employee_ID, Password, First_Name
		FROM Employees		
		WHERE Employee_ID = '" . $empID . "' AND Password = '" . $pass . "';";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(		
		'empID'=>$row['Employee_ID'],
		'fname'=>$row['First_Name']
	));
}

echo json_encode(array('result'=>$result));
?>
