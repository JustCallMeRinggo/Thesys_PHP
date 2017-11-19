<?php
	include 'dbconnect.php';
	$userID = $_GET['user_id'];

	$deactivateUserVisitorQuery = "UPDATE tblUsers SET status = 'INACTIVE' WHERE user_id = '$userID'";
	$deactivateUserVisitorQueryResult = mysqli_query($conn, $deactivateUserVisitorQuery);

	header('location: admin_users_visitors.php');
?>