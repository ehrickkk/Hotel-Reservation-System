<?php
// models/ReservationModel.php
require_once __DIR__ . '/Database.php';

class ReservationModel {
    private $pdo;

    // Room rates
    private $room_rates = array(
        'Single' => array('Regular' => 100, 'De Luxe' => 300, 'Suite' => 500),
        'Double' => array('Regular' => 200, 'De Luxe' => 500, 'Suite' => 800),
        'Family' => array('Regular' => 500, 'De Luxe' => 750, 'Suite' => 1000)
    );

    // Payment charges
    private $payment_charges = array(
        'Cash' => 0,
        'Check' => 0.05,
        'Credit Card' => 0.10
    );

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function calculateBill($checkin, $checkout, $room_capacity, $room_type, $payment_type) {
        $date1 = new DateTime($checkin);
        $date2 = new DateTime($checkout);
        $interval = $date1->diff($date2);
        $days = $interval->days;
        
        if ($days <= 0) {
            return array('error' => 'Check-out date must be after check-in date');
        }
        
        $rate_per_day = $this->room_rates[$room_capacity][$room_type];
        $subtotal = $rate_per_day * $days;
        
        $payment_charge = $subtotal * $this->payment_charges[$payment_type];
        
        $discount = 0;
        if ($payment_type == 'Cash') {
            if ($days >= 6) {
                $discount = $subtotal * 0.15; // 15% discount for 6+ days
            } elseif ($days >= 3) {
                $discount = $subtotal * 0.10; // 10% discount for 3-5 days
            }
        }
        
        $total = $subtotal + $payment_charge - $discount;
        
        return array(
            'days' => $days,
            'rate_per_day' => $rate_per_day,
            'subtotal' => $subtotal,
            'payment_charge' => $payment_charge,
            'discount' => $discount,
            'total' => $total
        );
    }

    public function saveReservation($data, $billing_info) {
        try {
            $sql = "INSERT INTO reservations (customer_name, contact_number, checkin_date, checkout_date, room_capacity, room_type, payment_type, days, rate_per_day, subtotal, payment_charge, discount, total_amount) 
                    VALUES (:name, :contact, :chk_in, :chk_out, :cap, :r_type, :p_type, :days, :rate, :subtotal, :charge, :discount, :total)";
                    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':contact', $data['contact_number']);
            $stmt->bindParam(':chk_in', $data['checkin']);
            $stmt->bindParam(':chk_out', $data['checkout']);
            $stmt->bindParam(':cap', $data['room_capacity']);
            $stmt->bindParam(':r_type', $data['room_type']);
            $stmt->bindParam(':p_type', $data['payment_type']);
            $stmt->bindParam(':days', $billing_info['days']);
            $stmt->bindParam(':rate', $billing_info['rate_per_day']);
            $stmt->bindParam(':subtotal', $billing_info['subtotal']);
            $stmt->bindParam(':charge', $billing_info['payment_charge']);
            $stmt->bindParam(':discount', $billing_info['discount']);
            $stmt->bindParam(':total', $billing_info['total']);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }

    public function getAllReservations() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM reservations ORDER BY created_at DESC");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            throw new Exception("Database fetch error: " . $e->getMessage());
        }
    }

    public function getReservationById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch(PDOException $e) {
            throw new Exception("Database fetch error: " . $e->getMessage());
        }
    }

    public function deleteReservation($id) {
        try {
            $sql = "DELETE FROM reservations WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception("Error deleting record: " . $e->getMessage());
        }
    }

    public function updateReservation($id, $data, $billing_info) {
        try {
            $sql = "UPDATE reservations SET 
                        customer_name = :name, 
                        contact_number = :contact, 
                        checkin_date = :chk_in, 
                        checkout_date = :chk_out, 
                        room_capacity = :cap, 
                        room_type = :r_type, 
                        payment_type = :p_type, 
                        days = :days, 
                        rate_per_day = :rate, 
                        subtotal = :subtotal, 
                        payment_charge = :charge, 
                        discount = :discount, 
                        total_amount = :total 
                    WHERE id = :id";
                    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':contact', $data['contact_number']);
            $stmt->bindParam(':chk_in', $data['checkin']);
            $stmt->bindParam(':chk_out', $data['checkout']);
            $stmt->bindParam(':cap', $data['room_capacity']);
            $stmt->bindParam(':r_type', $data['room_type']);
            $stmt->bindParam(':p_type', $data['payment_type']);
            $stmt->bindParam(':days', $billing_info['days']);
            $stmt->bindParam(':rate', $billing_info['rate_per_day']);
            $stmt->bindParam(':subtotal', $billing_info['subtotal']);
            $stmt->bindParam(':charge', $billing_info['payment_charge']);
            $stmt->bindParam(':discount', $billing_info['discount']);
            $stmt->bindParam(':total', $billing_info['total']);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception("Database update error: " . $e->getMessage());
        }
    }
}
?>
