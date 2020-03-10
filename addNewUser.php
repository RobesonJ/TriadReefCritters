<?php
$serverName = "trc-dba289.ckzqnrovuxcu.us-east-1.rds.amazonaws.com";
$connectionInfo = array( "Database"=>"Triad_Reef_Critters", "UID"=>"amitchell", "PWD"=>"amitchell2020!" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
	die( print_r( sqlsrv_errors(), true));
}
date_default_timezone_set("America/New_York");

// // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // //
// Get all data from the POST and initialize fields to be submitted
	////////////////////////
	//** Customer Data **//
$city = $_POST['city'];
$birthdate = $_POST['birthdate'];
$dob_last_change = 0;
$email = $_POST['email'];
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$phone = $_POST['phone'];
$zip = $_POST['zip'];
$rewardsID = "";
$salesID = null; // I refuse to do a sales id, it makes NO logical sense...
$state = $_POST['state'];
$street = $_POST['street'];
$userID = "";

	///////////////////////////
	//** User_Profile data **//
$loggedIn = 0;
$pass = $_POST['pass'];
$profileID = "";
$rewardsID = "";
$secretQ = $_POST['secretQ'];
$secretA = $_POST['secretA'];
$userID = "";
$user = $_POST['user'];

	///////////////////////
	//** Rewards data **//
$rewardsID = "";
$historyTotal = 0.00;
$balance = 0.00;
$earned = 20.00; // We'll give them $20 for signing up
$used = 0.00;
// // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // //
// Get new User ID (Find highest, Substring U off.. Add 1 to Number then put them back together)
$getNewUserID = "SELECT TOP 1 User_ID 
				 FROM Customers
				 ORDER BY User_ID Desc;";
$resultNewUserID = sqlsrv_query($conn, $getNewUserID);
$userID = "";
while($row = sqlsrv_fetch_array($resultNewUserID, SQLSRV_FETCH_ASSOC)){
	$userID = $row['User_ID'];
}
$sub = substr($userID,1);
$userID = "U" . ((int)$sub + 1);
// // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // //
// Get new Rewards ID (Find highest, Substring R off.. Add 1 to Number then put them back together)
$getNewRewardsID = "SELECT TOP 1 Reward_ID
					FROM Rewards
					ORDER BY Reward_ID Desc;";
$resultNewRewardID = sqlsrv_query($conn, $getNewRewardsID);
$rewardsID = "";
while($row = sqlsrv_fetch_array($resultNewRewardID, SQLSRV_FETCH_ASSOC)){
	$rewardsID = $row['Reward_ID'];
}
$sub = substr($rewardsID,1);
$rewardsID = "R" . ((int)$sub + 1);
/*
Current issue, if say the userProfile fails, it will still add a Customer and Reward.
Fixing this is troublesome... For now, pretend it doesn't exist.
*/

// Insert Rewards
$rewardsRecord = "INSERT INTO Rewards (Reward_ID, Rewards_Balance, Rewards_Earned, Rewards_Used, Purchase_History_Total) VALUES ('".$rewardsID."',25.0000,25.0000,0.0000,0.000);";
if(sqlsrv_query($conn, $rewardsRecord)){
	// Insert Customers
	$customersRecord = "INSERT INTO Customers (User_ID, Reward_ID, First_Name, Last_Name, Date_of_Birth, Street_Address, City, State, Postal_Code, Email_Address, Phone_Number, Sales_ID, DOB_Last_Change) VALUES('".$userID."','".$rewardsID."','".$fName."','".$lName."','".$birthdate."','".$street."','".$city."','".$state."','".$zip."','".$email."','".$phone."',null,0);";
	sqlsrv_rollback($conn);
	if(sqlsrv_query($conn, $customersRecord)){
			// Insert User_Profile
			$userProfileRecord = "INSERT INTO User_Profile (Profile_ID, User_ID, Reward_ID, Username, Password, Security_Question, Security_Question_Answer, Logged_In) VALUES('".$user."','".$userID."','".$rewardsID."','".$user."','".$pass."','".$secretQ."','".$secretA."',".$loggedIn.");";
			sqlsrv_rollback($conn);
			if(sqlsrv_query($conn, $userProfileRecord)){
				echo "values added - customer";
				sqlsrv_commit($conn);
			}else{
				echo "values not - profile";
				sqlsrv_rollback( $conn );
			}
	}else{
		echo "values not";
		sqlsrv_rollback($conn);
	}
}else{
	echo "values not - rewards";
	sqlsrv_rollback($conn);
}
sqlsrv_close( $conn );
?>

