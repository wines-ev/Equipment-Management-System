<?php
	require_once "../config.php";
	include "../session-checker.php";

	if (isset($_GET['ticket_number'])) {

		$sql = "DELETE FROM ticket_tbl WHERE ticket_number = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $_GET['ticket_number']);

			if (mysqli_stmt_execute($stmt)) {
				$sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";

					if ($stmt = mysqli_prepare($link, $sql)) {
						$date = date("d/m/Y");
						$time = date("h:i:sa");
						$action = "delete";
						$module = "ticket-management";
						mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_GET['ticket_number'], $_SESSION['username']);


						if (mysqli_stmt_execute($stmt)) {
							$_SESSION["ticket-deleted"] = $_GET['ticket_number'];
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