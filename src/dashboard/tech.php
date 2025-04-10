<?php	
	include("../config.php");
	require_once "../session-checker.php";
    
    function get_count($table, $status, $link) {
        $sql = "SELECT * FROM " . $table . " WHERE status = '" . $status . "'";
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error inserting ticket";
            }
        }
    }

    function get_ticket_count($table, $status, $link) {
        $sql = "SELECT * FROM " . $table . " WHERE status = '" . $status . "' AND assigned_to = '" . $_SESSION['username'] ."'";
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
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
    <title>Dashboard</title>
    
	<link rel="stylesheet" href="../../plugins/bs/bootstrap.min.css">
	<script src="../../plugins/bs/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/acb62c1ffe.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

                <div class="dashboard-grid-con">
                    <div class="grid" style="overflow: hidden;">
                        <div class="d-flex gap-xxl-5 mx-5">

                            <div class="flex-fill d-flex justify-content-around border py-5">
                                <div class="card border-0 mx-4" style="width: 20rem; background-color: rgb(128,128,128, 0.2) ;">
                                    <i class="fa-solid fa-computer text-center py-5 text-dark" style="font-size: 10rem;"></i>
                                    <div class="card-body bg-light p-0 pt-4" >
                                        <h5 class="card-title fs-4">Equipments</h5>
                                        <p class="card-text fs-5">
                                            Track, organize, and manage your equipments all in one place.
                                        </p>
                                        <a href="../equipment/equipment-management.php" class="btn btn-primary fs-5 mb-3">Manage Equipments</a>
                                    </div>
                                </div>
                                <div>
                                    <canvas id="equipment-chart" style="width: 30rem;"></canvas>
                                </div>

                                <script>
                                    const equipment_chart = document.getElementById('equipment-chart');

                                    const equipment_data = {
                                        labels: [
                                            'On Repair',
                                            'Working',
                                            'Retired'
                                        ],
                                        datasets: [{
                                            label: 'Equipments',
                                            data: [
                                                <?php echo get_count("equipment_tbl", "ON REPAIR", $link); ?>, 
                                                <?php echo get_count("equipment_tbl", "WORKING", $link); ?>, 
                                                <?php echo get_count("equipment_tbl", "RETIRED", $link); ?>,
                                            ],

                                            backgroundColor: [
                                            'rgb(255, 205, 86)',
                                            'rgb(54, 162, 235)',
                                            'rgb(255, 99, 132)'
                                            ],
                                            hoverOffset: 4
                                        }]
                                    };

                                    const equipment_config = {
                                        type: 'doughnut',
                                        data: equipment_data,
                                    };

                                    new Chart(equipment_chart, equipment_config);
                                </script>
                            </div>

                            <div class="flex-fill d-flex justify-content-around border py-5">
                                <div class="card border-0 mx-4" style="width: 20rem; background-color: rgb(128,128,128, 0.2) ;">
                                    <i class="fa-solid fa-ticket text-center py-5 text-dark" style="font-size: 10rem;"></i>
                                    <div class="card-body bg-light p-0 pt-4" >
                                        <h5 class="card-title fs-4">Tickets</h5>
                                        <p class="card-text fs-5">
                                            Track, organize, and manage your support tickets all in one place.
                                        </p>
                                        <a href="../ticket/ticket-management.php" class="btn btn-primary fs-5 mb-3">Manage tickets</a>
                                    </div>
                                </div>
                                <div>
                                    <canvas id="ticket-chart" style="width: 30rem;"></canvas>
                                </div>

                                <script>
                                    const ctx = document.getElementById('ticket-chart');

                                    const ticket_data = {
                                        labels: [
                                            'Pending',
                                            'On-going',
                                            'For approval',
                                            'Approved',
                                            'Closed'
                                        ],
                                        datasets: [{
                                            label: 'Tickets',
                                            data: [
                                                <?php echo get_ticket_count("ticket_tbl", "PENDING", $link); ?>, 
                                                <?php echo get_ticket_count("ticket_tbl", "ON-GOING", $link); ?>, 
                                                <?php echo get_ticket_count("ticket_tbl", "FOR APPOVAL", $link); ?>, 
                                                <?php echo get_ticket_count("ticket_tbl", "APPROVED", $link); ?>, 
                                                <?php echo get_ticket_count("ticket_tbl", "CLOSED", $link); ?>,
                                            ],

                                            backgroundColor: [
                                            'rgb(255, 205, 86)',
                                            'rgb(54, 162, 235)',
                                            'rgb(255, 99, 132)',
                                            'rgb(193, 140, 41)',
                                            'rgb(98, 36, 110)'
                                            ],
                                            hoverOffset: 4
                                        }]
                                    };

                                    const ticket_config = {
                                        type: 'doughnut',
                                        data: ticket_data,
                                    };

                                    new Chart(ctx, ticket_config);
                                </script>
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