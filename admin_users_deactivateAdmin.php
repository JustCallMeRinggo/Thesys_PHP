<?php
	include 'dbconnect.php';
	$userID = $_GET['user_id'];

	$deactivateUserAdminQuery = "UPDATE tblUsers SET status = 'INACTIVE' WHERE user_id = '$userID'";
	$deactivateUserAdminQueryResult = mysqli_query($conn, $deactivateUserAdminQuery);

	header('location: admin_users_admin.php');
?>