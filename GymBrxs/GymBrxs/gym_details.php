<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include('includes/header.php');
?>

<section class="map-section">
  <h2>Nearby Gyms</h2>

  <?php if (!$isLoggedIn): ?>
    <p style="text-align: center; color: red; font-weight: bold;">
      🔒 Please log in to view gyms on the map.
    </p>
  <?php endif; ?>

  <div id="map" style="height: 500px; width: 100%; max-width: 1000px; margin: auto; border-radius: 8px;"></div>
</section>

<script>
  const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

  function getURLParam(key) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has(key) ? parseFloat(urlParams.get(key)) : null;
  }

  function initMap() {
    const latParam = getURLParam('lat');
    const lngParam = getURLParam('lng');

    const map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 40.7128, lng: -74.0060 },
      zoom: 12
    });

    let userLat = null;
    let userLng = null;

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(position => {
        userLat = position.coords.latitude;
        userLng = position.coords.longitude;

        const userPosition = { lat: userLat, lng: userLng };

        new google.maps.Marker({
          position: userPosition,
          map,
          title: "You are here",
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            fillColor: '#4285F4',
            fillOpacity: 1,
            strokeWeight: 2,
            strokeColor: 'white'
          }
        });

        if (!latParam && !lngParam) {
          map.setCenter(userPosition);
        }

        if (isLoggedIn) {
          loadGyms(map, userLat, userLng, latParam, lngParam);
        }
      });
    } else {
      if (isLoggedIn) {
        loadGyms(map, null, null, latParam, lngParam);
      }
    }
  }

  function loadGyms(map, userLat, userLng, latParam, lngParam) {
    fetch('get_gyms.php')
      .then(response => response.json())
      .then(gyms => {
        if (userLat !== null && userLng !== null) {
          gyms.sort((a, b) => {
            const distA = Math.hypot(userLat - a.latitude, userLng - a.longitude);
            const distB = Math.hypot(userLat - b.latitude, userLng - b.longitude);
            return distA - distB;
          });
        }

        gyms.forEach(gym => {
          const lat = parseFloat(gym.latitude);
          const lng = parseFloat(gym.longitude);
          const pos = { lat, lng };

          const marker = new google.maps.Marker({
            position: pos,
            map,
            title: gym.name
          });

          const infoWindow = new google.maps.InfoWindow({
            content: `
              <div style="max-width: 250px;">
                <strong>${gym.name}</strong><br>
                ${gym.location ?? ''}<br>
                ${gym.amenities ? `<p>Amenities: ${gym.amenities}</p>` : ''}
                ${gym.rating ? `<p>Rating: ⭐ ${gym.rating}</p>` : ''}
                ${userLat !== null ? `<p><em>Distance: ${calculateDistance(userLat, userLng, lat, lng)} km</em></p>` : ''}
              </div>
            `
          });

          marker.addListener('click', () => infoWindow.open(map, marker));

          if (latParam && lngParam &&
              Math.abs(lat - latParam) < 0.0001 &&
              Math.abs(lng - lngParam) < 0.0001) {
            infoWindow.open(map, marker);
          }
        });
      });
  }

  function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(lat1 * Math.PI / 180) *
      Math.cos(lat2 * Math.PI / 180) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return (R * c).toFixed(2);
  }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBNW9IFIsfu2BFvgPfIaBvYxZcRZyLhvk&callback=initMap"></script>

<?php include('includes/footer.php'); ?>
