
const buttonCookies = document.getElementById("cookies-extra-info-btn");
const dataCookies = document.getElementById("cookies-extra-info");

const buttonPrivacy = document.getElementById("privacy-extra-info-btn");
const dataPrivacy = document.getElementById("privacy-extra-info");

const buttonToegankelijkheid = document.getElementById("toegankelijkheid-extra-info-btn");
const dataToegankelijkheid = document.getElementById("toegankelijkheid-extra-info");

function toggleData(btn, data) {
    btn.classList.toggle("show-extra-info-btn")
    data.classList.toggle("show-extra-info");
}

buttonCookies.addEventListener("click", () => {toggleData(buttonCookies, dataCookies);});
buttonPrivacy.addEventListener("click", () => {toggleData(buttonPrivacy, dataPrivacy);});
buttonToegankelijkheid.addEventListener("click", () => {toggleData(buttonToegankelijkheid, dataToegankelijkheid);});
