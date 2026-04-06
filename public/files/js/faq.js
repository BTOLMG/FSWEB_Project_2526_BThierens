const infoButtons = document.querySelectorAll(".extra-info-btn");

infoButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
        toggleContent(btn);
    });
});

const sidebarLinks = document.querySelectorAll(".sidebar-content a");
var prevTargetBtn = null;

sidebarLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
        e.preventDefault();

        const targetId = link.getAttribute("href").substring(1);
        const targetBtn = document.getElementById(targetId);

        if (targetBtn) {
            if (!targetBtn.classList.contains("show-extra-info-btn")) {
                toggleContent(targetBtn);
            }

            targetBtn.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });
});

function toggleContent(btn) {
    if (prevTargetBtn) {
        const dataElementId = prevTargetBtn.id.replace("-btn", "");
        const dataElement = document.getElementById(dataElementId);

        prevTargetBtn.classList.toggle("show-extra-info-btn");
        if (dataElement) {
            dataElement.classList.toggle("show-extra-info");
        }
    }

    const dataElementId = btn.id.replace("-btn", "");
    const dataElement = document.getElementById(dataElementId);

    btn.classList.toggle("show-extra-info-btn");
    if (dataElement) {
        dataElement.classList.toggle("show-extra-info");
    }

    prevTargetBtn = btn;
}
