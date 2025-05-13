<?php
session_start();
require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/functions.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = mysqli_real_escape_string($conn, trim($_POST['email']));
  $hours = mysqli_real_escape_string($conn, trim($_POST['available_hours']));
  $location = mysqli_real_escape_string($conn, trim($_POST['location']));

  $sql = "UPDATE users
          SET email = '$email',
              available_hours = '$hours',
              location = '$location'
          WHERE user_id = $user_id";

  if (mysqli_query($conn, $sql)) {
    $success = 'Profile updated.';
  } else {
    $error = 'Update failed: ' . mysqli_error($conn);
  }
}

// Fetch current user data
$res = mysqli_query($conn, "SELECT email, available_hours, location FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($res);

include('includes/header.php');
?>

<section class="profile-section">
  <h2>Your Profile</h2>

  <?php if ($error): ?>
    <p style="color:red; text-align:center;"><?= $error ?></p>
  <?php elseif ($success): ?>
    <p style="color:green; text-align:center;"><?= $success ?></p>
  <?php endif; ?>

  <form method="post" class="form-box">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>

    <label for="available_hours">Available Hours</label>
    <input type="text" id="available_hours" name="available_hours" value="<?= htmlspecialchars($user['available_hours'] ?? '') ?>">

    <label for="location">Location</label>
    <input type="text" id="location" name="location" value="<?= htmlspecialchars($user['location'] ?? '') ?>">

    <button type="submit">Update Profile</button>
  </form>
</section>

<?php include('includes/footer.php'); ?>
