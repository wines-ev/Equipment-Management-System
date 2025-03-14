<?php
require_once "../config.php";
include ("../session-checker.php");
if(isset($_POST['btnsubmit'])) {
	$sql = "SELECT * FROM equipment_tbl WHERE asset_number = ?";
	if($stmt = mysqli_prepare($link, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", $_POST['asset_number']);
		if(mysqli_stmt_execute($stmt)) {
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) == 0) {

				$sql = "SELECT * FROM equipment_tbl WHERE serial_number = ?";

				if($stmt = mysqli_prepare($link, $sql)) {
					mysqli_stmt_bind_param($stmt, "s", $_POST['serial_number']);
					if(mysqli_stmt_execute($stmt)) {
						$result = mysqli_stmt_get_result($stmt);
						if(mysqli_num_rows($result) == 0) {
							//insert
							$sql = "INSERT INTO equipment_tbl values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

							if ($stmt = mysqli_prepare($link, $sql)) {
								$asset_number = $_POST['asset_number'];
								$serial_number = $_POST['serial_number'];
								$type = $_POST['cmb_type'];
								$manufacturer = $_POST['manufacturer'];
								$year_model = $_POST['year_model'];
								$description = $_POST['description'];
								$branch = $_POST['cmb_branch'];
								$department = $_POST['cmb_department'];
								$status = "WORKING";
								$createdby = $_SESSION['username'];
								$datecreated = date("m/d/Y");

								mysqli_stmt_bind_param($stmt, "sssssssssss", $asset_number, $serial_number, $type, $manufacturer, 
								$year_model, $description, $branch, $department, $status, $createdby, $datecreated);


								if (mysqli_stmt_execute($stmt)) {
									header("location: equipment-management.php");
									$_SESSION["equipment-added"] = $asset_number = $_POST['asset_number'];;
								}
								else {
									echo "Error inserting equipment";
								}
							}
						}
						else {
							$_SESSION["serial_number_error"] = $_POST["serial_number"];
						}
					}
				}
			}
			else
			{	
				$_SESSION["asset_number_error"] = $_POST["asset_number"];
			}
		}
	}
	else
	{
		echo "<font color = 'red'>ERROR on SELECT statement</font>";
	}
}
?>

	
		

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add equipment</title>
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
</head>
<body>
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
					<p class="fs-4 mb-0">Equipment / Add equipment</p>
				</div>

				<div class="container">
					<div class="mx-auto bg-white border p-5 rounded-4 mt-5 w-50">
						<p class="fs-4 mb-5">Fill up this form and submit to add a new equipment</p>
						<form acion = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Asset number</span>
								<input class="form-control fs-4" type="text" name="asset_number" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Serial number</span>
								<input class="form-control fs-4" type="text" name="serial_number" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Type</span>
								<select class="form-select fs-4" name="cmb_type" id="cmbtype" required>
									<option value = "">Select Equipment Type</option>
									<option value = "Monitor">Monitor</option>
									<option value = "CPU">CPU</option>
									<option value = "Keyboard">Keyboard</option>
									<option value = "Mouse">Mouse</option>
									<option value = "AVR">AVR</option>
									<option value = "MAC">MAC</option>
									<option value = "Printer">Printer</option>
									<option value = "Projector">Projector</option>
								</select>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Manufacturer</span>
								<input class="form-control fs-4" type="text" name="manufacturer" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Year Model</span>
								<input class="form-control fs-4" type="number" min="1000" max="9999" name="year_model" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Description</span>
								<textarea class="form-control fs-4" id="description" name="description" rows="4"></textarea>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Branch</span>
								<select class="form-select fs-4" name="cmb_branch" id = "cmb_branch" required>
									<option value = "">Select Branch</option>
									<option value = "Juan Sumulong (Legarda / Main)">Juan Sumulong (Legarda / Main)</option>
									<option value = "Andres Bonifacio (Pasig)">Andres Bonifacio (Pasig)</option>
									<option value = "Apolinario Mabini (Pasay)">Apolinario Mabini (Pasay)</option>
									<option value = "Elisa Esguerra (Malabon)">Elisa Esguerra (Malabon)</option>
									<option value = "Jose Abad Santos (Pasay)">Jose Abad Santos (Pasay)</option>
									<option value = "Jose Rizal (Malabon)">Jose Rizal (Malabon)</option>
									<option value = "Plaridel (Mandaluyong)">Plaridel (Mandaluyong)</option>
									<option value = "School of Law (Pasay)">School of Law (Pasay)</option>
								</select>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Department</span>
								<select class="form-select fs-4" name="cmb_department" id = "cmb_department" required>
									<option value = "">Select Department</option>
									<option value = "College of Arts and Sciences">College of Arts and Sciences</option>
									<option value = "College of Criminal Justice Education">College of Criminal Justice Education</option>
									<option value = "College of Medical Laboratory Science">College of Medical Laboratory Science</option>
									<option value = "College of Nursing">College of Nursing</option>
									<option value = "College of Pharmacy">College of Pharmacy</option>
									<option value = "College of Physical Therapy">College of Physical Therapy</option>
									<option value = "College of Radiologic Technology">College of Radiologic Technology</option>
									<option value = "Information Technology Education (ITE) Cluster">Information Technology Education (ITE) Cluster</option>
									<option value = "Institute of Accountancy">Institute of Accountancy</option>
									<option value = "School of Business Administration">School of Business Administration</option>
									<option value = "School of Business Administration">School of Business Administration</option>
									<option value = "School of Business and Commerce">School of Business and Commerce</option>
									<option value = "School of Business Technology">School of Business Technology</option>
									<option value = "School of Computer Studies">School of Computer Studies</option>
									<option value = "School of Education">School of Education</option>
									<option value = "School of Hospitality and Tourism Management">School of Hospitality and Tourism Management</option>
									<option value = "School of Midwifery">School of Midwifery</option>
									<option value = "School of Psychology">School of Psychology</option>
								</select>
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

<script>
	const open_nav_icon = document.getElementById("open-nav-icon");
	const close_nav_icon = document.getElementById("close-nav-icon");
	const sidenav_title = document.getElementById("sidenav_title");
	const navtab_texts = document.getElementsByClassName("navtab-text");

	function openNav() {
		document.getElementById("sidenav").style.width = "20rem";
		open_nav_icon.style.display = "none";
		close_nav_icon.style.display = "block";
		sidenav_title.style.display = "block";		

		document.getElementById("sidenav").style.padding = "0 2rem";

		for(let text of navtab_texts) {
			text.style.display = "block";
		}
	}

	function closeNav() {
		if (screen.width > 767) {
			document.getElementById("sidenav").style.width = "7rem";
		}
		else {
			document.getElementById("sidenav").style.width = "0";
			document.getElementById("sidenav").style.padding = "0";
		}
		
		open_nav_icon.style.display = "block";
		close_nav_icon.style.display = "none";
		sidenav_title.style.display = "none";

		for(let text of navtab_texts) {
			text.style.display = "none";
		}
	}
</script>
</html>


