<?php
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Volunteer.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();

$errors = [];
$success = null;

//Add new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password = trim($_POST['password']);
  $role = UserRole::from($_POST['role']);
  $volunteer_id = null;

  if ($role === UserRole::VOLUNTEER) {
    $volunteer_id = (int)($_POST['volunteer_id'] ?? 0);
    $vol = Volunteer::find($volunteer_id);

    if (!$vol) {
      $errors[] = "Please select a valid volunteer.";
    } else {
      $username = trim($_POST['username']);
    }
  } else {
    $username = trim($_POST['username']);
  }

  if (empty($username) || empty($password)) {
    $errors[] = "Username and password are required.";
  }

  if (!$errors) {
    User::create($username, $password, $role, $volunteer_id);
    header("Location: view.php?success=1");
    exit;
  }
}

$volunteers = Volunteer::availableForAccount();
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
          <h1 class="h4 mb-0">Add New User</h1>
        </div>
        <div class="card-body">

          <?php if ($errors): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $err): ?>
                <div><?= htmlspecialchars($err) ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3">
              <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
              <select id="role" name="role" class="form-select" required>
                <option value="">Select role...</option>
                <option value="admin">Admin</option>
                <option value="volunteer">Volunteer</option>
              </select>
            </div>

            <div id="volunteer-field" class="mb-3" style="display:none;">
              <label for="volunteer_id" class="form-label">Volunteer <span class="text-danger">*</span></label>
              <select id="volunteer_id" name="volunteer_id" class="form-select">
                <option value="">Select a volunteer</option>
                <?php foreach ($volunteers as $v): ?>
                  <option value="<?= $v['volunteer_id'] ?>">
                    <?= htmlspecialchars($v['full_name']) ?> (<?= htmlspecialchars($v['email']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
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
                crossorigin="anonymous">
        </script>
      </div>
    </div>
  </div>
</main>
<script>
  const roleSelect = document.getElementById('role');
  const volunteerField = document.getElementById('volunteer-field');

  function toggleVolunteerField() {
    if (roleSelect.value === 'volunteer') {
      volunteerField.style.display = 'block';
    } else {
      volunteerField.style.display = 'none';
    }
  }

  roleSelect.addEventListener('change', toggleVolunteerField);
  toggleVolunteerField();
</script>
</body>
</html>
