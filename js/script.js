
const open_nav_icon = document.getElementById("open-nav-icon");
const close_nav_icon = document.getElementById("close-nav-icon");
const sidenav_title = document.getElementById("sidenav_title");
const navtab_texts = document.getElementsByClassName("navtab-text");

function openNav() {
    document.getElementById("sidenav").style.width = "20rem";
    open_nav_icon.style.display = "none";
    close_nav_icon.style.display = "block";
    sidenav_title.style.display = "block";		

    document.getElementById("sidenav").style.padding = "0 2rem";

    document.getElementById("sidenav").classList.remove("align-items-center");

    document.getElementById("sidenav-header").classList.remove("justify-content-center");
    document.getElementById("sidenav-header").classList.add("justify-content-between");

    Array.from(document.getElementsByClassName("icon")).forEach(element => {
        element.classList.remove("icon-fix");
    });

    Array.from(document.getElementsByClassName("collapse")).forEach(element => {
        element.classList.add("show");
    });
    
    for(let text of navtab_texts) {
        text.style.display = "block";
    }
}

function closeNav() {
    if (screen.width > 767) {
        document.getElementById("sidenav").style.width = "7rem";
    }
    else {
        document.getElementById("sidenav").style.width = "0";
        document.getElementById("sidenav").style.padding = "0";
    }

    document.getElementById("sidenav").classList.add("align-items-center");

    document.getElementById("sidenav-header").classList.remove("justify-content-between");
    document.getElementById("sidenav-header").classList.add("justify-content-center");

    
    Array.from(document.getElementsByClassName("icon")).forEach(element => {
        element.classList.add("icon-fix");
    });

    Array.from(document.getElementsByClassName("collapse")).forEach(element => {
        element.classList.remove("show");
    });





    
    open_nav_icon.style.display = "block";
    close_nav_icon.style.display = "none";
    sidenav_title.style.display = "none";

    for(let text of navtab_texts) {
        text.style.display = "none";
    }
}



