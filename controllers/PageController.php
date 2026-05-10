<?php
// controllers/PageController.php

class PageController {
    public function home() {
        $active_page = 'home';
        require_once 'views/home.php';
    }

    public function companyProfile() {
        $active_page = 'company_profile';
        require_once 'views/company_profile.php';
    }

    public function contacts() {
        $active_page = 'contacts';
        require_once 'views/contacts.php';
    }
}
?>
