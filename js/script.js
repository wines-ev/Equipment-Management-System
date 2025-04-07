
const open_nav_icon = document.getElementById("open-nav-icon");
const close_nav_icon = document.getElementById("close-nav-icon");
const au_logo = document.getElementById("au_logo");
const navtab_texts = document.getElementsByClassName("navtab-text");

function openNav() {
    document.getElementById("sidenav").style.width = "20rem";

    au_logo.style.width = "10rem";
    au_logo.style.height = "10rem";
    open_nav_icon.style.display = "none";
    close_nav_icon.style.display = "block";

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





    au_logo.style.width = "4rem";
    au_logo.style.height = "4rem";
    open_nav_icon.style.display = "block";
    close_nav_icon.style.display = "none";

    for(let text of navtab_texts) {
        text.style.display = "none";
    }
}



const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementById('liveToast')

if (toastTrigger) {
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
  toastTrigger.addEventListener('click', () => {
    toastBootstrap.show()
  })
}