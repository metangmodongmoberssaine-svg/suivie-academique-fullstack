// SCREENS ---------------------------------------
const screenError = document.getElementById("screen-error");
const screenLogin = document.getElementById("screen-login");
const screenApp = document.getElementById("screen-app");

// BUTTONS ---------------------------------------
const retryBtn = document.getElementById("retry-btn");
const enterAppBtn = document.getElementById("enter-app-btn");
const searchBtn = document.getElementById("search-btn");

// INPUT -----------------------------------------
const searchInput = document.getElementById("search-input");

// DROPDOWN MENUS --------------------------------
const unitsBtn = document.getElementById("units-btn");
const unitsMenu = document.getElementById("units-menu");

const unitsBtn2 = document.getElementById("units-btn2");
const unitsMenu2 = document.getElementById("units-menu2");

// API -------------------------------------------
const API_KEY = "3d3ffb52ed69feb26ce6477964999d6d"; // <<<<<<<<<<<<<< METS TA CLÉ

// NAVIGATION ------------------------------------
retryBtn.addEventListener("click", () => {
    screenError.classList.add("hidden");
    screenLogin.classList.remove("hidden");
});

enterAppBtn.addEventListener("click", () => {
    screenLogin.classList.add("hidden");
    screenApp.classList.remove("hidden");
});

// DROPDOWN UNITS --------------------------------
unitsBtn.addEventListener("click", () => {
    unitsMenu.classList.toggle("hidden");
});

unitsBtn2.addEventListener("click", () => {
    unitsMenu2.classList.toggle("hidden");
});

// Close dropdown when click outside
document.addEventListener("click", (e) => {
    if (!unitsBtn.contains(e.target) && !unitsMenu.contains(e.target)) {
        unitsMenu.classList.add("hidden");
    }
    if (!unitsBtn2.contains(e.target) && !unitsMenu2.contains(e.target)) {
        unitsMenu2.classList.add("hidden");
    }
});

// WEATHER SEARCH --------------------------------
searchBtn.addEventListener("click", () => {
    let city = searchInput.value.trim();
    if (city.length === 0) return;

    fetchWeather(city);
});

async function fetchWeather(city) {
    try {
        const url =
            `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${API_KEY}&units=metric`;
        
        const response = await fetch(url);
        if (!response.ok) throw new Error("API error");

        const data = await response.json();

        updateMainWeather(data);
        updateDaily();
        updateHourly();
    }
    catch (err) {
        screenApp.classList.add("hidden");
        screenError.classList.remove("hidden");
    }
}

// UPDATE UI MAIN WEATHER -------------------------
function updateMainWeather(data) {
    document.getElementById("city-name").textContent =
        `${data.name}, ${data.sys.country}`;
    
    document.getElementById("date-text").textContent =
        new Date().toDateString();

    document.getElementById("big-temp").textContent =
        Math.round(data.main.temp) + "°";

    document.getElementById("feels-like").textContent =
        Math.round(data.main.feels_like) + "°";

    document.getElementById("humidity").textContent =
        data.main.humidity + "%";

    document.getElementById("wind").textContent =
        data.wind.speed + " km/h";

    document.getElementById("precip").textContent = "0 mm";

    document.getElementById("weather-icon").textContent = pickEmoji(data.weather[0].main);
}

function pickEmoji(condition) {
    switch (condition) {
        case "Clear": return "☀️";
        case "Clouds": return "☁️";
        case "Rain": return "🌧️";
        case "Snow": return "❄️";
        case "Thunderstorm": return "⛈️";
        default: return "🌡️";
    }
}

// DUMMY DAILY + HOURLY ----------------------------------
function updateDaily() {
    const container = document.getElementById("daily-forecast");
    container.innerHTML = "";

    const days = ["Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "Mon"];

    days.forEach(day => {
        container.innerHTML += `
            <div class="forecast-card">
                <p>${day}</p>
                <img src="https://img.icons8.com/fluency/48/cloud.png">
                <p>20°</p>
            </div>
        `;
    });
}

function updateHourly() {
    const container = document.getElementById("hourly-forecast");
    container.innerHTML = "";

    const hours = ["3 PM","4 PM","5 PM","6 PM","7 PM","8 PM","9 PM","10 PM"];

    hours.forEach(h => {
        container.innerHTML += `
            <div class="forecast-card">
                <p>${h}</p>
                <img src="https://img.icons8.com/fluency/48/cloud.png">
                <p>18°</p>
            </div>
        `;
    });
}
