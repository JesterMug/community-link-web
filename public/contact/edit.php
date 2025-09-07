<?php
require_once __DIR__ . '/../../classes/ContactMessage.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();

$errors = [];
$success = null;

if (!isset($_GET['id'])) {
  header("Location: view.php");
  exit;
}

$id = (int)$_GET['id'];
$message = ContactMessage::find($id);

if (!$message) {
  $errors[] = "Message not found.";
}

// Handle mark as replied
if (isset($_POST['replied'])) {
  if (ContactMessage::markReplied($id)) {
    $success = "Message marked as replied.";
    $message->replied = 1;
  } else {
    $errors[] = "Failed to update message status.";
  }
}

// Handle delete
if (isset($_POST['delete'])) {
  if (ContactMessage::delete($id)) {
    header("Location: view.php?success=Message+deleted");
    exit;
  } else {
    $errors[] = "Failed to delete message.";
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>View Message · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <div class="row justify-content-center">
    <?php if ($success): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
          <div><?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title h3 mb-4"> Enquiry from <?= htmlspecialchars($message->full_name) ?></h2>

          <?php if ($message): ?>
            <h6>Email</h6>
            <p> <?= htmlspecialchars($message->email) ?></p>
            <h6>Phone</h6>
            <p> <?= htmlspecialchars($message->phone) ?></p>
            <h6>Submission Time</h6>
            <p> <?= htmlspecialchars($message->created_at) ?></p>
            <h6>Status</h6>
            <p> <?= $message->replied ? 'Replied' : 'Not Replied' ?></p>
            <h6>Message</h6>
            <div class="card p-3 mb-3">
              <p> <?= htmlspecialchars($message->message) ?> </p>
            </div>
            <form method="post" class="d-flex gap-2">
              <?php if (!$message->replied): ?>
                <button type="submit" name="replied" class="btn btn-success">Mark as Replied</button>
                <button type="submit" name="delete" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this message?')">Delete
                </button>
              <?php endif; ?>
              <a href="view.php" class="btn btn-secondary">Cancel</a>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</main>
</body>
</html>
