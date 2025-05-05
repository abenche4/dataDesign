<?php
require_once 'PharmacyDatabase.php';
$db = new PharmacyDatabase();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $contact = trim($_POST['contact']);
    $type = $_POST['user_type'];
    $password = $_POST['password'];

    if ($username && $contact && $type && $password) {
        $db->addUser($username, $contact, $type, $password);
        $message = "User '$username' registered successfully!";
    } else {
        $message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Register</h1>
  <?php if (!empty($message)) echo "<p>$message</p>"; ?>
  <form method="POST">
    Username: <input type="text" name="username" required><br>
    Contact Info: <input type="text" name="contact" required><br>
    User Type:
    <select name="user_type" required>
      <option value="patient">Patient</option>
      <option value="pharmacist">Pharmacist</option>
    </select><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
  </form>
  <p><a href="login.php">Back to Login</a></p>
</body>
</html>
