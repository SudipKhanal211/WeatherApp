// fetching aip
async function getWeather() {
    // api link
    const response = await fetch(
      "https://api.openweathermap.org/data/2.5/weather?q=Johor&lat=57&lon=-2.15&appid=65260a11e70c073c5526fe09eb332472&units=metric"
    );
    // fetching api for defealt city:
    var data = await response.json();
    console.log(data);

    // fetching data for required content:
    document.querySelector(".City").innerHTML = data.name;
    document.querySelector(".temp").innerHTML =
    Math.round(data.main.temp) + "°C";
    document.querySelector(".humidity").innerHTML =
    data.main.humidity + "%";
    document.querySelector(".wind").innerHTML = data.wind.speed + "Km\h";
    const icon1=data.weather[0].icon
    document.getElementById("image").src=`https://openweathermap.org/img/wn/${icon1}@2x.png`
    document.querySelector(".pressure").innerHTML=data.main.pressure
    document.querySelector(".condition").innerHTML=data.weather[0].main+","+data.weather[0].description


    let timestampOffset = data.timezone;
   const timestamp = Math.floor(Date.now() / 1000) + timestampOffset;
   const date = new Date(timestamp * 1000);
   const localDateTime = date.toLocaleString("en-US", {
     weekday: "long",
     day: "numeric",
     month: "short",
     year: "numeric",
     hour: "numeric",
     minute: "numeric",
     timeZone: "UTC",
   });
   document.querySelector(".date").innerHTML=localDateTime

  }
  getWeather();

  // fetching API for searched city
  const searchBox = document.querySelector(".search input");
  const searchbth = document.querySelector(".search button");
  async function searchWeather(city) {
    const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&lat=57&lon=-2.15&appid=65260a11e70c073c5526fe09eb332472&units=metric`
    );
    var data = await response.json();
    if(response.status==404){
      document.querySelector(".error").style.display="block"
      document.getElementById("hide").style.display="none"
    }
    // console.log(data);
    else{
      // fetching data for required content:
     document.querySelector(".City").innerHTML = data.name;
     document.querySelector(".temp").innerHTML =
     Math.round(data.main.temp) + "°C";
     document.querySelector(".humidity").innerHTML =
     data.main.humidity + "%";
     document.querySelector(".wind").innerHTML = data.wind.speed + "Km\h";
     const icon1=data.weather[0].icon
     document.getElementById("image").src=`https://openweathermap.org/img/wn/${icon1}@2x.png`
}
    }
  // https://openweathermap.org/img/wn/10d@2x.png
  searchbth.addEventListener("click", () => {
    if (searchBox.value===""){
      alert("Enter a city")
    }else{
    searchWeather(searchBox.value);}
  });

//   name: Sudip Khanal.
//  student number: 2418113