const menu = document.getElementById("offcanvasMenu");
const overlay = document.getElementById("overlay");
const openBtn = document.getElementById("menuButton");
const closeBtn = document.getElementById('closeMenuButton')

function openMenu() {
    menu.classList.add("open");
    overlay.classList.add("show");
}

function closeMenu() {
    menu.classList.remove("open");
    overlay.classList.remove("show");
}

openBtn.addEventListener("click", openMenu);
closeBtn.addEventListener("click", closeMenu);
overlay.addEventListener("click", closeMenu);
