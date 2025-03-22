<?php
if (isset($_POST['btnlogin'])) {
	require_once "config.php";

	$sql = "SELECT * FROM user_tbl WHERE username = ? AND password = ? AND status = 'ACTIVE'";

	if ($stmt = mysqli_prepare($link, $sql)) {

		mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);

		if(mysqli_stmt_execute($stmt)) {
			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) > 0) {
				$account = mysqli_fetch_array($result, MYSQLI_ASSOC);

				session_start();

				$_SESSION['username'] = $account['username'];
				$_SESSION['user_type'] = $account['user_type'];
				
				if ($account['user_type'] == "USER") {
					header("location: ticket/dashboard.php");
				}
				else {
					header("location: equipment/equipment-management.php");
				}
				
			} else {
				$_SESSION["incorrect_login"] = $_POST['txtusername'];
			}
		}
	} else {
		echo "<font color = 'red'> Error on the login statement.</font>";
	}
} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Technical Support Management System</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../plugins/bs/bootstrap.min.css">
	<script src="../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
</head>
<body class="login-body ">
	<div class="mask"></div>

	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>


	<div class="container">
		<div class="hero row justify-content-center bg-transparent">
			<div class="login-con col-10 col-md-7 col-lg-4 px-0 bg-white">
				<p class="mb-4 fs-1 text-center">Welcome Back!</p>
				<form class="login-form d-flex flex-column px-5 py-4" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
					
					<label for="txtusername" class="fs-4">Username</label>
					<input type = "text" class="form-control p-2 ps-3 fs-4 mb-4" placeholder="Enter username" name = "txtusername" id = "txtusername">

					<label for="txtusername" class="fs-4">Password</label>
					<div class="input-group mb-4">
						<input type="password" class="form-control  p-2 ps-3 fs-4" placeholder="Enter password" name = "txtpassword" id = "txtpassword">
						<button class="btn btn-outline-secondary px-4" type="button" id="toggle-hide-pass">
							<i class="fa-solid fa-eye" id="visible-pass"></i>
							<i class="fa-regular fa-eye-slash" id="invisible-pass"></i>
						</button>
					</div>
					
					<div class="d-flex justify-content-between mb-1">
						<div class="d-flex">
							<input type="checkbox" class="me-2" name="remember" id="remember" value="false">
							<label for="remember" class="fs-4">Remember me</label>
						</div>
						<a href="#" class="fs-4">Forgot Password?</a>
					</div>

					<div>
						<p class="fs-4 mb-3 text-danger" id="incorrect-login-text"></p>
					</div>

					<input type = "submit" class="btn bg-blue text-light fs-5 py-3 fw-bold" name = "btnlogin" value = "LOGIN">

					<div class="d-flex mt-4 mb-2">
						<hr class="w-100"> 
						<p class="text-nowrap mx-2 fs-5">or login with</p> 
						<hr class="w-100">
					</div>	

					<div class="d-flex justify-content-between other-login gap-3">
						<div class="w-100 py-3 d-flex justify-content-center align-items-center btn border border-secondary">
							<img src="../assets/img/google_logo.png" alt="" style="height: 15px;">
							<p class="mb-0 ms-2 fs-4">Google</p>
						</div>

						<div class="w-100 py-3 d-flex justify-content-center align-items-center btn border border-secondary">
							<img src="../assets/img/fb_logo.png" alt="" style="height: 15px;">
							<p class="mb-0 ms-2 fs-4">Facebook</p>
						</div>
					</div>

					<p class="redirect-signup fs-4 text-secondary text-center mt-4">Doesn't have an account yet? <a href="#">Sign Up</a></p>
				</form>
			</div>
			<div class="img-con d-none d-lg-block col-4 px-0 bg-blue position-relative">
				<div class="login-title px-4">
					<p class="fs-1 mx-3 text-light text-center">Technical Support Management System</p>
				</div>
				<div class="img-wrapper" style="height:100%; width: 100%; overflow: hidden;">
					<img src="../assets/img/Programmer.svg" alt="programmer.svg" style="margin-top:-1rem; scale: 1.1;">
				</div>	
			</div>
		</div>
	</div>
</body>

<?php
	if(isset($_SESSION["incorrect_login"])) {
		echo "<script>document.getElementById('txtusername').value = '" . $_SESSION["incorrect_login"] . "'</script>";
		echo "<script>document.getElementById('incorrect-login-text').innerHTML = 'Incorrect username or password'</script>";
		unset($_SESSION["incorrect_login"]);
	}

?>

<script>
	const toggle_hide_pass = document.getElementById("toggle-hide-pass");
	const visible_pass = document.getElementById("visible-pass");
	const invisible_pass = document.getElementById("invisible-pass");
	const input_pass = document.getElementById("txtpassword");

	toggle_hide_pass.addEventListener('click', () => {
		if (invisible_pass.style.display == "none") {
			visible_pass.style.display =  "none";
			invisible_pass.style.display =  "block";
			txtpassword.type = "password";
		}
		else {
			visible_pass.style.display =  "block";
			invisible_pass.style.display =  "none";
			txtpassword.type = "text";
		}
	})
	console.log(screen.width);
</script>
</html>