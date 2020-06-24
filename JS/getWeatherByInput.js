

async function getWeatherByInput() {

    // Request an API-key on http://weerlive.nl/api/toegang/index.php
    let apiUrl = `https://weerlive.nl/api/json-data-10min.php?key=<Apikey>&locatie=${plaats.value}`;
    try {
        const res = await fetch(apiUrl, { method: 'GET' });
        const data = await res.json();

       document.getElementById('map').style.visibility = "hidden";

        document.getElementById('location').innerHTML = `Het weer in <br>${data.liveweer[0].plaats}
        `

        document.getElementById('regenzon').
            innerHTML = `<img src='pics/regen.png'> ${data.liveweer[0].d0neerslag}% <br>
            <img src='pics/zon.png'> ${data.liveweer[0].d0zon}% <br>
            <img src='pics/sunrise1.png'> ${data.liveweer[0].sup} <br>
            <img src='pics/sunset1.png'> ${data.liveweer[0].sunder}`;

        function weatherToday() {

            document.getElementById('temperatuur').
                innerHTML = `<font size="5">${data.liveweer[0].d0tmin} / ${data.liveweer[0].d0tmax} ºC</font><br><p>
              <font size="10">${data.liveweer[0].temp}<font size="5">ºC</font></font><br><p>
              <font size="3">voelt aan als:</font><br><font size="5">${data.liveweer[0].gtemp} ºC</font>`;

            const image = document.getElementById('image');
            const img = document.createElement("img");
            while (image.firstChild) {
                image.removeChild(image.firstChild);
            }
            image.appendChild(img);
            img.src = `iconen-weerlive-wit/${data.liveweer[0].image}.png`

            img.addEventListener("click", getWeatherByLocation);

            document.getElementById('weer').innerHTML =
                `Verwachting: <br>${data.liveweer[0].verw}`

            const button = document.querySelector("#button");
            while (button.firstChild) {
                button.removeChild(button.firstChild);

            };


            const buttonForeCast = document.createElement("button");
            buttonForeCast.innerHTML = 'Toon vooruitzichten';
            buttonForeCast.onclick = () => {
                weatherTomorrow(), weatherDayAfterTomorrow()

                document.getElementById('morgen').classList.toggle('hidden');
                document.getElementById('overmorgen').classList.toggle('hidden');

                if (tomorrow.className != 'hidden' && dayAfterTomorrow.className != 'hidden') {
                    buttonForeCast.innerHTML = 'Verberg vooruitzichten'
                }
                else { buttonForeCast.innerHTML = 'Toon vooruitzichten' };
            };

            button.appendChild(buttonForeCast);

            const buttonMoreDetails = document.createElement("button");
            buttonMoreDetails.innerHTML = 'Meer gegevens';
            buttonMoreDetails.onclick = () => {
                showMoreDetails()
                document.getElementById('morgen').classList.toggle('hidden');
                document.getElementById('overmorgen').classList.toggle('hidden');

                if (tomorrow.className != 'hidden') { buttonMoreDetails.innerHTML = 'Verberg gegevens' }
                else { buttonMoreDetails.innerHTML = 'Meer gegevens' };
            };


            function showMoreDetails() {

                tomorrow.innerHTML =
                    ` <img src='pics/wind_icon_w.png'> ${data.liveweer[0].winds} Bft, 
                                ${data.liveweer[0].windkmh} km/u <br>
                                Weersgesteldheid: ${data.liveweer[0].samenv} <br>
                                Luchtdruk: ${data.liveweer[0].luchtd} hPa `

                dayAfterTomorrow.innerHTML =
                    `Relatieve luchtvochtigheid: ${data.liveweer[0].lv}% <br>
                                Dauwpunt: ${data.liveweer[0].dauwp} ºC <br> 
                                Zicht: ${data.liveweer[0].zicht} km`
            }


            button.appendChild(buttonMoreDetails);

        }

        weatherToday();
        
        //console.log(navigator.platform);

        function weatherTomorrow() {
            tomorrow.innerHTML = `<span style='text-decoration: underline;'>Morgen (${oDLSplit.split('-')[0]}-${oDLSplit.split('-')[1]}):</span> <br>
               <img src= 'iconen-weerlive-wit/${data.liveweer[0].d1weer}.png'<p><br>
                <font size="5"> ${data.liveweer[0].d1tmin} / ${data.liveweer[0].d1tmax} ºC <br>
                <font size="4">
                 <img src='pics/wind_icon_w.png'> ${data.liveweer[0].d1windr}, ${data.liveweer[0].d1windk} Bft<br>
                 <img src='pics/regen.png'> ${data.liveweer[0].d1neerslag}%,
                  <img src='pics/zon.png'> ${data.liveweer[0].d1zon}%`;

        }

        function weatherDayAfterTomorrow() {

            dayAfterTomorrow.innerHTML = `<span style='text-decoration: underline;'>Overmorgen (${tDLSplit.split('-')[0]}-${tDLSplit.split('-')[1]}):</span> <br>  
                    <img src= 'iconen-weerlive-wit/${data.liveweer[0].d2weer}.png'<p><br>
                    <font size="5"> ${data.liveweer[0].d2tmin} / ${data.liveweer[0].d2tmax} ºC<br>
                    <font size="4"> 
                    <img src='pics/wind_icon_w.png'> ${data.liveweer[0].d2windr}, ${data.liveweer[0].d2windk} Bft<br>
                   <img src='pics/regen.png'> ${data.liveweer[0].d2neerslag}%
                   <img src='pics/zon.png'> ${data.liveweer[0].d2zon}%`;

        }

        function changeBackground() {
            let hourSu = parseInt(data.liveweer[0].sunder.split(":")[0]);
            let minuteSu = parseInt(data.liveweer[0].sunder.split(":")[1]);
            let hourSr = parseInt(data.liveweer[0].sup.split(":")[0]);
            let minuteSr = parseInt(data.liveweer[0].sup.split(":")[1]);

            let sunrise = new Date(year, month, date, hourSr, minuteSr);
            let sunset = new Date(year, month, date, hourSu, minuteSu);

            function setDarkBackground() { 
            document.body.style.backgroundImage = "url('./pics/Background/dark_background.png')";
            document.getElementById('moon').style.display = "block" }

            (sunset.getTime() - currentTime.getTime()) <= 0 ||
                sunrise.getTime() - currentTime.getTime() > 0 ?
                setDarkBackground() :
               
                   (sunset.getTime() - currentTime.getTime()) < 900000 ||
                    (currentTime.getTime() - sunrise.getTime()) < 900000 ?
                    document.body.style.backgroundImage = "url('./pics/Background/Europa_dark15.png')" :

                    (sunset.getTime() - currentTime.getTime()) < 1800000 ||
                        (currentTime.getTime() - sunrise.getTime()) < 1800000 ?
                        document.body.style.backgroundImage = "url('./pics/Background/Europa_dark30.png')" :

                        document.body.style.backgroundImage = "url('./pics/Background/Europa.png')"
        
                }
        changeBackground();


        function calculateWindSpeed() {
            const windspeed = data.liveweer[0].winds;
            if (windspeed >= 0 && windspeed <= 3) {
                ms = 3000 - (500 * (windspeed - 1))
            }
            else if (windspeed >= 4 && windspeed <= 10) {
                ms = 1750 - (250 * (windspeed - 4))
            }
            else if (windspeed >= 11) {
                ms = 150
            }
           return ms;
        }

        const deg = windDirection.find(
            dir =>
                data.liveweer[0].windr === dir.direction
        )

        turnandmoveArrow();

        function turnandmoveArrow() {

            //Turns arrow into winddirection 

            document.getElementById('winds').innerHTML =
                `<img src='pics/wind_icon_w.png'> <br>
                     <font size="4">${data.liveweer[0].winds} Bft`;

            let arrow = document.getElementById('arrow');
            const img = document.createElement("img");

            while (arrow.firstChild) {
                arrow.removeChild(arrow.firstChild);
            }
            img.src = "./pics/arrow.png";
            img.style.webkitTransform = 'rotate(' + deg.deg + 'deg)';
            img.style.visibility = "visible";
            arrow.appendChild(img);

            const xDir = Math.cos((deg.deg * Math.PI) / 180) * -200;
            const yDir = Math.sin((deg.deg * Math.PI) / 180) * 200;

            calculateWindSpeed();

            //Move arrow five times in winddirection

            arrow.animate([
                { transform: 'translateX(' + xDir + 'px)' },
                { transform: 'translateY(' + yDir + 'px)' },

            ],
                {
                    duration: ms,
                    iterations: 5,

                });
        }


    }


    catch (error) {
        console.log(error)
    }

}

document.getElementById('about').addEventListener('click', function () {
    on()
})

function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}



