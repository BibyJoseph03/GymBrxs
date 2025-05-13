<?php
session_start();
require_once('includes/db_connect.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'] ?? null;
?>

<section class="hero">
  <h1>Welcome to GymBrxs</h1>
  <p>Your fitness journey starts here.</p>

  <?php if (!$user_id): ?>
    <a href="register.php" class="cta-button">Join Now</a>
  <?php endif; ?>
</section>

<section class="features">
    <h2>Why GymBrxs?</h2>
    <div class="feature-grid">
      <div class="feature">
        <h3>Real-Time Foot Traffic</h3>
        <p>Never show up to an overcrowded gym again. Check live occupancy levels before you go.</p>
      </div>
      <div class="feature">
        <h3>Personalized Schedules</h3>
        <p>Match gyms to your availability and preferences, ensuring the best fit for your lifestyle.</p>
      </div>
      <div class="feature">
        <h3>Smart Location Filters</h3>
        <p>See gyms nearby and filter by distance, amenities, and ratings.</p>
      </div>
      <div class="feature">
        <h3>Connect With Gym Brxs</h3>
        <p>Add friends, see who's nearby, and work out together for extra motivation.</p>
      </div>
    </div>
  </section>

<section class="profile-section">
  <h2>All Gyms in the System</h2>

  <?php
  $result = mysqli_query($conn,
    "SELECT gym_id, name, location, latitude, longitude, amenities, rating
     FROM gyms
     WHERE latitude IS NOT NULL AND longitude IS NOT NULL
       AND latitude != 0 AND longitude != 0"
  );
  ?>

  <?php if (mysqli_num_rows($result) === 0): ?>
    <p style="text-align:center; font-style: italic;">No gyms have been added yet.</p>
  <?php else: ?>
    <div class="feature-grid">
      <?php while ($gym = mysqli_fetch_assoc($result)): ?>
        <div class="feature">
          <h3><?= htmlspecialchars($gym['name']) ?></h3>

          <?php if (!empty($gym['location'])): ?>
            <p><strong>Location:</strong> <?= htmlspecialchars($gym['location']) ?></p>
          <?php endif; ?>

          <?php if (!empty($gym['rating'])): ?>
            <p><strong>Rating:</strong> ⭐ <?= htmlspecialchars($gym['rating']) ?></p>
          <?php endif; ?>

          <?php if (!empty($gym['amenities'])): ?>
            <p><strong>Amenities:</strong> <?= htmlspecialchars($gym['amenities']) ?></p>
          <?php endif; ?>

          <a href="gym_details.php?lat=<?= $gym['latitude'] ?>&lng=<?= $gym['longitude'] ?>"
             class="cta-button"
             style="margin-top: 0.5rem; display: inline-block;">
             View on Map
          </a>

          <?php if ($user_id): ?>
            <form action="favorite_gym.php" method="POST" style="margin-top: 0.5rem;">
              <input type="hidden" name="gym_id" value="<?= $gym['gym_id'] ?>">
              <button type="submit" class="cta-button" style="background: #fbbf24;">⭐ Favorite</button>
            </form>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</section>

<?php include('includes/footer.php'); ?>
