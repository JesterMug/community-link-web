<?php
require_once __DIR__ . '/../../db_connection.php';
require_once __DIR__ . '/../../classes/Event.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();

$errors = [];
$success = null;

// Handle delete
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  if (Event::delete($id)) {
    $success = "Event deleted successfully.";
  } else {
    $errors[] = "Error deleting event.";
  }
}

$events = Event::all();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Events · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <div class="col d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-4">Manage Events</h1>
    <a href="add.php" class="btn btn-sm btn-primary">Add Event</a>
  </div>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err): ?>
        <div><?= htmlspecialchars($err) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Events List  -->
  <div class="card">
    <div class="card-body">
      <table class="table table-striped align-middle">
        <thead>
        <tr>
          <th>Title</th>
          <th>Date</th>
          <th>Location</th>
          <th>Organisation</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$events): ?>
          <tr>
            <td colspan="5">No events found.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($events as $e): ?>
          <tr>
            <td><?= htmlspecialchars($e['title']) ?></td>
            <td><?= htmlspecialchars($e['date']) ?></td>
            <td><?= htmlspecialchars($e['location']) ?></td>
            <td><?= htmlspecialchars($e['organisation_name']) ?></td>
            <td>
              <a href="edit.php?id=<?= $e['event_id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="?delete=<?= $e['event_id'] ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('Delete this event?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
</body>
</html>
