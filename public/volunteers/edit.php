<?php
require_once __DIR__ . '/../../classes/Volunteer.php';
require_once __DIR__ . '/../../classes/Auth.php';

Auth::requireAuth();


$errors = [];
$success = null;
$volunteer = null;

// Get volunteer ID from URL
$volunteerId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($volunteerId) {
    $volunteer = Volunteer::find($volunteerId);
    if (!$volunteer) {
        $errors[] = "Volunteer not found.";
    }
} else {
    $errors[] = "Invalid volunteer ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $volunteer) {
    $volunteer->full_name = trim($_POST['full_name'] ?? '');
    $volunteer->email = trim($_POST['email'] ?? '');
    $volunteer->phone = trim($_POST['phone'] ?? '');
    $volunteer->skills = trim($_POST['skills'] ?? '') ?: null;
    $volunteer->status = $_POST['status'] === 'active' ? VolunteerStatus::Active : VolunteerStatus::Inactive;

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/volunteer_profiles/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $file = $_FILES['profile_picture'];
        $fileType = $file['type'];
        $fileSize = $file['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        } elseif ($fileSize > $maxSize) {
            $errors[] = "File size too large. Maximum 5MB allowed.";
        } else {
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = 'volunteer_' . $volunteerId . '_' . time() . '.' . $extension;
            $uploadPath = $uploadDir . $newName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Delete old profile picture if exists
                if ($volunteer->profile_picture && file_exists($uploadDir . $volunteer->profile_picture)) {
                    unlink($uploadDir . $volunteer->profile_picture);
                }
                $volunteer->profile_picture = $newName;
            } else {
                $errors[] = "Error uploading file.";
            }
        }
    }

    // Validation
    if (empty($volunteer->full_name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($volunteer->email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($volunteer->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($volunteer->phone)) {
        $errors[] = "Phone number is required.";
    }

    // Update if no errors
    if (!$errors) {
        if ($volunteer->update()) {
            $success = "Volunteer updated successfully.";
        } else {
            $errors[] = "Error updating volunteer.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Volunteer · CommunityLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h3 mb-4">Edit Volunteer Profile</h1>

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

                    <?php if ($volunteer): ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                       value="<?= htmlspecialchars($volunteer->full_name) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profile Picture</label>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <?php if ($volunteer->profile_picture): ?>
                                        <img src="../uploads/volunteer_profiles/<?= htmlspecialchars($volunteer->profile_picture) ?>"
                                             alt="Profile Picture"
                                             class="rounded-circle"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 80px; height: 80px;">
                                            <i class="text-white fs-1">?</i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                       accept="image/*">
                                <div class="form-text">Choose a new profile picture (JPG, PNG, GIF - Max 5MB)</div>
                            </div>


                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= htmlspecialchars($volunteer->email) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="<?= htmlspecialchars($volunteer->phone) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <textarea class="form-control" id="skills" name="skills" rows="3"><?= htmlspecialchars($volunteer->skills ?? '') ?></textarea>
                            </div>


                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?= $volunteer->status === VolunteerStatus::Active ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $volunteer->status === VolunteerStatus::Inactive ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Volunteer</button>
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
