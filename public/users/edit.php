<?php
require_once __DIR__ . '/../../classes/User.php';

$errors = [];
$success = null;

$userId = (int)$_GET['id'];
$user = User::find($userId);

if (!$user) {
  $errors[] = "User not found.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if ($username === '') {
    $errors[] = "Username is required.";
  }

  // Check if username is already taken
  if (empty($errors)) {
    if (User::usernameExists($username, $userId)) {
      $errors[] = "That username is already taken. Please choose another.";
    }
  }

  if (empty($errors)) {
    try {
      $updated = User::update($userId, $username, $password);
      if ($updated) {
        header("Location: view.php?success=1");
        exit;
      } else {
        $errors[] = "Failed to update user.";
      }
    } catch (PDOException $e) {
      // Generic catch-all fallback (e.g., DB down, other SQL issues)
      $errors[] = "An unexpected error occurred while updating the user.";
    }
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit User · CommunityLink</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body class="bg-light"> <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-header"><h1 class="h5 mb-0">Edit User</h1></div>
        <div class="card-body"> <?php if ($success): ?>
            <div
              class="alert alert-success"><?= htmlspecialchars($success) ?></div> <?php endif; ?> <?php if ($errors): ?>
            <div class="alert alert-danger"> <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div> <?php endforeach; ?> </div> <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username
                <span class="text-danger">*</span></label>
              <input type="text" id="username" name="username"
                     value="<?= htmlspecialchars($user->username) ?>"
                     class="form-control" required></div>
            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password"
                     id="password"
                     name="password"
                     class="form-control">
              <small class="text-muted">Leave blank to keep the current password.</small></div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Update User</button>
              <a href="view.php" class="btn btn-outline-secondary">Cancel</a></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
</body>
</html>
