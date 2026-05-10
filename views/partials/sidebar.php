<?php
// views/partials/sidebar.php
$active_page = isset($active_page) ? $active_page : '';
?>
<div class="sidebar">
    <div class="brand">Lor & Santos<br><span>Five Star Hotel</span></div>
    <a href="index.php?page=home" class="<?php echo ($active_page == 'home') ? 'active' : ''; ?>"><i class="fas fa-home" style="margin-right: 15px;"></i> Home</a>
    <a href="index.php?page=company_profile" class="<?php echo ($active_page == 'company_profile') ? 'active' : ''; ?>"><i class="fas fa-building" style="margin-right: 15px;"></i> Company's Profile</a>
    <a href="index.php?page=reservation" class="<?php echo ($active_page == 'reservation') ? 'active' : ''; ?>"><i class="fas fa-calendar-check" style="margin-right: 15px;"></i> Reservation</a>
    <a href="index.php?page=contacts" class="<?php echo ($active_page == 'contacts') ? 'active' : ''; ?>"><i class="fas fa-envelope" style="margin-right: 15px;"></i> Contacts</a>
    <a href="index.php?page=admin_login"><i class="fas fa-cog" style="margin-right: 15px;"></i> Admin Panel</a>
</div>
