<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Look up admin user by username
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    // Verify password against stord hash
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin'] = true;
        $_SESSION['username'] = $admin['username']; // track who is logged in
        header("Location: ./events.php");
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<h1>Admin Login</h1>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" class="w-50">
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php include __DIR__ . '/footer.php'; ?>