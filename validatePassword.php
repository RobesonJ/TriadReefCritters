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

$startOfParamOne = strpos($link,"=") + 1;
$endOfParamOne = strpos($link,",");
$user = substr($link,$startOfParamOne, ($endOfParamOne - $startOfParamOne));

// Gets the password passed via URL
$secondParam = strpos($link,",") + 1;
$pass = substr($link,$secondParam);

// Checks where BOTH are present in one record
//$sql = "SELECT Username, User_ID FROM User_Profile WHERE Username = '" . $user . "' AND Password = '" . $pass . "';";

$sql = "SELECT User_Profile.Username, User_Profile.User_ID, Customers.First_Name
		FROM User_Profile
		INNER JOIN
			 Customers
			 ON User_Profile.User_ID = Customers.User_ID
			 WHERE User_Profile.Username = '" . $user . "' AND User_Profile.Password = '" . $pass . "';";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'username'=>$row['Username'],
		'userID'=>$row['User_ID'],
		'fname'=>$row['First_Name']
	));
}

echo json_encode(array('result'=>$result));
?>
