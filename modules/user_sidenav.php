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

                <a class="d-flex align-items-center" href="dashboard.php">
                    <i class="fa-solid fa-chart-simple fs-2 text-light text-center" style="width: 5rem;"></i>
                    <p class="navtab-text text-light fs-4 mb-0">Dashboard</p>
                </a>

                <div class="d-flex align-items-center mt-4">
                    <a class="d-flex align-items-center" href="../ticket/ticket-management.php">
                        <i class="icon fa-solid fa-ticket fs-2 text-light text-center" style="width: 5rem;"></i>
                        <p class="navtab-text text-light fs-4 mb-0" style="width: 9rem;">Tickets</p>
                    </a>
                    <i class="fa-solid navtab-text fa-caret-up text-light fs-4 px-3" id="collapse-ticket-trigger" data-bs-toggle="collapse" href="#collapse-ticket" role="button" aria-expanded="false" aria-controls="collapse-ticket"></i>
                </div>

                <div class="collapse show" id="collapse-ticket">
                    <div class="ms-5 ps-2 d-flex flex-column">
                        <a class="text-light fs-5 py-1 ps-4" href="ticket-management.php">All tickets</a>
                        <a class="text-light fs-5 py-1 ps-4" href = "create-ticket.php">Create new ticket</a>
                        <a class="text-light fs-5 py-1 ps-4" href="ticket-management.php?update">Update a ticket</a>
                        <a class="text-light fs-5 py-1 ps-4" href="ticket-management.php?delete">Delete a ticket</a>
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

<script>
    Array.from(document.getElementsByClassName("fa-caret-up")).forEach(element => {
        element.addEventListener('click', (e) => {
            e.target.style.transition = "transform 0.5s";
            

            if (Array.from(e.target.classList).includes("collapsed")) {
                e.target.classList.remove("rotate-0");
                e.target.classList.add("rotate-180");
            }
            else {
                e.target.classList.remove("rotate-180");
                e.target.classList.add("rotate-0");
            }

        })
    });
</script>