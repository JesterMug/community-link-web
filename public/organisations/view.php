<?php
require_once __DIR__ . '/../../classes/Organisation.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAdmin();


$errors = [];
$success = null;

// Delete organisation
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $organisation = Organisation::find($deleteId);
    if ($organisation && $organisation->delete()) {
        $success = "Organisation deleted successfully.";
    } else {
        $errors[] = "Error deleting organisation.";
    }
}

//Get organisations
$organisations = Organisation::all();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Organisations · CommunityLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
    <div class="col d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4">Manage Organisations</h1>
        <a href="add.php" class="btn btn-sm btn-primary">New Organisation</a>
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

    <!-- Organisation list -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$organisations): ?>
                    <tr><td colspan="6">No organisations found.</td></tr>
                <?php else: ?>
                    <?php foreach ($organisations as $o): ?>
                        <tr>
                            <td><?= htmlspecialchars($o['organisation_id']) ?></td>
                            <td><?= htmlspecialchars($o['organisation_name']) ?></td>
                            <td><?= htmlspecialchars($o['contact_person_full_name']) ?></td>
                            <td><?= htmlspecialchars($o['email']) ?></td>
                            <td><?= htmlspecialchars($o['phone']) ?></td>

                            <td>
                                <a href="edit.php?id=<?= $o['organisation_id'] ?>" class="btn btn-sm btn-secondary">
                                    Edit
                                </a>
                                <a href="?delete=<?= $o['organisation_id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this organisation?')">
                                    Delete
                                </a>
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