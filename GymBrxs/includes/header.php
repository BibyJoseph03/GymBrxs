<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GymBrxs</title>
  <link rel="stylesheet" href="/GymBrxs/style.css?v=<?= time(); ?>" />
</head>
<body>
  <header>
    <h1>GymBrxs</h1>
    <nav>
      <a href="/GymBrxs/index.php">Home</a>
      <a href="/GymBrxs/gym_details.php">My Gym Map</a>
      <a href="/GymBrxs/search.php">Search</a>
      <a href="/GymBrxs/dashboard.php">Dashboard</a>


      <?php if ($isLoggedIn): ?>
        <a href="/GymBrxs/profile.php">Profile</a>
        <a href="/GymBrxs/logout.php">Logout</a>
      <?php else: ?>
        <a href="/GymBrxs/login.php">Login</a>
        <a href="/GymBrxs/register.php">Register</a>
      <?php endif; ?>
    </nav>
  </header>
