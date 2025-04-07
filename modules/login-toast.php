<button type="button" class="btn btn-primary d-none" id="liveToastBtn">Show live toast</button>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa-solid fa-circle-check text-success fs-4 me-2 pt-1"></i>
                <strong class="me-auto fs-3">Welcome, <?php echo $_SESSION["username"]; ?>!</strong>
                <small class="fs-5">Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body fs-4">
                You are logged in as <?php echo $_SESSION["user_type"]; ?>
            </div>
        </div>
    </div>