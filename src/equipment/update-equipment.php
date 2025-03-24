<?php
	require_once "../config.php";
	include "../session-checker.php";

	

	if (isset($_POST["btnsubmit"])) {
		$sql = "SELECT * FROM equipment_tbl WHERE serial_number = ?";

		if($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $_POST['serial_number']);
			if(mysqli_stmt_execute($stmt)) {
				$result = mysqli_stmt_get_result($stmt);
				$equipment = mysqli_fetch_array($result);
				if(mysqli_num_rows($result) == 0 || (mysqli_num_rows($result) == 1 && $equipment["asset_number"] == $_GET["asset_number"])) {
					$sql = "UPDATE equipment_tbl SET serial_number = ?, type = ?, manufacturer = ?, year_model = ?, description = ?, branch = ?, department = ?, status = ? WHERE asset_number = ?";

					if ($stmt = mysqli_prepare($link, $sql)) {
						mysqli_stmt_bind_param($stmt, "sssssssss", $_POST['serial_number'], $_POST['cmb_type'], $_POST['manufacturer'], $_POST['year_model'], $_POST['description'], $_POST['cmb_branch'], $_POST['cmb_department'], $_POST['rbstatus'], $_GET['asset_number']);

						if (mysqli_stmt_execute($stmt)) {
							$sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";
								if ($stmt = mysqli_prepare($link, $sql)) {
									$date = date("d/m/Y");
									$time = date("h:i:sa");
									$action = "update";
									$module = "equipment-management";
									$asset = "Asset #" . $_GET['asset_number'];
									mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $asset, $_SESSION['username']);


									if (mysqli_stmt_execute($stmt)) {
										echo "Equipment updated";
										$_SESSION["equipment-updated"] = $_GET['asset_number'];
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
				else {
					$_SESSION["serial_number_error"] = $_POST["serial_number"];
				}
			}
			else {
				echo "Error on SQL execute";
			}
		}
		else {
			echo "Error on SQL prepape";
		}
	}
	else {
		if (isset($_GET["asset_number"])) {
			$sql = "SELECT * FROM equipment_tbl WHERE asset_number = ?";
			if ($stmt = mysqli_prepare($link, $sql)) {
				mysqli_stmt_bind_param($stmt, "s", $_GET["asset_number"]);

				if (mysqli_stmt_execute($stmt)) {
					$result = mysqli_stmt_get_result($stmt);
					$equipment = mysqli_fetch_array($result);
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
	<title>Update Account</title>
	
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="../../css/style.css">
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
			<?php include ("../../modules/sidenav.php") ?>
			
			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5">
					<p class="fs-4 mb-0">Accounts / Update account</p>
					
				</div>

				<div class="container">
					<div class="mx-auto bg-white border p-5 rounded-4 mt-5 w-50 shadow">
						<p class="fs-4 mb-5">Change the value on this form and submit to update the account.</p>

						<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Asset number</span>
								<input class="form-control fs-4" type="text" value="<?php echo $equipment['asset_number']; ?>" disabled>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Serial number</span>
								<input class="form-control fs-4" type="text" name="serial_number" value="<?php echo $equipment['serial_number']; ?>" required>
							</div>
							
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Type</span>
								<select class="form-select fs-4" name="cmb_type" id="cmb_type" required>
									<option value = "Monitor" <?php if ($equipment['type'] == "Monitor") {echo "selected";} ?>>Monitor</option>
									<option value = "CPU" <?php if ($equipment['type'] == "CPU") {echo "selected";} ?>>CPU</option>
									<option value = "Keyboard" <?php if ($equipment['type'] == "Keyboard") {echo "selected";} ?>>Keyboard</option>
									<option value = "Mouse" <?php if ($equipment['type'] == "Mouse") {echo "selected";} ?>>Mouse</option>
									<option value = "AVR" <?php if ($equipment['type'] == "AVR") {echo "selected";} ?>>AVR</option>
									<option value = "MAC" <?php if ($equipment['type'] == "MAC") {echo "selected";} ?>>MAC</option>
									<option value = "Printer" <?php if ($equipment['type'] == "Printer") {echo "selected";} ?>>Printer</option>
									<option value = "Projector" <?php if ($equipment['type'] == "Projector") {echo "selected";} ?>>Projector</option>
								</select>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Manufacturer</span>
								<input class="form-control fs-4" type="text" name="manufacturer" value="<?php echo $equipment['manufacturer']; ?>" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Year Model</span>
								<input class="form-control fs-4" type="number" min="1000" max="9999" name="year_model"  value="<?php echo $equipment['year_model']; ?>" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Description</span>
								<textarea class="form-control fs-4" id="description" name="description" rows="3" maxlength="200"><?php echo $equipment['description']; ?></textarea>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Branch</span>
								<select class="form-select fs-4" name="cmb_branch" id = "cmb_branch" required>
									<option value = "Juan Sumulong (Legarda / Main)" <?php if ($equipment['branch'] == "Juan Sumulong (Legarda / Main)") {echo "selected";} ?>>Juan Sumulong (Legarda / Main)</option>
									<option value = "Andres Bonifacio (Pasig)" <?php if ($equipment['branch'] == "Andres Bonifacio (Pasig)") {echo "selected";} ?>>Andres Bonifacio (Pasig)</option>
									<option value = "Apolinario Mabini (Pasay)" <?php if ($equipment['branch'] == "Apolinario Mabini (Pasay)") {echo "selected";} ?>>Apolinario Mabini (Pasay)</option>
									<option value = "Elisa Esguerra (Malabon)" <?php if ($equipment['branch'] == "Elisa Esguerra (Malabon)") {echo "selected";} ?>>Elisa Esguerra (Malabon)</option>
									<option value = "Jose Abad Santos (Pasay)" <?php if ($equipment['branch'] == "Jose Abad Santos (Pasay)") {echo "selected";} ?>>Jose Abad Santos (Pasay)</option>
									<option value = "Jose Rizal (Malabon)" <?php if ($equipment['branch'] == "Jose Rizal (Malabon)") {echo "selected";} ?>>Jose Rizal (Malabon)</option>
									<option value = "Plaridel (Mandaluyong)" <?php if ($equipment['branch'] == "Plaridel (Mandaluyong)") {echo "selected";} ?>>Plaridel (Mandaluyong)</option>
									<option value = "School of Law (Pasay)" <?php if ($equipment['branch'] == "School of Law (Pasay)") {echo "selected";} ?>>School of Law (Pasay)</option>
								</select>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Department</span>
								<select class="form-select fs-4" name="cmb_department" id = "cmb_department" required>
									<option value = "College of Arts and Sciences" <?php if ($equipment['department'] == "College of Arts and Sciences") {echo "selected";} ?>>College of Arts and Sciences</option>
									<option value = "College of Criminal Justice Education" <?php if ($equipment['department'] == "College of Criminal Justice Education") {echo "selected";} ?>>College of Criminal Justice Education</option>
									<option value = "College of Medical Laboratory Science" <?php if ($equipment['department'] == "College of Medical Laboratory Science") {echo "selected";} ?>>College of Medical Laboratory Science</option>
									<option value = "College of Nursing" <?php if ($equipment['department'] == "College of Nursing") {echo "selected";} ?>>College of Nursing</option>
									<option value = "College of Pharmacy" <?php if ($equipment['department'] == "College of Pharmacy") {echo "selected";} ?>>College of Pharmacy</option>
									<option value = "College of Physical Therapy" <?php if ($equipment['department'] == "College of Physical Therapy") {echo "selected";} ?>>College of Physical Therapy</option>
									<option value = "College of Radiologic Technology" <?php if ($equipment['department'] == "College of Radiologic Technology") {echo "selected";} ?>>College of Radiologic Technology</option>
									<option value = "Information Technology Education (ITE) Cluster" <?php if ($equipment['department'] == "Information Technology Education (ITE) Cluster") {echo "selected";} ?>>Information Technology Education (ITE) Cluster</option>
									<option value = "Institute of Accountancy" <?php if ($equipment['department'] == "Institute of Accountancy") {echo "selected";} ?>>Institute of Accountancy</option>
									<option value = "School of Business Administration" <?php if ($equipment['department'] == "School of Business Administration") {echo "selected";} ?>>School of Business Administration</option>
									<option value = "School of Business Administration" <?php if ($equipment['department'] == "School of Business Administration") {echo "selected";} ?>>School of Business Administration</option>
									<option value = "School of Business and Commerce" <?php if ($equipment['department'] == "School of Business and Commerce") {echo "selected";} ?>>School of Business and Commerce</option>
									<option value = "School of Business Technology" <?php if ($equipment['department'] == "School of Business Technology") {echo "selected";} ?>>School of Business Technology</option>
									<option value = "School of Computer Studies" <?php if ($equipment['department'] == "School of Computer Studies") {echo "selected";} ?>>School of Computer Studies</option>
									<option value = "School of Education" <?php if ($equipment['department'] == "School of Education") {echo "selected";} ?>>School of Education</option>
									<option value = "School of Hospitality and Tourism Management" <?php if ($equipment['department'] == "School of Hospitality and Tourism Management") {echo "selected";} ?>>School of Hospitality and Tourism Management</option>
									<option value = "School of Midwifery" <?php if ($equipment['department'] == "School of Midwifery") {echo "selected";} ?>>School of Midwifery</option>
									<option value = "School of Psychology" <?php if ($equipment['department'] == "School of Psychology") {echo "selected";} ?>>School of Psychology</option>
								</select>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Status</span>
								<div class="input-group-text fs-4 bg-white" style="width: 65%;">
									<div class="form-check form-check-inline me-5">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus1" value="WORKING" <?php if ($equipment["status"] == 'WORKING') {echo "checked";} ?>>
											<label class="form-check-label" for="inlineRadio1">Working</label>
										</div>

										<div class="form-check form-check-inline me-5">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus2" value="ON REPAIR" <?php if ($equipment["status"]  == 'ON REPAIR') {echo "checked";} ?>>
											<label class="form-check-label" for="inlineRadio1">On-Repair</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus3" value="RETIRED" <?php if ($equipment["status"]  == 'RETIRED') {echo "checked";} ?>>
											<label class="form-check-label" for="inlineRadio1">Retired</label>
										</div>
								</div>
							</div>


				
							

							<div class="d-flex mt-5 gap-3 justify-content-end">
								<a class="btn bg-secondary text-light fs-4 px-5" href="equipment-management.php">Cancel</a>
								<input class="btn bg-blue text-light fs-4 px-5" type="submit" name="btnsubmit" value="Submit">
							</div>
						</form>
					</div>

				</div>

				
			</div>
		</div>
	</div>
</body>

<?php 
 if (isset($_SESSION["serial_number_error"])) {
	echo "<script>document.getElementById('asset_number').value = '" . $_POST['asset_number'] . "'</script>";
	echo "<script>document.getElementById('serial_number').value = '" . $_POST['serial_number'] . "'</script>";
	echo "<script>document.getElementById('cmb_type').value = '" . $_POST['cmb_type'] . "'</script>";
	echo "<script>document.getElementById('manufacturer').value = '" . $_POST['manufacturer'] . "'</script>";
	echo "<script>document.getElementById('year_model').value = '" . $_POST['year_model'] . "'</script>";
	echo "<script>document.getElementById('description').value = '" . $_POST['description'] . "'</script>";
	echo "<script>document.getElementById('cmb_branch').value = '" . $_POST['cmb_branch'] . "'</script>";
	echo "<script>document.getElementById('cmb_department').value = '" . $_POST['cmb_department'] . "'</script>";
 }

?>

<script src="../../js/script.js"></script>
</html>