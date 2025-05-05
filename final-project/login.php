<?php
session_start();
require_once 'PharmacyDatabase.php';
$db = new PharmacyDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $db->getConnection()->prepare(
        "SELECT userId, userName, userType, passwordHash FROM Users WHERE userName = ?"
    );
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id, $uname, $utype, $hash);
    $stmt->fetch();
    $stmt->close();

    if ($hash && password_verify($password, $hash)) {
        $_SESSION['userId'] = $id;
        $_SESSION['userName'] = $uname;
        $_SESSION['userType'] = $utype;
        header('Location: PharmacyServer.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Login</h1>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="registration.php">Register here</a></p>
</body>
</html>
