<?php
	include 'dbconnect.php';
	$userID = $_GET['user_id'];

	$deactivateUserStudentQuery = "UPDATE tblUsers SET status = 'INACTIVE' WHERE user_id = '$userID'";
	$deactivateUserStudentQueryResult = mysqli_query($conn, $deactivateUserStudentQuery);

	header('location: admin_users_student.php');
?>