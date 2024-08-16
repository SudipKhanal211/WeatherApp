<?php
$servername = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['city'])) {
    $city = $_GET['city'];
} else {
    $city = "Johor";
}
$select_db = mysqli_select_db($con, "weather");

if (!$select_db) {
    die("Database selection failed: " . mysqli_error($con));
}

$select_query = "SELECT * FROM weather_data WHERE city='$city' AND date > NOW() - INTERVAL 6 DAY ORDER BY date DESC";
$data = mysqli_query($con, $select_query);

if (!$data) {
    die("Query failed: " . mysqli_error($con));
}

$emp_array = [];
while ($row = mysqli_fetch_assoc($data)) {
    array_push($emp_array, $row);
}

echo json_encode($emp_array);

// Close the connection
mysqli_close($con);
?>
