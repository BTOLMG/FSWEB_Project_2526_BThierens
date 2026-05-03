function filterLijst(input, lijstId, geenId) {
    const term   = input.value.trim().toLowerCase();
    const items  = document.querySelectorAll(`#${lijstId} .overzicht-item`);
    const geenEl = document.getElementById(geenId);
    let   hits   = 0;

    items.forEach(item => {
        const match = !term || item.dataset.zoekterm.includes(term);
        item.style.display = match ? '' : 'none';

        if (match) hits++;
    });

    geenEl.classList.toggle('hidden', hits > 0);
}

function bevestigVerwijder(naam) {
    return confirm(`Ben je zeker dat je "${naam}" wil verwijderen? Dit kan niet ongedaan worden gemaakt.`);
}
