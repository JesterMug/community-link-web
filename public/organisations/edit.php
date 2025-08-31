<?php
require_once __DIR__ . '/../../classes/Organisation.php';

$errors = [];
$success = null;
$organisation = null;

// Get organisation ID from URL
$organisationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($organisationId) {
    $organisation = Organisation::find($organisationId);
    if (!$organisation) {
        $errors[] = "Organisation not found.";
    }
} else {
    $errors[] = "Invalid organisation ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $organisation) {
    $organisation->organisation_name = trim($_POST['organisation_name'] ?? '');
    $organisation->contact_person_full_name = trim($_POST['contact_person_full_name'] ?? '');
    $organisation->email = trim($_POST['email'] ?? '');
    $organisation->phone = trim($_POST['phone'] ?? '');

    // Validation
    if (empty($organisation->organisation_name)) {
        $errors[] = "Organisation name is required.";
    }
    if (empty($organisation->email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($organisation->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($organisation->phone)) {
        $errors[] = "Phone number is required.";
    }
    if (empty($organisation->contact_person_full_name)) {
        $errors[] = "Contact person name is required.";
    }

    // Update if no errors
    if (!$errors) {
        if ($organisation->update()) {
            $success = "Organisation updated successfully.";
        } else {
            $errors[] = "Error updating organisation.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Organisation · CommunityLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h3 mb-4">Edit Organisation</h1>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <?php if ($errors): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <div><?= htmlspecialchars($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($organisation): ?>
                        <form method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Organisation Name</label>
                                <input type="text" class="form-control" id="organisation_name" name="organisation_name"
                                       value="<?= htmlspecialchars($organisation->organisation_name) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Contact Person Name</label>
                                <input type="text" class="form-control" id="contact_person_full_name" name="contact_person_full_name"
                                       value="<?= htmlspecialchars($organisation->contact_person_full_name) ?>" required>
                            </div>


                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= htmlspecialchars($organisation->email) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="<?= htmlspecialchars($organisation->phone) ?>" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Organisation</button>
                                <a href="view.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>