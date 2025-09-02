<?php
require_once __DIR__ . '/../../classes/ContactMessage.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();

$errors = [];
$success = null;

// Handle deletion
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  if (ContactMessage::delete($id)) {
    $success = "Message deleted successfully.";
  } else {
    $errors[] = "Failed to delete message.";
  }
}

// Handle delete all
if (isset($_GET['delete_all'])) {
  if (ContactMessage::deleteAll()) {
    $success = "All messages deleted successfully.";
  } else {
    $errors[] = "Failed to delete all messages.";
  }
}

// mark as replied
if (isset($_GET['replied'])) {
  $id = (int)$_GET['replied'];
  if (ContactMessage::markReplied($id)) {
    $success = "Message marked as replied.";
  } else {
    $errors[] = "Failed to update message status.";
  }
}

$messages = ContactMessage::all();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Contact Messages · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <div class="col d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-4">Contact Messages</h1>
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

  <div class="card">
    <div class="card-body">
      <table class="table table-striped align-middle">
        <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Replied</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$messages): ?>
            <tr><td colspan="6">No messages found.</td></tr>
        <?php else: ?>
            <?php foreach ($messages as $m): ?>
              <tr>
                <td><?= htmlspecialchars($m['full_name']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= $m['replied'] ? 'Yes' : 'No' ?></td>
                <td><?= htmlspecialchars($m['created_at']) ?></td>
                <td>
                  <a href="edit.php?id=<?= $m['contact_messages_id'] ?>" class="btn btn-sm btn-primary">Open</a>
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
