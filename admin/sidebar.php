<aside class="sidebar">
    <a href="../index.php" class="logo sidebar-logo">Fit<span>Boss</span></a>
    <nav class="sidebar-nav">
        <ul>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'member.php' ? 'active' : ''; ?>">
                <a href="member.php">Manajemen Member</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'schedule.php' ? 'active' : ''; ?>">
                <a href="schedule.php">Manajemen Jadwal</a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="logout-link">Logout</a>
    </div>
</aside>