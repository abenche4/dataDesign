<!-- <html>
<head><title>Add Prescription</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Add Reservation</h1>
    <form method="POST" action="?action=addPrescription">
        Patient Username: <input type="text" name="patient_username" /><br>
        Medication ID : <input type="number" name="medication_id"/><br>
        Dossage Instructions: <textarea name="dosage_instructions"></textarea><br>
        Quantity: <input type="number" name="quantity" /><br>
        <button type="submit">Save</button>
    </form>
    <a href="PharmacyServer.php">Back to Home</a>
</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
  <title>Add Prescription</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Add Prescription</h1>
  <form method="POST" action="?action=addPrescription">
    <label>Patient Username:</label><br>
    <input type="text" name="patient_username" required><br><br>

    <label>Medication ID:</label><br>
    <input type="number" name="medication_id" required><br><br>

    <label>Dosage Instructions:</label><br>
    <textarea name="dosage_instructions" required></textarea><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required><br><br>

    <button type="submit">Save</button>
  </form>
  <p><a href="PharmacyServer.php">Back to Home</a></p>
</body>
</html>