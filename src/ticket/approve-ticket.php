<?php
	require_once "../config.php";
	include "../session-checker.php";

	if (isset($_GET['ticket_number'])) {

		$sql = "UPDATE ticket_tbl SET status = 'CLOSED', date_approved = ?, approved_by = ?  WHERE ticket_number = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
            $date = date("Y-m-d H-i-s");
			mysqli_stmt_bind_param($stmt, "sss", $date, $_SESSION['username'], $_GET['ticket_number']);

			if (mysqli_stmt_execute($stmt)) {
				$_SESSION["ticket-approved"] = $_GET['ticket_number'];
                header("location: ticket-management.php");
                exit();
			}
		}
		else {
			echo "<font color='red>Error on updating account.</font>";
		}
	}
?>