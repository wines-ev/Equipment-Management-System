<?php
require_once "../config.php";
include ("../session-checker.php");
if(isset($_POST['btnsubmit']))
{
	$sql = "SELECT * FROM user_tbl WHERE username = ?";
	if($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
		if(mysqli_stmt_execute($stmt))
		{
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) == 0)
			{
				//insert
				
				$sql = "INSERT INTO user_tbl values(?, ?, ?, ?, ?, ?);";

				if ($stmt = mysqli_prepare($link, $sql)) {
					$username = $_POST['txtusername'];
					$password = $_POST['txtpassword'];
					$usertype = $_POST['cmbtype'];
					$status = "ACTIVE";
					$createdby = $_SESSION['username'];
					$datecreated = date("m/d/Y");

					mysqli_stmt_bind_param($stmt, "ssssss", $username, $password, $usertype, $status, $createdby, $datecreated);


					if (mysqli_stmt_execute($stmt)) {
						header("location: account-management.php");


					}
					else {
						echo "Error inserting account";
					}
				}
			}
			else
			{
				echo "Username already in use.";
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
	<title>Create New Account</title>
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
					<p class="fs-4 mb-0">Accounts / Create account</p>
				</div>

				<div class="container">
					<div class="mx-auto bg-white border p-5 rounded-4 mt-5 w-50">
						<p class="fs-4 mb-5">Fill up this form and submit to create a new account</p>
						<form acion = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Username</span>
								<input class="form-control fs-4" type="text" name = "txtusername" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Password</span>
								<input class="form-control fs-4" type="password" name = "txtpassword" required>
							</div>

							<div class="input-group mb-3">
								<span class="input-group-text fs-4 py-3" id="basic-addon1" style="width: 35%;">Account Type</span>
								<select class="form-select fs-4" name = "cmbtype" id = "cmbtype" required>
									<option value = "">--Select Account Type--</option>
									<option value = "ADMINISTRATOR">Administrator</option>
									<option value = "TECHNICAL">Technical</option>
									<option value = "STAFF">Staff</option>
								</select>
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


