<?php
require_once __DIR__ . '/../../classes/Event.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$event = Event::find($id);

if (!$event) {
  echo "Event not found.";
  exit;
}

$org = $event->organisation();
$volunteers = $event->volunteers();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Event Details · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h1 class="h5 mb-0"><?= htmlspecialchars($event->title) ?></h1>
      <a href="edit.php?id=<?= $event->event_id ?>" class="btn btn-sm btn-primary">Edit Event</a>
    </div>
    <div class="card-body">
      <h5>Location</h5> <p><?= htmlspecialchars($event->location) ?></p>
      <h5>Date & Time</h5> <p><?= htmlspecialchars($event->date) ?></p>

      <?php if ($org): ?>
        <h5>Organisation</h5> <p><?= htmlspecialchars($org['organisation_name']) ?></p>
      <?php endif; ?>

      <h5>Description</h5><p><?= nl2br(htmlspecialchars($event->description)) ?></p>

      <h5 class="mt-4">Volunteers</h5>
      <?php if ($volunteers): ?>
        <ul class="list-group">
          <?php foreach ($volunteers as $v): ?>
            <li class="list-group-item">
              <?= htmlspecialchars($v['full_name']) ?> (<?= htmlspecialchars($v['email']) ?>)
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No volunteers assigned.</p>
      <?php endif; ?>
    </div>
  </div>
</main>

</body>
</html>
