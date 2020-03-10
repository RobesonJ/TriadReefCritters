<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
// $connectionInfo = array( "Database"=>"dbName", "UID"=>"username", "PWD"=>"password" );
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false ) {
	
    die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM Tank_Service";

$query = sqlsrv_query($conn, $sql);

$result = array();
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(	
		'empID'=>$row['Employee_ID'],
		'lastServDate'=>$row['Last_Service_Date'],
		'nextServDate'=>$row['Next_Service_Date'],
		'requestDate'=>$row['Request_Date'],
		'servDateEnd'=>$row['Service_End_Date'],
		'servStartDate'=>$row['Service_Start_Date'],
		'servNotes'=>$row['Service_Notes'],
		'servPrice'=>$row['Service_Price'],
		'servStatus'=>$row['Service_Status'],
		'servType'=>$row['Service_Type'],
		'tankServID'=>$row['Tank_Service_ID'],
		'viewStatus'=>$row['Viewing_Status'],		
	));
}

echo json_encode(array('result'=>$result));
sqlsrv_close($conn);
?>