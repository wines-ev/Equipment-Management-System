<?php	
	include("../config.php");
	require_once "../session-checker.php";

    function get_ticket_count_by_status($table, $status, $link) {
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

    function get_all_ticket_count($link) {
        $sql = "SELECT * FROM ticket_tbl";
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
                    <div class="grid">
                        <div class="d-flex justify-content-between gap-5 mx-5 mb-5">

                            <div class="card shadow rounded-3 border-0 w-100">
                                <div>
                                    <p class="fs-4 mb-0 px-3 py-4 rounded-top-3 text-light bg-blue"><?php echo get_all_ticket_count($link) ?> Tickets</p>
                                </div>

                                <a href="#">
                                    <div class="d-flex justify-content-between align-items-center text-dark p-3">
                                        <p class="fs-5 mb-0">View details</p>
                                        <i class="fa-solid fa-angle-right fs-5"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="card shadow rounded-3 border-0 w-100">
                                <div>
                                    <p class="fs-4 mb-0 px-3 py-4 rounded-top-3 text-light bg-success"><?php echo get_all_equipment_count($link) ?> Equipments</p>
                                </div>

                                <a href="#" class="d-flex justify-content-between text-dark p-3">
                                    <p class="fs-5 mb-0">View details</p>
                                    <i class="fa-solid fa-angle-right fs-5"></i>
                                </a>
                            </div>

                            <div class="card shadow rounded-3 border-0 w-100">
                                <div>
                                    <p class="fs-4 mb-0 px-3 py-4 rounded-top-3 text-light bg-danger"><?php echo get_all_user_count($link) ?> Users</p>
                                </div>

                                <a href="#" class="d-flex justify-content-between text-dark p-3">
                                    <p class="fs-5 mb-0">View details</p>
                                    <i class="fa-solid fa-angle-right fs-5"></i>
                                </a>
                            </div>

                            

                        </div>

                        <div class="row shadow border-top mx-5 pt-5 pb-3 rounded-3 mb-5">

                            <div class="col-12 col-lg-6 col-xxl-5 d-flex justify-content-start px-0">
                                <div class="card border-0 mx-5" style="width: 20rem; background-color: rgb(128,128,128, 0.2) ;">
                                    <i class="fa-solid fa-ticket text-center py-5 rounded-3 text-dark" style="font-size: 10rem;"></i>
                                    <div class="card-body bg-light p-0 pt-4" >
                                        <h5 class="card-title fs-4">Tickets</h5>
                                        <p class="card-text fs-5">
                                            Track, organize, and manage your support tickets all in one place.
                                        </p>
                                        <a href="../ticket-admin/ticket-management.php" class="btn bg-blue text-light fs-5 mb-3 px-3 mt-xxl-3">Manage tickets</a>
                                    </div>
                                </div>
                                <div>
                                    <canvas id="ticket-chart" style="width: 30rem;"></canvas>
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
                                                <?php echo get_ticket_count_by_status("ticket_tbl", "PENDING", $link); ?>, 
                                                <?php echo get_ticket_count_by_status("ticket_tbl", "ON-GOING", $link); ?>, 
                                                <?php echo get_ticket_count_by_status("ticket_tbl", "FOR APPROVAL", $link); ?>, 
                                                <?php echo get_ticket_count_by_status("ticket_tbl", "CLOSED", $link); ?>,
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

                            <div class="col-12 col-lg-6 col-xxl-7 d-flex justify-content-center px-0">
                                <div>
                                    <div>
                                        <p class="fs-4 mb-4 pb-2 fw-bold">Monthly Ticket Accomplishment</p>
                                    </div>
                                    <canvas id="ticket-line-chart"></canvas>
                                    

                                </div>

                                <script>
                                    const ctx = document.getElementById('ticket-line-chart');

                                    let months = [];
                                    let monthly_open_count = [];
                                    let monthly_close_count = [];

                                    <?php
                                        $month = date('m');
                                        $year = date('Y');
                                        
                                        for ($i = 0; $i <= 5; $i++) {
                                            $dateObj   = DateTime::createFromFormat('!m', $month);
                                            $monthName = $dateObj->format('F');
                                            echo "months.unshift('" . $monthName . "');";
                                            
                                            echo "monthly_open_count.unshift(" . get_monthly_open_ticket_count($month, $year, $link) . ");";
                                            echo "monthly_close_count.unshift(" . get_monthly_close_ticket_count($month, $year, $link) . ");";

                                            $month = sprintf('%02d', $month - 1);

                                            if ($month == "00") {
                                                $month = 12;
                                                $year = sprintf('%4d', $year - 1);
                                            }
                                        }


                                        

                                    ?>

                                    
                                    
                                    const ticket_line_data = {
                                        labels: months,
                                        datasets: [
                                            {
                                                label: 'Opened',
                                                data: monthly_open_count,

                                                fill: false,
                                                borderColor: 'rgb(48, 131, 183)',
                                                backgroundColor: 'white',
                                                tension: 0.1
                                            },
                                            {
                                                label: 'Closed',
                                                data: monthly_close_count,

                                                fill: false,
                                                borderColor: 'rgb(216, 69, 69)',
                                                backgroundColor: 'white',
                                                tension: 0.1
                                            }   
                                        ]
                                    };

                                    const ticket_line_config = {
                                        type: 'line',
                                        data: ticket_line_data,
                                    };

                                    new Chart(ctx, ticket_line_config);
                                </script>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mx-5 mb-4">
                            <p class="fs-4 mb-0">Recent tickets</p>
                        </div>
                        
                        <div class="accout-table-con pb-5 mx-5 fs-5">
                        <?php



                            $sql = "SELECT * FROM ticket_tbl ORDER BY date_created DESC LIMIT 5";

                            if($stmt = mysqli_prepare($link, $sql)) {
                                if (mysqli_stmt_execute($stmt)) {
                                    $result = mysqli_stmt_get_result($stmt);
                                    buildtable($result);
                                }
                            }
                            

                            function buildtable($result) {
                                if(mysqli_num_rows($result) > 0) {
                                    echo "<table id='account-table' class='shadow'>";
                                    
                                    echo "<thead><tr>";
                                    echo "
                                    <th class='fs-4'>Ticket Number</th>
                                    <th class='fs-4'>Problem</th>
                                    <th class='fs-4'>Date</th>
                                    <th class='fs-4'>Time</th>
                                    <th class='fs-4'>Status</th>";
                                    
                                    echo "</tr></thead>";

                                    while($row = mysqli_fetch_array($result)) {
                                        $_SESSION['count'] = intval($_SESSION['count']) + 1;
                                        echo "<tr class='data-row' >";
                                        echo "<td id='ticket-number' class='fs-5'>" . $row['ticket_number'] . "</td>";
                                        echo "<td class='fs-5'>" . $row['problem'] . "</td>";

                                        $date =  explode(' ', $row['date_created']);
                                        echo "<td class='fs-5'>" . $date[0] . "</td>";

                                        $time =  date('h:i:s a', strtotime($date[1]));
                                        echo "<td class='fs-5'>" . $time . "</td>";



                                        echo "<td id='status' class='fs-5'>" . $row['status'] . "</td>";
                                        echo "</tr>";
                                        
                                    }
                                    echo "</table>";
                                }
                                else {
                                    echo "<p class='fs-4'>No rercord/s found.</p>";
                                }
                            }
                        ?>

                        </div>
                    </div>
                </div>

                

                

                

                

            </div>
        </div>
    </div>
</body>
<script src="../../js/script.js"></script>
<script>
    const rows = document.getElementById("account-table").childNodes[1].childNodes;
	
	for (var i = 0; i < rows.length; i++) {
		if (i%2 == 0) {
			rows[i].classList.add("bg-blue-50");
		}
	}
</script>
</html>