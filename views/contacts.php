<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Five Star Hotel - Contacts</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contact-card {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.5rem;
            border-left: 5px solid var(--secondary);
            transition: var(--transition);
        }
        .contact-card:hover {
            transform: translateX(10px);
        }
        .contact-icon {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-right: 1.5rem;
            width: 60px;
            text-align: center;
        }
        .contact-info h3 {
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        .contact-info p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }
        
        .contact-layout {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 3rem;
        }
    </style>
</head>
<body>
    <?php require_once 'views/partials/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>Contact Us</h1>
        </div>
        
        <div class="content-area">
            <div class="card">
                <h2 class="section-title">Get in Touch with Us</h2>
                <div class="contact-layout">
                    <div>
                        <div class="contact-card">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt" style="color: #ef4444;"></i></div>
                            <div class="contact-info">
                                <h3>Location</h3>
                                <p>129-E Riri Avenue, Metro Manila, Philippines</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="contact-info">
                                <h3>Phone / Mobile</h3>
                                <p>+63 912 587 9210<br>+63 961 956 4821</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon"><i class="fas fa-envelope-open-text" style="color: var(--accent);"></i></div>
                            <div class="contact-info">
                                <h3>Email Address</h3>
                                <p>inquiry.lorsantoshotel@gmail.com<br>support.lorsantoshotel@gmail</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div style="background: var(--bg-light); padding: 2.5rem; border-radius: 12px; border: 1px solid var(--border);">
                            <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Send us a Message</h3>
                            <form>
                                <div class="form-group">
                                    <label>Your Name</label>
                                    <input type="text" class="form-control" placeholder="John Doe">
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="john@example.com">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" rows="5" placeholder="How can we help you?"></textarea>
                                </div>
                                <button type="button" class="btn-primary" style="padding: 1rem 2rem; width: 100%; border-radius: 8px; font-size: 1.1rem;">
                                    Send Message <i class="fas fa-paper-plane" style="margin-left: 8px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
