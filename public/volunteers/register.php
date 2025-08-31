<?php
require_once __DIR__ . '/../../classes/Model.php';
require_once __DIR__ . '/../../classes/Volunteer.php';

$errors = [];
$old = [
    'full_name' => '',
    'email'     => '',
    'phone'     => '',
    'skills'    => '',
];

$success = isset($_GET['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // collect
    $old['full_name'] = trim($_POST['full_name'] ?? '');
    $old['email']     = trim($_POST['email'] ?? '');
    $old['phone']     = trim($_POST['phone'] ?? '');
    $old['skills']    = trim($_POST['skills'] ?? '');

    // validate
    if ($old['full_name'] === '') {
        $errors['full_name'] = 'Full name is required.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if ($old['phone'] === '') {
        $errors['phone'] = 'Phone number is required.';
    } else if (!preg_match('/^[0-9+\-\s()]{6,}$/', $old['phone'])) {
        $errors['phone'] = 'Please enter a valid phone number.';
    }

    // File upload
    $profilePath = null;
    if (empty($_FILES['profile_picture']['name'])) {
        $errors['profile_picture'] = 'Profile picture is required.';
    } else if (!is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
        $errors['profile_picture'] = 'Invalid upload.';
    } else {
        $tmp  = $_FILES['profile_picture']['tmp_name'];
        $size = (int)$_FILES['profile_picture']['size'];

        if ($size > 2 * 1024 * 1024) {
            $errors['profile_picture'] = 'Max file size is 2MB.';
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $tmp);
            finfo_close($finfo);

            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            if (!isset($allowed[$mime])) {
                $errors['profile_picture'] = 'Only JPG, PNG or WEBP are allowed.';
            } else {
                $uploadDirFs = realpath(__DIR__ . '/../../') . '/volunteer_profiles';
                if (!is_dir($uploadDirFs)) {
                    mkdir($uploadDirFs, 0755, true);
                }
                $newName = bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
                $destFs  = $uploadDirFs . '/' . $newName;
                if (!move_uploaded_file($tmp, $destFs)) {
                    $errors['profile_picture'] = 'Failed to save uploaded file.';
                } else {
                    $profilePath = '/volunteer_profiles/' . $newName;
                }
            }
        }
    }

    // save
    if (!$errors) {
        try {
            $vol = new Volunteer([
                'full_name'       => $old['full_name'],
                'email'           => $old['email'],
                'phone'           => $old['phone'],
                'skills'          => $old['skills'] ?: null,
                'profile_picture' => $profilePath,
                'status'          => VolunteerStatus::Inactive,
            ]);

            $vol->save();
            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?success=1');
            exit;
        } catch (PDOException $e) {
            // Handle specific database errors
            if ($e->getCode() == 23000) { // Duplicate entry error
                $dbError = 'This email address is already registered.';
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
    <title>Volunteer Registration</title>
    <!-- Bootstrap 5 (latest) -->
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

<main class="container my-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Thanks for registering! We’ll be in touch soon.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0">Volunteer registration</h1>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" novalidate>
                        <!-- Full name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>"
                                id="full_name" name="full_name"
                                value="<?= htmlspecialchars($old['full_name']) ?>"
                                required
                            >
                            <?php if (isset($errors['full_name'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['full_name']) ?></div>
                            <?php else: ?>
                                <div class="form-text">As you’d like it to appear for event rosters.</div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                id="email" name="email"
                                value="<?= htmlspecialchars($old['email']) ?>"
                                required
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
                                class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                                id="phone" name="phone"
                                value="<?= htmlspecialchars($old['phone']) ?>"
                                placeholder="+61 4xx xxx xxx"
                                required
                            >
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Skills -->
                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills / interests</label>
                            <textarea
                                class="form-control"
                                id="skills" name="skills" rows="3"
                                placeholder="eg. first aid, customer service, pack-in/pack-out, cash handling"
                            ><?= htmlspecialchars($old['skills']) ?></textarea>
                        </div>

                        <!-- Profile picture -->
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile picture <span class="text-danger">*</span></label>
                            <input
                                class="form-control <?= isset($errors['profile_picture']) ? 'is-invalid' : '' ?>"
                                type="file" id="profile_picture" name="profile_picture" accept="image/*"
                                required
                            >
                            <?php if (isset($errors['profile_picture'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['profile_picture']) ?></div>
                            <?php else: ?>
                                <div class="form-text">JPG/PNG/WEBP, max 2MB.</div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-primary">Submit registration</button>
                            <a href="/" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialise all toasts
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
