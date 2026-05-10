<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Five Star Hotel - Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require_once 'views/partials/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>Welcome!</h1>
            <div style="color: var(--text-muted); font-size: 0.9rem;">
                <i class="fas fa-clock"></i> <?php echo date('F d, Y - l'); ?>
            </div>
        </div>
        
        <div class="content-area">
            <div class="hero">
                <div class="hero-content">
                    <h2>Experience True Luxury</h2>
                    <p>Discover comfort, elegance, and world-class service in the heart of the city. Your unforgettable stay begins here.</p>
                    <a href="index.php?page=reservation" class="cta-button">Book Your Stay Now <i class="fas fa-arrow-right" style="margin-left:8px;"></i></a>
                </div>
            </div>
            
            <div class="section-title">Why Choose Us?</div>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon" style="color: var(--secondary);"><i class="fas fa-bed"></i></div>
                    <h3>Luxurious Suites</h3>
                    <p>Choose from our selection of breathtaking Single, Double, and Family rooms offering maximum comfort and stunning city views.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="color: var(--accent);"><i class="fas fa-tags"></i></div>
                    <h3>Best Value Rates</h3>
                    <p>Competitive prices starting from just ₱100/day. Enjoy special exclusive discounts up to 15% when you pay in cash for extended stays.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="color: #f59e0b;"><i class="fas fa-concierge-bell"></i></div>
                    <h3>Premium Amenities</h3>
                    <p>24/7 dedicated room service, complimentary high-speed Wi-Fi, spa access, and award-winning dining experiences.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
