function loadMeme() {
    fetch("api/beamer-meme.php").then(response => response.text()).then(memeUrl => {
        let memeContainer = document.getElementById("meme-container");
        if(memeUrl.endsWith(".mp4")) {
            let video = document.createElement("video");
            video.autoplay = true;
            video.muted = true;
            video.playsInline = true;
            video.loop = true;
            let source = document.createElement("source");
            source.type = "video/mp4";
            source.src = memeUrl;
            video.appendChild(source);
            memeContainer.innerHTML = "";
            memeContainer.appendChild(video);

        } else {
            let img = document.createElement("img");
            img.src = memeUrl;
            memeContainer.innerHTML = "";
            memeContainer.appendChild(img);
        }
    })
}

function injectTOTracker() {
    let script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "/assets/to.js"
    document.getElementsByClassName("left-frame")[0].contentDocument.head.appendChild(script);
}

function updateColumn(column) {
    fetch("api/redeliste.php?column=" + column).then(res => res.json()).then(data => {
        document.getElementById("title" + column).innerHTML = data.title;
        document.getElementById("content" + column).innerHTML = data.content.replaceAll("\n", "<br>");
    })
}

new EventSource("api/beamer-events.php").onmessage = function(event) {
    let to = document.getElementsByClassName("left-frame")[0].contentWindow;
    switch(event.data.split(",")[0]) {
        case "reload-to":
            to.location.reload();
            injectTOTracker();
            break;
        case "set-to":
            to.setCurrentTO(to.findTO(event.data.split(",")[1]));
            break;
        case "update-column":
            updateColumn(parseInt(event.data.split(",")[1]));
            break;
        case "reload-meme":
            loadMeme();
            break;
        case "pause":
            break;
    }
};

for(let i = 0; i<3; i++) {
    updateColumn(i);
}
loadMeme();
setTimeout(injectTOTracker, 500);