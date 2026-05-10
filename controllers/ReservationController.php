<?php
// controllers/ReservationController.php
require_once 'models/ReservationModel.php';

class ReservationController {
    private $model;

    public function __construct() {
        $this->model = new ReservationModel();
    }

    public function index() {
        $active_page = 'reservation';
        
        $name = $checkin = $checkout = "";
        $contact_number = "";
        $room_capacity = $room_type = $payment_type = "";
        $errors = array();
        $billing_info = null;
        $success_msg = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit'])) {
                $name = trim($_POST['name']);
                $contact_number = trim($_POST['contact_number']);
                $checkin = $_POST['checkin'];
                $checkout = $_POST['checkout'];
                $room_capacity = isset($_POST['room_capacity']) ? $_POST['room_capacity'] : '';
                $room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';
                $payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
                
                if (empty($name)) $errors[] = "Customer name is required";
                if (empty($contact_number)) $errors[] = "Contact number is required";
                if (empty($checkin)) $errors[] = "Check-in date is required";
                if (empty($checkout)) $errors[] = "Check-out date is required";
                if (empty($room_capacity)) $errors[] = "No selected room capacity";
                if (empty($room_type)) $errors[] = "No selected room type";
                if (empty($payment_type)) $errors[] = "No selected type of payment";
                
                if (empty($errors)) {
                    $billing_info = $this->model->calculateBill($checkin, $checkout, $room_capacity, $room_type, $payment_type);
                    
                    if (isset($billing_info['error'])) {
                        $errors[] = $billing_info['error'];
                        $billing_info = null;
                    } else {
                        try {
                            $data = [
                                'name' => $name,
                                'contact_number' => $contact_number,
                                'checkin' => $checkin,
                                'checkout' => $checkout,
                                'room_capacity' => $room_capacity,
                                'room_type' => $room_type,
                                'payment_type' => $payment_type
                            ];
                            
                            if ($this->model->saveReservation($data, $billing_info)) {
                                $success_msg = "Reservation successful! Your record has been saved to the database.";
                            }
                        } catch(Exception $e) {
                            $errors[] = $e->getMessage();
                            $billing_info = null;
                        }
                    }
                }
            } elseif (isset($_POST['clear'])) {
                // Clear is handled automatically if we don't save post data to variables
                $name = $checkin = $checkout = "";
                $contact_number = "";
                $room_capacity = $room_type = $payment_type = "";
                $errors = array();
                $billing_info = null;
                $success_msg = "";
            }
        }

        require_once 'views/reservation.php';
    }
}
?>
