<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $message  = trim($_POST['message'] ?? '');
    $honeypot = trim($_POST['website'] ?? '');

    // Honeypot check
    if ($honeypot !== '') {
        echo '<div class="alert alert-danger">Access Denied</div>';
        include __DIR__ . '/footer.php';
        exit;
    }

    // Validation
    if ($name === '' || $email === '' || $message === '') {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!$errors) {
        try {
            // Send to admin
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = MAIL_PORT;

            $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
            $mail->addAddress(MAIL_FROM); // send to yourself
            $mail->addReplyTo($email, $name);

            $mail->Subject = "Contact Form Submission from $name";
            $mail->Body    = "Name: $name\nEmail: $email\nMessage:\n$message";
            $mail->send();

            // Send copy to user
            $copy = new PHPMailer(true);
            $copy->CharSet = 'UTF-8';
            $copy->isSMTP();
            $copy->Host       = MAIL_HOST;
            $copy->SMTPAuth   = true;
            $copy->Username   = MAIL_USERNAME;
            $copy->Password   = MAIL_PASSWORD;
            $copy->SMTPSecure = 'tls';
            $copy->Port       = MAIL_PORT;

            $copy->setFrom(MAIL_FROM, MAIL_FROM_NAME);
            $copy->addAddress($email, $name);
            $copy->Subject = "Copy of your submission";
            $copy->Body    = "Thanks for reaching out!\n\nHere’s what you sent:\n\n$message";
            $copy->send();

            $success = true;
        } catch (Exception $e) {
            $errors[] = "Mailer Error: " . $e->getMessage();
        }
    }
}
?>

<h1>Contact Us</h1>

<?php if ($success): ?>
  <div class="alert alert-success">
    Thank you, <?= htmlspecialchars($name) ?>! Your message has been sent successfully.
  </div>
<?php else: ?>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err) echo "<div>".htmlspecialchars($err)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="w-75">
    <div class="mb-3">
      <label class="form-label">Name *</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email *</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Message *</label>
      <textarea name="message" class="form-control" rows="5" required></textarea>
    </div>
    <!-- Honeypot field -->
    <div style="display:none;">
      <label>Website</label>
      <input type="text" name="website">
    </div>
    <button type="submit" class="btn btn-primary">Send</button>
  </form>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>