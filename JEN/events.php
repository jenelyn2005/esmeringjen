<?php
require_once 'connection.php';
require_once 'includes/auth.php';
requireAuth();

$events = $conn->query(
    "SELECT e.event_id, e.event_name, e.venue, e.registration_fee,
            CONCAT(o.first_name, ' ', o.last_name) AS organizer_name
     FROM events e
     LEFT JOIN organizers o ON o.organizer_id = e.organizer_id
     ORDER BY e.event_id DESC"
)->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | EventDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/app.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <?php include 'includes/navigation.php'; ?>
    <header class="mb-4"><div class="page-kicker">Planning</div><h1 class="page-title display-6 fw-bold mb-2">Events</h1><p class="text-secondary mb-0">Browse the events managed in your system.</p></header>
    <section class="table-panel"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>ID</th><th>Event</th><th>Venue</th><th>Fee</th><th>Organizer</th></tr></thead><tbody>
    <?php if (!$events): ?><tr><td colspan="5" class="text-secondary p-4">No events found.</td></tr><?php else: ?>
        <?php foreach ($events as $event): ?><tr><td><?php echo htmlspecialchars((string) $event->event_id); ?></td><td class="fw-semibold"><?php echo htmlspecialchars($event->event_name); ?></td><td><?php echo htmlspecialchars($event->venue); ?></td><td><?php echo htmlspecialchars((string) $event->registration_fee); ?></td><td><?php echo htmlspecialchars($event->organizer_name ?? 'Unassigned'); ?></td></tr><?php endforeach; ?>
    <?php endif; ?></tbody></table></div></section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
