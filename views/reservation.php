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
    <?php require_once 'views/partials/sidebar.php'; ?>
    
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

            <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 1.2rem;"></i>
                <?php echo htmlspecialchars($success_msg); ?>
            </div>
            <?php endif; ?>
            
            <div class="grid-2">
                <!-- Left Column: Form -->
                <div class="card">
                    <h2 class="section-title">Guest Details</h2>
                    <form method="POST" action="index.php?page=reservation">
                        <div class="form-group">
                            <label>Customer Name:</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" placeholder="Enter your full name">
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label>Contact Number:</label>
                            <input type="text" class="form-control" name="contact_number" value="<?php echo htmlspecialchars($contact_number ?? ''); ?>" placeholder="e.g. 09123456789">
                        </div>

                        <h2 class="section-title">Stay Duration</h2>
                        <div class="grid-2">
                            <div class="form-group">
                                <label>Check-in Date:</label>
                                <input type="date" class="form-control" name="checkin" value="<?php echo htmlspecialchars($checkin ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label>Check-out Date:</label>
                                <input type="date" class="form-control" name="checkout" value="<?php echo htmlspecialchars($checkout ?? ''); ?>">
                            </div>
                        </div>

                        <h2 class="section-title" style="margin-top: 1rem;">Preferences</h2>
                        <div class="grid-3" style="gap: 1rem; margin-bottom: 2rem;">
                            <!-- Room Capacity -->
                            <div class="radio-group">
                                <h4>Capacity</h4>
                                <div class="radio-option">
                                    <input type="radio" id="single" name="room_capacity" value="Single" <?php echo (($room_capacity ?? '') == 'Single') ? 'checked' : ''; ?>>
                                    <label for="single">Single</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="double" name="room_capacity" value="Double" <?php echo (($room_capacity ?? '') == 'Double') ? 'checked' : ''; ?>>
                                    <label for="double">Double</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="family" name="room_capacity" value="Family" <?php echo (($room_capacity ?? '') == 'Family') ? 'checked' : ''; ?>>
                                    <label for="family">Family</label>
                                </div>
                            </div>

                            <!-- Room Type -->
                            <div class="radio-group">
                                <h4>Type</h4>
                                <div class="radio-option">
                                    <input type="radio" id="regular" name="room_type" value="Regular" <?php echo (($room_type ?? '') == 'Regular') ? 'checked' : ''; ?>>
                                    <label for="regular">Regular</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="deluxe" name="room_type" value="De Luxe" <?php echo (($room_type ?? '') == 'De Luxe') ? 'checked' : ''; ?>>
                                    <label for="deluxe">De Luxe</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="suite" name="room_type" value="Suite" <?php echo (($room_type ?? '') == 'Suite') ? 'checked' : ''; ?>>
                                    <label for="suite">Suite</label>
                                </div>
                            </div>

                            <!-- Payment Type -->
                            <div class="radio-group">
                                <h4>Payment</h4>
                                <div class="radio-option">
                                    <input type="radio" id="cash" name="payment_type" value="Cash" <?php echo (($payment_type ?? '') == 'Cash') ? 'checked' : ''; ?>>
                                    <label for="cash">Cash</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="cheque" name="payment_type" value="Check" <?php echo (($payment_type ?? '') == 'Check') ? 'checked' : ''; ?>>
                                    <label for="cheque">Check (+5%)</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="creditcard" name="payment_type" value="Credit Card" <?php echo (($payment_type ?? '') == 'Credit Card') ? 'checked' : ''; ?>>
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
                    <?php if (!empty($billing_info) && !isset($billing_info['error'])): ?>
                    <div class="billing-box">
                        <div class="section-title">Billing Summary</div>
                        
                        <div class="billing-row">
                            <span>Customer Name:</span>
                            <span style="font-weight: 600;"><?php echo htmlspecialchars($name ?? ''); ?></span>
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
                            <span style="font-weight: 600;"><?php echo htmlspecialchars(($room_capacity ?? '') . ' - ' . ($room_type ?? '')); ?></span>
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
                            <span>Payment Charge (<?php echo htmlspecialchars($payment_type ?? ''); ?>):</span>
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
