<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg app-nav mb-4">
    <div class="container-fluid px-0">
        <a class="navbar-brand fw-bold" href="dashboard.php">EventDesk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavigation">
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?php echo $currentPage === 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                <a class="nav-link <?php echo $currentPage === 'events.php' ? 'active' : ''; ?>" href="events.php">Events</a>
                <a class="nav-link <?php echo $currentPage === 'organizers.php' ? 'active' : ''; ?>" href="organizers.php">Organizers</a>
                <a class="nav-link <?php echo $currentPage === 'indexx.php' ? 'active' : ''; ?>" href="indexx.php">Participants</a>
                <a class="nav-link <?php echo $currentPage === 'registrations.php' ? 'active' : ''; ?>" href="registrations.php">Registrations</a>
                <span class="nav-link text-secondary">Hi, <?php echo htmlspecialchars(currentUserName()); ?> (<?php echo htmlspecialchars($_SESSION['user']['role'] ?? 'user'); ?>)</span>
                <a class="nav-link" href="logout.php">Log out</a>
                <?php include __DIR__ . '/theme-toggle.php'; ?>
            </div>
        </div>
    </div>
</nav>
