//https://leafletjs.com/reference.html
//https://stackoverflow.com/questions/49333263/how-to-use-leaflet-markerclustergroup
//https://github.com/leaflet/leaflet.markercluster
document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('map', {
        center: [50.8503463, 4.3517211],
        zoom: 10,
        zoomControl: true,
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    const clusterGroup = L.markerClusterGroup({
        maxClusterRadius: 50,
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: true,
        zoomToBoundsOnClick: true,
        iconCreateFunction(cluster) {
            const count = cluster.getChildCount();
            return L.divIcon({
                html: `<div class="cluster-marker" style="width:40px;height:40px"><span>${count}</span></div>`,
                className: '',
                iconSize: [40, 40],
                iconAnchor: [40 / 2, 40 / 2],
            });
        },
    });
    map.addLayer(clusterGroup);


    let alleActoren = [];
    let markers     = {};
    let actieveId   = null;

    const filterState   = {
        zoekterm:       '',
        categories:     new Set(),
        gemeentes:      new Set(),
        radiusKm:       null,
        radiusCenter:   null,
    };

    let radiusCircle        = null;
    let radiusCenterMarker  = null;
    let pickingCenter       = false;

    const cardList          = document.getElementById('kaart-card-list');
    const loadingEl         = document.getElementById('kaart-loading');
    const resultBadge       = document.getElementById('result-count');
    const searchInput       = document.getElementById('kaart-search');
    const activeFiltersEl   = document.getElementById('kaart-active-filters');
    const categorieList     = document.getElementById('filter-categorie-list');
    const gemeenteList      = document.getElementById('filter-gemeente-list');
    const gemeenteZoek      = document.getElementById('gemeente-zoek');

    const radiusSlider      = document.getElementById('radius-slider');
    const radiusKmLabel     = document.getElementById('radius-km');
    const radiusLabel       = document.getElementById('radius-label');
    const radiusClearBtn    = document.getElementById('radius-clear');
    const radiusInstruction = document.getElementById('radius-instruction');
    const btnMijnLocatie    = document.getElementById('btn-mijn-locatie');
    const btnKlikKaart      = document.getElementById('btn-klik-kaart');

    const categorieConfig = {
        'Vrije tijd': { kleur: 'yellow', icoon: 'fa-star',         badgeClass: 'badge-vrije-tijd' },
        'Gezondheid': { kleur: 'green',  icoon: 'fa-heart-pulse',  badgeClass: 'badge-gezondheid' },
    };

    function getCategorieConfig(categorie) {
        if (categorieConfig[categorie] != null) return categorieConfig[categorie];
        else return { kleur: 'blue', icoon: 'fa-location-dot', badgeClass: '' };
    }

    fetch('/api/getAllActoren')
        .then(response => {
            if (!response.ok) throw new Error(response.status);
            return response.json();
        })
        .then(data => {
            alleActoren = data;
            loadingEl?.remove();
            fillFilterUI(data);
            update();
        })
        .catch(error => {
            console.error(error);
            loadingEl.innerHTML = '<i class="fa fa-circle-exclamation"></i><span>Er ging iets mis.</span>';
        });

    function fillFilterUI(actoren) {
        const aantalActorenInCat = {};
        actoren.forEach(a => {
            if (a.categorie != null) aantalActorenInCat[a.categorie] = (aantalActorenInCat[a.categorie] ?? 0) + 1;
        });
        categorieList.innerHTML = '';
        Object.entries(aantalActorenInCat).sort().forEach(([naam, count]) => {
            categorieList.appendChild(buildCheckItem(naam, "cat", count, () => {
                toggleSet(filterState.categories, naam);
                update();
            }));
        });


        const aantalActorenIngem = {};
        actoren.forEach(a => {
            if (a.gemeente) aantalActorenIngem[a.gemeente] = (aantalActorenIngem[a.gemeente] ?? 0) + 1;
        });
        gemeenteList.innerHTML = '';
        Object.entries(aantalActorenIngem).sort().forEach(([naam, count]) => {
            const li = buildCheckItem(naam, "gem", count, () => {
                toggleSet(filterState.gemeentes, naam);
                update();
            });
            li.dataset.naam = naam.toLowerCase();
            gemeenteList.appendChild(li);
        });

        gemeenteZoek.addEventListener('input', () => {
            const term = gemeenteZoek.value.trim().toLowerCase();
            gemeenteList.querySelectorAll('li').forEach(li => {
                li.style.display = li.dataset.naam.includes(term) ? '' : 'none';
            });
        });
    }

    function buildCheckItem(naam, type, count, onChange) {
        const li        = document.createElement('li');
        const label     = document.createElement('label');
        label.className = 'filter-check-label';

        const id = `filter-${type}-${naam.replaceAll(' ', '-')}`;
        label.innerHTML = `
            <input type="checkbox" id="${id}">
            <span class="filter-custom-check"></span>
            <span class="filter-check-name">${naam}</span>
            <span class="filter-check-count">${count}</span>
        `;
        label.querySelector('input').addEventListener('change', e => {
            label.classList.toggle('checked', e.target.checked);
            onChange();
        });

        li.appendChild(label);
        return li;
    }

    document.querySelectorAll('.filter-accordion-header').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.parentNode.classList.toggle('open');
        });
    });

    function updateSliderTrack(val) {
        const pct = ((val - 1) / 49) * 100;
        radiusSlider.style.setProperty('--pct', pct + '%');
        radiusKmLabel.textContent = val + ' km';
    }

    radiusSlider.addEventListener('input', () => {
        const km = parseInt(radiusSlider.value, 10);
        updateSliderTrack(km);
        if (filterState.radiusCenter) {
            filterState.radiusKm = km;
            tekenRadiuscirkel();
            update();
        }
    });

    btnMijnLocatie.addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert('Geolocatie is niet beschikbaar in jouw browser.');
            return;
        }
        btnMijnLocatie.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Locatie ophalen…';
        btnMijnLocatie.disabled = true;

        navigator.geolocation.getCurrentPosition(
            pos => {
                btnMijnLocatie.innerHTML = '<i class="fa fa-location-crosshairs"></i> Mijn locatie';
                btnMijnLocatie.disabled = false;
                setRadiusCenter(pos.coords.latitude, pos.coords.longitude);
            },
            () => {
                btnMijnLocatie.innerHTML = '<i class="fa fa-location-crosshairs"></i> Mijn locatie';
                btnMijnLocatie.disabled = false;
                alert('Kon locatie niet ophalen. Controleer de browserinstellingen.');
            },
            { timeout: 8000 }
        );
    });

    btnKlikKaart.addEventListener('click', () => {
        pickingCenter = !pickingCenter;
        radiusInstruction.style.display = pickingCenter ? '' : 'none';
        document.getElementById('map').classList.toggle('picking-center', pickingCenter);
        btnKlikKaart.style.opacity = pickingCenter ? '0.6' : '';
    });

    map.on('click', e => {
        if (!pickingCenter) return;
        pickingCenter = false;
        radiusInstruction.style.display = 'none';
        document.getElementById('map').classList.remove('picking-center');
        btnKlikKaart.style.opacity = '';
        setRadiusCenter(e.latlng.lat, e.latlng.lng);
    });

    function setRadiusCenter(lat, lon) {
        filterState.radiusCenter = { lat, lon };
        filterState.radiusKm = parseInt(radiusSlider.value, 10);
        tekenRadiuscirkel();
        map.setView([lat, lon], map.getZoom());
        update();
    }

    function tekenRadiuscirkel() {
        if (!filterState.radiusCenter) return;

        const { lat, lon } = filterState.radiusCenter;
        const km = filterState.radiusKm;

        if (radiusCircle)       { map.removeLayer(radiusCircle); }
        if (radiusCenterMarker) { map.removeLayer(radiusCenterMarker); }

        radiusCircle = L.circle([lat, lon], {
            radius:      km * 1000,
            color:       getComputedStyle(document.documentElement).getPropertyValue('--primary-blue-color').trim(),
            fillColor:   getComputedStyle(document.documentElement).getPropertyValue('--primary-blue-color').trim(),
            fillOpacity: 0.07,
            weight:      2,
            dashArray:   '6 7',
        }).addTo(map);

        const centerIcon = L.divIcon({
            html: `<div style="width:10px;height:10px;border-radius:50%;background:var(--primary-blue-color);border:2px solid #fff;"></div>`,
            className: '',
        });
        radiusCenterMarker = L.marker([lat, lon], { icon: centerIcon, interactive: false }).addTo(map);

        const plaatsnaam = filterState.radiusCenterNaam ?? `${lat.toFixed(4)}, ${lon.toFixed(4)}`;
        radiusLabel.textContent = `${km} km rond ${plaatsnaam}`;
        radiusClearBtn.style.display = '';
    }

    radiusClearBtn.addEventListener('click', () => {
        filterState.radiusCenter = null;
        filterState.radiusKm     = null;
        filterState.radiusCenterNaam = null;

        if (radiusCircle)       { map.removeLayer(radiusCircle);       radiusCircle = null; }
        if (radiusCenterMarker) { map.removeLayer(radiusCenterMarker); radiusCenterMarker = null; }

        radiusLabel.textContent      = 'Geen straal actief';
        radiusClearBtn.style.display = 'none';
        update();
    });

    let zoekTimeout;
    searchInput.addEventListener('input', () => {
        clearTimeout(zoekTimeout);
        zoekTimeout = setTimeout(() => {
            filterState.zoekterm = searchInput.value.trim().toLowerCase();
            update();
        }, 180);
    });

    function update() {
        let resultaat = alleActoren;

        if (filterState.zoekterm) {
            const zoekterm = filterState.zoekterm;
            resultaat = resultaat.filter(a =>
                a.naam?.toLowerCase().includes(zoekterm)         ||
                a.categorie?.toLowerCase().includes(zoekterm)    ||
                a.gemeente?.toLowerCase().includes(zoekterm)
            );
        }

        if (filterState.categories.size > 0) {
            resultaat = resultaat.filter(a => filterState.categories.has(a.categorie));
        }

        if (filterState.gemeentes.size > 0) {
            resultaat = resultaat.filter(a => filterState.gemeentes.has(a.gemeente));
        }

        if (filterState.radiusCenter && filterState.radiusKm) {
            const { lat, lon } = filterState.radiusCenter;
            const km = filterState.radiusKm;
            resultaat = resultaat.filter(a => {
                if (a.lat == null || a.lon == null) return false;
                return haversineKm(lat, lon, a.lat, a.lon) <= km;
            });
        }

        renderChips();
        renderLijst(resultaat);
        renderMarkers(resultaat);
    }

    function renderChips() {
        activeFiltersEl.innerHTML = '';
        let hasChips = false;

        filterState.categories.forEach(naam => {
            hasChips = true;
            activeFiltersEl.appendChild(makeChip(naam, '', () => {
                filterState.categories.delete(naam);
                uncheckFilter('cat', naam);
                update();
            }));
        });

        filterState.gemeentes.forEach(naam => {
            hasChips = true;
            activeFiltersEl.appendChild(makeChip(naam, 'chip-gemeente', () => {
                filterState.gemeentes.delete(naam);
                uncheckFilter('gem', naam);
                update();
            }));
        });

        if (filterState.radiusKm && filterState.radiusCenter) {
            hasChips = true;
            activeFiltersEl.appendChild(makeChip(
                `${filterState.radiusKm} km straal`,
                'chip-radius',
                () => radiusClearBtn.click()
            ));
        }

        activeFiltersEl.style.display = hasChips ? '' : 'none';
    }

    function makeChip(tekst, extraClass, onRemove) {
        const chip = document.createElement('span');
        chip.className = `chip ${extraClass}`;
        chip.innerHTML = `${tekst}<button class="chip-remove" title="Verwijder filter"><i class="fa fa-xmark"></i></button>`;
        chip.querySelector('button').addEventListener('click', onRemove);
        return chip;
    }

    function uncheckFilter(type, naam) {
        const id = `filter-${type}-${naam.replaceAll(' ', '-')}`;
        const input = document.getElementById(id);
        if (input) {
            input.checked = false;
            input.parentNode.classList.remove('checked');
        }
    }

    function renderLijst(actoren) {
        cardList.querySelectorAll('.card, .empty').forEach(el => el.remove());
        resultBadge.textContent = actoren.length + (actoren.length === 1 ? ' resultaat' : ' resultaten');

        if (actoren.length === 0) {
            const leeg = document.createElement('div');
            leeg.className = 'empty';
            leeg.innerHTML = '<i class="fa fa-search" style="font-size:1.5rem"></i><span>Geen aanbieders gevonden.</span>';
            cardList.appendChild(leeg);
            return;
        }

        const favorieten = getFavorieten();
        actoren.forEach(actor => cardList.appendChild(buildCard(actor, favorieten)));
    }

    function renderMarkers(actoren) {
        clusterGroup.clearLayers();
        markers = {};

        actoren.forEach(actor => {
            if (actor.lat == null || actor.lon == null) return;
            const marker = buildMarker(actor);
            markers[actor.id] = marker;
            clusterGroup.addLayer(marker);
        });
    }

    function buildCard(actor, favorieten) {
        const categorieConfig    = getCategorieConfig(actor.categorie);
        const isFav  = favorieten.includes(actor.id);
        const adres  = formatAdres(actor);

        const card = document.createElement('article');
        card.className = 'card';
        card.dataset.id = actor.id;

        card.innerHTML = `
            <div class="card-top">
                <span class="card-badge ${categorieConfig.badgeClass}">${actor.categorie ?? 'Onbekend'}</span>
                <button class="favoriet-button ${isFav ? 'favoriet-actief' : ''}"
                    data-id="${actor.id}"
                    title="${isFav ? 'Verwijder uit favorieten' : 'Toevoegen aan favorieten'}">
                    <i class="fa-solid fa-heart"></i>
                </button>
            </div>
            <h3 class="card-name">${actor.naam}</h3>
            ${adres ? `<p class="card-address"><i class="fa fa-location-dot"></i>${adres}</p>` : ''}
            <div class="card-footer">
                <a href="/details/${actor.id}" class="card-details-btn">Details bekijken</a>
            </div>
        `;

        card.querySelector('.favoriet-button').addEventListener('click', e => {
            e.stopPropagation();
            const btn  = e.currentTarget;
            toggleFavoriet(btn);
            btn.querySelector('i').className = btn.classList.contains('favoriet-actief')
                ? 'fa-solid fa-heart' : 'fa-solid fa-heart';
        });

        card.addEventListener('click', e => {
            activeerActor(actor.id, 'card');
        });

        return card;
    }

    function buildMarker(actor) {
        const categorieConfig = getCategorieConfig(actor.categorie);
        const adres = formatAdres(actor);

        const iconHtml = `<div class="marker ${categorieConfig.kleur}"><i class="fa-solid ${categorieConfig.icoon}"></i></div>`;

        const icon = L.divIcon({
            html:       iconHtml,
            className:  '',
            iconSize:   [40, 40],
            iconAnchor: [20, 40],
            popupAnchor:[0, -40],
        });

        const marker = L.marker([actor.lat, actor.lon], { icon });

        marker.bindPopup(`
            <div class="popup">
                <span class="popup-badge ${categorieConfig.badgeClass}">${actor.categorie ?? 'Onbekend'}</span>
                <p class="popup-name">${actor.naam}</p>
                ${adres ? `<p class="popup-address"><i class="fa fa-location-dot"></i>${adres}</p>` : ''}
                <a href="/details/${actor.id}" class="popup-btn">Details bekijken</a>
            </div>
        `, { maxWidth: 250 });

        marker.on('click', () => activeerActor(actor.id, 'marker'));

        return marker;
    }

    function activeerActor(id, bron) {
        if (actieveId !== null) {
            cardList.querySelector(`.card[data-id="${actieveId}"]`)?.classList.remove('active');
            deactiveerMarkerEl(actieveId);
        }

        actieveId = id;

        const card = cardList.querySelector(`.card[data-id="${id}"]`);
        card?.classList.add('active');
        if (bron === 'marker') card?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        const marker = markers[id];
        if (marker) {
            activeerMarkerEl(marker);
            if (bron === 'card') {
                clusterGroup.zoomToShowLayer(marker, () => marker.openPopup());
            }
        }
    }

    function activeerMarkerEl(marker) {
        const el = marker.getElement()?.querySelector('.marker');
        if (el) el.classList.add('active');
    }

    function deactiveerMarkerEl(id) {
        const marker = markers[id];
        if (!marker) return;
        const el = marker.getElement()?.querySelector('.marker');
        if (el) el.classList.remove('active');
    }

    map.on('popupclose', () => {
        if (actieveId !== null) {
            cardList.querySelector(`.card[data-id="${actieveId}"]`)?.classList.remove('active');
            deactiveerMarkerEl(actieveId);
            actieveId = null;
        }
    });


    function toggleSet(set, val) {
        if (set.has(val)) set.delete(val);
        else set.add(val);
    }

    function formatAdres(actor) {
        const straat = actor.straatnaam
            ? (actor.straatnaam + ' ' + (actor.huisnummer ?? '') + (actor.busnummer ? ' ' + actor.busnummer : '')).trim()
            : null;
        const plaats = (actor.postcode && actor.gemeente)
            ? actor.postcode + ' ' + actor.gemeente
            : actor.gemeente ?? null;
        return [straat, plaats].filter(Boolean).join(', ');
    }

    //https://www.geeksforgeeks.org/dsa/haversine-formula-to-find-distance-between-two-points-on-a-sphere/
    function haversineKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) ** 2
                + Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function toRad(deg) {
        return deg * Math.PI / 180;
    }
});
