<div class="account-header bg-white d-flex align-items-center py-1 mb-4 shadow">
    <div class="d-flex w-100 justify-content-between align-items-center px-5 py-2">
        <div class="d-flex align-items-center">
            <span id="open-nav-icon" class="me-5 fs-2" style="font-size:2rem; cursor:pointer;" onclick="openNav()">&#9776;</span>
            <div>
                <p class="fs-1 mb-0">Ticket Management System</p>
            </div>
        </div>

        <div class="d-flex gap-3 icons">
            <button class="btn bg-grey-50 rounded-circle" style="width: 4rem; height: 4rem;">
                <i class="fa-solid fa-circle-info fs-2 text-dark"></i>
            </button>
            <button class="btn bg-grey-50 rounded-circle" style="width: 4rem; height: 4rem;">
                <i class="fa-solid fa-comment fs-2 text-dark"></i>
            </button>
            <button class="btn bg-grey-50 rounded-circle" style="width: 4rem; height: 4rem;">
                <i class="fa-solid fa-bell fs-2 text-dark"></i>
            </button>
            
            <div class="d-flex gap-3 align-items-center text-end ms-3">
                <div>
                    <p class="mb-0 fs-4"><?php echo $_SESSION["username"] ?></p>
                    <p class="mb-0"><?php echo $_SESSION["user_type"] ?></p>
                </div>
                <button class="btn bg-grey-50 rounded-circle" style="width: 4rem; height: 4rem;">
                    <i class="fa-solid fa-user fs-2 text-dark"></i>
                </button>
            </div>
        </div>
    </div>
</div>