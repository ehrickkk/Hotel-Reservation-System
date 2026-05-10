<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Five Star Hotel - Company Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
        }
        .mission-vision {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .mv-box {
            background: var(--primary);
            color: white;
            padding: 2.5rem;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        .mv-box h3 {
            color: var(--secondary);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }
        .mv-box p {
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }
        .mv-box i {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 150px;
            opacity: 0.1;
            z-index: 1;
        }
    </style>
</head>
<body>
    <?php require_once 'views/partials/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>Company's Profile</h1>
        </div>
        
        <div class="content-area">
            <div class="card">
                <h2 class="section-title">About Us</h2>
                <p style="line-height: 1.8; color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem;">
                    Established in 2026, Lor & Santos Five Star Hotel emerged from a vision to redefine urban luxury. We have cultivated an environment where modern sophistication seamlessly blends with traditional hospitality. With state-of-the-art facilities, award-winning culinary locations, and unparalleled personalized service, our establishment stands as the pinnacle of prestigious accommodation in the region.
                </p>

                <div class="mission-vision">
                    <div class="mv-box">
                        <i class="fas fa-bullseye"></i>
                        <h3>Our Mission</h3>
                        <p>To provide distinctively elegant experiences and exceptional service that anticipates and fulfills our guests' every need, fostering lasting relationships through genuine care and commitment to excellence.</p>
                    </div>
                    <div class="mv-box" style="background: var(--secondary);">
                        <i class="fas fa-eye"></i>
                        <h3 style="color: white; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 10px; display: inline-block;">Our Vision</h3>
                        <p>To be the globally recognized symbol of premium luxury hospitality, setting the standard for sustainable operations, innovative services, and unforgettable guest stays.</p>
                    </div>
                </div>

                <div class="section-title">Our Core Values</div>
                <div class="features" style="grid-template-columns: repeat(4, 1fr);">
                    <div class="feature-card" style="padding: 1.5rem; text-align: center;">
                        <i class="fas fa-star" style="font-size: 2rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                        <h4 style="margin-bottom: 0.5rem; color: var(--primary);">Excellence</h4>
                        <p style="font-size: 0.9rem;">Delivering the highest quality in everything we do.</p>
                    </div>
                    <div class="feature-card" style="padding: 1.5rem; text-align: center;">
                        <i class="fas fa-heart" style="font-size: 2rem; color: #ef4444; margin-bottom: 1rem;"></i>
                        <h4 style="margin-bottom: 0.5rem; color: var(--primary);">Hospitality</h4>
                        <p style="font-size: 0.9rem;">Welcoming every guest like family.</p>
                    </div>
                    <div class="feature-card" style="padding: 1.5rem; text-align: center;">
                        <i class="fas fa-leaf" style="font-size: 2rem; color: var(--accent); margin-bottom: 1rem;"></i>
                        <h4 style="margin-bottom: 0.5rem; color: var(--primary);">Sustainability</h4>
                        <p style="font-size: 0.9rem;">Protecting our environment for tomorrow.</p>
                    </div>
                    <div class="feature-card" style="padding: 1.5rem; text-align: center;">
                        <i class="fas fa-shield-alt" style="font-size: 2rem; color: var(--secondary); margin-bottom: 1rem;"></i>
                        <h4 style="margin-bottom: 0.5rem; color: var(--primary);">Integrity</h4>
                        <p style="font-size: 0.9rem;">Honesty and transparency in our operations.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
