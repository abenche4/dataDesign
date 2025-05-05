<!DOCTYPE html>
<html>
<head>
  <title>Inventory</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Medication Inventory</h1>
  <table border="1">
    <tr>
      <th>Medication ID</th>
      <th>Name</th>
      <th>Dosage</th>
      <th>Manufacturer</th>
      <th>Quantity Available</th>
      <th>Last Updated</th>
    </tr>
    <?php if (empty($inventory)): ?>
      <tr><td colspan="6">No inventory data found.</td></tr>
    <?php else: ?>
      <?php foreach ($inventory as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['medicationId']) ?></td>
          <td><?= htmlspecialchars($item['medicationName']) ?></td>
          <td><?= htmlspecialchars($item['dosage']) ?></td>
          <td><?= htmlspecialchars($item['manufacturer']) ?></td>
          <td><?= htmlspecialchars($item['quantityAvailable']) ?></td>
          <td><?= htmlspecialchars($item['lastUpdated']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </table>
  <p><a href="PharmacyServer.php">Back to Home</a></p>
</body>
</html>
