const resultBox = document.querySelector(".result-box");
const searchWrapper = document.querySelector(".search-wrapper");
const inputBox = document.getElementById("input-box");

let keywords = [];

fetch('/api/keywords')
    .then(res => res.json())
    .then(data => keywords = data);

inputBox.onkeyup = function() {
    let result = [];
    let input = inputBox.value.trim().toLowerCase();

    if (input.length > 0) {
        result = keywords.map((item) => {
            let score = 0;
            let lowerItem = item.toLowerCase();

            if (lowerItem.startsWith(input)) score += 2;
            else if (lowerItem.includes(input)) score += 1;

            return { name: item, relevance: score };
        })
        .filter(item => item.relevance > 0)
        .sort((a, b) => b.relevance - a.relevance);
    }

    if(result.length > 6) {
        resultBox.classList.add("has-scrollbar");
    }else{
        resultBox.classList.remove("has-scrollbar");
    }

    display(result, input);
}

function display(result, searchTerm) {
    if (result.length) {
        const content = result.map((item) =>{

            // 'gi' betekent: Global (zoek overal) en Case-Insensitive (negeer hoofdletters)
            let regex = new RegExp(`(${searchTerm})`, "gi");
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
