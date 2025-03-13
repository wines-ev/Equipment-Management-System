<?php
	require_once "../config.php";
	include "../session-checker.php";

	

	if (isset($_POST["btnsubmit"])) {

		$sql = "UPDATE user_tbl SET password = ?, user_type = ?, status = ? WHERE username = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "ssss", $_POST['txtpassword'], $_POST['cmbtype'], $_POST['rbstatus'], $_GET['username']);

			if (mysqli_stmt_execute($stmt)) {
				$sql = "INSERT INTO logs_tbl (datelog, timelog, action, module, performedto, performedby) VALUE(?, ?, ?, ?, ?, ?)";
					if ($stmt = mysqli_prepare($link, $sql)) {
						$date = date("d/m/Y");
						$time = date("h:i:sa");
						$action = "update";
						$module = "account-management";
						mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_GET['username'], $_SESSION['username']);


						if (mysqli_stmt_execute($stmt)) {
							echo "User account updated";
							$_SESSION["updated"] = true;
							$_SESSION["updated-account"] = $_GET['username'];
							header("location: account-management.php");
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
		if (isset($_GET["username"]) && !empty($_GET["username"])) {
			$sql = "SELECT * FROM user_tbl WHERE username = ?";
			if ($stmt = mysqli_prepare($link, $sql)) {
				mysqli_stmt_bind_param($stmt, "s", $_GET["username"]);

				if (mysqli_stmt_execute($stmt)) {
					$result = mysqli_stmt_get_result($stmt);
					$account = mysqli_fetch_array($result);
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
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
</head>
<body>
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
							<div class="input-group mb-4">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Username</span>
								<input class="form-control fs-4" type="text" value="<?php echo $account['username']; ?>" disabled>
							</div>

							<div class="input-group mb-4">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Password</span>
								<input class="form-control fs-4" type="password" name="txtpassword" value="<?php echo $account['password']; ?>">
							</div>
							
							<div class="input-group mb-4">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Change Usertype to</span>
								<select class="form-select fs-4" name="cmbtype" id="cmbtype" required>
									<option value="ADMINISTRATOR" <?php if ($account['user_type'] == "ADMINISTRATOR") {echo "selected";} ?>>Administrator</option>
									<option value="TECHNICAL" <?php if ($account['user_type'] == "TECHNICAL") {echo "selected";} ?>>Technical</option>
									<option value="STAFF" <?php if ($account['user_type'] == "STAFF") {echo "selected";} ?>>Staff</option>
								</select>
							</div>

							<div class="input-group mb-4">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Status</span>
								<div class="input-group-text fs-4 bg-white" style="width: 65%;">
									<?php 
										$status = $account['status'];

										if ($status == 'ACTIVE') {		
									?>
										<div class="form-check form-check-inline me-5">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus1" value="ACTIVE" checked>
											<label class="form-check-label" for="inlineRadio1">Active</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus2" value="INACTIVE">
											<label class="form-check-label" for="inlineRadio1">Inactive</label>
										</div>

									<?php
										}
										else {
									?>
										<div class="form-check form-check-inline me-5">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus1" value="ACTIVE">
											<label class="form-check-label" for="inlineRadio1">Active</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="rbstatus" id="rbstatus2" value="INACTIVE" checked>
											<label class="form-check-label" for="inlineRadio1">Inactive</label>
										</div>

									<?php
										}
									?>
								</div>
								
							</div>


				
							

							<div class="d-flex mt-5 gap-3 justify-content-end">
								<a class="btn bg-secondary text-light fs-4 px-5" href="account-management.php">Cancel</a>
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
		if (screen.width > 767 && screen.width < 1280) {
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

	const rows = document.getElementById("account-table").childNodes[0].childNodes;
	
	for (var i = 0; i < rows.length; i++) {
		if (i%2 == 0) {
			rows[i].classList.add("bg-blue-50");
		}
	}
</script>
</html>