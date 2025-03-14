<?php
	require_once "../config.php";
	include "../session-checker.php";

	if (isset($_GET['asset_number'])) {

		$sql = "DELETE FROM equipment_tbl WHERE asset_number = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", trim($_GET['asset_number']));

			if (mysqli_stmt_execute($stmt)) {
				$sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";

					if ($stmt = mysqli_prepare($link, $sql)) {
						$date = date("d/m/Y");
						$time = date("h:i:sa");
						$action = "delete";
						$module = "account-management";
						$asset = "Asset #" . $_GET['asset_number'];
						mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $asset, $_SESSION['username']);

						if (mysqli_stmt_execute($stmt)) {
							echo "User account deleted";
							$_SESSION["equipment-deleted"] = $_GET['asset_number'];
							header("location: equipment-management.php");
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