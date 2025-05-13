<?php
require_once('includes/db_connect.php');
header('Content-Type: application/json');

$sql = "SELECT gym_id, name, latitude, longitude, location, amenities, rating
        FROM gyms
        WHERE latitude IS NOT NULL AND longitude IS NOT NULL
          AND latitude != 0 AND longitude != 0";

$result = mysqli_query($conn, $sql);

$gyms = [];

while ($row = mysqli_fetch_assoc($result)) {
    $gyms[] = $row;
}

echo json_encode($gyms);
?>
