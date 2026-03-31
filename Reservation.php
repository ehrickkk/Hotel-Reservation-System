<?php
session_start();
require_once 'db.php'; // Include database connection

// Initialize variables
$name = $checkin = $checkout = "";
$contact_number = "";
$room_capacity = $room_type = $payment_type = "";
$errors = array();
$billing_info = null;
$success_msg = "";

// Room rates
$room_rates = array(
    'Single' => array('Regular' => 100, 'De Luxe' => 300, 'Suite' => 500),
    'Double' => array('Regular' => 200, 'De Luxe' => 500, 'Suite' => 800),
    'Family' => array('Regular' => 500, 'De Luxe' => 750, 'Suite' => 1000)
);

// Payment charges
$payment_charges = array(
    'Cash' => 0,
    'Check' => 0.05,
    'Credit Card' => 0.10
);

function calculateBill($checkin, $checkout, $room_capacity, $room_type, $payment_type, $room_rates, $payment_charges) {
    // Calculate number of days
    $date1 = new DateTime($checkin);
    $date2 = new DateTime($checkout);
    $interval = $date1->diff($date2);
    $days = $interval->days;
    
    if ($days <= 0) {
        return array('error' => 'Check-out date must be after check-in date');
    }
    
    // Get base rate
    $rate_per_day = $room_rates[$room_capacity][$room_type];
    $subtotal = $rate_per_day * $days;
    
    // Apply payment charge
    $payment_charge = $subtotal * $payment_charges[$payment_type];
    
    // Apply discount for cash payments
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Validate inputs
        $name = trim($_POST['name']);
        $contact_number = trim($_POST['contact_number']);
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $room_capacity = isset($_POST['room_capacity']) ? $_POST['room_capacity'] : '';
        $room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';
        $payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
        
        // Validation
        if (empty($name)) $errors[] = "Customer name is required";
        if (empty($contact_number)) $errors[] = "Contact number is required";
        if (empty($checkin)) $errors[] = "Check-in date is required";
        if (empty($checkout)) $errors[] = "Check-out date is required";
        if (empty($room_capacity)) $errors[] = "No selected room capacity";
        if (empty($room_type)) $errors[] = "No selected room type";
        if (empty($payment_type)) $errors[] = "No selected type of payment";
        
        // If no errors, calculate billing and INSERT to database using PDO
        if (empty($errors)) {
            $billing_info = calculateBill($checkin, $checkout, $room_capacity, $room_type, $payment_type, $room_rates, $payment_charges);
            
            if (isset($billing_info['error'])) {
                $errors[] = $billing_info['error'];
                $billing_info = null;
            } else {
                // PDO Database Insert
                try {
                    $sql = "INSERT INTO reservations (customer_name, contact_number, checkin_date, checkout_date, room_capacity, room_type, payment_type, days, rate_per_day, subtotal, payment_charge, discount, total_amount) 
                            VALUES (:name, :contact, :chk_in, :chk_out, :cap, :r_type, :p_type, :days, :rate, :subtotal, :charge, :discount, :total)";
                            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':contact', $contact_number);
                    $stmt->bindParam(':chk_in', $checkin);
                    $stmt->bindParam(':chk_out', $checkout);
                    $stmt->bindParam(':cap', $room_capacity);
                    $stmt->bindParam(':r_type', $room_type);
                    $stmt->bindParam(':p_type', $payment_type);
                    $stmt->bindParam(':days', $billing_info['days']);
                    $stmt->bindParam(':rate', $billing_info['rate_per_day']);
                    $stmt->bindParam(':subtotal', $billing_info['subtotal']);
                    $stmt->bindParam(':charge', $billing_info['payment_charge']);
                    $stmt->bindParam(':discount', $billing_info['discount']);
                    $stmt->bindParam(':total', $billing_info['total']);
                    
                    if ($stmt->execute()) {
                        $success_msg = "Reservation successful! Your record has been saved to the database.";
                    }
                } catch(PDOException $e) {
                    $errors[] = "Database Error: " . $e->getMessage();
                    $billing_info = null; // Do not show billing if DB fails
                }
            }
        }
    } elseif (isset($_POST['clear'])) {
        // Clear all fields
        $name = $checkin = $checkout = "";
        $contact_number = "";
        $room_capacity = $room_type = $payment_type = "";
        $errors = array();
        $billing_info = null;
        $success_msg = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Five Star Hotel - Reservation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="brand">Lor & Santos<br><span>Five Star Hotel</span></div>
        <a href="Home.php"><i class="fas fa-home" style="margin-right: 15px;"></i> Home</a>
        <a href="CompanyProfile.php"><i class="fas fa-building" style="margin-right: 15px;"></i> Company's Profile</a>
        <a href="Reservation.php" class="active"><i class="fas fa-calendar-check" style="margin-right: 15px;"></i> Reservation</a>
        <a href="Contacts.php"><i class="fas fa-envelope" style="margin-right: 15px;"></i> Contacts</a>
        <a href="AdminDashboard.php"><i class="fas fa-cog" style="margin-right: 15px;"></i> Admin Panel</a>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Online Reservation</h1>
            <div style="color: var(--text-muted); font-size: 0.9rem;">
                <i class="fas fa-clock"></i> <?php echo date('F d, Y @ g:i:s A'); ?>
            </div>
        </div>
        
        <div class="content-area">
            <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right: 10px; font-size: 1.2rem;"></i>
                <div>
                    <strong>Please correct the following errors:</strong>
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($success_msg): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 1.2rem;"></i>
                <?php echo htmlspecialchars($success_msg); ?>
            </div>
            <?php endif; ?>
            
            <div class="grid-2">
                <!-- Left Column: Form -->
                <div class="card">
                    <h2 class="section-title">Guest Details</h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label>Customer Name:</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter your full name">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label>Contact Number:</label>
                            <input type="text" class="form-control" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" placeholder="e.g. 09123456789">
                        </div>

                        <h2 class="section-title">Stay Duration</h2>
                        <div class="grid-2">
                            <div class="form-group">
                                <label>Check-in Date:</label>
                                <input type="date" class="form-control" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
                            </div>
                            <div class="form-group">
                                <label>Check-out Date:</label>
                                <input type="date" class="form-control" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
                            </div>
                        </div>

                        <h2 class="section-title" style="margin-top: 1rem;">Preferences</h2>
                        <div class="grid-3" style="gap: 1rem; margin-bottom: 2rem;">
                            <!-- Room Capacity -->
                            <div class="radio-group">
                                <h4>Capacity</h4>
                                <div class="radio-option">
                                    <input type="radio" id="single" name="room_capacity" value="Single" <?php echo ($room_capacity == 'Single') ? 'checked' : ''; ?>>
                                    <label for="single">Single</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="double" name="room_capacity" value="Double" <?php echo ($room_capacity == 'Double') ? 'checked' : ''; ?>>
                                    <label for="double">Double</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="family" name="room_capacity" value="Family" <?php echo ($room_capacity == 'Family') ? 'checked' : ''; ?>>
                                    <label for="family">Family</label>
                                </div>
                            </div>

                            <!-- Room Type -->
                            <div class="radio-group">
                                <h4>Type</h4>
                                <div class="radio-option">
                                    <input type="radio" id="regular" name="room_type" value="Regular" <?php echo ($room_type == 'Regular') ? 'checked' : ''; ?>>
                                    <label for="regular">Regular</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="deluxe" name="room_type" value="De Luxe" <?php echo ($room_type == 'De Luxe') ? 'checked' : ''; ?>>
                                    <label for="deluxe">De Luxe</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="suite" name="room_type" value="Suite" <?php echo ($room_type == 'Suite') ? 'checked' : ''; ?>>
                                    <label for="suite">Suite</label>
                                </div>
                            </div>

                            <!-- Payment Type -->
                            <div class="radio-group">
                                <h4>Payment</h4>
                                <div class="radio-option">
                                    <input type="radio" id="cash" name="payment_type" value="Cash" <?php echo ($payment_type == 'Cash') ? 'checked' : ''; ?>>
                                    <label for="cash">Cash</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="cheque" name="payment_type" value="Check" <?php echo ($payment_type == 'Check') ? 'checked' : ''; ?>>
                                    <label for="cheque">Check (+5%)</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="creditcard" name="payment_type" value="Credit Card" <?php echo ($payment_type == 'Credit Card') ? 'checked' : ''; ?>>
                                    <label for="creditcard">Credit Card (+10%)</label>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                            <button type="submit" name="submit" class="btn-primary" style="padding: 0.8rem 2rem; border-radius: 8px; font-weight: 600;font-size: 1rem;">
                                Submit Reservation
                            </button>
                            <button type="submit" name="clear" class="btn-small" style="background:var(--bg-light); border: 1px solid var(--border); color: var(--text-main); font-size: 1rem;">
                                Clear Entry
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Billing Information or Guide -->
                <div>
                    <?php if ($billing_info && !isset($billing_info['error'])): ?>
                    <div class="billing-box">
                        <div class="section-title">Billing Summary</div>
                        
                        <div class="billing-row">
                            <span>Customer Name:</span>
                            <span style="font-weight: 600;"><?php echo htmlspecialchars($name); ?></span>
                        </div>
                        <div class="billing-row">
                            <span>Check-in Date:</span>
                            <span style="font-weight: 600;"><?php echo date('F d, Y', strtotime($checkin)); ?></span>
                        </div>
                        <div class="billing-row">
                            <span>Check-out Date:</span>
                            <span style="font-weight: 600;"><?php echo date('F d, Y', strtotime($checkout)); ?></span>
                        </div>
                        <div class="billing-row">
                            <span>Number of Days:</span>
                            <span style="font-weight: 600; color: var(--secondary);"><?php echo $billing_info['days']; ?> night(s)</span>
                        </div>
                        <div class="billing-row">
                            <span>Room Category:</span>
                            <span style="font-weight: 600;"><?php echo htmlspecialchars($room_capacity . ' - ' . $room_type); ?></span>
                        </div>
                        <div class="billing-row">
                            <span>Rate per Night:</span>
                            <span style="font-weight: 600;">₱<?php echo number_format($billing_info['rate_per_day'], 2); ?></span>
                        </div>
                        <div class="billing-row">
                            <span>Subtotal:</span>
                            <span style="font-weight: 600;">₱<?php echo number_format($billing_info['subtotal'], 2); ?></span>
                        </div>
                        
                        <?php if ($billing_info['payment_charge'] > 0): ?>
                        <div class="billing-row">
                            <span>Payment Charge (<?php echo $payment_type; ?>):</span>
                            <span style="font-weight: 600; color: #ef4444;">+ ₱<?php echo number_format($billing_info['payment_charge'], 2); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($billing_info['discount'] > 0): ?>
                        <div class="billing-row">
                            <span>Cash Discount:</span>
                            <span style="font-weight: 600; color: var(--accent);">- ₱<?php echo number_format($billing_info['discount'], 2); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="billing-row">
                            <span>TOTAL AMOUNT:</span>
                            <span>₱<?php echo number_format($billing_info['total'], 2); ?></span>
                        </div>
                        <div style="text-align: center; margin-top: 2rem;">
                            <span class="badge" style="background:var(--accent); color: white; padding: 0.5rem 1rem; font-size: 1rem;"><i class="fas fa-check-circle"></i> Booking Saved Successfully</span>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="card" style="background:#f8fafc;">
                        <h2 class="section-title">Room Rates Reference</h2>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Capacity</th>
                                        <th>Regular</th>
                                        <th>De Luxe</th>
                                        <th>Suite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Single</strong></td>
                                        <td>₱100</td>
                                        <td>₱300</td>
                                        <td>₱500</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Double</strong></td>
                                        <td>₱200</td>
                                        <td>₱500</td>
                                        <td>₱800</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Family</strong></td>
                                        <td>₱500</td>
                                        <td>₱750</td>
                                        <td>₱1,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div style="margin-top: 2rem;">
                            <h3 style="font-size: 1rem; color: var(--primary); margin-bottom: 0.5rem;"><i class="fas fa-info-circle"></i> Payment Information</h3>
                            <ul style="color: var(--text-muted); font-size: 0.9rem; margin-left: 20px; line-height: 1.6;">
                                <li><strong>Cash Payments:</strong> Get a 10% discount for 3-5 days stay, and 15% discount for 6+ days!</li>
                                <li><strong>Check Payments:</strong> Adds a 5% surcharge to the subtotal.</li>
                                <li><strong>Credit Card:</strong> Adds a 10% surcharge to the subtotal.</li>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>