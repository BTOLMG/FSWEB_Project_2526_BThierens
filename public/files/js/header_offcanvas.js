const menu = document.getElementById("offcanvasMenu");
const overlay = document.getElementById("overlay");
const openBtn = document.getElementById("menuButton");

function openMenu() {
    menu.classList.add("open");
    overlay.classList.add("show");
}

function closeMenu() {
    menu.classList.remove("open");
    overlay.classList.remove("show");
}

openBtn.addEventListener("click", openMenu);
overlay.addEventListener("click", closeMenu);
