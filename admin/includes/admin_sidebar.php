<?php
// admin/includes/admin_sidebar.php
?>
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2>Menu Admin</h2>
    </div>
    <ul class="sidebar-menu">
        <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
        <li><a href="modules/venues.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'venues.php') ? 'active' : ''; ?>">Manajemen Lapangan</a></li>
        <li><a href="modules/bookings.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'bookings.php') ? 'active' : ''; ?>">Manajemen Booking</a></li>
        </ul>
</aside>