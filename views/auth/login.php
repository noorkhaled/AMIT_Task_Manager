<?php $base = rtrim((require __DIR__ . '/../../config/config.php')['base_url'], '/'); ?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h4 mb-3"><?= $title ?? 'Login' ?></h1>

        <form action="<?= $base ?>/login" method="post" novalidate>
          <?= $csrfField ?>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
          </div>
          <button class="btn btn-primary w-100" type="submit">Login</button>
        </form>

        <p class="mt-3 mb-0 text-center">
          No account? <a href="<?= $base ?>/register">Register</a>
        </p>
      </div>
    </div>
  </div>
</div>
