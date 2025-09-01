<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../classes/Auth.php';

if (isset($_GET['logout'])) {
    Auth::logout();
}
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/Lab03_Group05/">CommunityLink</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Authenticated users -->
                    
                    <!-- Home - visible to all authenticated users -->
                    <li class="nav-item">
                        <a class="nav-link" href="/Lab03_Group05/">Home</a>
                    </li>

                    <?php if (Auth::isAdmin()): ?>
                        <!-- Admin-only links -->
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/users/view.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/volunteers/view.php">Volunteers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/organisations/view.php">Organisations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/events/view.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/contact/view.php">Messages</a>
                        </li>
                    <?php elseif (Auth::isVolunteer()): ?>
                        <!-- Volunteer-only links -->
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/events/view.php">View Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Lab03_Group05/public/volunteers/profile.php">My Profile</a>
                        </li>
                    <?php endif; ?>

                    <!-- Logout link for authenticated users -->
                    <li class="nav-item">
                        <a class="nav-link" href="?logout=1" onclick="return confirm('Are you sure you want to logout?')">
                            Logout (<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>)
                        </a>
                    </li>

                <?php else: ?>
                    <!-- Non-authenticated users (public) -->
                    <li class="nav-item">
                        <a class="nav-link" href="/Lab03_Group05/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Lab03_Group05/public/contact/add.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Lab03_Group05/public/auth/login.php">Login</a>
                    </li>
                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</nav>
