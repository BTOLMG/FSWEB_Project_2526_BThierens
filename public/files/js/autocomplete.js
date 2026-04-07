let tempKeywords = [
    'hulp',
    'welzijn',
    'zorg',
    'ondersteuning',
    'maatschappelijk werk',
    'thuiszorg',
    'thuisverpleging',
    'gezondheidszorg',
    'eerstelijnszorg',
    'psychologische hulp',
    'psycholoog',
    'psychiater',
    'therapie',
    'geestelijke gezondheid',
    'crisisopvang',
    'opvang',
    'dagopvang',
    'dagbesteding',
    'begeleid wonen',
    'woonondersteuning',
    'woonzorgcentrum',
    'ouderenzorg',
    'seniorenwerking',
    'mantelzorg',
    'mantelzorgondersteuning',
    'mobiliteitshulp',
    'hulpmiddelen',
    'ergotherapie',
    'kinesitherapie',
    'logopedie',
    'revalidatie',
    'preventie',
    'verslavingszorg',
    'drugs',
    'alcoholhulp',
    'armoedebestrijding',
    'budgetbeheer',
    'schuldbemiddeling',
    'inkomensondersteuning',
    'leefloon',
    'OCMW',
    'lokaal bestuur',
    'buurtwerk',
    'wijkwerking',
    'buurtcentrum',
    'sociale huisvesting',
    'inclusie',
    'handicap',
    'handicapzorg',
    'persoonlijke assistentie',
    'toegankelijkheid',
    'jeugdhulp',
    'jongerenwerking',
    'kinderopvang',
    'opvoedingsondersteuning',
    'pleegzorg',
    'jongerenbegeleiding',
    'consultatiebureau',
    'vrijwilligerswerk',
    'sociale economie',
    'arbeidsbemiddeling',
    'jobcoaching',
    'tewerkstelling',
    'activering',
    'sociale tewerkstelling',
    'organisaties',
    'voorzieningen',
    'diensten',
    'zorgaanbieders',
    'welzijnsaanbieders',
    'hulpverleners',
    'sociale kaart',
    'sociale kaart vlaanderen',
    'zorgaanbod',
    'welzijnsaanbod',
    'hulpverlening vinden',
    'diensten in de buurt',
    'zorggids',
    'welzijnsgids',
    'preventieve zorg',
    'gezondheidsbevordering',
    'rouwverwerking',
    'angststoornissen',
    'depressie hulp',
    'zelfmoordpreventie',
    'mobiliteit',
    'hulpmiddelen uitleendienst',
    'advies',
    'informatiepunt',
    'steunpunt',
    'contactpunt',
    'maatschappelijke ondersteuning'
];


const resultBox = document.querySelector(".result-box");
const searchWrapper = document.querySelector(".search-wrapper");
const inputBox = document.getElementById("input-box");

inputBox.onkeyup = function() {
    let result = [];
    let input = inputBox.value.trim().toLowerCase();

    if (input.length > 0) {

        result = tempKeywords.map((item) => {
            let score = 0;
            let lowerItem = item.toLowerCase();

            if (lowerItem.startsWith(input)) score += 2;
            else if (lowerItem.includes(input)) score += 1;

            return { name: item, relevance: score };
        })
        .filter(item => item.relevance > 0)
        .sort((a, b) => b.relevance - a.relevance);
    }

    display(result.slice(0,5), input);
}

function display(result, searchTerm) {
    if (result.length) {
        const content = result.map((item) =>{

            // 'gi' betekent: Global (zoek overal) en Case-Insensitive (negeer hoofdletters)
            let regex = new RegExp(`(${searchTerm})`, "gi");

            // $1 zegt: "Gebruik de tekst die je gevonden hebt, precies zoals die daar stond"
            let highlighted = item.name.replace(regex, "<b>$1</b>");

            return "<li onclick=selectedInput(this)>" + highlighted +  "</li>";
        });
        resultBox.innerHTML = "<ul>" + content.join('') + "</ul>";

        searchWrapper.classList.add("no-box-shadow");

    } else {
        resultBox.innerHTML = "";
        searchWrapper.classList.remove("no-box-shadow");
    }
}

function selectedInput(list){
    inputBox.value = list.innerText;
    resultBox.innerHTML = "";
    searchWrapper.classList.remove("no-box-shadow");
}
