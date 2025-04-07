<?php
	require_once "../config.php";
	include "../session-checker.php";

	if (isset($_GET['ticket_number'])) {

		$sql = "UPDATE ticket_tbl SET status = 'FOR APPROVAL', date_completed = ?  WHERE ticket_number = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
            $date = date("Y-m-d H-i-s");
			mysqli_stmt_bind_param($stmt, "ss", $date, $_GET['ticket_number']);

			if (mysqli_stmt_execute($stmt)) {
				$sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";
				if ($stmt = mysqli_prepare($link, $sql)) {
					$date = date("d/m/Y");
					$time = date("h:i:sa");
					$action = "complete";
					$module = "ticket-management";
					$performed_to = "Ticket #" . $_GET['ticket_number'];
					mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $performed_to, $_SESSION['username']);


					if (mysqli_stmt_execute($stmt)) {
						$_SESSION["ticket-completed"] = $_GET['ticket_number'];
						header("location: ticket-management.php");
						exit();
					}
				}
				else {
					echo "<font color='red'>Error on inserting logs.</font>";
				}

			}
		}
		else {
			echo "<font color='red>Error on updating account.</font>";
		}
	}
?>