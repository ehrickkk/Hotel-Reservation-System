<?php
// controllers/AdminController.php
require_once 'models/AdminModel.php';
require_once 'models/ReservationModel.php';

class AdminController {
    private $adminModel;
    private $reservationModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
        $this->reservationModel = new ReservationModel();
    }

    public function login() {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            header("Location: index.php?page=admin_dashboard");
            exit();
        }

        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            if (empty($username) || empty($password)) {
                $error = "Please enter both username and password.";
            } else {
                try {
                    if ($this->adminModel->verifyLogin($username, $password)) {
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_username'] = $username;
                        
                        header("Location: index.php?page=admin_dashboard");
                        exit();
                    } else {
                        $error = "Invalid username or password.";
                    }
                } catch(Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        
        require_once 'views/admin_login.php';
    }

    public function dashboard() {
        $this->checkAuth();

        $msg = "";
        $msgType = "";

        if (isset($_GET['delete'])) {
            $delete_id = $_GET['delete'];
            try {
                if ($this->reservationModel->deleteReservation($delete_id)) {
                    $msg = "Reservation record completely deleted.";
                    $msgType = "success";
                }
            } catch(Exception $e) {
                $msg = $e->getMessage();
                $msgType = "error";
            }
        }

        try {
            $reservations = $this->reservationModel->getAllReservations();
        } catch(Exception $e) {
            die($e->getMessage());
        }

        require_once 'views/admin_dashboard.php';
    }

    public function edit() {
        $this->checkAuth();

        $msg = "";
        $msgType = "";
        $reservation = null;

        if (isset($_GET['id'])) {
            $edit_id = $_GET['id'];
            try {
                $reservation = $this->reservationModel->getReservationById($edit_id);
                if (!$reservation) {
                    die("Record not found.");
                }
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            header("Location: index.php?page=admin_dashboard");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = trim($_POST['name']);
            $contact = trim($_POST['contact']);
            
            try {
                // The update function expects data and billing_info. In AdminEdit, we only update name and contact.
                // We'll pass the existing data for the rest.
                $data = [
                    'name' => $name,
                    'contact_number' => $contact,
                    'checkin' => $reservation['checkin_date'],
                    'checkout' => $reservation['checkout_date'],
                    'room_capacity' => $reservation['room_capacity'],
                    'room_type' => $reservation['room_type'],
                    'payment_type' => $reservation['payment_type']
                ];
                
                $billing_info = [
                    'days' => $reservation['days'],
                    'rate_per_day' => $reservation['rate_per_day'],
                    'subtotal' => $reservation['subtotal'],
                    'payment_charge' => $reservation['payment_charge'],
                    'discount' => $reservation['discount'],
                    'total' => $reservation['total_amount']
                ];

                if ($this->reservationModel->updateReservation($id, $data, $billing_info)) {
                    $msg = "Reservation updated successfully!";
                    $msgType = "success";
                    $reservation['customer_name'] = $name;
                    $reservation['contact_number'] = $contact;
                }
            } catch(Exception $e) {
                $msg = $e->getMessage();
                $msgType = "error";
            }
        }

        require_once 'views/admin_edit.php';
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();
        
        // Redirect to Home.php (or index.php?page=home)
        header("Location: index.php?page=home");
        exit();
    }

    private function checkAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header("Location: index.php?page=admin_login");
            exit();
        }
    }
}
?>
