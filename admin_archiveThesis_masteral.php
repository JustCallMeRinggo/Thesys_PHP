<?php
	include 'dbconnect.php';
	$thesisID = $_GET['thesis_id'];

	$archiveThesisQuery = "UPDATE tblThesis SET status = 'ARCHIVED' WHERE thesis_id = '$thesisID'";
	$archiveThesisQueryResult = mysqli_query($conn, $archiveThesisQuery);

	header('location: admin_thesis_masteral.php');
?>