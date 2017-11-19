<?php
	include 'dbconnect.php';
	$userID = $_GET['user_id'];

	$deactivateUserFacultyQuery = "UPDATE tblUsers SET status = 'INACTIVE' WHERE user_id = '$userID'";
	$deactivateUserFacultyQueryResult = mysqli_query($conn, $deactivateUserFacultyQuery);

	header('location: admin_users_faculty.php');
?>