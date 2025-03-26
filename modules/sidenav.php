<div>
    <div id="sidenav" class="sidenav position-relative bg-blue z-1 overflow-hidden">
        <div class="d-flex flex-column justify-content-between h-100 pb-5">
            <div class="d-flex flex-column gap-4">
                <div id="sidenav-header" class="d-flex align-items-center justify-content-between w-100 mb-5">
                    <div class="d-flex align-items-center" style="height: 6rem;">
                        <img class="au_logo" src="../../assets/img/au_logo.png" alt="" style="width: 4rem; height: 4rem;">
                        <p id="sidenav_title" class="fs-2 ms-3 mb-0 text-light">TSMS</p>
                    </div>
                    <span id="close-nav-icon" class="text-light fs-2" style="cursor:pointer" onclick="closeNav()">&#9776;</span>
                </div>

                <?php
                    if ($_SESSION['user_type'] == "ADMINISTRATOR") {
                        $dashboard = "../dashboard/admin.php";
                    } 
                    else if ($_SESSION['user_type'] == "TECHNICAL") {
                        $dashboard = "../dashboard/tech.php";
                    }
                    else {
                        $dashboard = "../dashboard/user.php";
                    }
                ?>

                <a class="d-flex align-items-center" href="<?php echo $dashboard; ?>">
                    <i class="fa-solid fa-chart-simple fs-2 text-light text-center" style="width: 5rem;"></i>
                    <p class="navtab-text text-light fs-4 mb-0">Dashboard</p>
                </a>

                <?php
                    if ($_SESSION['user_type'] == "ADMINISTRATOR") {
                ?>
                

                <div class="d-flex align-items-center mt-4">
                    <a class="d-flex align-items-center" href="../account/account-management.php">
                        <i class="icon fa-solid fa-users fs-2 text-light text-center" id="account-icon" style="width: 5rem;"></i>
                        <p class="navtab-text text-light fs-4 mb-0" style="width: 9rem;">Accounts</p> 
                    </a>
                </div>
 
          

                <?php
                    }

                ?>


                <div class="d-flex align-items-center mt-4">
                    <a class="d-flex align-items-center" href="../equipment/equipment-management.php">
                        <i class="icon fa-solid fa-computer fs-2 text-light text-center" id="equipment-icon" style="width: 5rem;"></i>
                        <p class="navtab-text text-light fs-4 mb-0" style="width: 9rem;">Equipments</p>
                    </a>
                </div>



                <?php
                    if ($_SESSION['user_type'] == "ADMINISTRATOR") {
                        $ticket_path = "../ticket-admin/";
                    } 
                    else if ($_SESSION['user_type'] == "TECHNICAL") {
                        $ticket_path = "../ticket-tech/";
                    }
                    else {
                        $ticket_path = "../ticket/";
                    }
                ?>

                <div class="d-flex align-items-center mt-4">
                    <a class="d-flex align-items-center" href="<?php echo $ticket_path ?>ticket-management.php">
                        <i class="icon fa-solid fa-ticket fs-2 text-light text-center" style="width: 5rem;"></i>
                        <p class="navtab-text text-light fs-4 mb-0" style="width: 9rem;">Tickets</p>
                    </a>
                </div>



                
            </div>
            <div>
                <a class="d-flex align-items-center" style="bottom: 2rem;" href="../logout.php">
                    <i class="fa-solid fa-door-open fs-2 text-light text-center" style="width: 5rem;"></i>
                    <p class="navtab-text text-light fs-4 mb-0">Logout</p>
                </a>
            </div>
        </div>
    </div>
</div>