<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

$sql = "SELECT * FROM Inventory";

$query = sqlsrv_query($conn, $sql);

$result = array();

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
	array_push($result,array(
		'aquariumCategory'=>$row['Aquarium_Category'],
		'description'=>$row['Description'],
		'fishCategory'=>$row['Fish_Category'],
		'imgSource'=>$row['img_source'],
		'inventoryID'=>$row['Inventory_ID'],
		'price'=>$row['Price'],
		'qty'=>$row['Qty'],
		'upc'=>$row['UPC'],
		'vendor'=>$row['Vendor']
	));
}

echo json_encode(array('result'=>$result));
?>