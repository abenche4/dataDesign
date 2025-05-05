<!DOCTYPE html>
<html>
<head>
  <title>User Profile</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Welcome, <?= htmlspecialchars($user['userName']) ?>!</h1>
  <p><strong>Type:</strong> <?= htmlspecialchars($user['userType']) ?></p>
  <p><strong>Contact:</strong> <?= htmlspecialchars($user['contactInfo']) ?></p>

  <h2>Your Prescriptions</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Medication</th>
      <th>Dosage Instructions</th>
      <th>Quantity</th>
      <th>Date</th>
    </tr>
    <?php foreach ($user['prescriptions'] as $rx): ?>
      <tr>
        <td><?= $rx['prescriptionId'] ?></td>
        <td><?= $rx['medicationName'] ?></td>
        <td><?= $rx['dosageInstructions'] ?></td>
        <td><?= $rx['quantity'] ?></td>
        <td><?= $rx['prescribedDate'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <p><a href="PharmacyServer.php">Back to Home</a></p>
</body>
</html>
