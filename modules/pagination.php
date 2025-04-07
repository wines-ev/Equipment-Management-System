<?php
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;

    $new_query_string = http_build_query(array_merge($_GET,array('page' => null)));

    $suffix = (!empty($new_query_string)) ? "&" : "";

    $url = htmlspecialchars($_SERVER["PHP_SELF"]) . "?" . $new_query_string . $suffix;



    
    if ($page == 1) {
        // if in page 1, disable previous button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='" . $url ."page=" . $page - 1 . "'>Previous</a></li>";
    }
    else {
        // else (not in page 1), enable previous button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='" . $url ."page=" . $page - 1 . "'>Previous</a></li>";
    }

    

    if ($page - 2 > 0 && intval($_SESSION['excess']) == 0) {
        // if in last page (no more excess) and there are 2 previous pages, print the left most page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='" . $url ."page=" . $page - 2 . "'>" . $page - 2 . "</a></li>";
    }
    
    if ($page - 1 > 0) {
        // if on page 2 or higher, print previous page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='" . $url ."page=" . $page - 1 . "'>" . $page - 1 . "</a></li>";
    }

    // print the active page
    echo "<li class='page-item active fs-4 text-dark'><a class='page-link px-3 fs-4 text-light' href='" . $url ."page=" . $page . "'>" . $page . "</a></li>";

    if (intval($_SESSION['excess']) > 0) {
        // if there is next page (has excess), print the next page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='" . $url ."page=" . $page + 1 . "'>" . $page + 1 . "</a></li>";
    }
    

    if ($page - 1 <= 0 && intval($_SESSION['excess']) > 10) {
        // if in first page and there is 2 next pages, print the right most page
        echo "<li class='page-item'><a class='page-link px-3 fs-4 text-dark' href='" . $url ."page=" . $page + 2 . "'>" . $page + 2 . "</a></li>";
    }

    if (intval($_SESSION['excess']) == 0) {
        // if in last page (no more excess), disable next button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark disabled' href='" . $url ."page=" . $page + 1 . "'>Next</a></li>";
    }
    else {
        // else, enable next button
        echo "<li class='page-item'><a class='page-link fs-4 text-dark' href='" . $url ."page=" . $page + 1 . "'>Next</a></li>";
    }
    

?>