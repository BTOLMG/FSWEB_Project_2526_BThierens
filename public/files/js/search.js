document.addEventListener("DOMContentLoaded", () => {
    const favorieten = getFavorieten();

    document.querySelectorAll(".favoriet-button").forEach((button) => {
        const actorId = parseInt(button.dataset.id);
        if (favorieten.includes(actorId)) {
            button.classList.add("favoriet-actief");
            button.title = "Verwijder uit favorieten";
        }
    });
});

function toggleFavoriet(button) {
    const actorId = parseInt(button.dataset.id);
    let favorieten = getFavorieten();

    if (favorieten.includes(actorId)) {
        favorieten = favorieten.filter((id) => id !== actorId);
        button.classList.remove("favoriet-actief");
        button.title = "Toevoegen aan favorieten";
    } else {
        favorieten.push(actorId);
        button.classList.add("favoriet-actief");
        button.title = "Verwijder uit favorieten";
        spawnHearts(button);
    }

    saveFavorieten(favorieten);
}

function spawnHearts(button) {
    const count = Math.floor(Math.random() * 2) + 6;

    for (let i = 0; i < count; i++) {
        setTimeout(() => spawnHeart(button), i * 80);
    }
}

document.querySelectorAll('.accordion-header').forEach(btn => {
    btn.addEventListener('click', () => {
        const panel = btn.closest('.accordion-panel');
        const isOpen = panel.classList.toggle('open');
        btn.setAttribute('aria-expanded', isOpen);
    });
});

function removeFilter(name, value) {
    const form = document.getElementById('filter-form');
    form.querySelectorAll(`input[name="${name}"]`).forEach(input => {
        if (input.value === value) input.checked = false;
    });
    form.submit();
}

function spawnHeart(button) {
    const rect = button.getBoundingClientRect();
    const drift = (Math.random() - 0.5) * 120;
    const duration = 600 + Math.random() * 600;
    const size = 0.8 + Math.random() * 1.2;
    const startRotate = (Math.random() - 0.5) * 30;
    const endRotate = (Math.random() - 0.5) * 60;

    const heart = document.createElement("span");
    heart.innerHTML = '<i class="fa fa-heart"></i>';
    heart.style.cssText = `
        color: var(--primary-red-color);
        position: fixed;
        font-size: ${size}rem;
        pointer-events: none;
        z-index: 9999;
        left: ${rect.left + rect.width / 2 - 12}px;
        top: ${rect.top}px;
    `;

    document.body.appendChild(heart);

    heart.animate(
        [
            {
                transform: `translate(0, 0) rotate(${startRotate}deg) scale(1)`,
                opacity: 1,
            },
            {
                transform: `translate(${drift}px, -90px) rotate(${endRotate}deg) scale(1.3)`,
                opacity: 1,
                offset: 0.45,
            },
            {
                transform: `translate(${drift}px, 10px) rotate(${endRotate}deg) scale(0.7)`,
                opacity: 0,
            },
        ],
        {
            duration,
            easing: "ease-out",
            fill: "forwards",
        },
    ).onfinish = () => heart.remove();
}

function filterAccordionItems(input, lijstId, geenResultatenId) {
    const zoekterm       = input.value.trim().toLowerCase();
    const lijst          = document.getElementById(lijstId);
    const geenResultaten = document.getElementById(geenResultatenId);
    const alleItems      = lijst.querySelectorAll('li');

    let aantalZichtbaar = 0;

    alleItems.forEach(function(item) {
        const tekst  = item.dataset.zoekterm ?? '';
        const tonen = zoekterm === '' || tekst.includes(zoekterm);

        item.style.display = tonen ? '' : 'none';

        if (tonen) {
            aantalZichtbaar++;

            const labelEl = item.querySelector('.accordionItem-label');
            if (labelEl) {
                if (zoekterm === '') {
                    labelEl.innerHTML = labelEl.textContent;
                } else {
                    const origineleTekst = labelEl.textContent;
                    const regex          = new RegExp(`(${zoekterm})`, 'gi');
                    labelEl.innerHTML    = origineleTekst.replace(regex, '<b>$1</b>');
                }
            }
        }
    });

    geenResultaten.classList.toggle('hidden', aantalZichtbaar > 0);
}

