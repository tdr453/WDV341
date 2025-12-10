<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

// Get all events from DB
$stmt = $pdo->query("SELECT * FROM events ORDER BY start_date ASC");
$events = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="mb-0">All Events</h1>
  <a href="./admin_event_new.php" class="btn btn-success">Add Event</a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>No.</th>
        <th>Title</th>
        <th>Location</th>
        <th>Start</th>
        <th>End</th>
        <th>Published</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($events)): ?>
        <tr>
          <td colspan="7" class="text-center text-muted">No events found.</td>
        </tr>
      <?php else: ?>
        <?php $i = 1; foreach ($events as $evt): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($evt['title']) ?></td>
            <td><?= htmlspecialchars($evt['location']) ?></td>
            <td><?= date('M j, Y g:ia', strtotime($evt['start_date'])) ?></td>
            <td><?= $evt['end_date'] ? date('M j, Y g:ia', strtotime($evt['end_date'])) : '—' ?></td>
            <td><?= $evt['is_published'] ? 'Yes' : 'No' ?></td>
            <td class="text-end">
              <a href="./admin_event_edit.php?id=<?= (int)$evt['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
              <form action="./admin_event_delete.php" method="post" class="d-inline">
                <input type="hidden" name="id" value="<?= (int)$evt['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this event?')">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>