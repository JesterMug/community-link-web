<?php
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();


$errors = [];
$success = null;

// Delete user
if (isset($_GET['delete'])) {
  $deleteId = (int) $_GET['delete'];
  if (User::delete($deleteId)) {
    $success = "User deleted successfully.";
  } else {
    $errors[] = "Error deleting user.";
  }
}

//Get users
$users = User::all();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Users · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <div class="col d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-4">Manage Users</h1>
    <a href="add.php" class="btn btn-sm btn-primary">New User</a>
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

  <!-- User list -->
  <div class="card">
    <div class="card-body">
      <table class="table table-striped align-middle">
        <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$users): ?>
          <tr><td colspan="3">No users found.</td></tr>
        <?php else: ?>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['user_id']) ?></td>
              <td><?= htmlspecialchars($u['username']) ?></td>
              <td>
                <a href="edit.php?id=<?= $u['user_id'] ?>"
                   class="btn btn-sm btn-secondary">
                  Edit
                </a>
                <?php if ($u['role'] != 'admin'): ?>
                <a href="?delete=<?= $u['user_id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this user?')">
                  Delete
                </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>
