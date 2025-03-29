<?php
    $page = 1;

    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    
    if ($page == 1) {
        // if in page 1, disable previous button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='ticket-management.php?page=" . $page - 1 . "'>Previous</a></li>";
    }
    else {
        // else (not in page 1), enable previous button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='ticket-management.php?page=" . $page - 1 . "'>Previous</a></li>";
    }

    

    if ($page - 2 > 0 && intval($_SESSION['excess']) == 0) {
        // if in last page (no more excess) and there are 2 previous pages, print the left most page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='ticket-management.php?page=" . $page - 2 . "'>" . $page - 2 . "</a></li>";
    }
    
    if ($page - 1 > 0) {
        // if on page 2 or higher, print previous page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='ticket-management.php?page=" . $page - 1 . "'>" . $page - 1 . "</a></li>";
    }

    // print the active page
    echo "<li class='page-item active fs-4 text-dark'><a class='page-link px-3 fs-4 text-light' href='ticket-management.php?page=" . $page . "'>" . $page . "</a></li>";

    if (intval($_SESSION['excess']) > 0) {
        // if there is next page (has excess), print the next page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='ticket-management.php?page=" . $page + 1 . "'>" . $page + 1 . "</a></li>";
    }
    

    if ($page - 1 <= 0 && intval($_SESSION['excess']) > 10) {
        // if in first page and there is 2 next pages, print the right most page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='ticket-management.php?page=" . $page + 2 . "'>" . $page + 2 . "</a></li>";
    }

    if (intval($_SESSION['excess']) == 0) {
        // if in last page (no more excess), disable next button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='ticket-management.php?page=" . $page + 1 . "'>Next</a></li>";
    }
    else {
        // else, enable next button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='ticket-management.php?page=" . $page + 1 . "'>Next</a></li>";
    }
    

?>