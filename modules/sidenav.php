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

                <a class="d-flex align-items-center mb-4" href="#">
                    <i class="fa-solid fa-chart-simple fs-2 text-light text-center" style="width: 5rem;"></i>
                    <p class="navtab-text text-light fs-4 mb-0">Dashboard</p>
                </a>

                <a class="d-flex align-items-center mb-4" href="../equipment/equipment-management.php">
                    <i class="fa-solid fa-computer fs-2 text-light text-center" style="width: 5rem;"></i>
                    <p class="navtab-text text-light fs-4 mb-0">
                        Equipments
                    </p>
                </a>
                
                <a class="d-flex align-items-center mb-4" href="../account/account-management.php">
                    <i class="fa-solid fa-users fs-2 text-light text-center" style="width: 5rem;"></i>
                    <p class="navtab-text text-light fs-4 mb-0" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Accounts
                    </p>
                </a>
                <div class="collapse" id="collapseExample">
                    <div class="ms-3 d-flex flex-column">
                        <a class="text-light" href="#">All accounts</a>
                        <a class="text-light" href="#">Administrator</a>
                        <a class="text-light" href="#">Technical</a>
                        <a class="text-light" href="#">Staff</a>
                        <a class="text-light" href = "create-account.php">Create new account</a>
                    </div>
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