<?php
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();


$errors = [];
$success = null;

//Add new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if ($username === '' || $password === '') {
    $errors[] = "Username and password required.";
  } else {
    User::create($username, $password);
    header("Location: view.php?success=1");
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register User · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
        crossorigin="anonymous">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-header">
          <h1 class="h5 mb-0">Add New User</h1>
        </div>
        <div class="card-body">

          <form method="post">
            <div class="col mb-3">
              <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Create User</button>
              <a href="view.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </form>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
                crossorigin="anonymous"></script>
      </div>
    </div>
  </div>
</main>
</body>
</html>
