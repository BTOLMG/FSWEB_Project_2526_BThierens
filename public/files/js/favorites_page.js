const ids = getFavorieten();

fetch("/api/actoren?ids=" + ids.join(","))
    .then((res) => res.json())
    .then((actoren) => {
        const container = document.getElementById("favorieten-container");
        document.getElementById("favorites-loading").remove();

        if (actoren.length === 0) {
            container.innerHTML =
                "<p>Je hebt nog geen favorieten opgeslagen.</p>";
            return;
        }

        actoren.forEach((actor) => {
            const card = document.createElement("div");
            card.classList.add("fav-card");
            card.dataset.id = actor.id;

            card.innerHTML = `
                <div class="fav-card-top">
                    <span class="fav-card-badge">${actor.categorie.toUpperCase()}</span>
                    <button class="favoriet-button" data-id="${actor.id}" title="Verwijder uit favorieten">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
                <div class="fav-card-body">
                    <h2>${actor.naam}</h2>
                    <p>${actor.beschrijving ?? ""}</p>
                </div>
                <div class="fav-card-footer">
                    ${actor.gemeente ? `<span class="fav-card-meta"><i class="fa fa-map-marker"></i> <a href="https://www.google.com/maps?q=${encodeURIComponent(actor.straatnaam + ' ' + actor.huisnummer + ' ' + actor.busnummer + ' ' + actor.postcode + ' ' + actor.gemeente)}" target="_blank">${actor.gemeente}</a></span>` : ""}
                    ${actor.telefoon ? `<span class="fav-card-meta"><i class="fa fa-phone"></i> <a href="tel:${actor.telefoon}">${actor.telefoon}</a></span>` : ""}
                    ${actor.mail ? `<span class="fav-card-meta"><i class="fa fa-envelope"></i> <a href="mailto:${actor.mail}">${actor.mail}</a></span>` : ""}
                    ${actor.website ? `<span class="fav-card-meta"><i class="fa fa-globe"></i> <a href="${actor.website}" target="_blank">${actor.website}</a></span>` : ""}
                </div>
                <a href="${detailsLink.replace(':id', actor.id)}" class="fav-card-link">Bekijk details</a>
            `;

            card.querySelector(".favoriet-button").onclick = function () {
                toggleFavoriet(this);
                card.remove();
            };

            container.appendChild(card);
        });
    });
