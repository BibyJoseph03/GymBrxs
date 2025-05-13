<?php
session_start();
require_once('includes/db_connect.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
  echo "<p style='text-align:center; color:red;'>Please log in to view your dashboard.</p>";
  include('includes/footer.php');
  exit;
}

// Pull gyms the user has favorited
$result = mysqli_query($conn,
  "SELECT g.gym_id, g.name, g.location, g.latitude, g.longitude, g.amenities, g.rating
   FROM gyms g
   INNER JOIN favorites f ON g.gym_id = f.gym_id
   WHERE f.user_id = $user_id
     AND g.latitude IS NOT NULL AND g.longitude IS NOT NULL
     AND g.latitude != 0 AND g.longitude != 0"
);
?>

<section class="profile-section">
  <h2>Your Saved Gyms</h2>

  <?php if (mysqli_num_rows($result) === 0): ?>
    <p style="text-align:center; font-style: italic;">You haven’t favorited any gyms yet.</p>
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

          <a
            href="gym_details.php?lat=<?= $gym['latitude'] ?>&lng=<?= $gym['longitude'] ?>"
            class="cta-button"
            style="margin-top: 0.5rem; display: inline-block;"
          >
            View on Map
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</section>

<?php include('includes/footer.php'); ?>
