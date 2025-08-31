<?php
require_once __DIR__ . '/../../classes/Volunteer.php';

$errors = [];
$success = null;

// Delete volunteer
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $volunteer = Volunteer::find($deleteId);
    if ($volunteer && $volunteer->delete()) {
        $success = "Volunteer deleted successfully.";
    } else {
        $errors[] = "Error deleting volunteer.";
    }
}

//Get volunteers
$volunteers = Volunteer::all();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Volunteers · CommunityLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
    <div class="col d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4">Manage Volunteers</h1>
        <a href="add.php" class="btn btn-sm btn-primary">New Volunteer</a>
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

    <!-- Volunteer list -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$volunteers): ?>
                    <tr><td colspan="6">No volunteers found.</td></tr>
                <?php else: ?>
                    <?php foreach ($volunteers as $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($v['volunteer_id']) ?></td>
                            <td><?= htmlspecialchars($v['full_name'] )?></td>
                            <td><?= htmlspecialchars($v['email']) ?></td>
                            <td><?= htmlspecialchars($v['phone']) ?></td>
                            <td><?= htmlspecialchars($v['status']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $v['volunteer_id'] ?>" class="btn btn-sm btn-secondary">
                                    Edit
                                </a>
                                <a href="?delete=<?= $v['volunteer_id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this volunteer?')">
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