<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
// $connectionInfo = array( "Database"=>"dbName", "UID"=>"username", "PWD"=>"password" );
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false ) {
	
    die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM Employees";

$query = sqlsrv_query($conn, $sql);

$result = array();
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(	
		'city'=>$row['City_Name'],
		'birthdate'=>$row['Employee_Date_Of_Birth'],		
		'email'=>$row['Email_Address'],
		'fname'=>$row['First_Name'],
		'lname'=>$row['Last_Name'],
		'phone'=>$row['Phone_Number'],
		'empID'=>$row['Employee_ID'],
		'empTypeDesc'=>$row['Employee_Type_Description'],
		'endDate'=>$row['End_Date'],
		'wage'=>$row['Hourly_Wage'],
		'address'=>$row['Street_Address'],
		'userID'=>$row['User_ID'],
		'password'=>$row['Password'],
		'rewardID' =>$row['Reward_ID'],
		'ssn'=>$row['SSN'],
		'startDate'=>$row['Start_Date'],
		'serviceEmp'=>$row['Service_Employee']
		
	));
}

echo json_encode(array('result'=>$result));
sqlsrv_close($conn);
?>
