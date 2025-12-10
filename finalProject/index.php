<?php
require __DIR__ . '/config.php';
require __DIR__ . '/db.php';
include __DIR__ . '/header.php';

// Query events in chronological order
$stmt = $pdo->query("SELECT * FROM events WHERE is_published = 1 ORDER BY start_date ASC");
$events = $stmt->fetchAll();
?>

<h1 class="mb-4">Upcoming Events</h1>

<?php if (empty($events)): ?>
  <p class="text-muted">No events yet. Add some in phpMyAdmin or through the admin page later.</p>
<?php else: ?>
  <div class="row g-4">
    <?php foreach ($events as $evt): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($evt['title']) ?></h5>
            <p class="card-text text-muted mb-1">
              <strong>Location:</strong> <?= htmlspecialchars($evt['location']) ?>
            </p>
            <p class="card-text mb-1">
              <strong>Date:</strong>
              <?= date('M j, Y g:ia', strtotime($evt['start_date'])) ?>
              <?php if ($evt['end_date']): ?>
                — <?= date('M j, Y g:ia', strtotime($evt['end_date'])) ?>
              <?php endif; ?>
            </p>
            <p class="card-text"><?= htmlspecialchars($evt['description']) ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>