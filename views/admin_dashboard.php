<?php
/* @var array $reservations */
/* @var string $msg */
/* @var string $msgType */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Five Star Hotel - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-header {
            background: linear-gradient(135deg, var(--primary) 0%, #334155 100%);
            padding: 2rem;
            color: white;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-card {
            background: var(--bg-white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">Admin<br><span>Lor & Santos Hotel</span></div>
        <a href="index.php?page=home"><i class="fas fa-home" style="margin-right: 15px;"></i> Back to Website</a>
        <a href="index.php?page=admin_dashboard" class="active"><i class="fas fa-tachometer-alt" style="margin-right: 15px;"></i> Dashboard </a>
        <div style="flex-grow: 1;"></div>
        <a href="index.php?page=admin_logout" style="color: #fda4af; border-top: 1px solid rgba(255,255,255,0.1);"><i class="fas fa-sign-out-alt" style="margin-right: 15px;"></i> Logout Securely</a>
    </div>
    
    <div class="main-content">
        <div class="content-area" style="max-width: 1400px; padding: 2rem;">
            
            <div class="admin-header">
                <div>
                    <h1 style="color: white; letter-spacing: 0;">Admin Control Panel</h1>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 5px;">Manage hotel reservations, read records, update data, and delete invalid entries.</p>
                </div>
                <div style="text-align: right;">
                    <strong>Total Reservations: <?php echo count($reservations); ?></strong><br>
                    <span style="font-size: 0.9rem; color: rgba(255,255,255,0.5);">Real-time Database Connection Active</span>
                </div>
            </div>

            <?php if (!empty($msg)): ?>
            <div class="alert alert-<?php echo $msgType; ?>">
                <?php echo htmlspecialchars($msg); ?>
            </div>
            <?php endif; ?>

            <div class="admin-card">
                <h2 class="section-title">All Reservations</h2>
                
                <div class="table-container">
                    <?php if (count($reservations) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Guest Name</th>
                                <th>Contact</th>
                                <th>Dates</th>
                                <th>Room details</th>
                                <th>Total</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $row): ?>
                            <tr>
                                <td style="color: var(--text-muted);">#<?php echo $row['id']; ?></td>
                                <td style="font-weight: 500; color: var(--primary);"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                <td style="font-size: 0.9rem;">
                                    <?php echo date('M d', strtotime($row['checkin_date'])); ?> to <?php echo date('M d', strtotime($row['checkout_date'])); ?><br>
                                    <span style="color:var(--secondary);">(<?php echo $row['days']; ?> days)</span>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['room_capacity'] . ' - ' . $row['room_type']); ?><br>
                                    <span class="badge" style="background:#e0e7ff; color:#4f46e5; margin-top: 5px; display:inline-block; font-size: 0.75rem;"><?php echo $row['payment_type']; ?></span>
                                </td>
                                <td style="font-weight: 600;">₱<?php echo number_format($row['total_amount'], 2); ?></td>
                                <td style="text-align: center;">
                                    <a href="index.php?page=admin_edit&id=<?php echo $row['id']; ?>" class="btn-small btn-primary" style="margin-right: 5px;" title="Edit Reservation">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="index.php?page=admin_dashboard&delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to completely delete this reservation? This cannot be undone.');" class="btn-small btn-danger" title="Delete record">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p style="text-align: center; color: var(--text-muted); padding: 3rem 0; font-size: 1.1rem;">
                        <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; color: #cbd5e1; display: block;"></i>
                        No reservations found in the database.
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
