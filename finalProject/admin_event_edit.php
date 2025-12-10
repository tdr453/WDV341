<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: ./login.php");
    exit;
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$errors = [];
$success = false;

// Fetch existing event
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
$stmt->execute(['id' => $id]);
$event = $stmt->fetch();

if (!$event) {
    echo '<div class="alert alert-danger">Event not found. <a href="./events.php">Back to Events</a></div>';
    include __DIR__ . '/footer.php';
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $start_date  = $_POST['start_date'] ?? '';
    $end_date    = $_POST['end_date'] ?? null;
    $published   = isset($_POST['is_published']) ? 1 : 0;

    if ($title === '' || $description === '' || $location === '' || $start_date === '') {
        $errors[] = "All required fields must be filled.";
    }

    if (!$errors) {
        $stmt = $pdo->prepare(
            "UPDATE events SET title = :title, description = :description, location = :location,
             start_date = :start_date, end_date = :end_date, is_published = :is_published
             WHERE id = :id"
        );
        $stmt->execute([
            'id'           => $id,
            'title'        => $title,
            'description'  => $description,
            'location'     => $location,
            'start_date'   => $start_date,
            'end_date'     => $end_date ?: null,
            'is_published' => $published
        ]);
        $success = true;

        // Refresh event data
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $event = $stmt->fetch();
    }
}
?>

<h1>Edit Event</h1>

<?php if ($success): ?>
  <div class="alert alert-success">Event updated successfully! <a href="./events.php">Back to Events</a></div>
<?php endif; ?>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<div>".htmlspecialchars($err)."</div>"; ?>
  </div>
<?php endif; ?>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Title *</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Location *</label>
    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event['location']) ?>" required>
  </div>
  <div class="col-12">
    <label class="form-label">Description *</label>
    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
  </div>
  <div class="col-md-6">
    <label class="form-label">Start Date/Time *</label>
    <input type="datetime-local" name="start_date" class="form-control"
           value="<?= date('Y-m-d\TH:i', strtotime($event['start_date'])) ?>" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">End Date/Time</label>
    <input type="datetime-local" name="end_date" class="form-control"
           value="<?= $event['end_date'] ? date('Y-m-d\TH:i', strtotime($event['end_date'])) : '' ?>">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input type="checkbox" name="is_published" class="form-check-input" id="publishCheck"
             <?= $event['is_published'] ? 'checked' : '' ?>>
      <label for="publishCheck" class="form-check-label">Publish immediately</label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Update Event</button>
    <a href="./events.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>