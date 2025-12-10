<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= APP_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/WDV341/finalProject/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="./index.php">Event Planner</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="./events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./contact.php">Contact</a>
        </li>
        <?php if (!empty($_SESSION['admin'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="./admin_event_new.php">Add Event</a>
          </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if (!empty($_SESSION['admin'])): ?>
          <li class="nav-item">
            <span class="navbar-text text-light me-3">
              Logged in as <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
            </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="./login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">