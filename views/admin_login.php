<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lor & Santos Hotel - Admin Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }
        .login-brand h1 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <a href="index.php?page=home" style="position: absolute; top: 2rem; left: 2rem; color: white; text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Hotel Website
    </a>
    
    <div class="login-card">
        <div class="login-brand">
            <i class="fas fa-user-shield"></i>
            <h1>Admin Authentication</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Please sign in to access the control panel</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error" style="padding: 0.8rem; font-size: 0.9rem;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?page=admin_login" method="POST">
            <div class="form-group">
                <label>Username</label>
                <div style="position: relative;">
                    <i class="fas fa-user" style="position: absolute; left: 15px; top: 15px; color: var(--text-muted);"></i>
                    <input type="text" name="username" class="form-control" style="padding-left: 40px;" placeholder="Enter admin username" required>
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Password</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 15px; top: 15px; color: var(--text-muted);"></i>
                    <input type="password" name="password" class="form-control" style="padding-left: 40px;" placeholder="Enter your password" required>
                </div>
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; border-radius: 8px; font-weight: 600; font-size: 1rem; border: none; cursor: pointer;">
                Login securely <i class="fas fa-sign-in-alt" style="margin-left: 8px;"></i>
            </button>
        </form>
    </div>
</body>
</html>
