<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM Customers";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
    array_push($result,array(
        'city'=>$row['City'],
        'birthdate'=>$row['Date_of_Birth'],
        'birthday_last_changed'=>$row['DOB_Last_Change'],
        'email'=>$row['Email_Address'],
        'fname'=>$row['First_Name'],
        'lname'=>$row['Last_Name'],
        'phone'=>$row['Phone_Number'],
        'postalCode'=>$row['Postal_Code'],
        'rewardID'=>$row['Reward_ID'],
        'salesID'=>$row['Sales_ID'],
        'state'=>$row['State'],
        'address'=>$row['Street_Address'],
        'userID'=>$row['User_ID']
    ));
}

echo json_encode(array('result'=>$result));
?>
