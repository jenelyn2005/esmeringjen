<?php
require_once 'connection.php';
require_once 'includes/auth.php';
requireAuth();

function countRows(PDO $conn, string $table): int
{
    return (int) $conn->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
}

$counts = [
    'events' => countRows($conn, 'events'),
    'organizers' => countRows($conn, 'organizers'),
    'participants' => countRows($conn, 'participants'),
    'registrations' => countRows($conn, 'registrations'),
];

$recentRegistrations = $conn->query(
    "SELECT r.registration_id, r.registration_date, e.event_name,
            CONCAT(p.first_name, ' ', p.last_name) AS participant_name
     FROM registrations r
     INNER JOIN events e ON e.event_id = r.event_id
     INNER JOIN participants p ON p.participants_id = r.participants_id
     ORDER BY r.registration_id DESC
     LIMIT 5"
)->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | EventDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/app.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <?php include 'includes/navigation.php'; ?>

    <header class="mb-4">
        <div class="page-kicker">Event management</div>
        <h1 class="page-title display-6 fw-bold mb-2">Dashboard</h1>
        <p class="text-secondary mb-0">A quick view of your event activity.</p>
    </header>

    <div class="row g-3 mb-4">
        <?php foreach ($counts as $label => $value): ?>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-value"><?php echo htmlspecialchars((string) $value); ?></div>
                    <div class="stat-label text-capitalize"><?php echo htmlspecialchars($label); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <section class="table-panel">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h2 class="h5 mb-0">Recent registrations</h2>
            <a class="btn btn-sm btn-outline-primary" href="registrations.php">View all</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Participant</th><th>Event</th><th>Date</th></tr></thead>
                <tbody>
                <?php if (!$recentRegistrations): ?>
                    <tr><td colspan="3" class="text-secondary p-4">No registrations yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($recentRegistrations as $registration): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registration->participant_name); ?></td>
                            <td><?php echo htmlspecialchars($registration->event_name); ?></td>
                            <td><?php echo htmlspecialchars((string) $registration->registration_date); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
