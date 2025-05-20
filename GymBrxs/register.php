<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $password);

  if ($stmt->execute()) {
    header("Location: login.php");
    exit;
  } else {
    $error = "Registration failed.";
  }
}
?>

<?php include('includes/header.php'); ?>

<section class="form-section">
  <form class="form-box" method="POST" action="register.php">
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login here</a></p>
</section>

<?php include('includes/footer.php'); ?>
