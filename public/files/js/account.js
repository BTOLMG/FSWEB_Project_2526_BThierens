function filterLijst(input, lijstId, geenId) {
    const term = input.value.trim().toLowerCase();
    const items = document.querySelectorAll(`#${lijstId} .overzicht-item`);
    const geenEl = document.getElementById(geenId);
    let hits = 0;
    items.forEach((item) => {
        const match = !term || item.dataset.zoekterm.includes(term);
        item.style.display = match ? "" : "none";
        if (match) hits++;
    });
    geenEl.classList.toggle("hidden", hits > 0);
}

function toggleUren(checkbox) {
    const grid = checkbox.closest(".opening-grid");
    const allLabels = [...grid.querySelectorAll(".opening-toggle input")];
    const idx = allLabels.indexOf(checkbox);
    const timeInputs = [...grid.querySelectorAll(".opening-time input")];
    const van = timeInputs[idx * 2];
    const tot = timeInputs[idx * 2 + 1];
    const open = checkbox.checked;
    van.disabled = !open;
    tot.disabled = !open;
    if (!open) {
        van.value = "";
        tot.value = "";
    }

    van.required = checkbox.checked;
    tot.required = checkbox.checked;
}

document.querySelectorAll('input[type="time"]').forEach((input) => {
    input.addEventListener("change", () => {
        const parent = input.closest(".opening-grid");
        const van = parent.querySelector('input[name*="[van]"]');
        const tot = parent.querySelector('input[name*="[tot]"]');

        if (van.value && tot.value && van.value >= tot.value) {
            tot.setCustomValidity("Eindtijd moet later zijn dan starttijd");
        } else {
            tot.setCustomValidity("");
        }
    });
});

//https://www.youtube.com/watch?v=vOPr5k_SGVA
document
    .getElementById("geocode-btn")
    .addEventListener("click", async function () {
        const straatnaam = document.getElementById("straatnaam").value.trim();
        const huisnummer = document.getElementById("huisnummer").value.trim();
        const postcode = document.getElementById("postcode").value.trim();
        const gemeente = document.getElementById("gemeente").value.trim();

        const status = document.getElementById("geo-status");

        if (!straatnaam && !gemeente) {
            status.textContent = "Vul minstens een straatnaam of gemeente in.";
            status.className = "geo-status geo-error";
            return;
        }

        const query = [straatnaam, huisnummer, postcode, gemeente, "België"]
            .filter(Boolean)
            .join(", ");

        status.textContent = "Coördinaten ophalen …";
        status.className = "geo-status geo-loading";
        this.disabled = true;

        try {
			fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
				.then(data => data.json())
				.then(data => {
					if (data.length === 0) {
						status.textContent = 'Adres niet gevonden. Controleer de velden en probeer opnieuw.';
                        status.className = "geo-status geo-error";
					} else {
						document.getElementById("lat").value = parseFloat(
                            data[0].lat,
                        ).toFixed(6);
                        document.getElementById("lon").value = parseFloat(
                            data[0].lon,
                        ).toFixed(6);

						const subStatus = data[0].display_name.split(',');
						geoStatus = subStatus[0] + ',' + subStatus[1] + ',' + subStatus[2] + ',' + subStatus[6];

                        status.textContent = "✓ Gevonden: " + geoStatus;
                        status.className = "geo-status geo-success";
					}
				});
        } catch (e) {
            status.textContent = "Verbindingsfout. Probeer later opnieuw.";
            status.className = "geo-status geo-error";
        } finally {
            this.disabled = false;
        }
    });

function toggleRubriekDropdown() {
    const dropdown = document.getElementById("rubriek-dropdown");
    const trigger = document.getElementById("rubriek-trigger");
    const zoek = document.getElementById("rubriek-zoek");

    const isOpen = dropdown.classList.toggle("open");
    trigger.classList.toggle("open", isOpen);

    if (isOpen) {
        zoek.focus();
        zoek.value = "";
        filterRubrieken("");
    }
}

document.addEventListener("click", function (e) {
    const wrap = document.getElementById("rubriek-dropdown-wrap");
    if (wrap && !wrap.contains(e.target)) {
        document.getElementById("rubriek-dropdown").classList.remove("open");
        document.getElementById("rubriek-trigger").classList.remove("open");
    }
});

function toggleRubriek(id, naam) {
    const optionEl = document.querySelector(`.rubriek-option[data-id="${id}"]`);
    const inputEl = document.getElementById(`rubriek-input-${id}`);
    const isAan = optionEl.classList.toggle("selected");

    inputEl.checked = isAan;

    const chipsEl = document.getElementById("rubriek-chips");
    if (isAan) {
        const chip = document.createElement("span");
        chip.className = "rubriek-chip";
        chip.dataset.id = id;
        chip.innerHTML = `${naam}<button type="button" onclick="verwijderRubriek('${id}')"><i class="fa fa-xmark"></i></button>`;
        chipsEl.appendChild(chip);
    } else {
        chipsEl.querySelector(`.rubriek-chip[data-id="${id}"]`)?.remove();
    }
}

function verwijderRubriek(id) {
    document.getElementById(`rubriek-input-${id}`).checked = false;
    document
        .querySelector(`.rubriek-option[data-id="${id}"]`)
        ?.classList.remove("selected");
    document.querySelector(`.rubriek-chip[data-id="${id}"]`)?.remove();
}

function filterRubrieken(term) {
    const zoekterm = term.trim().toLowerCase();
    const items = document.querySelectorAll(".rubriek-option");
    const geen = document.getElementById("rubriek-geen");
    let zichtbaar = 0;

    items.forEach((item) => {
        const match = !zoekterm || item.dataset.naam.includes(zoekterm);
        item.style.display = match ? "" : "none";
        if (match) zichtbaar++;
    });

    geen.style.display = zichtbaar === 0 ? "" : "none";
}
