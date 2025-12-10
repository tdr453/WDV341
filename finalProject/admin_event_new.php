<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: ./login.php");
    exit;
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $start_date  = $_POST['start_date'] ?? '';
    $end_date    = $_POST['end_date'] ?? null;
    $published   = isset($_POST['is_published']) ? 1 : 0;

    // validation
    if ($title === '' || $description === '' || $location === '' || $start_date === '') {
        $errors[] = "All required fields must be filled.";
    }

    if (!$errors) {
        $stmt = $pdo->prepare(
            "INSERT INTO events (title, description, location, start_date, end_date, is_published)
             VALUES (:title, :description, :location, :start_date, :end_date, :is_published)"
        );
        $stmt->execute([
            'title'        => $title,
            'description'  => $description,
            'location'     => $location,
            'start_date'   => $start_date,
            'end_date'     => $end_date ?: null,
            'is_published' => $published
        ]);
        $success = true;
    }
}
?>

<h1>Add New Event</h1>

<?php if ($success): ?>
  <div class="alert alert-success">Event added successfully! <a href="./events.php">Back to Events</a></div>
<?php else: ?>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err) echo "<div>".htmlspecialchars($err)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Title *</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Location *</label>
      <input type="text" name="location" class="form-control" required>
    </div>
    <div class="col-12">
      <label class="form-label">Description *</label>
      <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Start Date/Time *</label>
      <input type="datetime-local" name="start_date" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">End Date/Time</label>
      <input type="datetime-local" name="end_date" class="form-control">
    </div>
    <div class="col-12">
      <div class="form-check">
        <input type="checkbox" name="is_published" class="form-check-input" id="publishCheck" checked>
        <label for="publishCheck" class="form-check-label">Publish immediately</label>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Save Event</button>
      <a href="./events.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>