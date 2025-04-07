<?php	
	include("../config.php");
	include "../session-checker.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?php include ("../../modules/login-toast.php") ?>
    <div class="container-fluid mx-0 px-0">
        <div class="accounts-hero d-flex align-items-start">
            <?php include ("../../modules/sidenav.php") ?>
            
            <div class="accounts-con">
                <?php include ("../../modules/header.php") ?>

                <div class="d-flex justify-content-between mx-5 mb-4 pb-2">
                    <p class="fs-4 mb-0">Dashboard</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" class="d-flex gap-3">
                        <div class="input-group flex-fill" style="width: 30rem;">
                            <input type="text" class="form-control fs-4 py-2" name="txtsearch" placeholder="Search something">
                            <button class="btn bg-secondary text-light btn-outline-secondary fs-4 px-2" type="submit" name="btnsearch">
                                <i class="fa-solid fa-magnifying-glass px-3"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid mx-5">
                    <div class="row">
                        <div class="col-3">
                            <div class="card border-secondary-subtle" style="width: 20rem; background-color: rgb(128,128,128, 0.2) ;">
                                <i class="fa-solid fa-ticket text-center py-5 text-dark" style="font-size: 10rem;"></i>
                                <div class="card-body bg-light rounded-bottom" >
                                    <h5 class="card-title fs-4">Tickets</h5>
                                    <p class="card-text fs-5">
                                        Track, organize, and manage your support tickets all in one place.
                                    </p>
                                    <a href="../ticket/ticket-management.php" class="btn btn-primary fs-5 mt-3">Manage tickets</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="card border-secondary-subtle" style="width: 20rem; background-color: rgb(128,128,128, 0.2) ;">
                                <i class="fa-solid fa-ticket text-center py-5 text-dark" style="font-size: 10rem;"></i>
                                <div class="card-body bg-light rounded-bottom" >
                                    <h5 class="card-title fs-4">Tickets</h5>
                                    <p class="card-text fs-5">
                                        Track, organize, and manage your equipments all in one place.
                                    </p>
                                    <a href="../equipment/equipment-management.php" class="btn btn-primary fs-5 mt-3">View equipments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-5 flex-fill position-relative">
                    <p id="footer-text" class="fs-5">Copyright 2025, Evander Villareal Wines</p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../../js/script.js"></script>
<?php
	if (isset($_SESSION["just_logged_in"])) {
		echo "<script>document.getElementById('liveToastBtn').click();</script>";
	}
    unset($_SESSION["just_logged_in"]);
?>

</html>