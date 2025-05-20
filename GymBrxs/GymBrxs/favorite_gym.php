<?php
session_start();
require_once('includes/db_connect.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['gym_id'])) {
  header("Location: index.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$gym_id = intval($_POST['gym_id']);

$sql = "INSERT IGNORE INTO favorites (user_id, gym_id) VALUES ($user_id, $gym_id)";
mysqli_query($conn, $sql);

header("Location: index.php");
exit;
?>
