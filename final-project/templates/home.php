<!-- <html>
<head><title>Pharmacy Portal</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Pharmacy Portal</h1>
    <nav>
        <a href="?action=addPrescription" class="nav-link">Add Prescription</a>
        <a href="?action=viewPrescriptions" class="nav-link">View Prescriptions</a>
        <a href="?action=viewInventory" class="nav-link">View Inventory</a> 
        <a href="?action=profile" class="nav-link">View My Profile</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>
</body>
</html> -->

<!-- <?php session_start(); ?> -->
<html>
<head><title>Pharmacy Portal</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Pharmacy Portal</h1>
  <nav>
    <?php if ($_SESSION['userType'] === 'pharmacist'): ?>
      <a href="?action=addPrescription" class="nav-link">Add Prescription</a>
    <?php endif; ?>

    <a href="?action=viewPrescriptions" class="nav-link">View Prescriptions</a>

    <?php if ($_SESSION['userType'] === 'pharmacist'): ?>
      <a href="?action=viewInventory" class="nav-link">View Inventory</a>
    <?php endif; ?>

    <a href="?action=profile" class="nav-link">View My Profile</a>
    <a href="logout.php" class="nav-link">Logout</a>
  </nav>
</body>
</html>