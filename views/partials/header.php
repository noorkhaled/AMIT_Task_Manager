<?php
$config = require __DIR__ . '/../../config/config.php';
$base   = rtrim($config['base_url'], '/');
$title  = $title ?? 'Task Manager';

use App\Helpers\Flash;

$flashes = Flash::pullAll();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="<?= $base ?>/tasks">Task Manager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="topnav" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <?php if (!empty($_SESSION['user'])): ?>
            <li class="nav-item me-2 align-self-center text-muted">Hello, <?= htmlspecialchars($_SESSION['user']['name']) ?></li>
            <li class="nav-item">
              <form action="<?= $base ?>/logout" method="post" class="d-inline">
                <?= $csrfField ?>
                <button class="btn btn-outline-secondary btn-sm" type="submit">Logout</button>
              </form>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="btn btn-outline-primary me-2 btn-sm" href="<?= $base ?>/login">Login</a></li>
            <li class="nav-item"><a class="btn btn-primary btn-sm" href="<?= $base ?>/register">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <?php if (!empty($flashes['toasts'])): ?>
      <?php foreach ($flashes['toasts'] as $type => $msgs): ?>
        <?php foreach ($msgs as $msg): ?>
          <div class="toast align-items-center text-bg-<?= $type === 'success' ? 'success' : ($type === 'info' ? 'info' : 'secondary') ?> border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body"><?= htmlspecialchars($msg) ?></div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <main class="container py-4">
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($flashes['alerts'])): ?>
      <?php foreach ($flashes['alerts'] as $type => $msgs): ?>
        <?php foreach ($msgs as $msg): ?>
          <div class="alert alert-<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($msg) ?></div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php endif; ?>