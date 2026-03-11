

async function getWeatherByInput() {
document.getElementById('moon').style.display = "none"; 
document.getElementById('map').style.visibility = "hidden";

 // register key at http://weerlive.nl/api/toegang/index.php
    let apiUrl = `https://weerlive.nl/api/json-data-10min.php?key=<key>&locatie=${plaats.value}`;
    try {
        const res = await fetch(apiUrl, { method: 'GET' });
        const data = await res.json();
        
        document.getElementById('location').innerHTML = `Het weer in <span style='text-decoration: underline;'>${data.liveweer[0].plaats}
        `
        document.getElementById('regenzon').
            innerHTML = `<img src='weerlive/pics/regen.png'> ${data.liveweer[0].d0neerslag}% <br>
            <img src='weerlive/pics/zon.png'> ${data.liveweer[0].d0zon}% <br>
            <img src='weerlive/pics/sunrise1.png'> ${data.liveweer[0].sup} <br>
            <img src='weerlive/pics/sunset1.png'> ${data.liveweer[0].sunder}`;

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
            img.src = `weerlive/iconen-weerlive-wit/${data.liveweer[0].image}.png`

            switch (data.liveweer[0].image) {
                case "regen":
                case "buien":
                    {
                        letItRain();
                    }
                    break;

                case "sneeuw":
                    {
                       //  snowStorm;
                       console.log("Het sneeuwt!");
                    }
                    break;
            }

            img.addEventListener("click", getWeatherByLocation);

            document.getElementById('weer').innerHTML =
                `Verwachting: <br>${data.liveweer[0].verw}`

            const button = document.querySelector("#button");
            while (button.firstChild) {
                button.removeChild(button.firstChild);

            };


            const buttonForeCast = document.createElement("button");
                buttonForeCast.innerHTML = 'Toon vooruitzichten'
                buttonForeCast.onclick = () => {
                    weatherTomorrow(), weatherDayAfterTomorrow()

                    switch (buttonForeCast.innerHTML) {
                        case "Toon vooruitzichten": {

                    document.getElementById('morgen').style.visibility= "visible";
                    document.getElementById('overmorgen').style.visibility= "visible";
                    buttonForeCast.innerHTML = 'Verberg vooruitzichten';
                    buttonMoreDetails.innerHTML = 'Meer gegevens';
                    } 
                    break;

                    case "Verberg vooruitzichten": {
                      document.getElementById('morgen').style.visibility= "hidden";
                      document.getElementById('overmorgen').style.visibility= "hidden";
                      buttonForeCast.innerHTML = 'Toon vooruitzichten';
                      buttonMoreDetails.innerHTML = 'Meer gegevens';

                    }
                    break;
                }
                };

                button.appendChild(buttonForeCast);

                const buttonMoreDetails = document.createElement("button");
                buttonMoreDetails.innerHTML = 'Meer gegevens';
                buttonMoreDetails.onclick = () => {
                    showMoreDetails()

                    switch (buttonMoreDetails.innerHTML) {
                        case "Meer gegevens": {

                   document.getElementById('morgen').style.visibility= "visible";
                   document.getElementById('overmorgen').style.visibility= "visible";
                   buttonMoreDetails.innerHTML = 'Verberg gegevens';
                   buttonForeCast.innerHTML = 'Toon vooruitzichten';
                    } 
                    break;

                    case "Verberg gegevens": {
                        document.getElementById('morgen').style.visibility= "hidden";
                        document.getElementById('overmorgen').style.visibility= "hidden";
                        buttonMoreDetails.innerHTML = 'Meer gegevens';

                    }
                    break;
                }
                };

            function showMoreDetails() {

                tomorrow.innerHTML =
                    ` <img src='weerlive/pics/wind_icon_w.png'> ${data.liveweer[0].winds} Bft, 
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

         function weatherTomorrow() {
            tomorrow.innerHTML = `<span style='text-decoration: underline;'>Morgen (${oDLSplit.split('-')[0]}-${oDLSplit.split('-')[1]}):</span> <br>
               <img src= 'weerlive/iconen-weerlive-wit/${data.liveweer[0].d1weer}.png'<p><br>
                <font size="5"> ${data.liveweer[0].d1tmin} / ${data.liveweer[0].d1tmax} ºC <br>
                <font size="4">
                 <img src='weerlive/pics/wind_icon_w.png'> ${data.liveweer[0].d1windr}, ${data.liveweer[0].d1windk} Bft<br>
                 <img src='weerlive/pics/regen.png'> ${data.liveweer[0].d1neerslag}%,
                  <img src='weerlive/pics/zon.png'> ${data.liveweer[0].d1zon}%`;

        }

        function weatherDayAfterTomorrow() {

            dayAfterTomorrow.innerHTML = `<span style='text-decoration: underline;'>Overmorgen (${tDLSplit.split('-')[0]}-${tDLSplit.split('-')[1]}):</span> <br>  
                    <img src= 'weerlive/iconen-weerlive-wit/${data.liveweer[0].d2weer}.png'<p><br>
                    <font size="5"> ${data.liveweer[0].d2tmin} / ${data.liveweer[0].d2tmax} ºC<br>
                    <font size="4"> 
                    <img src='weerlive/pics/wind_icon_w.png'> ${data.liveweer[0].d2windr}, ${data.liveweer[0].d2windk} Bft<br>
                   <img src='weerlive/pics/regen.png'> ${data.liveweer[0].d2neerslag}%
                   <img src='weerlive/pics/zon.png'> ${data.liveweer[0].d2zon}%`;

        }

        function changeBackground() {
            let hourSu = parseInt(data.liveweer[0].sunder.split(":")[0]);
            let minuteSu = parseInt(data.liveweer[0].sunder.split(":")[1]);
            let hourSr = parseInt(data.liveweer[0].sup.split(":")[0]);
            let minuteSr = parseInt(data.liveweer[0].sup.split(":")[1]);

            let sunrise = new Date(year, month, date, hourSr, minuteSr);
            let sunset = new Date(year, month, date, hourSu, minuteSu);

            function setTwilightBackground15() {
                document.body.style.backgroundImage = "url('./weerlive/pics/Background/Europa_dark15.png')";
                document.getElementById('moon').style.display = "block"
            }

            function setTwilightBackground30() {
                document.body.style.backgroundImage = "url('./weerlive/pics/Background/Europa_dark30.png')";
                document.getElementById('moon').style.display = "block"
            }

            function setDarkBackground() {
                document.body.style.backgroundImage = "url('./weerlive/pics/Background/dark_background.png')";
                document.getElementById('moon').style.display = "block"
            }

            (sunset.getTime() - currentTime.getTime()) <= 0 ||
                sunrise.getTime() - currentTime.getTime() > 0 ?
                setTwilightBackground15() :

                (sunset.getTime() - currentTime.getTime()) < -900000 ||
                    (currentTime.getTime() - sunrise.getTime()) < -900000 ?
                    setTwilightBackground30() :

                    (sunset.getTime() - currentTime.getTime()) < -1800000 ||
                        (currentTime.getTime() - sunrise.getTime()) < -1800000 ?
                        setDarkBackground() :

                        document.body.style.backgroundImage = "url('./weerlive/pics/Background/Europa.png')"

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
                `<img src='weerlive/pics/wind_icon_w.png'> <br>
                     <font size="4">${data.liveweer[0].winds} Bft`;

            let arrow = document.getElementById('arrow');
            const img = document.createElement("img");

            while (arrow.firstChild) {
                arrow.removeChild(arrow.firstChild);
            }
            img.src = "./weerlive/pics/arrow.png";
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



