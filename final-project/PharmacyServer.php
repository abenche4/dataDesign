

<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}
require_once 'PharmacyDatabase.php';

class PharmacyPortal {
    private $db;

    public function __construct() {
        $this->db = new PharmacyDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'addPrescription':
                $this->addPrescription();
                break;
            case 'viewPrescriptions':
                $this->viewPrescriptions();
                break;
            case 'viewInventory':
                $this->viewInventory();
                break;
            case 'userDetails':
                $this->showUserDetails();
                break;
            case 'addUser':
                $this->addUser();
                break;
                case 'profile':
                    $this->viewProfile();
                    break;
            default:
                $this->home();
        }
    }

    private function home() {
        include 'templates/home.php';
    }

    private function addPrescription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientUserName = $_POST['patient_username'];
            $medicationId= $_POST['medication_id'];
            $dosageInstructions = $_POST['dosage_instructions'];
            $quantity = $_POST['quantity'];

            $this->db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
            header("Location:?action=viewPrescriptions&message=Prescription Added");
        } else {
            include 'templates/addPrescription.php';
        }
    }

    private function viewPrescriptions() {
        $userId = $_SESSION['userId'];
        $userType = $_SESSION['userType'];
    
        $prescriptions = $this->db->getPrescriptions($userId, $userType);
        include 'templates/viewPrescriptions.php';
    }

    private function viewInventory() {
        $inventory = $this->db->MedicationInventory();
        include 'templates/viewInventory.php';
    }

    private function showUserDetails() {
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            echo "User ID is required.";
            return;
        }
    
        $details = $this->db->getUserDetails($userId);
        echo "<pre>";
        print_r($details);
        echo "</pre>";
    }

    private function viewProfile() {
    // session_start();
    if (!isset($_SESSION['userId'])) {
        echo "You must be logged in.";
        return;
    }

    $userId = $_SESSION['userId'];
    $user = $this->db->getUserDetails($userId);
    include 'templates/profile.php';
}

public function getConnection() {
    return $this->connection;
}
}

$portal = new PharmacyPortal();
$portal->handleRequest();