<?php
	require_once "../config.php";
	include "../session-checker.php";

	if (isset($_POST["btnsubmit"])) {
		
    
        if ($_SESSION["current_problem"] == $_POST["cmb_problem"] ) {
            $sql = "UPDATE ticket_tbl SET problem = ?, details = COALESCE(NULLIF(?, ''), details)  WHERE ticket_number = ?";
        }
        else {
            $sql = "UPDATE ticket_tbl SET problem = ?, details = ? WHERE ticket_number = ?";
        }

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $_POST['cmb_problem'], $_POST['txt_details'], $_GET['ticket_number']);

            if (mysqli_stmt_execute($stmt)) {
                $sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        $date = date("d/m/Y");
                        $time = date("h:i:sa");
                        $action = "update";
                        $module = "ticket-management";
                        $performed_to = "Ticket #" . $_GET['ticket_number'];
                        mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $performed_to, $_SESSION['username']);


                        if (mysqli_stmt_execute($stmt)) {
                            $_SESSION["ticket-updated"] = $_GET['ticket_number'];
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
            echo "<font color='red>Error on updating ticket.</font>";
        }
	}
	else {
		if (isset($_GET["ticket_number"])) {
			$sql = "SELECT * FROM ticket_tbl WHERE ticket_number = ?";
			if ($stmt = mysqli_prepare($link, $sql)) {
				mysqli_stmt_bind_param($stmt, "s", $_GET["ticket_number"]);

				if (mysqli_stmt_execute($stmt)) {
					$result = mysqli_stmt_get_result($stmt);
					$ticket = mysqli_fetch_array($result);

                    $_SESSION["current_problem"] = $ticket["problem"];
                    $_SESSION["current_details"] = $ticket["details"];
				}
			}
		}
		else {
			echo "<font color='red'>Error on loading account data.</font>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Ticket</title>
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
</head>
<body>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>

	<button type="button" id="pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Launch error modal
	</button>

	<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">
						Error!
					</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">
						<?php 
							if (isset($_SESSION["asset_number_error"])) {
								echo "Asset number '<span class='fw-bold'>" . $_SESSION["asset_number_error"] . "</span>' already in use.";
							}
							else if (isset($_SESSION["serial_number_error"])) {
								echo "Serial number '<span class='fw-bold'>" . $_SESSION["serial_number_error"] . "</span>' already in use.";
							}
						?>
					
					</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary fs-4 px-4" id="dismiss-modal" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	


	<?php
		if (isset($_SESSION["serial_number_error"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["serial_number_error"]);
		}
	?>

	<button type="button" id="pop-up-trigger" class="pop-up-trigger btn btn-primary fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Launch error modal
	</button>

	<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title fs-1" id="exampleModalLabel">
						Error!
					</p>
					<button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-4 my-4">
					<p class="fs-4">
						<?php 
							if (isset($_SESSION["asset_number_error"])) {
								echo "Asset number '<span class='fw-bold'>" . $_SESSION["asset_number_error"] . "</span>' already in use.";
							}
							else if (isset($_SESSION["serial_number_error"])) {
								echo "Serial number '<span class='fw-bold'>" . $_SESSION["serial_number_error"] . "</span>' already in use.";
							}
						?>
					
					</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary fs-4 px-4" id="dismiss-modal" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>	

	<?php
		if (isset($_SESSION["asset_number_error"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["asset_number_error"]);
		}
		if (isset($_SESSION["serial_number_error"])) {
			echo "<script>document.getElementById('pop-up-trigger').click();</script>";
			unset($_SESSION["serial_number_error"]);
		}
	?>

	
	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/user_sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5">
					<p class="fs-4 mb-0">Tickets / Update ticket</p>
					
				</div>

				<div class="container">
					<div class="mx-auto bg-white border p-5 rounded-4 mt-5 w-50 shadow">
						<p class="fs-4 mb-5">Change the value on this form and submit to update the ticket.</p>

						<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Ticket number</span>
								<input class="form-control fs-4" type="text" value="<?php echo $ticket['ticket_number']; ?>" disabled>
							</div>
							
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Problem</span>
								<select class="form-select fs-4" name="cmb_problem" id="cmb_problem" required>
                                    <option value = "Hardware" <?php if ($ticket['problem'] == "Hardware") {echo "selected";} ?>>Hardware</option>
                                    
									
									<option value = "Software" <?php if ($ticket['problem'] == "Software") {echo "selected";} ?>>Software</option>
									<option value = "Connection" <?php if ($ticket['problem'] == "Connection") {echo "selected";} ?>>Connection</option>
								</select>
							</div>

			

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Details</span>
								<textarea class="form-control fs-4" id="txt_details" name="txt_details" rows="3" maxlength="200"><?php echo trim($ticket['details']); ?></textarea>
							</div>
							
							<div class="d-flex mt-5 gap-3 justify-content-end">
								<a class="btn bg-secondary text-light fs-4 px-5" href="ticket-management.php">Cancel</a>
								<input class="btn bg-blue text-light fs-4 px-5" type="submit" name="btnsubmit" value="Submit">
							</div>
						</form>
					</div>

				</div>

				
			</div>
		</div>
	</div>
</body>

<script src="../../js/script.js"></script>
</html>