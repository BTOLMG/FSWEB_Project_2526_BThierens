function getFavorieten() {
    return JSON.parse(localStorage.getItem("favorieten") ?? "[]");
}

function saveFavorieten(favorieten) {
    localStorage.setItem("favorieten", JSON.stringify(favorieten));
}

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
    }

    saveFavorieten(favorieten);
}
