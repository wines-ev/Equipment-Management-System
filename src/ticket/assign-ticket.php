<?php
	require_once "../config.php";
	include "../session-checker.php";

	if (isset($_POST["btnsubmit"])) {

        $sql = "UPDATE ticket_tbl SET assigned_to = ?, status = 'ON-GOING', date_assigned = ? WHERE ticket_number = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            $date = date("Y-m-d H-i-s");
            mysqli_stmt_bind_param($stmt, "sss", $_POST['cmb_tech'], $date, $_GET['ticket_number']);

            if (mysqli_stmt_execute($stmt)) {
				$sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";
				if ($stmt = mysqli_prepare($link, $sql)) {
					$date = date("d/m/Y");
					$time = date("h:i:sa");
					$action = "assign";
					$module = "ticket-management";
					$performed_to = "Ticket #" . $_GET['ticket_number'];
					mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $performed_to, $_SESSION['username']);


					if (mysqli_stmt_execute($stmt)) {
						$_SESSION["ticket-assigned"] = $_GET['ticket_number'];
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
            echo "<font color='red>Error on assigning ticket.</font>";
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
	<title>Assign Ticket</title>
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

	
	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item fs-4"><a href="ticket-management.php">Tickets</a></li>
							<li class="breadcrumb-item fs-4 active" aria-current="page">Assign tickets</li>
						</ol>
					</nav>
				</div>

				<div class="container">
					<div class="mx-auto bg-white border p-5 rounded-4 mt-5 w-50 shadow">
						<p class="fs-4 mb-5">Change the value on this form and submit to assign the tickets.</p>

						<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Ticket number</span>
								<input class="form-control fs-4" type="text" value="<?php echo $ticket['ticket_number']; ?>" disabled>
							</div>
							
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Problem</span>
                                <input class="form-control fs-4" type="text" value="<?php echo $ticket['problem']; ?>" disabled>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Details</span>
								<textarea class="form-control fs-4" id="txt_details" name="txt_details" rows="3" maxlength="200" disabled><?php echo trim($ticket['details']); ?></textarea>
							</div>

                            <div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Assign to</span>
                                <?php
                                        $sql = "SELECT username FROM user_tbl WHERE user_type = 'TECHNICAL'";
                                        if($stmt = mysqli_prepare($link, $sql)) {
                                            if (mysqli_stmt_execute($stmt)) {
                                                $result = mysqli_stmt_get_result($stmt);
                                            }
                                            else {
                                                echo "error on executing sql";
                                            }
                                        }
                                        else {
                                            echo "error on preparing sql";
                                        }
                                    ?>

								<select class="form-select fs-4" name="cmb_tech" id="cmb_tech" required>
									<option value="">Select technician</option>
                                    <?php
                                        if(mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value = '" . $row['username'] . "'" . ($ticket['assigned_to'] == $row['username'] ?  "selected" : "") . ">" . $row['username'] . "</option>" ;
                                            }
                                        }
                                        else {
                                            echo "<option value = ''>No technician found</option>" ;
                                        }
                                    ?>

                                    
								</select>
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