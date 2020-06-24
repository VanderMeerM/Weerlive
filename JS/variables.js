
const tomorrow = document.querySelector("#morgen");
const dayAfterTomorrow = document.getElementById('overmorgen');

let oneDayLater = new Date().getTime() + (3600 * 1000 * 24);
let twoDaysLater = new Date().getTime() + (3600 * 1000 * 24 * 2);
let oDLSplit = new Date(oneDayLater).toLocaleDateString("nl-NL")
let tDLSplit = new Date(twoDaysLater).toLocaleDateString("nl-NL")

let currentTime = new Date(); 
let hour = parseInt(new Date().getHours());
let minutes = parseInt(new Date().getMinutes());
let year = currentTime.getFullYear();
let month = currentTime.getMonth();
let date = currentTime.getDate()

let ms;


windDirection = [
    { direction: "Noord", deg: 90 },
    { direction: "NNO", deg: 112.5 },
    { direction: "NO", deg: 135 },
    { direction: "ONO", deg: 157.5 },
    { direction: "Oost", deg: 180 },
    { direction: "OZO", deg: 205.5 },
    { direction: "ZO", deg: 225 },
    { direction: "ZZO", deg: -112.5 },
    { direction: "Zuid", deg: -90 },
    { direction: "ZZW", deg: -67.5 },
    { direction: "ZW", deg: -45 },
    { direction: "WZW", deg: -22.5 },
    { direction: "WNW", deg: 22.5 },
    { direction: "NW", deg: 45 },
    { direction: "NNW", deg: 67.5 },
    { direction: "West", deg: 0 }
]

