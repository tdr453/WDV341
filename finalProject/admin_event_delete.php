<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: ./login.php");
    exit;
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

// After deletion, redirect back to Events page
header("Location: ./events.php");
exit;
