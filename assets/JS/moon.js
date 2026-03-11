
function load_moon_phases(obj) {
    let gets = []
    for (var i in obj) {
        gets.push(i + "=" + encodeURIComponent(obj[i]))
    }
    let xmlhttp = new XMLHttpRequest()
    let url = "https://www.icalendar37.net/lunar/api/?" + gets.join("&")
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let moon = JSON.parse(xmlhttp.responseText)
            example_1(moon)

        }
    }
    xmlhttp.open("GET", url, true)
    xmlhttp.send()
}
document.addEventListener("DOMContentLoaded", function () {
    let configMoon = {
        lang: 'en', // 'ca' 'de' 'en' 'es' 'fr' 'it' 'pl' 'pt' 'ru' 'zh' (*)
        month: new Date().getMonth() + 1, // 1  - 12
        year: new Date().getFullYear(),

        size: 50, //pixels
        lightColor: "#FFFF88", //CSS color
        shadeColor: "#111111", //CSS color
        sizeQuarter: 20, //pixels
        texturize: false //true - false
    }
    configMoon.LDZ = new Date(configMoon.year, configMoon.month - 1, 1) / 1000
    load_moon_phases(configMoon)
})

function example_1(moon) {
    let day = new Date().getDate()
    let html = "<div class='moon'>"
    html += moon.phase[day].svg
    document.getElementById("moon").innerHTML = html
}
