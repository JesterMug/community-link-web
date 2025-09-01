<?php
require_once __DIR__ . '/../../classes/ContactMessage.php';

$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone'] ?? '');
  $message = trim($_POST['message']);

  if ($name === '' || $email === '' || $message === '') {
    $errors[] = "Name, email, and message are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  } elseif ($phone !== '' && !preg_match('/^[0-9]{2} [0-9]{4} [0-9]{4}$/', $phone)) {
    $errors[] = "Please enter a valid phone number (format: XX 1234 5678).";
  }

  if (empty($errors)) {
    try {
      $saved = ContactMessage::create($name, $email, $phone, $message);

      if ($saved) {
        $to = 'jago.ayin@icloud.com';
        $subject = "New Contact Form from $email";
        $body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email";

        if (mail($to, $subject, $body, $headers)) {
          $success = "Your message has been sent successfully!";
//          . $body;
        }
      } else {
        $errors[] = "Failed to save your message. Please try again later.";
      }
    } catch (PDOException $e) {
      $errors[] = "An Unknown error occurred. Please try again later.";
    }
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us · CommunityLink</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

<main class="container my-5">
  <h1>Contact Us</h1>

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

  <form method="post">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name"
             placeholder="John Doe"
             value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="john.doe@email.com"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">Phone</label>
      <input type="tel" class="form-control" id="phone" name="phone"
              placeholder="XX 1234 5678"
             value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label for="message" class="form-label">Message</label>
      <textarea class="form-control" id="message" name="message" rows="5" placeholder="Hi, what is the maximum amount of.."
                required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Send</button>
  </form>

</main>
</body>
</html>
