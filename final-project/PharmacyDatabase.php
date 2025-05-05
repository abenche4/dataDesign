<?php
class PharmacyDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "pharmacy_portal_db";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        // echo "Successfully connected to the database";
    }

    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity)  {
        $stmt = $this->connection->prepare(
            "SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'"
        );
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();
        
        if ($patientId){
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
            echo "Prescription added successfully";
        }else{
            echo "failed to add prescription";
        }
    }

    public function getPrescriptions($userId = null, $userType = null) {
        if ($userType === 'pharmacist') {
            $sql = "SELECT p.prescriptionId, p.userId, p.medicationId, m.medicationName,
                           p.dosageInstructions, p.quantity
                    FROM prescriptions p
                    JOIN medications m ON p.medicationId = m.medicationId";
            $result = $this->connection->query($sql);
        } else {
            $stmt = $this->connection->prepare("
                SELECT p.prescriptionId, p.userId, p.medicationId, m.medicationName,
                       p.dosageInstructions, p.quantity
                FROM prescriptions p
                JOIN medications m ON p.medicationId = m.medicationId
                WHERE p.userId = ?
            ");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function MedicationInventory() {
        $result = $this->connection->query("SELECT * FROM MedicationInventoryView");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addUser($userName, $contactInfo, $userType, $password = null) {
    if ($password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed = null;
    }

    $stmt = $this->connection->prepare("CALL AddOrUpdateUser(?, ?, ?, ?)");
    $null = null;
    $stmt->bind_param("isss", $null, $userName, $contactInfo, $userType);
    $stmt->execute();
    $stmt->close();

    if ($hashed) {
        // Store hashed password if it's a new user
        $stmt = $this->connection->prepare("UPDATE Users SET passwordHash = ? WHERE userName = ?");
        $stmt->bind_param("ss", $hashed, $userName);
        $stmt->execute();
        $stmt->close();
    }


    }

    public function getUserByUsername($userName) {
        $stmt = $this->connection->prepare(
            "SELECT userId, userName, userType FROM Users WHERE userName = ? LIMIT 1"
        );
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;  // ['userId'=>…, 'userName'=>…, 'userType'=>…] or null
    }

    public function getUserDetails($userId) {
    // Get basic user info
    $stmt = $this->connection->prepare("
        SELECT userId, userName, userType, contactInfo 
        FROM Users 
        WHERE userId = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        return null;
    }

    // Get user's prescriptions
    $stmt = $this->connection->prepare("
        SELECT p.prescriptionId, p.medicationId, m.medicationName,
               p.dosageInstructions, p.quantity, p.prescribedDate
        FROM Prescriptions p
        JOIN Medications m ON p.medicationId = m.medicationId
        WHERE p.userId = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescriptions = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Attach prescriptions to user data
    $user['prescriptions'] = $prescriptions;

    return $user;
}
public function getConnection() {
    return $this->connection;
}
}
?>