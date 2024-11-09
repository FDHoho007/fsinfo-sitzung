const currentTO = document.getElementById("current-to");

document.getElementById("change-to").onsubmit = function () {
    fetch("api/redeliste.php?to=" + currentTO.value)
    return false;
}

document.getElementById("next-to").onclick = function () {
    currentTO.selectedIndex = (currentTO.selectedIndex + 1) % currentTO.children.length;
    fetch("api/redeliste.php?to=" + currentTO.value)
}

let updateQueue = {
    "title": {},
    "content": {}
};
let typing = {
    "title": {0: 0, 1: 0, 2: 0},
    "content": {0: 0, 1: 0, 2: 0}
};

function updateTitle(column, title) {
    updateQueue.title[column] = title;
    typing.title[column] = Date.now();
}

function updateContent(column, content) {
    updateQueue.content[column] = content;
    typing.content[column] = Date.now();
}

function updateColumn(column) {
    fetch("api/redeliste.php?column=" + column).then(res => res.json()).then(data => {
        if(typing.title[column] < Date.now() - 2 * 1000) {
            document.getElementById("title" + column).value = data.title;
        }
        if(typing.content[column] < Date.now() - 2 * 1000) {
            document.getElementById("content" + column).value = data.content;
        }
    })
}

setInterval(() => {
    for(let col in updateQueue.title) {
        fetch("api/redeliste.php?column=" + col, {
            method: "POST",
            headers:{"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams({"title": updateQueue.title[col]})
        })
    }
    updateQueue.title = {};
    for(let col in updateQueue.content) {
        fetch("api/redeliste.php?column=" + col, {
            method: "POST",
            headers:{"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams({"content": updateQueue.content[col]})
        })
    }
    updateQueue.content = {};
}, 1000);

fetch("api/beamer-to.php").then(res => res.text()).then(html => {
    const doc = new DOMParser().parseFromString(html, "text/html");
    for(let to of doc.querySelectorAll("ol li")) {
        let option = document.createElement("option");
        option.innerText = to.innerText.trim();
        currentTO.appendChild(option);
    }
});

new EventSource("api/beamer-events.php").onmessage = function(event) {
    switch(event.data.split(",")[0]) {
        case "update-column":
            updateColumn(parseInt(event.data.split(",")[1]));
            break;
    }
};

for(let i = 0; i<3; i++) {
    updateColumn(i);
}