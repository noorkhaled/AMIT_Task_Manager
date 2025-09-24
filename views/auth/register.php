<?php $base = rtrim((require __DIR__ . '/../../config/config.php')['base_url'], '/'); ?>
<div class="row justify-content-center">
  <div class="col-12 col-md-7 col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h4 mb-3"><?= $title ?? 'Register' ?></h1>

        <form action="<?= $base ?>/register" method="post" novalidate>
          <?= $csrfField ?>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" type="text" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" minlength="8" required>
            <div class="form-text">At least 8 characters.</div>
          </div>
          <button class="btn btn-primary w-100" type="submit">Register</button>
        </form>

        <p class="mt-3 mb-0 text-center">
          Already have an account? <a href="<?= $base ?>/login">Login</a>
        </p>
      </div>
    </div>
  </div>
</div>
