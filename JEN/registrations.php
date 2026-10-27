<?php
require_once 'connection.php';
require_once 'includes/auth.php';
requireAuth();

$registrations = $conn->query(
    "SELECT r.registration_id, r.registration_date, e.event_name,
            CONCAT(p.first_name, ' ', p.last_name) AS participant_name,
            p.email
     FROM registrations r
     INNER JOIN events e ON e.event_id = r.event_id
     INNER JOIN participants p ON p.participants_id = r.participants_id
     ORDER BY r.registration_id DESC"
)->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrations | EventDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/app.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <?php include 'includes/navigation.php'; ?>
    <header class="mb-4"><div class="page-kicker">Attendance</div><h1 class="page-title display-6 fw-bold mb-2">Registrations</h1><p class="text-secondary mb-0">Track participants signed up for your events.</p></header>
    <section class="table-panel"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>ID</th><th>Participant</th><th>Email</th><th>Event</th><th>Date</th></tr></thead><tbody>
    <?php if (!$registrations): ?><tr><td colspan="5" class="text-secondary p-4">No registrations found.</td></tr><?php else: ?>
        <?php foreach ($registrations as $registration): ?><tr><td><?php echo htmlspecialchars((string) $registration->registration_id); ?></td><td class="fw-semibold"><?php echo htmlspecialchars($registration->participant_name); ?></td><td><?php echo htmlspecialchars((string) $registration->email); ?></td><td><?php echo htmlspecialchars($registration->event_name); ?></td><td><?php echo htmlspecialchars((string) $registration->registration_date); ?></td></tr><?php endforeach; ?>
    <?php endif; ?></tbody></table></div></section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
