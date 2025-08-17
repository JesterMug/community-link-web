<?php
require_once __DIR__ . '/../../db_connection.php';
require_once __DIR__ . '/../../classes/Model.php';
require_once __DIR__ . '/../../classes/Organisation.php';
/**
 * @var string $db_hostname
 * @var string $db_name
 * @var string $db_username
 * @var string $db_password
 */
$dsn = "mysql:host=$db_hostname;dbname=$db_name";
$dbh = new PDO($dsn, "$db_username", "$db_password");
Model::setPDO($dbh);

$errors = [];
$old = [
    'organisation_name'         => '',
    'contact_person_full_name' => '',
    'email'                    => '',
    'phone'                    => '',
];

$success = isset($_GET['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // collect
    $old['organisation_name']         = trim($_POST['organisation_name'] ?? '');
    $old['contact_person_full_name'] = trim($_POST['contact_person_full_name'] ?? '');
    $old['email']                    = trim($_POST['email'] ?? '');
    $old['phone']                    = trim($_POST['phone'] ?? '');

    // validate (all required now)
    if ($old['organisation_name'] === '') {
        $errors['organisation_name'] = 'Organisation name is required.';
    }
    if ($old['contact_person_full_name'] === '') {
        $errors['contact_person_full_name'] = 'Contact person is required.';
    }
    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'A valid email is required.';
    }
    if ($old['phone'] === '' || !preg_match('/^[0-9+\-\s()]{6,}$/', $old['phone'])) {
        $errors['phone'] = 'A valid phone number is required.';
    }

    if (!$errors) {
        try {
            $org = new Organisation([
                'organisation_name'         => $old['organisation_name'],
                'contact_person_full_name' => $old['contact_person_full_name'],
                'email'                    => $old['email'],
                'phone'                    => $old['phone'],
            ]);
            $org->save();

            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?success=1');
            exit;
        } catch (PDOException $e) {
            // Handle specific database errors
            if ($e->getCode() == 23000) { // Duplicate entry error
                $dbError = 'An organisation with this email is already registered.';
            } else {
                $dbError = 'An unexpected error occurred. Please try again later.';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Organisation · CommunityLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<!-- Toast container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php if (isset($dbError)): ?>
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= htmlspecialchars($dbError) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Thanks! Your organisation has been submitted.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0">Partner Organisation Registration</h1>
                </div>
                <div class="card-body">
                    <form method="post" novalidate>
                        <!-- Organisation name -->
                        <div class="mb-3">
                            <label for="organisation_name" class="form-label">Organisation name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="organisation_name" name="organisation_name" required
                                class="form-control <?= isset($errors['organisation_name']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($old['organisation_name']) ?>"
                            >
                            <?php if (isset($errors['organisation_name'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['organisation_name']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Contact person -->
                        <div class="mb-3">
                            <label for="contact_person_full_name" class="form-label">Contact person (full name) <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="contact_person_full_name" name="contact_person_full_name" required
                                class="form-control <?= isset($errors['contact_person_full_name']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($old['contact_person_full_name']) ?>"
                            >
                            <?php if (isset($errors['contact_person_full_name'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['contact_person_full_name']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                id="email" name="email" required
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($old['email']) ?>"
                            >
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="phone" name="phone" required
                                class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($old['phone']) ?>"
                                placeholder="+61 ..."
                            >
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-primary">Submit organisation</button>
                            <a href="/Lab03_Group05/" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize all toasts
    var toasts = document.querySelectorAll('.toast');
    toasts.forEach(function(toast) {
        new bootstrap.Toast(toast, {
            autohide: true,
            delay: 5000
        });
    });
</script>
</body>
</html>
