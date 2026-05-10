<?php
// index.php - Front Controller
session_start();

// Basic Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        require_once 'controllers/PageController.php';
        $controller = new PageController();
        $controller->home();
        break;
        
    case 'company_profile':
        require_once 'controllers/PageController.php';
        $controller = new PageController();
        $controller->companyProfile();
        break;
        
    case 'contacts':
        require_once 'controllers/PageController.php';
        $controller = new PageController();
        $controller->contacts();
        break;
        
    case 'reservation':
        require_once 'controllers/ReservationController.php';
        $controller = new ReservationController();
        $controller->index();
        break;
        
    case 'admin_login':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->login();
        break;
        
    case 'admin_dashboard':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
        
    case 'admin_edit':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->edit();
        break;
        
    case 'admin_logout':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->logout();
        break;
        
    default:
        // Fallback to home
        require_once 'controllers/PageController.php';
        $controller = new PageController();
        $controller->home();
        break;
}
?>
