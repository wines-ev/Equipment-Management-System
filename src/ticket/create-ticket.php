<?php
require_once "../config.php";
include ("../session-checker.php");

$ticket_number = date("Ymdhis");

if(isset($_POST['btnsubmit'])) {

	$sql = "INSERT INTO ticket_tbl values(?, ?, ?, 'PENDING', ?, ?, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL');";

	if ($stmt = mysqli_prepare($link, $sql)) {
		$datecreated = date("Y-m-d H:i:s");

		mysqli_stmt_bind_param($stmt, "sssss", $ticket_number, $_POST['cmb_problem'], $_POST['txt_details'], $_SESSION['username'], $datecreated);

		if (mysqli_stmt_execute($stmt)) {
			header("location: ticket-management.php");
			$_SESSION["ticket-added"] = $ticket_number;
		} else {
			echo "Error inserting ticket";
		}

		
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create New Account</title>
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container-fluid mx-0 px-0">
		<div class="accounts-hero d-flex align-items-start">
			<?php include ("../../modules/user_sidenav.php") ?>

			<div class="accounts-con">
				<?php include ("../../modules/header.php") ?>
				
				<div class="d-flex justify-content-between mx-5">
					<p class="fs-4 mb-0">Tickets / Create ticket</p>
				</div>

				<div class="container">
					<div class="mx-auto bg-white border p-5 rounded-4 mt-5 w-50">
						<p class="fs-4 mb-5">Fill up this form and submit to create a new ticket</p>
						<form acion = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Ticket number</span>
								<input class="form-control fs-4" type="text" name = "txt_ticket_number" value="<?php echo $ticket_number ?>" disabled>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Account Type</span>
								<select class="form-select fs-4" name = "cmb_problem" id = "cmb_problem" required>
									<option value = "">Select Problem</option>
									<option value = "Hardware">Hardware</option>
									<option value = "Software">Software</option>
									<option value = "Connection">Connection</option>
								</select>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Details</span>
								<textarea class="form-control fs-4" name = "txt_details" rows="4" required> </textarea>
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


