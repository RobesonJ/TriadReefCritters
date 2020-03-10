<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$user = $_POST['userName'];
$pass = $_POST['newPassword'];

$sql = "UPDATE User_Profile SET Password = '" . $pass . "' WHERE Username = '" . $user . "';";
$query = sqlsrv_query($conn, $sql);

if(sqlsrv_query($conn, $sql)){
	echo "values added";
}else{
	echo "values not added";
}
sqlsrv_close( $conn );
?>
