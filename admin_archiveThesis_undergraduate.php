<?php
	include 'dbconnect.php';
	$thesisID = $_GET['thesis_id'];

	$archiveThesisnQuery = "UPDATE tblThesis SET status = 'ARCHIVED' WHERE thesis_id = '$thesisID'";
	$archiveThesisQueryResult = mysqli_query($conn, $archvieThesisQuery);

	header('location: admin_archiveThesis_undergraduate.php');
?>