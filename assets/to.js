let currentTO = null;
let start = 0;

function findTO(name) {
    for(let li of document.querySelectorAll("ol li")) {
        if(li.innerText.includes(name)) {
            return li;
        }
    }
    return null;
}

function setCurrentTO(to) {
    if(to === "null") {
        to = null;
    }
    if(currentTO !== null) {
        let timeSeconds = Math.floor((Date.now() - start) / 1000);
        let timeMinutes = Math.floor(timeSeconds / 60);
        timeSeconds = timeSeconds % 60;
        if(timeSeconds < 10) {
            timeSeconds = "0" + timeSeconds;
        }
        currentTO.style.fontWeight = "";
        currentTO.innerHTML += " (" + timeMinutes + ":" + timeSeconds + ")";
    }
    if(to !== null) {
        to.style.fontWeight = "bold";
        to.scrollIntoView();
        start = Date.now();
    }
    currentTO = to;
}