<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: AdminLogin.php");
    exit();
}

require_once 'db.php'; // Include database connection

$msg = "";
$msgType = "";
$reservation = null;

// Fetch the existing record to be updated
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :id");
        $stmt->bindParam(':id', $edit_id);
        $stmt->execute();
        $reservation = $stmt->fetch();
        
        if (!$reservation) {
            die("Record not found.");
        }
    } catch(PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: AdminDashboard.php");
    exit();
}

// Handle Update Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $status = $_POST['status']; // Just illustrative, but we could update info
    // For this seatwork requirement, updating the customer name and contact is the easiest way to demonstrate "UPDATE" functionality safely.
    
    try {
        $sql = "UPDATE reservations SET customer_name = :name, contact_number = :contact WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            $msg = "Reservation updated successfully!";
            $msgType = "success";
            // Refresh record
            $reservation['customer_name'] = $name;
            $reservation['contact_number'] = $contact;
        }
    } catch(PDOException $e) {
        $msg = "Error updating record: " . $e->getMessage();
        $msgType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Five Star Hotel - Edit Reservation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-card {
            background: var(--bg-white);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">Admin<br><span>Lor & Santos Hotel</span></div>
        <a href="Home.php"><i class="fas fa-home" style="margin-right: 15px;"></i> Back to Website</a>
        <a href="AdminDashboard.php"><i class="fas fa-arrow-left" style="margin-right: 15px;"></i> Back to Dashboard</a>
        <div style="flex-grow: 1;"></div>
        <a href="AdminLogout.php" style="color: #fda4af; border-top: 1px solid rgba(255,255,255,0.1);"><i class="fas fa-sign-out-alt" style="margin-right: 15px;"></i> Logout Securely</a>
    </div>
    
    <div class="main-content">
        <div class="content-area" style="padding: 3rem;">
            
            <?php if ($msg): ?>
            <div class="alert alert-<?php echo $msgType; ?> admin-card" style="margin-bottom: 2rem; padding: 1rem 1.5rem;">
                <?php echo htmlspecialchars($msg); ?>
            </div>
            <?php endif; ?>

            <div class="admin-card">
                <h2 class="section-title">Edit Reservation Data (Update)</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Update the core information for reservation ID #<?php echo $reservation['id']; ?>.</p>
                
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $reservation['id']; ?>">
                    
                    <div class="form-group">
                        <label>Customer Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($reservation['customer_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Contact Number:</label>
                        <input type="text" class="form-control" name="contact" value="<?php echo htmlspecialchars($reservation['contact_number']); ?>" required>
                    </div>

                    <div class="form-group" style="background: var(--bg-light); padding: 1rem; border-radius: 8px; border: 1px solid var(--border); margin-top: 1.5rem;">
                        <h4 style="margin-bottom: 0.5rem; color: var(--primary);">Data Not Editable from this page:</h4>
                        <p style="font-size:0.9rem; color:var(--text-muted);">
                            <strong>Room:</strong> <?php echo $reservation['room_capacity'] . ' ' . $reservation['room_type']; ?><br>
                            <strong>Check In/Out:</strong> <?php echo $reservation['checkin_date'] . ' to ' . $reservation['checkout_date']; ?><br>
                            <strong>Total Billed:</strong> ₱<?php echo number_format($reservation['total_amount'], 2); ?>
                        </p>
                    </div>

                    <div style="margin-top: 2rem; display: flex; gap: 10px;">
                        <button type="submit" name="update" class="btn-primary" style="padding: 0.8rem 2rem; border-radius: 8px; border: none; font-size: 1rem; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-save" style="margin-right: 8px;"></i> Update Record
                        </button>
                        <a href="AdminDashboard.php" class="btn-small" style="background:var(--bg-light); color: var(--text-main); border: 1px solid var(--border); padding: 0.8rem 2rem; display: flex; align-items: center; justify-content: center;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
