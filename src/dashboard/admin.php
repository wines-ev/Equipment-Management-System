<?php	
	include("../config.php");
	require_once "../session-checker.php";

    function get_count_by_status($table, $status, $link) {
        $sql = "SELECT * FROM " . $table . " WHERE status = '" . $status . "'";
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error";
            }
        }
    }

    function get_all_count($table, $link) {
        $sql = "SELECT * FROM " . $table;
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error";
            }
        }
    }

    function get_all_equipment_count($link) {
        $sql = "SELECT * FROM equipment_tbl";
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error";
            }
        }
    }

    function get_all_user_count($link) {
        $sql = "SELECT * FROM user_tbl";
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error";
            }
        }
    }


    function get_monthly_open_ticket_count($month, $year , $link) {
        $sql = "SELECT * FROM ticket_tbl WHERE MONTH(date_created) = " . $month . " AND YEAR(date_created) = " . $year;
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error";
            }
        }
    }

    
    function get_monthly_close_ticket_count($month, $year , $link) {
        $sql = "SELECT * FROM ticket_tbl WHERE status = 'CLOSED' AND MONTH(date_created) = " . $month . " AND YEAR(date_created) = " . $year;
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_num_rows($result);
            } else {
                echo "Error";
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

                <div class="dashboard-grid-con px-5">
                    <div class="grid">
                        <div class="d-flex justify-content-between gap-5 mb-2">

                            <div class="card shadow rounded-3 border-0 w-100">
                                <div>
                                    <p class="fs-4 mb-0 px-3 py-4 rounded-top-3 text-light bg-blue"><?php echo get_all_count("ticket_tbl",  $link) ?> Tickets</p>
                                </div>

                                <a href="../ticket/ticket-management.php">
                                    <div class="d-flex justify-content-between align-items-center text-dark p-3">
                                        <p class="fs-5 mb-0">View details</p>
                                        <i class="fa-solid fa-angle-right fs-5"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="card shadow rounded-3 border-0 w-100">
                                <div>
                                    <p class="fs-4 mb-0 px-3 py-4 rounded-top-3 text-light bg-success"><?php echo get_all_count("equipment_tbl", $link) ?> Equipments</p>
                                </div>

                                <a href="../equipment/equipment-management.php" class="d-flex justify-content-between text-dark p-3">
                                    <p class="fs-5 mb-0">View details</p>
                                    <i class="fa-solid fa-angle-right fs-5"></i>
                                </a>
                            </div>

                            <div class="card shadow rounded-3 border-0 w-100">
                                <div>
                                    <p class="fs-4 mb-0 px-3 py-4 rounded-top-3 text-light bg-danger"><?php echo get_all_count("user_tbl", $link) ?> Users</p>
                                </div>

                                <a href="../account/account-management.php" class="d-flex justify-content-between text-dark p-3">
                                    <p class="fs-5 mb-0">View details</p>
                                    <i class="fa-solid fa-angle-right fs-5"></i>
                                </a>
                            </div>
                        </div>



                        
                        <div class="d-flex flex-wrap gap-5 pt-5 pb-3 mb-5">
                            <div class="d-flex flex-fill justify-content-start p-4 shadow rounded-3 bg-light">
                                <div class="card bg-transparent rounded-0 border-0 me-5" style="width: 20rem;">
                                    <div class="text-center rounded-2" style="background-color: rgb(128,128,128, 0.4) ;">
                                        <i class="fa-solid fa-ticket text-center py-5 text-dark" style="font-size: 10rem;"></i>
                                    </div>
                                    <div class="card-body p-0 pt-4" >
                                        <h5 class="card-title fs-4">Tickets</h5>
                                        <p class="card-text fs-5">
                                            Track, organize, and manage your support tickets all in one place.
                                        </p>
                                        <a href="../ticket/ticket-management.php" class="btn bg-blue text-light fs-4 mb-3 px-3 mt-xxl-3">Manage tickets</a>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="fs-5 mb-0 text-center position-absolute" style="top: 58.5%; left:50%; transform: translate(-50%, -50%)">
                                        <p>
                                            <span class="fw-bold display-3"><?php echo get_all_count("ticket_tbl",  $link) ?></span>
                                            <br> Total
                                        </p>
                                    </div>
                                    
                                    <canvas id="ticket-chart"></canvas>
                                </div>

                                <script>
                                    const ticket_chart = document.getElementById('ticket-chart');

                                    const ticket_data = {
                                        labels: [
                                            'Pending',
                                            'On-Going',
                                            'For Approval',
                                            'Closed'
                                        ],
                                        datasets: [{
                                            label: 'Tickets',
                                            data: [
                                                <?php echo get_count_by_status("ticket_tbl", "PENDING", $link); ?>, 
                                                <?php echo get_count_by_status("ticket_tbl", "ON-GOING", $link); ?>, 
                                                <?php echo get_count_by_status("ticket_tbl", "FOR APPROVAL", $link); ?>, 
                                                <?php echo get_count_by_status("ticket_tbl", "CLOSED", $link); ?>,
                                            ],

                                            backgroundColor: [
                                            'rgb(255, 205, 86)',
                                            'rgb(54, 162, 235)',
                                            'rgb(61, 209, 118)',
                                            'rgb(255, 99, 132)'
                                            ],
                                            hoverOffset: 12
                                        }]
                                    };

                                    const ticket_config = {
                                        type: 'doughnut',
                                        data: ticket_data,
                                    };

                                    new Chart(ticket_chart, ticket_config);
                                </script>

                            </div>

                            <div class="d-flex flex-fill justify-content-start p-4 shadow rounded-3 bg-light">
                                <div class="card border-0 me-5" style="width: 20rem; background-color: rgb(128,128,128, 0.2) ;">
                                    <div class="text-center rounded-2" style="background-color: rgb(128,128,128, 0.4) ;">
                                        <i class="fa-solid fa-computer text-center py-5 text-dark" style="font-size: 10rem;"></i>
                                    </div>
                                    <div class="card-body bg-light p-0 pt-4" >
                                        <h5 class="card-title fs-4">Equipments</h5>
                                        <p class="card-text fs-5">
                                            Track, organize, and manage your equipments all in one place.
                                        </p>
                                        <a href="../equipment/equipment-management.php" class="btn bg-blue text-light fs-4 mb-3 px-3 mt-xxl-3">Manage equipments</a>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <div class="fs-5 mb-0 text-center position-absolute" style="top: 58.5%; left:50%; transform: translate(-50%, -50%)">
                                        <p>
                                            <span class="fw-bold display-3"><?php echo get_all_count("equipment_tbl",  $link) ?></span>
                                            <br> Total
                                        </p>
                                    </div>
                                    
                                    <canvas id="equipment-chart"></canvas>
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
                                                <?php echo get_count_by_status("equipment_tbl", "ON REPAIR", $link); ?>, 
                                                <?php echo get_count_by_status("equipment_tbl", "WORKING", $link); ?>, 
                                                <?php echo get_count_by_status("equipment_tbl", "RETIRED", $link); ?>,
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