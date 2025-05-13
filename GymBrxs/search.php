<?php
require_once('includes/db_connect.php');
include('includes/header.php');

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name      = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
  $location  = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
  $latitude  = floatval($_POST['latitude'] ?? 0);
  $longitude = floatval($_POST['longitude'] ?? 0);
  $amenities = mysqli_real_escape_string($conn, $_POST['amenities'] ?? '');
  $rating    = floatval($_POST['rating'] ?? 0);

  if (!$name || !$location || !$latitude || !$longitude) {
    $msg = "❌ Missing required fields. Please complete the form.";
  } else {
    // Check for duplicates
    $check = mysqli_query($conn,
      "SELECT * FROM gyms
       WHERE name = '$name'
       AND ABS(latitude - $latitude) < 0.0001
       AND ABS(longitude - $longitude) < 0.0001"
    );

    if (mysqli_num_rows($check) > 0) {
      $msg = "⚠️ This gym is already in the system.";
    } else {
      $sql = "INSERT INTO gyms (name, location, latitude, longitude, amenities, rating)
              VALUES ('$name', '$location', $latitude, $longitude, '$amenities', $rating)";
      if (mysqli_query($conn, $sql)) {
        $msg = "✅ Gym saved successfully!";
      } else {
        $msg = "❌ Insert error: " . mysqli_error($conn);
      }
    }
  }
}
?>

<section class="form-section">
  <h2>Add a New Gym</h2>

  <?php if (!empty($msg)) echo "<p style='text-align:center;'>$msg</p>"; ?>

  <input id="pac-input" type="text" placeholder="Search for gym or location"
    style="width: 90%; padding: 0.5rem; margin-bottom: 1rem;" />

  <div id="map" style="height: 400px; width: 100%; max-width: 800px; margin: auto; border-radius: 8px;"></div>

  <form method="POST" action="search.php" class="form-box" style="margin-top: 2rem;">
    <label>Gym Name</label>
    <input type="text" name="name" id="gym-name" required>

    <label>Location</label>
    <input type="text" name="location" id="gym-location" required>

    <label>Latitude</label>
    <input type="text" name="latitude" id="gym-lat" readonly required>

    <label>Longitude</label>
    <input type="text" name="longitude" id="gym-lng" readonly required>

    <label>Amenities</label>
    <input type="text" name="amenities">

    <label>Rating (auto-filled)</label>
    <input type="number" step="0.1" name="rating" id="gym-rating">

    <button type="submit">Save Gym</button>
  </form>
</section>

<script>
  let map, marker;

  function initMap() {
    const center = { lat: 40.7128, lng: -74.0060 };
    map = new google.maps.Map(document.getElementById("map"), {
      center,
      zoom: 13
    });

    const input = document.getElementById("pac-input");
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo("bounds", map);
    autocomplete.setFields(["name", "geometry", "formatted_address", "rating"]);

    autocomplete.addListener("place_changed", () => {
      const place = autocomplete.getPlace();
      if (!place.geometry) {
        alert("No geometry found.");
        return;
      }

      const loc = place.geometry.location;
      map.setCenter(loc);
      map.setZoom(15);

      if (marker) marker.setMap(null);
      marker = new google.maps.Marker({
        map,
        position: loc
      });

      document.getElementById("gym-name").value = place.name || '';
      document.getElementById("gym-location").value = place.formatted_address || '';
      document.getElementById("gym-lat").value = loc.lat();
      document.getElementById("gym-lng").value = loc.lng();
      document.getElementById("gym-rating").value = place.rating ?? '';
    });
  }
</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBNW9IFIsfu2BFvgPfIaBvYxZcRZyLhvk&libraries=places&callback=initMap">
</script>

<?php include('includes/footer.php'); ?>
