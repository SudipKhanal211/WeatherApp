<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Failed to connect to MySQL: " . $conn->connect_error);
}

if (isset($_GET['city']) && !empty($_GET['city'])) {
    $city = $_GET['city'];
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid=b47c4825a61febc09405d85ef9ad589e&units=metric";
    $response = file_get_contents($url);

    if ($response === false) {
        die("Failed to get weather data");
    }
    
    $data = json_decode($response, true);

    $city = $data['name'];
    $country = $data['sys']['country'];
    $weather_condition = $data['weather'][0]['main'];
    $temperature = $data['main']['temp'];
    $feels_like = $data['main']['feels_like'];
    $pressure = $data['main']['pressure'];
    $humidity = $data['main']['humidity'];
    $wind_speed = $data['wind']['speed'];
    $icon = "https://openweathermap.org/img/w/{$data['weather'][0]['icon']}.png";

    $insertData = "INSERT INTO weather (city, country, weather_condition, temperature, feels_like, pressure, humidity, wind_speed, icon_url, date) VALUES ('$city', '$country', '$weather_condition', $temperature, $feels_like, $pressure, $humidity, $wind_speed, '$icon', NOW())";

    if ($conn->query($insertData)) {
        echo json_encode(["message" => "Data for city '$city' inserted successfully."]);
    } else {
        echo json_encode(["error" => "Failed to insert data: " . $conn->error]);
    }
} else {
    $allCityData = "SELECT * FROM weather_data";
    $result = $conn->query($allCityData);

    if ($result) {
        $allDataArray = array();
        while ($row = $result->fetch_assoc()) {
            $allDataArray[] = $row;
        }
        echo json_encode($allDataArray);
    } else {
        echo json_encode(["error" => "Error fetching all city data: " . $conn->error]);
    }
}

$conn->close();
?>