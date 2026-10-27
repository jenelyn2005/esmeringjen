<?php
require_once 'connection.php';
require_once 'includes/auth.php';
requireAuth();

$organizers = $conn->query(
    "SELECT o.organizer_id, o.first_name, o.last_name, o.company_name,
            e.event_name
     FROM organizers o
     LEFT JOIN events e ON e.event_id = o.event_id
     ORDER BY o.organizer_id DESC"
)->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizers | EventDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/app.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <?php include 'includes/navigation.php'; ?>
    <header class="mb-4"><div class="page-kicker">People</div><h1 class="page-title display-6 fw-bold mb-2">Organizers</h1><p class="text-secondary mb-0">See who is coordinating each event.</p></header>
    <section class="table-panel"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>ID</th><th>Name</th><th>Company</th><th>Event</th></tr></thead><tbody>
    <?php if (!$organizers): ?><tr><td colspan="4" class="text-secondary p-4">No organizers found.</td></tr><?php else: ?>
        <?php foreach ($organizers as $organizer): ?><tr><td><?php echo htmlspecialchars((string) $organizer->organizer_id); ?></td><td class="fw-semibold"><?php echo htmlspecialchars($organizer->first_name . ' ' . $organizer->last_name); ?></td><td><?php echo htmlspecialchars($organizer->company_name ?? ''); ?></td><td><?php echo htmlspecialchars($organizer->event_name ?? 'Unassigned'); ?></td></tr><?php endforeach; ?>
    <?php endif; ?></tbody></table></div></section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
