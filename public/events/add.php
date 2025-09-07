<?php
require_once __DIR__ . '/../../classes/Event.php';
require_once __DIR__ . '/../../classes/Organisation.php';
require_once __DIR__ . '/../../classes/Volunteer.php';
require_once __DIR__ . '/../../classes/VolunteerEvent.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $location = trim($_POST['location']);
  $description = trim($_POST['description']);
  $date_part = trim($_POST['date']);
  $time_part = trim($_POST['time']);
  $organisation_id = (int)($_POST['organisation_id'] ?? 0);
  $volunteers = $_POST['volunteers'] ?? [];

  if ($title === '' || $location === '' || $description === '' || $date_part === '' || $time_part === '' || !$organisation_id) {
    $errors[] = "All fields are required.";
  } else {

    $date = $date_part . ' ' . $time_part . ':00';

    $event = new Event([
      'title' => $title,
      'location' => $location,
      'description' => $description,
      'date' => $date,
      'organisation_id' => $organisation_id
    ]);

    if ($event->save()) {
      foreach ($volunteers as $vid) {
        VolunteerEvent::assign((int)$vid, $event->event_id);
      }
      header("Location: view.php?success=1");
      exit;
    } else {
      $errors[] = "Error saving event.";
    }
  }
}

$orgs = Organisation::all();
$volunteers = Volunteer::availableForEvent();
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Event · CommunityLink</title>
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
          <h1 class="h4 mb-0">Add New Event</h1>
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
              <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
              <input type="text" id="location" name="location" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" id="date" name="date" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="time" class="form-label">Time <span class="text-danger">*</span></label>
                <input type="time" id="time" name="time" class="form-control" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="organisation_id" class="form-label">Organisation <span class="text-danger">*</span></label>
              <select id="organisation_id" name="organisation_id" class="form-select" required>
                <option value="">Select organisation...</option>
                <?php foreach ($orgs as $o): ?>
                  <option value="<?= $o['organisation_id'] ?>"><?= htmlspecialchars($o['organisation_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
              <label for="volunteers" class="form-label">Assign Volunteers</label>
              <select id="volunteers" name="volunteers[]" class="form-select" multiple>
                <?php foreach ($volunteers as $v): ?>
                  <option value="<?= $v['volunteer_id'] ?>">
                    <?= htmlspecialchars($v['full_name']) ?> (<?= htmlspecialchars($v['email']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted">Hold shift to select multiple.</small>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Save Event</button>
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
