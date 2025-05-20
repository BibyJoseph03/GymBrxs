<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('includes/db_connect.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "User not found.";
  }
}
?>

<?php include('includes/header.php'); ?>

<section class="form-section">
  <div class="form-box">
    <h2>Login</h2>
    <?php if ($error): ?>
      <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
  </div>
</section>

<?php include('includes/footer.php'); ?>
